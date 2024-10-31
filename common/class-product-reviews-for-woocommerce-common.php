<?php
/**
 * The common functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/common
 */

/**
 * The common functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the common stylesheet and JavaScript.
 * namespace product_reviews_for_woocommerce_common.
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/common
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Product_Reviews_For_Woocommerce_Common {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function prfw_common_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . 'common', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'common/src/scss/product-reviews-for-woocommerce-common.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function prfw_common_enqueue_scripts() {
		wp_register_script( $this->plugin_name . 'common', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'common/src/js/product-reviews-for-woocommerce-common.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name . 'common', 'prfw_common_param', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name . 'common' );

	}

	/**
	 * Function name mwb_prfw_create_custom_question
	 * this function is used to create the custom question
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_create_custom_question() {
		check_ajax_referer( 'mwb_review_public', 'nonce' );
		$captcha_token = isset( $_POST['qstn_token'] ) ? sanitize_text_field( wp_unslash( $_POST['qstn_token'] ) ) : '';
		$check_enable = get_option( 'mwb_prfw_qna_approval_required', false );
		$enable_captcha_verification = get_option( 'mwb_prfw_enable_captcha', false );
		$captcha_secret_key          = get_option( 'mwb_prfw_captcha_secret_key', false );
		if ( $enable_captcha_verification && $captcha_secret_key ) {
			if ( isset( $captcha_token ) ) {
				$response = wp_remote_post(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $captcha_secret_key,
							'response' => $captcha_token,
							'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
						),
					)
				);
				$res      = json_decode( $response['body'], true );
				if ( ! ( true === $res['success'] ) ) {
					echo esc_html( 'error' );
					wp_die();
				} else {
					$approved     = 1;
					if ( $check_enable ) {
						$approved = 0;
					}
					$url              = get_site_url();
					$name             = isset( $_POST['name_val'] ) ? sanitize_text_field( wp_unslash( $_POST['name_val'] ) ) : '';
					$customer_user_id = get_current_user_id();
					$u_email          = isset( $_POST['email_val'] ) ? sanitize_text_field( wp_unslash( $_POST['email_val'] ) ) : '';
					$qstn_val         = isset( $_POST['qstn_val'] ) ? sanitize_text_field( wp_unslash( $_POST['qstn_val'] ) ) : '';
					$pid              = isset( $_POST['product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) : '';
					$comment_agent    = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
					$ip               = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

					if ( $name && $u_email && $pid ) {
						$commentdata = array(
							'comment_author'       => $name,
							'comment_author_email' => $u_email,
							'comment_author_url'   => $url,
							'user_id'              => $customer_user_id,
							'comment_content'      => $qstn_val,
							'comment_karma'        => 0,
							'comment_agent'        => $comment_agent,
							'comment_post_ID'      => $pid,
							'comment_author_IP'    => $ip,
							'comment_type'         => 'mwb_qa',
							'comment_approved'     => $approved,
						);
						$review_id   = wp_insert_comment( $commentdata );
					}
					echo esc_html( 'success' );
					wp_die();
				}
			}
		} else {

			$approved     = 1;
			if ( $check_enable ) {
				$approved = 0;
			}
			$url              = get_site_url();
			$name             = isset( $_POST['name_val'] ) ? sanitize_text_field( wp_unslash( $_POST['name_val'] ) ) : '';
			$customer_user_id = get_current_user_id();
			$u_email          = isset( $_POST['email_val'] ) ? sanitize_text_field( wp_unslash( $_POST['email_val'] ) ) : '';
			$qstn_val         = isset( $_POST['qstn_val'] ) ? sanitize_text_field( wp_unslash( $_POST['qstn_val'] ) ) : '';
			$pid              = isset( $_POST['product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) : '';
			$comment_agent    = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
			$ip               = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

			if ( $name && $u_email && $pid ) {
				$commentdata = array(
					'comment_author'       => $name,
					'comment_author_email' => $u_email,
					'comment_author_url'   => $url,
					'user_id'              => $customer_user_id,
					'comment_content'      => $qstn_val,
					'comment_karma'        => 0,
					'comment_agent'        => $comment_agent,
					'comment_post_ID'      => $pid,
					'comment_author_IP'    => $ip,
					'comment_type'         => 'mwb_qa',
					'comment_approved'     => $approved,
				);
				$review_id   = wp_insert_comment( $commentdata );
			}

			echo esc_html( 'success' );
			wp_die();
		}
	}
	/**
	 * Function name mwb_prfw_reply_qa
	 * this function is used to reply the answer
	 *
	 * @return void
	 */
	public function mwb_prfw_reply_qa() {
		check_ajax_referer( 'mwb_review_public', 'nonce' );
		$answer_token = isset( $_POST['answer_token'] ) ? sanitize_text_field( wp_unslash( $_POST['answer_token'] ) ) : '';

		$check_enable = get_option( 'mwb_prfw_qna_approval_required', false );
		$enable_captcha_verification = get_option( 'mwb_prfw_enable_captcha', false );
		$captcha_secret_key          = get_option( 'mwb_prfw_captcha_secret_key', false );
		if ( $enable_captcha_verification && $captcha_secret_key ) {
			if ( isset( $answer_token ) ) {
				$response = wp_remote_post(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $captcha_secret_key,
							'response' => $answer_token,
							'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
						),
					)
				);
				$res      = json_decode( $response['body'], true );
				if ( ! ( true === $res['success'] ) ) {
					echo esc_html( 'error' );
					wp_die();
				} else {
					$url          = get_site_url();
					$check_enable = get_option( 'mwb_prfw_qna_approval_required', false );
					$approved     = 1;
					if ( $check_enable ) {
						$approved = 0;
					}
					$customer_user_id = get_current_user_id();
					$name             = isset( $_POST['name_val'] ) ? sanitize_text_field( wp_unslash( $_POST['name_val'] ) ) : '';
					$email_val        = isset( $_POST['email_val'] ) ? sanitize_text_field( wp_unslash( $_POST['email_val'] ) ) : '';
					$reply_qstn_val   = isset( $_POST['reply_qstn_val'] ) ? sanitize_text_field( wp_unslash( $_POST['reply_qstn_val'] ) ) : '';
					$comment_id       = isset( $_POST['comment_id'] ) ? sanitize_text_field( wp_unslash( $_POST['comment_id'] ) ) : '';
					$product_id       = isset( $_POST['product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) : '';
					$comment_agent    = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
					$ip               = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
					if ( $name && $email_val && $comment_id && $product_id ) {
						$commentdata = array(
							'comment_author'       => $name,
							'comment_author_email' => $email_val,
							'comment_author_url'   => $url,
							'user_id'              => $customer_user_id,
							'comment_content'      => $reply_qstn_val,
							'comment_agent'        => $comment_agent,
							'comment_post_ID'      => $product_id,
							'comment_author_IP'    => $ip,
							'comment_parent'       => $comment_id,
							'comment_approved'     => $approved,
							'comment_type'         => 'mwb_qa',
						);
						$reply_comment = wp_insert_comment( $commentdata );
					}
					echo esc_html( 'success' );
					wp_die();
				}
			}
		} else {
			$url          = get_site_url();
			$check_enable = get_option( 'mwb_prfw_qna_approval_required', false );
			$approved     = 1;
			if ( $check_enable ) {
				$approved = 0;
			}
			$customer_user_id = get_current_user_id();
			$name             = isset( $_POST['name_val'] ) ? sanitize_text_field( wp_unslash( $_POST['name_val'] ) ) : '';
			$email_val        = isset( $_POST['email_val'] ) ? sanitize_text_field( wp_unslash( $_POST['email_val'] ) ) : '';
			$reply_qstn_val   = isset( $_POST['reply_qstn_val'] ) ? sanitize_text_field( wp_unslash( $_POST['reply_qstn_val'] ) ) : '';
			$comment_id       = isset( $_POST['comment_id'] ) ? sanitize_text_field( wp_unslash( $_POST['comment_id'] ) ) : '';
			$product_id       = isset( $_POST['product_id'] ) ? sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) : '';
			$comment_agent    = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
			$ip               = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
			if ( $name && $email_val && $comment_id && $product_id ) {
				$commentdata = array(
					'comment_author'       => $name,
					'comment_author_email' => $email_val,
					'comment_author_url'   => $url,
					'user_id'              => $customer_user_id,
					'comment_content'      => $reply_qstn_val,
					'comment_agent'        => $comment_agent,
					'comment_post_ID'      => $product_id,
					'comment_author_IP'    => $ip,
					'comment_parent'       => $comment_id,
					'comment_approved'     => $approved,
					'comment_type'         => 'mwb_qa',
				);
				$reply_comment = wp_insert_comment( $commentdata );
				echo esc_html( 'success' );
					wp_die();
			}
		}
	}
	/**
	 * Function name mwb_prfw_review_voting
	 * this function wil save values in db while submitting review
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_review_voting() {
		global $wpdb;
		check_ajax_referer( 'mwb_review_public', 'nonce' );
		$comment_id  = isset( $_POST['comment_id'] ) ? sanitize_text_field( wp_unslash( $_POST['comment_id'] ) ) : '';
		$vote_value  = isset( $_POST['vote_val'] ) ? sanitize_text_field( wp_unslash( $_POST['vote_val'] ) ) : '';
		$ip          = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$review_data = $wpdb->get_results( $wpdb->prepare( ' SELECT vote_value FROM ' . $wpdb->prefix . 'mwb_review_vote where comment_id = %s AND ip_address = %s', $comment_id, $ip ) );
		if ( ! empty( $review_data ) ) {
			$wpdb->update(
				$wpdb->prefix . 'mwb_review_vote',
				array(
					'vote_value'   => $vote_value,
				),
				array(
					'ip_address' => $ip,
					'comment_id'  => $comment_id,
				)
			);
			$comment_count = count( $review_data );
			update_comment_meta( $comment_id, 'mwb_prfw_review_vote_count', $comment_count );
		} else {
			$wpdb->insert(
				$wpdb->prefix . 'mwb_review_vote',
				array(
					'vote_value'   => $vote_value,
					'ip_address' => $ip,
					'comment_id'  => $comment_id,
				)
			);
		}
		$review_data_yes = $wpdb->get_results( $wpdb->prepare( ' SELECT * FROM ' . $wpdb->prefix . "mwb_review_vote where vote_value = 'yes' AND comment_id = %s", $comment_id ) );
		$mwb_positive_count = 0;
		if ( ! empty( $review_data_yes ) ) {
			$mwb_positive_count = count( $review_data_yes );
		}
		update_comment_meta( $comment_id, 'mwb_prfw_positive_vote_count', $mwb_positive_count );

		$review_data_no = $wpdb->get_results( $wpdb->prepare( ' SELECT * FROM ' . $wpdb->prefix . "mwb_review_vote where vote_value = 'no' AND comment_id = %s", $comment_id ) );
		$mwb_negative_count = 0;
		if ( ! empty( $review_data_no ) ) {
			$mwb_negative_count = count( $review_data_no );
		}
		update_comment_meta( $comment_id, 'mwb_prfw_negative_vote_count', $mwb_negative_count );

		$vote_data = array( $mwb_positive_count, $mwb_negative_count );

		wp_send_json( $vote_data );

		wp_die();
	}
	/**
	 * Function name mwb_prfw_create_shortcode_display_review
	 * this funciton is used to create_shortcode
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_create_shortcode_display_review() {
		add_shortcode( 'MWB_SHOW_REVIEW_GRID', array( $this, 'mwb_prfw_display_grid_view' ) );
		add_shortcode( 'MWB_SHOW_REVIEW_LIST', array( $this, 'mwb_prfw_display_list_view' ) );
		add_shortcode( 'MWB_SHOW_REVIEW_SLIDER', array( $this, 'mwb_prfw_display_slider_view' ) );
	}
	/**
	 * Function name mwb_prfw_display_grid_view
	 * this function is used to show grid view reviews
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_display_grid_view() {
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'common/partials/product-reviews-for-woocommerce-common-grid-view.php';
	}
	/**
	 * Function name mwb_prfw_display_list_view
	 * this function is used to show list view reviews
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_display_list_view() {
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'common/partials/product-reviews-for-woocommerce-common-list-view.php';
	}
	/**
	 * Function name mwb_prfw_display_slider_view
	 * this function is used to show grid view reviews
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_display_slider_view() {
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'common/partials/product-reviews-for-woocommerce-common-slider-view.php';
	}
	/**
	 * Function name  Smwb_prfw_upload_images
	 * this function is used to upload images.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_upload_images() {
		check_ajax_referer( 'mwb_review_public', 'nonce' );

		if ( isset( $_FILES['mwb_review_image']['name'] ) && isset( $_FILES['mwb_review_image']['tmp_name'] ) ) {
			if ( is_array( $_FILES['mwb_review_image']['name'] ) ) {
				$file_len      = count( $_FILES['mwb_review_image']['name'] );
				$file_name_arr = array();
				for ( $i = 0; $i < $file_len; $i++ ) {
					$file_name_to_upload = isset( $_FILES['mwb_review_image']['name'][ $i ] ) ? wp_kses_post( $_FILES['mwb_review_image']['name'][ $i ] ) : '';
					$file_to_upload      = isset( $_FILES['mwb_review_image']['tmp_name'][ $i ] ) ? wp_kses_post( $_FILES['mwb_review_image']['tmp_name'][ $i ] ) : '';
					$upload_dir          = wp_upload_dir();
					$file_name_to_upload = str_replace( ' ', '_', trim( $file_name_to_upload ) );
					$file_to_upload      = str_replace( ' ', '_', trim( $file_to_upload ) );
					$upload_basedir      = $upload_dir['basedir'] . '/mwb_review_images/';
					if ( ! file_exists( $upload_basedir ) ) {
						wp_mkdir_p( $upload_basedir );
					}
					$target_file     = $upload_basedir . basename( $file_name_to_upload );
					$image_file_type = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );
					if ( ! file_exists( $target_file ) ) {
						move_uploaded_file( $file_to_upload, $target_file );
					}
						$upload_baseurl = $upload_dir['baseurl'] . '/mwb_review_images/';
						$mwb_image_url  = $upload_baseurl . $file_name_to_upload;
						$mwb_image_path = $upload_basedir . $file_name_to_upload;
					if ( file_exists( $mwb_image_path ) ) {
						$file_name_arr[] = $mwb_image_url;
					}
				}
			}
			echo wp_json_encode( $file_name_arr );
		}
		wp_die();
	}
	/**
	 * Function name mwb_prfw_set_type_wp_mail.
	 * this fucntion is used to set the mail type to html.
	 *
	 * @since             1.0.0
	 * @return array
	 */
	public function mwb_prfw_set_type_wp_mail() {
		return 'text/html';
	}

	/**
	 * Function name mwb_prfw_submit_ajax_review_form
	 * this function is used to submit image using ajax
	 *
	 * @since     1.0.0
	 * @return void
	 */
	public function mwb_prfw_submit_ajax_review_form() {
		check_ajax_referer( 'mwb_review_public', 'nonce' );
		$data = isset( $_POST['formdata'] ) ? map_deep( wp_unslash( $_POST['formdata'] ), 'sanitize_text_field' ) : '';

		$new_arr = array();
		foreach ( $data as $pairs ) {
			$new_arr[ $pairs['name'] ] = $pairs['value'];
		}

		$enable_captcha_verification = get_option( 'mwb_prfw_enable_captcha', false );
		$captcha_secret_key          = get_option( 'mwb_prfw_captcha_secret_key', false );
		if ( $enable_captcha_verification && $captcha_secret_key ) {
			if ( isset( $new_arr['token'] ) ) {
				$response = wp_remote_post(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $captcha_secret_key,
							'response' => $new_arr['token'],
							'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
						),
					)
				);
				$res      = json_decode( $response['body'], true );
				if ( ! ( true === $res['success'] ) ) {
					echo esc_html( 'error' );
					wp_die();
				} else {
					$this->mwb_prfw_create_ajax_review( $new_arr );
				}
			}
		} else {
			$this->mwb_prfw_create_ajax_review( $new_arr );
		}
	}

	/**
	 * Function name mwb_prfw_create_ajax_review
	 * this function is used to create ajax review
	 *
	 * @param array $new_arr contains data.
	 * @return void
	 */
	public function mwb_prfw_create_ajax_review( $new_arr ) {

		$url       = get_site_url();
		$email_val = isset( $new_arr['email'] ) ? sanitize_text_field( wp_unslash( $new_arr['email'] ) ) : '';
		$author    = isset( $new_arr['author'] ) ? sanitize_text_field( wp_unslash( $new_arr['author'] ) ) : '';
		$u_id      = 0;
		if ( is_user_logged_in() ) {

			$current_user = wp_get_current_user();
			$email_val    = $current_user->user_email;
			$author       = $current_user->user_login;
			$u_id         = $current_user->ID;
		}
		$comment_content = isset( $new_arr['comment'] ) ? sanitize_text_field( wp_unslash( $new_arr['comment'] ) ) : '';
		$rating          = isset( $new_arr['rating'] ) ? sanitize_text_field( wp_unslash( $new_arr['rating'] ) ) : '';
		$product_id      = isset( $new_arr['comment_post_ID'] ) ? sanitize_text_field( wp_unslash( $new_arr['comment_post_ID'] ) ) : '';
		$comment_agent   = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
		$ip              = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$mwb_title       = isset( $new_arr['mwb_title_product_review'] ) ? sanitize_text_field( wp_unslash( $new_arr['mwb_title_product_review'] ) ) : '';
		$image_url       = isset( $new_arr['mwb_prfw_ajax_file_url'] ) ? map_deep( wp_unslash( json_decode( wp_unslash( $new_arr['mwb_prfw_ajax_file_url'] ) ) ), 'sanitize_text_field' ) : '';

		self::mwb_prfw_clear_transients( $product_id );
		$approve                  = 1;
		$mwb_prfw_review_approval = get_option( 'mwb_prfw_approval_required' );
		if ( $mwb_prfw_review_approval ) {
			$approve = 0;
		}

		$commentdata = array(
			'comment_author'       => $author,
			'comment_author_email' => $email_val,
			'comment_author_url'   => $url,
			'user_id'              => $u_id,
			'comment_content'      => $comment_content,
			'comment_agent'        => $comment_agent,
			'comment_post_ID'      => $product_id,
			'comment_author_IP'    => $ip,
			'comment_approved'     => $approve,
			'comment_type'         => 'review',
		);
		$comment_done = wp_insert_comment( $commentdata );
		if ( $comment_done ) {
			delete_transient( 'wc_count_comments' );
			update_comment_meta( $comment_done, 'rating', $rating );
			self::mwb_prfw_clear_transients( $product_id );
			update_comment_meta( $comment_done, 'mwb_add_review_title', $mwb_title );
			update_comment_meta( $comment_done, 'mwb_review_image', $image_url );
			$dynamic_fields = get_option( 'mwb_prfw_dynamic_fields_details', array() );
				$review_arr = array();
			foreach ( $dynamic_fields as $k => $v ) {
				if ( '' !== $v ) {
					$v    = str_replace( ' ', '_', trim( $v ) );
					$data = array_key_exists( $v, $new_arr ) ? $new_arr[ $v ] : '';
					if ( '' !== $data ) {

						$review_arr[ $v ] = $data;
					}
				}
			}
			update_comment_meta( $comment_done, 'mwb_prfw_dynamic_review_features', $review_arr );
			do_action( 'mwb_prfw_submit_attr_ajax', $comment_done, $new_arr );
			echo 'success';
			wp_die();
		}
		echo 'error';
		wp_die();
	}

	/**
	 * Ensure product average rating and review count is kept up to date.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function mwb_prfw_clear_transients( $post_id ) {
		if ( 'product' === get_post_type( $post_id ) ) {
			$product = wc_get_product( $post_id );
			$product->set_rating_counts( self::mwb_prfw_get_rating_counts_for_product( $product ) );
			$product->set_average_rating( self::mwb_prfw_get_average_rating_for_product( $product ) );
			$product->set_review_count( self::mwb_prfw_get_review_count_for_product( $product ) );
			$product->save();
		}
	}

	/**
	 * Get product rating for a product. Please note this is not cached.
	 *
	 * @since 3.0.0
	 * @param WC_Product $product Product instance.
	 * @return float
	 */
	public static function mwb_prfw_get_average_rating_for_product( &$product ) {
		global $wpdb;

		$count = $product->get_rating_count();

		if ( $count ) {
			$ratings = $wpdb->get_var(
				$wpdb->prepare(
					"
				SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value > 0
					",
					$product->get_id()
				)
			);
			$average = number_format( $ratings / $count, 2, '.', '' );
		} else {
			$average = 0;
		}

		return $average;
	}
	/**
	 * Get product rating count for a product. Please note this is not cached.
	 *
	 * @since 3.0.0
	 * @param WC_Product $product Product instance.
	 * @return int[]
	 */
	public static function mwb_prfw_get_rating_counts_for_product( &$product ) {
		global $wpdb;

		$counts     = array();
		$raw_counts = $wpdb->get_results(
			$wpdb->prepare(
				"
			SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
			AND meta_value > 0
			GROUP BY meta_value
				",
				$product->get_id()
			)
		);

		foreach ( $raw_counts as $count ) {
			$counts[ $count->meta_value ] = absint( $count->meta_value_count ); // WPCS: slow query ok.
		}

		return $counts;
	}

	/**
	 * Get product review count for a product (not replies). Please note this is not cached.
	 *
	 * @since 3.0.0
	 * @param WC_Product $product Product instance.
	 * @return int
	 */
	public static function mwb_prfw_get_review_count_for_product( &$product ) {
		$counts = self::mwb_prfw_get_review_counts_for_product_ids( array( $product->get_id() ) );

		return $counts[ $product->get_id() ];
	}
	/**
	 * Utility function for getting review counts for multiple products in one query. This is not cached.
	 *
	 * @since 5.0.0
	 *
	 * @param array $product_ids Array of product IDs.
	 *
	 * @return array
	 */
	public static function mwb_prfw_get_review_counts_for_product_ids( $product_ids ) {
		global $wpdb;

		if ( empty( $product_ids ) ) {
			return array();
		}

		$product_id_string_placeholder = substr( str_repeat( ',%s', count( $product_ids ) ), 1 );

		$review_counts = $wpdb->get_results(
			// phpcs:disable WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- Ignored for allowing interpolation in IN query.
			$wpdb->prepare(
				"
					SELECT comment_post_ID as product_id, COUNT( comment_post_ID ) as review_count
					FROM $wpdb->comments
					WHERE
						comment_parent = 0
						AND comment_post_ID IN ( $product_id_string_placeholder )
						AND comment_approved = '1'
						AND comment_type in ( 'review', '', 'comment' )
					GROUP BY product_id
				",
				$product_ids
			),
			// phpcs:enable WordPress.DB.PreparedSQL.InterpolatedNotPrepared.
			ARRAY_A
		);

		// Convert to key value pairs.
		$counts = array_replace( array_fill_keys( $product_ids, 0 ), array_column( $review_counts, 'review_count', 'product_id' ) );

		return $counts;
	}


	/**
	 * Function name mwb_third_abdn_daily_cart_cron_schedule.
	 * this fucntion will schedule second cron for sending second mail daily.
	 *
	 * @return void
	 * @since             1.0.0
	 */
	public function mwb_prfw_schedule_daily_review_cron() {
		$cur_stamp = wp_next_scheduled( 'mwb_prfw_daily_cron_schedule' );
		if ( ! $cur_stamp ) {
			wp_schedule_event( time(), 'daily', 'mwb_prfw_daily_cron_schedule' );
		}
	}
	/**
	 * Function name mwb_third_abdn_cron_callback_daily.
	 * this fucntion is call back of second cron
	 *
	 * @since             1.0.0
	 * @return void
	 */
	public function mwb_prfw_daily_cron_callback() {
		$review_reminder = get_option( 'mwb_prfw_enable_review_reminder' );
		if ( $review_reminder ) {
			$this->mwb_prfw_select_order_data();
		}
	}
	/**
	 * Function name mwb_prfw_select_order_data
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_select_order_data() {

		if ( ! function_exists( 'wc_get_orders' ) ) {
			require_once WP_PLUGIN_DIR . '/woocommerce/includes/wc-order-functions.php';
		}
		$get_delay = get_option( 'mwb_prfw_reminder_after_days' );
		if ( $get_delay ) {

			$date_days_earlier = gmdate( 'Y-m-d', strtotime( '-' . $get_delay . 'day' ) );
			$args = array(
				'date_before' => $date_days_earlier,
				'date_after'  => $date_days_earlier,
				'status'      => 'completed',
			);

			$result = wc_get_orders( $args );

			$mwb_particular_mail   = get_option( 'mwb_prfw_enable_reminder_each_product' );
			$mwb_prfw_mail_subject = get_option( 'mwb_prfw_reminder_subject' );
			$mwb_prfw_mail         = get_option( 'mwb_prfw_reminder_email' );
			foreach ( $result as $results ) {
				$html     = '';
				$order_id = $results->get_id();
				$fname    = $results->get_billing_first_name();
				$lname    = $results->get_billing_last_name();

				$fullname = $fname . ' ' . $lname;

				$email = $results->get_billing_email();
				foreach ( $results->get_items() as $item_id => $item ) {
					$product_id = $item->get_product_id();
					$name       = $item->get_name();
					$html       .= '<p><a href= "' . get_permalink( $product_id ) . '">' . $name . '</a></p>';
					$single      = '<p><a href= "' . get_permalink( $product_id ) . '">' . $name . '</a></p>';

					if ( $mwb_particular_mail ) {
						$mwb_prfw_mail_content = $mwb_prfw_mail;
						if ( strpos( $mwb_prfw_mail_content, '{customer}' ) ) {

							$mwb_prfw_mail_content = str_replace( '{customer}', $fullname, $mwb_prfw_mail_content );
						} else {
							$mwb_prfw_mail_content = $mwb_prfw_mail_content;
						}
						if ( strpos( $mwb_prfw_mail_content, '{product}' ) ) {

							$mwb_prfw_mail_content = str_replace( '{product}', $single, $mwb_prfw_mail_content );
						} else {
								$mwb_prfw_mail_content = $mwb_prfw_mail_content;
						}
						$sent_revimder_each = wp_mail( $email, $mwb_prfw_mail_subject, $mwb_prfw_mail_content );
						if ( $sent_revimder_each ) {
							update_post_meta( $order_id, 'mwb_prfw_reminder_sent', 1 );
							update_post_meta( $order_id, 'mwb_prfw_review_done', 'false' );
						}
					}
				}
				if ( ! $mwb_particular_mail ) {
					$mwb_prfw_mail_content = $mwb_prfw_mail;
					if ( strpos( $mwb_prfw_mail_content, '{customer}' ) ) {

						$mwb_prfw_mail_content = str_replace( '{customer}', $fullname, $mwb_prfw_mail_content );
					} else {
						$mwb_prfw_mail_content = $mwb_prfw_mail_content;
					}

					if ( strpos( $mwb_prfw_mail_content, '{product}' ) ) {

						$mwb_prfw_mail_content = str_replace( '{product}', $html, $mwb_prfw_mail_content );
					} else {
							$mwb_prfw_mail_content = $mwb_prfw_mail_content;
					}
					$check_mail_reminder_meta_val = get_post_meta( $order_id, 'mwb_prfw_reminder_sent', true );
					if ( $check_mail_reminder_meta_val ) {
							continue;
					}
					$sent_revimder = wp_mail( $email, $mwb_prfw_mail_subject, $mwb_prfw_mail_content );
					if ( $sent_revimder ) {
						update_post_meta( $order_id, 'mwb_prfw_reminder_sent', 1 );
						update_post_meta( $order_id, 'mwb_prfw_review_done', 'false' );

					}
				}
			}
		}
	}

	/**
	 * Function name mwb_prfw_review_checking_cron
	 * this fucntion will schedule a cron daily to check review.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_review_checking_cron() {
		$cur_stamp = wp_next_scheduled( 'mwb_prfw_review_checking_cron_daily' );
		if ( ! $cur_stamp ) {
			wp_schedule_event( time(), 'daily', 'mwb_prfw_review_checking_cron_daily' );
		}
	}
	/**
	 * Function name mwb_prfw_schedule_check_review_daily
	 * this function is used to check daily review
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_schedule_check_review_daily() {
		$args = array(

			'type__in'   => 'review',
			'status'     => 'hold,approve',
			'date_query' => array(
				'after'     => 'yesterday',
				'before'    => 'today',
				'inclusive' => true,
			),

		);
		$comments = get_comments( $args );
		if ( $comments ) {

			foreach ( $comments as $comment ) {
				$user_id         = $comment->user_id;
				$user            = get_userdata( $user_id );
				$name            = $user->user_login;
				$email           = $user->user_email;
				$customer_orders = get_posts(
					array(
						'meta_key'    => '_customer_user',
						'meta_value'  => $user_id,
						'post_type'   => 'shop_order',
						'post_status' => 'wc-completed',
						'numberposts' => -1,
					)
				);
			}
		}
		if ( $customer_orders ) {
			foreach ( $customer_orders as $k => $value ) {
				$order_id = $value->ID;

				$get_meta_val               = get_post_meta( $order_id, 'mwb_prfw_review_done', true );
				$get_user_meta_coupon       = get_user_meta( $user_id, 'mwb_prfw_coupon_reminder_sent', true );
				$get_user_meta_coupon_allow = get_option( 'mwb_prfw_enable_review_discount' );
				$coupon_mail_subject        = get_option( 'mwb_prfw_coupon_mail_subject' );
				$coupon_mail_content        = get_option( 'mwb_prfw_reminder_email_coupon_content' );

				if ( strpos( $coupon_mail_content, '{customer}' ) ) {

					$coupon_mail_content = str_replace( '{customer}', $name, $coupon_mail_content );
				} else {
					$coupon_mail_content = $coupon_mail_content;
				}
				if ( 'false' === $get_meta_val ) {
					update_post_meta( $order_id, 'mwb_prfw_review_done', 'true' );
					if ( $get_user_meta_coupon_allow ) {

						if ( ! $get_user_meta_coupon ) {

							$mwb_prfw_coupon_discount = get_option( 'mwb_prfw_coupon_discount' );
							$mwb_prfw_coupon_expiry   = get_option( 'mwb_prfw_coupon_expiry' );
							$mwb_prfw_coupon_prefix   = get_option( 'mwb_prfw_coupon_prefix' );
							$rand                     = substr( md5( microtime() ), wp_rand( 0, 26 ), 5 );
							$coupon_expiry_time       = time() + ( $mwb_prfw_coupon_expiry * 60 * 60 * 24 );
							$mwb_prfw_coupon_name     = $mwb_prfw_coupon_prefix . $rand;

							/**
							* Create a coupon for sending in email.
							*/
							$coupon_code   = $mwb_prfw_coupon_name; // Code.
							$amount        = $mwb_prfw_coupon_discount; // Amount.
							$discount_type = 'percent'; // Type: percent.

							$coupon = array(
								'post_title'   => $coupon_code,
								'post_content' => '',
								'post_status'  => 'publish',
								'post_author'  => 1,
								'post_type'    => 'shop_coupon',
							);
							$new_coupon_id = wp_insert_post( $coupon );
							update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
							update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
							$get_limit_coupon = get_option( 'mwb_prfw_review_disc_frequency' );
							if ( $get_limit_coupon ) {
								update_post_meta( $new_coupon_id, 'usage_limit', 1 );
							}
							update_post_meta( $new_coupon_id, 'individual_use', 'no' );
							update_post_meta( $new_coupon_id, 'expiry_date', $coupon_expiry_time );
							update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
							update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
							$db_code_coupon_mwb = wc_get_coupon_code_by_id( $new_coupon_id );
							$check_mail         = wp_mail( $email, $coupon_mail_subject, $coupon_mail_content . ' <strong>' . $db_code_coupon_mwb . '</strong>' );
							if ( $check_mail ) {
								update_user_meta( $user_id, 'mwb_prfw_coupon_reminder_sent', 'true' );
							}
						}
					}
				}
			}
		}
	}
}
