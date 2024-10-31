<?php
/**
 * The admin-specific on-boarding functionality of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package     product_reviews_for_woocommerce
 * @subpackage  product_reviews_for_woocommerce/includes
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
		require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
/**
 * Class Name Review
 * This class will show the details of review-logs logs by extending WP_List_Table.
 */
class Product_Reviews_For_Woocommerce_Review_Data extends WP_List_Table {

	/**
	 * Getting data from Database.
	 *
	 * @since 1.0.0
	 * @param string $orderby sorting order by column.
	 * @param string $order sorting order.
	 * @param string $search_item item to search.
	 * @param string $mwb_comment_status comment status.
	 * @return array array containing the data fetched from database
	 */
	public function mwb_review_data( $orderby, $order, $search_item, $mwb_comment_status ) {
		$comments_query = new WP_Comment_Query();

		$args           = array(
			'type__in' => 'review',
		);
		if ( 'mine' === $mwb_comment_status ) {
			$args['status'] = array( 'hold', 'approve' );
			$args['user_id'] = get_current_user_id();
		} elseif ( 'spam' === $mwb_comment_status ) {
			$args['status'] = array( 'spam' );
		} elseif ( 'trash' === $mwb_comment_status ) {
			$args['status'] = array( 'trash' );
		} elseif ( 'approved' === $mwb_comment_status ) {
			$args['status'] = array( 'approve' );
		} elseif ( 'moderated' === $mwb_comment_status ) {
			$args['status'] = array( 'hold' );
		} elseif ( 'all' === $mwb_comment_status ) {
			$args['status'] = array( 'hold', 'approve' );
		} else {
			$args['status'] = array( 'hold', 'approve' );
		}
		$result   = $comments_query->query( $args );
		$data_arr = array();
		if ( count( $result ) > 0 ) {
			foreach ( $result as $key => $value ) {
				$comment_id = $value->comment_ID;

					$data_arr[] = array(
						'id' => $comment_id,
						'customer' => $value,
						'review'    => $value,
						'product'    => $value,
						'date'     => $value->comment_date,
					);
			}
		}
		return $data_arr;

	}

	/**
	 * Function name get_views
	 * show views of comment table
	 *
	 * @since 1.0.0
	 * @return array
	 */
	protected function get_views() {

		global $post_id, $comment_status, $comment_type;

		$status_links = array();
		$mine_all = count(
			get_comments(
				array(
					'type__in' => 'review',
					'status'   => array( 'hold', 'approve' ),
					'user_id'  => get_current_user_id(),
				)
			)
		);
		$all_count = count(
			get_comments(
				array(
					'type__in' => 'review',
					'status' => array( 'hold', 'approve' ),
				)
			)
		);

		$trash_count = count(
			get_comments(
				array(
					'type__in' => 'review',
					'status' => array( 'trash' ),
				)
			)
		);

		$a_count = count(
			get_comments(
				array(
					'type__in' => 'review',
					'status'   => array( 'approve' ),
				)
			)
		);
		$spam_count = count(
			get_comments(
				array(
					'type__in' => 'review',
					'status'   => array( 'spam' ),
				)
			)
		);
		$p_count = count(
			get_comments(
				array(
					'type__in' => 'review',
					'status'   => array( 'hold' ),
				)
			)
		);

		$view_arr = array(
			__( 'All', 'product-reviews-for-woocommerce' ) => array(
				'action' => 'all',
				'count' => $all_count,
			),

			__( 'Mine', 'product-reviews-for-woocommerce' ) => array(
				'action' => 'mine',
				'count' => $mine_all,
			),
			__( 'Pending', 'product-reviews-for-woocommerce' ) => array(
				'action' => 'moderated',
				'count' => $p_count,
			),
			__( 'Approved', 'product-reviews-for-woocommerce' ) => array(
				'action' => 'approved',
				'count' => $a_count,
			),
			__( 'Spam', 'product-reviews-for-woocommerce' ) => array(
				'action' => 'spam',
				'count' => $spam_count,
			),
			__( 'Trash', 'product-reviews-for-woocommerce' ) => array(
				'action' => 'trash',
				'count' => $trash_count,
			),
		);

		$link = add_query_arg(
			array( 'page'  => 'reviews' ),
			admin_url( 'admin.php' )
		);
		if ( ! empty( $comment_type ) && 'all' !== $comment_type ) {
			$link = add_query_arg( 'comment_type', $comment_type, $link );
		}

		foreach ( $view_arr as $status => $label ) {
			$current_link_attributes = '';
			if ( $status === $comment_status ) {
				$current_link_attributes = ' class="current" aria-current="page"';
			}
			$link = add_query_arg( 'comment_status', $label['action'], $link );
			if ( $post_id ) {
				$link = add_query_arg( 'p', absint( $post_id ), $link );
			}
			$status_links[ $status ] = '<a href=' . esc_url( $link . $current_link_attributes ) . '>' .
				$status . '(' . $label['count'] . ')'
			. '</a>';
		}
		return $status_links;
	}



	/**
	 * Function name column_customer
	 *
	 * @param array $comment contains comment.
	 * @return void
	 */
	public function column_customer( $comment ) {
		$comment = $comment['customer'];
		$comment_avatar = get_comment( $comment->comment_ID );
		$avatar = get_avatar( $comment_avatar, 32, 'mystery' );
		if ( $avatar ) {
			echo wp_kses_post( $avatar );
		}
		$author_url = get_comment_author_url( $comment );

		$author_url_display = untrailingslashit( preg_replace( '|^http(s)?://(www\.)?|i', '', $author_url ) );
		if ( strlen( $author_url_display ) > 50 ) {
			$author_url_display = wp_html_excerpt( $author_url_display, 49, '&hellip;' );
		}

		echo '<strong>';
		comment_author( $comment );
		echo '</strong><br />';
		if ( ! empty( $author_url_display ) ) {
			printf( '<a href="%s">%s</a><br />', esc_url( $author_url ), esc_html( $author_url_display ) );
		}

		if ( ! empty( $comment->comment_author_email ) ) {

			$email = $comment->comment_author_email;

			if ( ! empty( $email ) && '@' !== $email ) {
				printf( '<a href="%1$s">%2$s</a><br />', esc_url( 'mailto:' . $email ), esc_html( $email ) );
			}
		}
	}
	/**
	 * Function name column_product
	 *
	 * @param array $comment contains comment.
	 * @since 1.0.0
	 * @return void
	 */
	public function column_product( $comment ) {
		$comment = $comment['product'];
		$post = get_post( $comment->comment_post_ID );
		if ( ! $post ) {
			return;
		}
		if ( current_user_can( 'edit_post', $post->ID ) ) {
			$post_link = "<a href='" . get_edit_post_link( $post->ID ) . "' class='comments-edit-item-link'>";
			$post_link .= esc_html( get_the_title( $post->ID ) ) . '</a>';
		} else {
			$post_link = esc_html( get_the_title( $post->ID ) );
		}

		echo '<div class="response-links">';
		echo wp_kses_post( $post_link );
		$post_type_object = get_post_type_object( $post->post_type );
		echo "<a href='" . wp_kses_post( get_permalink( $post->ID ) ) . "' class='comments-view-item-link'>" . esc_attr( $post_type_object->labels->view_item ) . '</a>';
		echo '<span class="post-com-count-wrapper post-com-count-', esc_html( $post->ID ), '">';
		echo '</span> ';
		echo '</div>';
	}


	/**
	 * Function name column_review
	 *
	 * @param array $comment contains comment.
	 * @since 1.0.0
	 * @return array
	 */
	public function column_review( $comment ) {

		$comment = $comment['review'];
		if ( $comment->comment_parent ) {
			$parent = get_comment( $comment->comment_parent );
		}
		$post_id = $comment->comment_post_ID;
		$the_comment_status = wp_get_comment_status( $comment );
		if ( ( isset( $_GET['comment_status'] ) && ( 'all' === $_GET['comment_status'] ) ) || ( ! isset( $_GET['comment_status'] ) ) || ( isset( $_GET['comment_status'] ) && ( 'mine' === $_GET['comment_status'] ) ) ) {
			if ( 'approved' === $the_comment_status ) {
				$action = array(
					'unapproved' => '<a href="javascript:void(0)" class="unapprove_data" data-id="' . $comment->comment_ID . '">Unapprove</a>',
					'reply hide-if-no-js' => '<a href="javascript:void(0)" class="mwb_reply_comment_button" data-comment-type= "comment" data-post-id="' . $post_id . '" data-id="' . $comment->comment_ID . '">Reply</a>',
					'edit' => '<a href="' . get_edit_comment_link( $comment->comment_ID ) . '" data-id="' . $comment->comment_ID . '">Edit</a>',
					'spam' => '<a href="javascript:void(0)" class="spam_comment" data-id="' . $comment->comment_ID . '">Spam</a>',
					'trash' => '<a href="javascript:void(0)" class="trash_comment" data-id="' . $comment->comment_ID . '">Trash</a>',
				);

			} else {

				$action = array(
					'approved' => '<a href="javascript:void(0)" class="mwb_approve_comment" data-id="' . $comment->comment_ID . '">Approve</a>',
					'reply' => '<a href="javascript:void(0)" class="mwb_reply_comment_button" data-comment-type= "comment" data-id="' . $comment->comment_ID . '">Reply</a>',
					'edit' => '<a href="' . get_edit_comment_link( $comment->comment_ID ) . '" data-id="' . $comment->comment_ID . '">Edit</a>',
					'spam' => '<a href="javascript:void(0)" class="spam_comment" data-id="' . $comment->comment_ID . '">Spam</a>',
					'trash' => '<a href="javascript:void(0)" class="trash_comment" data-id="' . $comment->comment_ID . '">Trash</a>',
				);
			}
		}

		if ( isset( $_GET['comment_status'] ) && ( 'spam' === $_GET['comment_status'] ) ) {
			$action = array(
				'unspam' => '<a href="javascript:void(0)" class="mwb_unspam" data-id="' . $comment->comment_ID . '">Not Spam</a>',
				'delete' => '<a href="javascript:void(0)" class="mwb_prfw_permanent_delete" data-id="' . $comment->comment_ID . '">Delete Permanently</a>',
			);

		}

		if ( isset( $_GET['comment_status'] ) && ( 'approved' === $_GET['comment_status'] ) ) {
			$action = array(
				'unapproved' => '<a href="javascript:void(0)" class="unapprove_data" data-id="' . $comment->comment_ID . '">Unapprove</a>',
				'reply hide-if-no-js' => '<a href="javascript:void(0)" class="mwb_reply_comment_button" data-comment-type= "comment" data-post-id="' . $post_id . '" data-id="' . $comment->comment_ID . '">Reply</a>',
				'edit' => '<a href="' . get_edit_comment_link( $comment->comment_ID ) . '"  data-id="' . $comment->comment_ID . '">Edit</a>',
				'spam' => '<a href="javascript:void(0)" class="spam_comment" data-id="' . $comment->comment_ID . '">Spam</a>',
				'trash' => '<a href="javascript:void(0)" class="trash_comment" data-id="' . $comment->comment_ID . '">Trash</a>',
			);

		}
		if ( isset( $_GET['comment_status'] ) && ( 'moderated' === $_GET['comment_status'] ) ) {

			$action = array(
				'approved' => '<a href="javascript:void(0)" class="mwb_approve_comment" data-id="' . $comment->comment_ID . '">Approve</a>',
				'reply hide-if-no-js' => '<a href="javascript:void(0)" class="mwb_reply_comment_button" data-comment-type= "comment" data-post-id="' . $post_id . '" data-id="' . $comment->comment_ID . '">Reply</a>',
				'edit' => '<a href="' . get_edit_comment_link( $comment->comment_ID ) . '" id="view_data" data-id="' . $comment->comment_ID . '">Edit</a>',
				'spam' => '<a href="javascript:void(0)" class="spam_comment" data-id="' . $comment->comment_ID . '">Spam</a>',
				'trash' => '<a href="javascript:void(0)" class="trash_comment" data-id="' . $comment->comment_ID . '">Trash</a>',
			);

		}
		if ( isset( $_GET['comment_status'] ) && ( 'trash' === $_GET['comment_status'] ) ) {
			$action = array(
				'spam' => '<a href="javascript:void(0)" class="spam_comment" data-id="' . $comment->comment_ID . '">Spam</a>',
				'unspam' => '<a href="javascript:void(0)" class="mwb_prfw_restore_comment" data-id="' . $comment->comment_ID . '">Restore</a>',
				'delete' => '<a href="javascript:void(0)" class="mwb_prfw_permanent_delete" data-id="' . $comment->comment_ID . '">Delete Permanently</a>',
			);

		}
		$comment->rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
		$comment->mwb_meta = get_comment_meta( $comment->comment_ID, 'mwb_add_review_title', true );
		$comment->mwb_meta_review_image = get_comment_meta( $comment->comment_ID, 'mwb_review_image', true );
		if ( $comment->mwb_meta ) {
			echo esc_html( $comment->mwb_meta );
		}
		if ( $comment->comment_parent ) {
			$parent = get_comment( $comment->comment_parent );
			if ( $parent ) {
				$parent_link = esc_url( get_comment_link( $parent ) );
				$name = get_comment_author( $parent );
				echo '<p>';
				printf(
					/* translators: %s: name */
					esc_html__( 'In reply to %s', 'product-reviews-for-woocommerce' ),
					'<a href="' . esc_html( $parent_link ) . '">' . esc_html( $name ) . '</a>'
				);
				echo '</p>';
			}
		}
		?>
		<div>
			<span class="star-rating">
				<?php
				if ( $comment->rating > 0 ) {
					for ( $i = 1; $i < 6; $i++ ) {
						$class = ( $i <= $comment->rating ) ? 'filled' : 'empty';
						?>
						<span class="dashicons dashicons-star-<?php echo esc_html( $class ); ?>"></span>
						<?php
					}
				}
				?>
			</span>
		</div>
		<?php
		comment_text( $comment );

		$dynamic_feature = get_comment_meta( $comment->comment_ID, 'mwb_prfw_dynamic_review_features', true );
		if ( $dynamic_feature ) {
			echo "<div class='mwb_prfw-main_review_extra'>";
			foreach ( $dynamic_feature as $key => $value ) {
				$v = str_replace( '_', ' ', trim( $key ) );
				echo esc_html( $v );
				if ( $value > 0 ) {
					?>
					<div>
					<?php
					for ( $i = 1; $i < 6; $i++ ) {

						$class = ( $i <= $value ) ? 'filled' : 'empty';
						?>
						<span class="dashicons dashicons-star-<?php echo esc_html( $class ); ?>"></span>
						<?php
					}
					?>
						</div>

					<?php
				}
			}
			echo '</div>';
		}
		if ( $comment->mwb_meta_review_image ) {
			foreach ( $comment->mwb_meta_review_image as $k => $value ) {
				$mwb_prfw_file_type_check = wp_check_filetype( $value )['ext'];
				if ( 'jpg' === $mwb_prfw_file_type_check || 'jpeg' === $mwb_prfw_file_type_check || 'png' === $mwb_prfw_file_type_check || 'svg' === $mwb_prfw_file_type_check || 'gif' === $mwb_prfw_file_type_check || 'tiff' === $mwb_prfw_file_type_check || 'bmp' === $mwb_prfw_file_type_check || 'raw' === $mwb_prfw_file_type_check || 'eps' === $mwb_prfw_file_type_check ) {
						echo "<img src='" . esc_url( $value ) . "' width='100px' height='100px' > ";
				} else {
					echo '<video width="150" controls ><source src=' . esc_url( $value ) . '></video>';
				}
			}
		}
		return $this->row_actions( $action );

	}

	/**
	 * Hiding databse id column.
	 *
	 * @since 1.0.0
	 * @return array array contining the column to hide
	 */
	public function get_hidden_columns() {
		return array( 'id' );
	}
	/**
	 * Setting sortable columns.
	 *
	 * @since 1.0.0
	 * @return array array containing the columns to sort.
	 */
	public function get_sortable_columns() {
			return array(
				'username' => array( 'username', true ),
				'email'    => array( 'email', true ),
				'time'     => array( 'time', true ),
			);
	}
	/**
	 * Get all columns to list as the Heading.
	 *
	 * @since 1.0.0
	 * @return array array containing the datbase keys and Title to show as heading of the table.
	 */
	public function get_columns() {
		$columns = array(
			'cb'       => '<input type="checkbox" />',
			'id'       => __( 'ID', 'product-reviews-for-woocommerce' ),
			'customer'   => __( 'Customer', 'product-reviews-for-woocommerce' ),
			'review' => __( 'Review', 'product-reviews-for-woocommerce' ),
			'product'     => __( 'Product', 'product-reviews-for-woocommerce' ),
			'date'     => __( 'Date', 'product-reviews-for-woocommerce' ),
		);
		return $columns;
	}
	/**
	 * Callback function will be used during bulk delete.
	 *
	 * @param array $item array contining the databse row id will bve used for deletion.
	 * @since 1.0.0
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />',
			$item['id']
		);
	}
	/**
	 * Getting value of the respective column.
	 *
	 * @param array  $item contains items from the database.
	 * @param string $column_name contains column name to get data for.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {

			case 'id':
			case 'customer':
			case 'review':
			case 'tags':
			case 'product':
			case 'date':
				return $item[ $column_name ];
			default:
				return 'No Value';
		}

	}
	/**
	 * Array containing the bulk actions.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'unapprove' => __( 'Un-Approve', 'product-reviews-for-woocommerce' ),
			'approve' => __( 'Approve', 'product-reviews-for-woocommerce' ),
			'trash' => __( 'Move To Trash', 'product-reviews-for-woocommerce' ),
			'spam' => __( 'Mark as Spam', 'product-reviews-for-woocommerce' ),
			'delete' => __( 'Delete', 'product-reviews-for-woocommerce' ),
		);
		return $actions;
	}
	/**
	 * Function name apply_bulk_action
	 * this function is used to apply bulk action
	 *
	 * @param int    $id contains id.
	 * @param string $action contains action.
	 * @return void
	 */
	public static function apply_bulk_action( $id, $action ) {
		$comment_update_arr = array(
			'comment_ID' => $id,
		);

		if ( 'delete' === $action ) {
				wp_delete_comment( $id );
		} elseif ( 'approve' === $action ) {
				$comment_update_arr['comment_approved'] = 1;
		} elseif ( 'unapprove' === $action ) {
			$comment_update_arr['comment_approved'] = 0;

		} elseif ( 'trash' === $action ) {
			$comment_update_arr['comment_approved'] = 'trash';
		} elseif ( 'spam' === $action ) {
			$comment_update_arr['comment_approved'] = 'spam';

		}

	}
	/**
	 * Processing bulk action to delete review-logs log
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function process_bulk_action() {

		if ( wp_verify_nonce( isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '' ) ) {
			$action = ( isset( $_POST['action'] ) ? sanitize_text_field( wp_unslash( $_POST['action'] ) ) : ( isset( $_POST['action2'] ) ? sanitize_text_field( wp_unslash( $_POST['action2'] ) ) : '' ) );

			if ( $action ) {
				if ( ( isset( $_POST['action'] ) && $action === $_POST['action'] ) || ( isset( $_POST['action2'] ) && $action === $_POST['action2'] ) ) {
					$ids = isset( $_POST['bulk-delete'] ) ? map_deep( wp_unslash( $_POST['bulk-delete'] ), 'sanitize_text_field' ) : '';
					foreach ( $ids as $id ) {
						self::apply_bulk_action( $id, $action );
					}
				}
				if ( 'spam' === $action ) {
					$send_action = __( 'Marked as spam', 'product-reviews-for-woocommerce' );
				} elseif ( 'trash' === $action ) {
					$send_action = __( 'Moved To Trash', 'product-reviews-for-woocommerce' );
				} elseif ( 'approve' === $action ) {
					$send_action = __( 'Approved', 'product-reviews-for-woocommerce' );
				} elseif ( 'unapprove' === $action ) {
					$send_action = __( 'Un-Approved', 'product-reviews-for-woocommerce' );
				} elseif ( 'delete' === $action ) {
					$send_action = __( 'Deleted', 'product-reviews-for-woocommerce' );
				}
				wp_safe_redirect(
					add_query_arg(
						array(
							'page'     => 'reviews',
							'action'  => $send_action,
							'deleted'  => true,
						),
						admin_url( 'admin.php' )
					)
				);
				exit;
			}
		}

	}
	/**
	 * Main function to preparing all table and show in front end.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function prepare_items() {
		if ( wp_verify_nonce( isset( $_POST['search_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['search_nonce'] ) ) : '' ) ) {
			$search_item = isset( $_POST['s'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['s'] ) ) ) : '';
		} else {
			$search_item = '';
		}
		$orderby            = isset( $_GET['orderby'] ) ? trim( sanitize_key( wp_unslash( $_GET['orderby'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$order              = isset( $_GET['order'] ) ? trim( sanitize_key( wp_unslash( $_GET['order'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$mwb_comment_status = isset( $_GET['comment_status'] ) ? trim( sanitize_key( wp_unslash( $_GET['comment_status'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing
		$mwb_all_data = $this->mwb_review_data( $orderby, $order, $search_item, $mwb_comment_status );

		$per_page     = 10;
		$current_page = $this->get_pagenum();
		$total_data   = count( $mwb_all_data );
		$this->set_pagination_args(
			array(
				'total_items' => $total_data,
				'per_page'    => $per_page,
			)
		);
		$this->items = array_slice( $mwb_all_data, ( ( $current_page - 1 ) * $per_page ), $per_page );
		// callback to get columns.
		$columns = $this->get_columns();
		// callback to get hidden columns.
		$hidden = $this->get_hidden_columns();
		// callback to get sortable columns.
		$sortable = $this->get_sortable_columns();
		$this->process_bulk_action();
		// all callback called to the header.
		$this->_column_headers = array( $columns, $hidden, $sortable, 'customer' );
	}
}

?>
