<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/public
 */

use function PHPSTORM_META\type;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 * namespace product_reviews_for_woocommerce_public.
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/public
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Product_Reviews_For_Woocommerce_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function prfw_public_enqueue_styles() {

		wp_enqueue_style( 'slick-css', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/src/slick/slick.css', array(), $this->version, false );
		wp_enqueue_style( 'slick-min-css', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/src/slick/slick_theme.min.css', array(), $this->version, false );

		wp_enqueue_style( $this->plugin_name, PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/src/scss/product-reviews-for-woocommerce-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );

		wp_enqueue_style( $this->plugin_name . 'custom-css', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/css/mwb-prfw-custom.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function prfw_public_enqueue_scripts() {

		wp_enqueue_script( 'slick-js', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/src/slick/slick.min.js', array( 'jquery' ), $this->version, false );

		$mwb_add = false;
		if ( is_product() ) {
			$mwb_add = true;
		}
		$popup_show = get_option( 'mwb_prfw_show_form_on' );
		$show_from_modal = false;
		if ( 'popup' === $popup_show ) {
			$show_from_modal = true;
		}
		$allow_ajax = get_option( 'mwb_prfw_form_submit_ajax' );
		$allow_ajax_submit = false;
		if ( $allow_ajax ) {
			$allow_ajax_submit = true;
		}
		$name_validate = __( 'Only String is allowed', 'product-reviews-for-woocommerce' );
		$email_validate = __( 'Please Enter Email In Valid Format', 'product-reviews-for-woocommerce' );
		$mwb_prfw_qstn_submit_msg = __( 'Thank You Your Question has Been submitted', 'product-reviews-for-woocommerce' );
		$mwb_prfw_qstn_submit_html = '<div class="mwb_prfw-question_box"><svg class="mwb-c" width="131" height="118" viewBox="0 0 131 118" fill="none" xmlns="http://www.w3.org/2000/svg">
			<circle class="mwb-c-a" cx="50" cy="68" r="50" fill="#2196F3"/>
			<path d="M37.0889 80.0614L16.0529 68.7587C15.0768 68.2342 14.099 69.4507 14.8211 70.2912L36.757 95.8247C38.9455 98.3721 42.9731 98.0805 44.7719 95.2446L77.2465 44.046C77.9035 43.0102 76.4779 41.9296 75.6582 42.842L43.1748 78.9985C41.6339 80.7137 39.12 81.1528 37.0889 80.0614Z" fill="white"/>
			<circle class="mwb-c-1" cx="92" cy="24" r="4" stroke="#FF9A9A" stroke-width="2"/>
			<circle class="mwb-c-2" cx="93.5" cy="6.5" r="5" stroke="#FFD79A" stroke-width="3"/>
			<circle class="mwb-c-3" cx="118" cy="17" r="11" stroke="#9AFFC2" stroke-width="4"/>
			<circle class="mwb-c-4" cx="107.5" cy="41.5" r="6" stroke="#F79AFF" stroke-width="3"/>
			</svg>' . $mwb_prfw_qstn_submit_msg . '</div>';
		$mwb_prfw_answer_submit_msg = __( 'Thank You Your Answer has Been submitted', 'product-reviews-for-woocommerce' );
		$mwb_prfw_answer_submit_html = '<div class="mwb_prfw-answer_box"><svg class="mwb-c" width="131" height="118" viewBox="0 0 131 118" fill="none" xmlns="http://www.w3.org/2000/svg">
			<circle class="mwb-c-a" cx="50" cy="68" r="50" fill="#2196F3"/>
			<path d="M37.0889 80.0614L16.0529 68.7587C15.0768 68.2342 14.099 69.4507 14.8211 70.2912L36.757 95.8247C38.9455 98.3721 42.9731 98.0805 44.7719 95.2446L77.2465 44.046C77.9035 43.0102 76.4779 41.9296 75.6582 42.842L43.1748 78.9985C41.6339 80.7137 39.12 81.1528 37.0889 80.0614Z" fill="white"/>
			<circle class="mwb-c-1" cx="92" cy="24" r="4" stroke="#FF9A9A" stroke-width="2"/>
			<circle class="mwb-c-2" cx="93.5" cy="6.5" r="5" stroke="#FFD79A" stroke-width="3"/>
			<circle class="mwb-c-3" cx="118" cy="17" r="11" stroke="#9AFFC2" stroke-width="4"/>
			<circle class="mwb-c-4" cx="107.5" cy="41.5" r="6" stroke="#F79AFF" stroke-width="3"/>
			</svg>' . $mwb_prfw_answer_submit_msg . '</div>';
		wp_register_script( $this->plugin_name, PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/product-reviews-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'prfw_public_param',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'mwb_review_public' ),
				'mwb_add_form' => $mwb_add,
				'mwb_review_modal' => $show_from_modal,
				'allow_ajax'       => $allow_ajax_submit,
				'review_submit_ajax_msg' => __( 'Thank You, Your review has Been submitted', 'product-reviews-for-woocommerce' ),
				'mwb_prfw_qstn_submit_text' => $mwb_prfw_qstn_submit_html,
				'mwb_prfw_ans_submit_text' => $mwb_prfw_answer_submit_html,
				'mwb_prfw_email_validate' => $email_validate,
				'mwb_prfw_name_validate' => $name_validate,
				'mwb_prfw_image_vaildation' => __( 'Please upload Files less than 5', 'product-reviews-for-woocommerce' ),
				'mwb_prfw_vaildation_captcha_text' => __( 'Captcha not verified Please Refresh and try again later!!', 'product-reviews-for-woocommerce' ),
				'mwb_prfw_comment_text_require' => __( 'Please Enter Review text', 'product-reviews-for-woocommerce' ),
				'mwb_prfw_min_image_size' => __( 'File too small, please select a file greater than 50kb', 'product-reviews-for-woocommerce' ),
				'mwb_prfw_max_image_size' => __( 'File too Big, please select a file less than 4 mb', 'product-reviews-for-woocommerce' ),
				'api_site_key' => get_option( 'mwb_prfw_captcha_site_key', false ),
				'captcha_enable' => get_option( 'mwb_prfw_enable_captcha', false ),
			)
		);
		wp_enqueue_script( $this->plugin_name );

		wp_enqueue_script( 'jquery-ui-dialog' );

		wp_enqueue_script( 'mwb_script_js_review', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/js/mwb-prfw-custom.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			'mwb_script_js_review',
			'prfw_custpm_js',
			array(
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			)
		);

		wp_enqueue_script( $this->plugin_name . 'public-sweet-alert', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . '/package/lib/sweet-alert.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Function name mwb_prfw_add_cutom_review_field
	 * this function is used to add custom field to the review section
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mwb_prfw_add_cutom_review_field() {
		$captcha_site_key = get_option( 'mwb_prfw_captcha_site_key', false );
		$enable_captcha_verification = get_option( 'mwb_prfw_enable_captcha', false );
		if ( $enable_captcha_verification ) {
			wp_enqueue_script( 'mwb_google_recaptcha-v3', 'https://www.google.com/recaptcha/api.js?render=' . $captcha_site_key, array(), '3.0.0', true );
			wp_enqueue_script( 'mwb_google_captcha', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'public/src/js/product-reviews-for-woocommerce-captcha.js', array( 'jquery' ), $this->version, false );

			wp_localize_script(
				'mwb_google_captcha',
				'prfw_google_captcha',
				array(
					'ajaxurl'    => admin_url( 'admin-ajax.php' ),
					'api_site_key' => get_option( 'mwb_prfw_captcha_site_key', false ),
					'captcha_enable' => get_option( 'mwb_prfw_enable_captcha', false ),
				)
			);
		}
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/product-reviews-for-woocommerce-review-fields.php';
	}

	/**
	 * Function name mwb_prfw_captcha_verify
	 * this function is used to verify the captcha
	 *
	 * @param array $commentdata contains all comment data.
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_prfw_captcha_verify( $commentdata ) {

		$post_id = $commentdata['comment_post_ID'];
		$enable_captcha_verification = get_option( 'mwb_prfw_enable_captcha', false );
		$captcha_secret_key  = get_option( 'mwb_prfw_captcha_secret_key', false );
		if ( $enable_captcha_verification && $captcha_secret_key ) {
			if ( isset( $_POST['review_submit_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['review_submit_nonce'] ) ), 'review_submit_nonce' ) ) {
				if ( isset( $_POST['token'] ) ) {
					$response = wp_remote_post(
						'https://www.google.com/recaptcha/api/siteverify',
						array(
							'body' => array(
								'secret'   => $captcha_secret_key,
								'response' => sanitize_text_field( wp_unslash( $_POST['token'] ) ),
								'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
							),
						)
					);
					$post_id = $commentdata['comment_post_ID'];
					$res = json_decode( $response['body'], true );
					if ( ! ( true === $res['success'] ) ) {
						wp_die( esc_html__( 'Error:  You Are Not a Human!!!!', 'product-reviews-for-woocommerce' ) . '<a href="' . wp_kses_post( get_permalink( $post_id ) ) . '">' . esc_html__( '  Go Back', 'product-reviews-for-woocommerce' ) . '</a>' . esc_html__( 'and resubmit the Form', 'product-reviews-for-woocommerce' ) );

						return $commentdata;
					} else {
						return $commentdata;

					}
				}
			}
		} else {
			return $commentdata;
		}

	}

	/**
	 * Function name mwb_prfw_save_data_review
	 * this function is used to save custom data review
	 *
	 * @param int $comment_id current comment id.
	 * @return void
	 */
	public function mwb_prfw_save_data_review( $comment_id ) {
		if ( isset( $_POST['mwb_title_product_review'] ) ) {
			if ( isset( $_POST['review_submit_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['review_submit_nonce'] ) ), 'review_submit_nonce' ) ) {
				$prfw_title = isset( $_POST['mwb_title_product_review'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_title_product_review'] ) ) : '';

				$file_name_arr = isset( $_POST['mwb_prfw_ajax_file_url'] ) ? map_deep( wp_unslash( json_decode( map_deep( wp_unslash( $_POST['mwb_prfw_ajax_file_url'] ), 'sanitize_text_field' ) ) ), 'sanitize_text_field' ) : '';
				if ( $file_name_arr ) {

					update_comment_meta( $comment_id, 'mwb_review_image', $file_name_arr );
				}
				$mwb_prfw_review_approval = get_option( 'mwb_prfw_approval_required' );
				if ( $mwb_prfw_review_approval ) {
					$comment_update_arr = array(
						'comment_ID' => $comment_id,
						'comment_approved' => 0,
					);
					wp_update_comment( $comment_update_arr );
				}
					update_comment_meta( $comment_id, 'mwb_add_review_title', $prfw_title );
					$dynamic_fields = get_option( 'mwb_prfw_dynamic_fields_details', array() );
					$review_arr = array();
				foreach ( $dynamic_fields as $k => $v ) {
					if ( '' !== $v ) {
						$v                = str_replace( ' ', '_', trim( $v ) );
						$data  = array_key_exists( $v, $_POST ) ? map_deep( wp_unslash( $_POST[ $v ] ), 'sanitize_text_field' ) : '';
						if ( '' !== $data ) {

							$review_arr[ $v ] = $data;
						}
					}
				}
					update_comment_meta( $comment_id, 'mwb_prfw_dynamic_review_features', $review_arr );
					do_action( 'mwb_prfw_save_attr_feature', $comment_id, $_POST );
			}
		}
	}

	/**
	 * Function name mwb_prfw_add_qna_tab
	 * this function is used to create a new tab on product page
	 *
	 * @param array $tabs contains tabs.
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_prfw_add_qna_tab( $tabs ) {

		// 2 Adding new tabs and set the right order
		global $product;
		$product_id     = $product->get_id();
		$args           = array(
			'type__in' => 'mwb_qa',
			'parent'   => 0,
			'post_id'  => $product_id,
			'status'   => 'approve',
		);
		$comments_query = new WP_Comment_Query();
		$result = $comments_query->query( $args );
		if ( ! empty( $result ) ) {
			$count = '(' . count( $result ) . ')';
		} else {
			$count = '(' . 0 . ')';
		}
		$enable_qa = get_option( 'mwb_prfw_enable_qna' );
		if ( $enable_qa ) {

			$tabs['mwb_qa_tab'] = array(
				'title'    => __( 'Question and Answer', 'product-reviews-for-woocommerce' ) . $count,
				'priority' => 100,
				'callback' => array( $this, 'mwb_prfw_add_qa_tab_callback' ),
			);
		}
		return $tabs;

	}

	/**
	 * Function name mwb_prfw_add_qa_tab_callback
	 * this function is callback of adding new tab
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_add_qa_tab_callback() {
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/product-reviews-for-woocommerce-qna-callback.php';
	}

	/**
	 * Function name mwb_prfw_question_modal
	 * this function is used to open question modal
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_question_modal() {
		global $post;
		$pid = get_the_ID();
		if ( $pid ) {
			require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/product-reviews-for-woocommerce-qna-modal.php';
		}
	}

	/**
	 * Function name mwb_prfw_unset_qna
	 * this function is used to unset question and answer from review tab
	 *
	 * @param array $args arguments.
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_prfw_unset_qna( $args ) {
		$args['type'] = 'review';
		return $args;
	}

	/**
	 * Function name mwb_prfw_show_meta_values
	 * this function is used to show the meta values.
	 *
	 * @param object $comment current comment details.
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_show_meta_values( $comment ) {
		$comment_id = $comment->comment_ID;
		$prfw_title      = get_comment_meta( $comment_id, 'mwb_add_review_title', true );
		$dynamic_feature = get_comment_meta( $comment_id, 'mwb_prfw_dynamic_review_features', true );
		if ( $dynamic_feature ) {
			echo "<div class='mwb_prfw-main_review_extra'>";
			foreach ( $dynamic_feature as $key => $value ) {
				$v = str_replace( '_', ' ', trim( $key ) );
				echo '<span>' . esc_html( $v ) . '</span>';
				echo '<span>' . wp_kses_post( wc_get_rating_html( $value ) ) . '</span>';
			}
			echo '</div>';
		}
		if ( $prfw_title ) {
			echo "<div class='mwb_prfw-main_review_title'>" . esc_html( $prfw_title ) . '</div>';
		}
		$img = get_comment_meta( $comment_id, 'mwb_review_image', true );
		if ( $img ) {
			echo "<div class='mwb_prfw-main_review_img'>";
			foreach ( $img as $k => $value ) {
				$mwb_prfw_file_type_check = wp_check_filetype( $value )['ext'];
				if ( 'jpg' === $mwb_prfw_file_type_check || 'jpeg' === $mwb_prfw_file_type_check || 'png' === $mwb_prfw_file_type_check || 'svg' === $mwb_prfw_file_type_check || 'gif' === $mwb_prfw_file_type_check || 'tiff' === $mwb_prfw_file_type_check || 'bmp' === $mwb_prfw_file_type_check || 'raw' === $mwb_prfw_file_type_check || 'eps' === $mwb_prfw_file_type_check ) {
					echo "<img src='" . esc_url( $value ) . "' width='100px' height='100px' > ";
				} else {
					echo '<video width="150" controls ><source src=' . esc_url( $value ) . '></video>';
				}
			}
			echo '</div>';

		}
		do_action( 'mwb_prfw_show_feature_slider', $comment_id );

	}

	/**
	 * Function name mwb_prfw_get_review_voting
	 *
	 * @param object $comment contains comment details.
	 * @return void
	 */
	public function mwb_prfw_get_review_voting( $comment ) {
		global $wpdb;
		$comment_id = $comment->comment_ID;

		$mwb_positive_count = get_comment_meta( $comment_id, 'mwb_prfw_positive_vote_count', true );
		$mwb_negative_count = get_comment_meta( $comment_id, 'mwb_prfw_negative_vote_count', true );
		$allow_vote  = get_option( 'mwb_prfw_enable_review_voting', false );
		if ( $allow_vote ) {
			require PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/product-reviews-for-woocommerce-review-vote-html.php';
		}
	}

	/**
	 * Function name mwb_prfw_add_custom_button
	 *
	 * @param object $template object.
	 * @since 1.0.0
	 * @return object
	 */
	public function mwb_prfw_add_custom_button( $template ) {

		$check = get_option( 'woocommerce_review_rating_verification_required' );
		if ( 'no' === $check ) {
			$popup_show = get_option( 'mwb_prfw_show_form_on' );
			if ( 'popup' === $popup_show ) {
				require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/product-reviews-for-woocommerce-review-form-popup-button.php';
			}
		}
		return $template;
	}

	/**
	 * Funcrion name mwb_prfw_show_review_bar
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_show_review_bar() {
		global $product;
		if ( $product ) {
			$id = $product->get_id();
			$get_count = count(
				get_comments(
					array(
						'post_id' => get_the_ID(),
						'type'    => 'review',
					)
				)
			);
			$get_rating_count = get_post_meta( $id, '_wc_rating_count', true );
			$get_review_count   = get_post_meta( $id, '_wc_review_count', true );
			$rating_ccc = $product->get_rating_count();
			$get_rating_text = array(
				'5' => __( 'Perfect', 'product-reviews-for-woocommerce' ),
				'4' => __( 'Good', 'product-reviews-for-woocommerce' ),
				'3' => __( 'Average', 'product-reviews-for-woocommerce' ),
				'2' => __( 'Not that bad', 'product-reviews-for-woocommerce' ),
				'1' => __( 'Very poor', 'product-reviews-for-woocommerce' ),
			);
			require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'public/partials/product-reviews-for-woocommerce-review-bar-chart-html.php';

		}

	}

	/**
	 * Function name mwb_prfw_add_seo_field_to_json_ld
	 * this function is used to add seo fields to the product.
	 *
	 * @param array  $markup contains markup array.
	 * @param object $product contains product details.
	 * @since 1.0.2
	 * @return array
	 */
	public function mwb_prfw_add_seo_field_to_json_ld( $markup, $product ) {
		$product_id = $product->get_ID();
		$mwb_prfw_brand = get_post_meta( $product_id, 'mwb_prfw_brand', true );

		$mwb_prfw_gtin_mpn = get_post_meta( $product_id, 'mwb_prfw_gtin_mpn', true );
		if ( get_option( 'mwb_prfw_enable_seo_boost' ) ) {
			if ( $mwb_prfw_gtin_mpn ) {
				$markup[ strtolower( get_option( 'mwb_prfw_choose_seo_boost_type' ) ) ] = $mwb_prfw_gtin_mpn;
			}
			if ( $mwb_prfw_brand ) {
				$markup['brand'] = array(
					'@type' => 'Brand',
					'name' => $mwb_prfw_brand,
				);
			}
		}
		return $markup;

	}

}
