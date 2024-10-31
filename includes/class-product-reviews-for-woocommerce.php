<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Product_Reviews_For_Woocommerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Product_Reviews_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $prfw_onboard    To initializsed the object of class onboard.
	 */
	protected $prfw_onboard;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area,
	 * the public-facing side of the site and common side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'PRODUCT_REVIEWS_FOR_WOOCOMMERCE_VERSION' ) ) {

			$this->version = PRODUCT_REVIEWS_FOR_WOOCOMMERCE_VERSION;
		} else {

			$this->version = '1.0.0';
		}

		$this->plugin_name = 'product-reviews-for-woocommerce';

		$this->product_reviews_for_woocommerce_dependencies();
		$this->product_reviews_for_woocommerce_locale();
		if ( is_admin() ) {
			$this->product_reviews_for_woocommerce_admin_hooks();
		} else {
			$this->product_reviews_for_woocommerce_public_hooks();
		}
		$this->product_reviews_for_woocommerce_common_hooks();

		$this->product_reviews_for_woocommerce_api_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Product_Reviews_For_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Product_Reviews_For_Woocommerce_i18n. Defines internationalization functionality.
	 * - Product_Reviews_For_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Product_Reviews_For_Woocommerce_Common. Defines all hooks for the common area.
	 * - Product_Reviews_For_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_reviews_for_woocommerce_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-product-reviews-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-product-reviews-for-woocommerce-i18n.php';

		if ( is_admin() ) {

			// The class responsible for defining all actions that occur in the admin area.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-product-reviews-for-woocommerce-admin.php';

			// The class responsible for on-boarding steps for plugin.
			if ( is_dir( plugin_dir_path( dirname( __FILE__ ) ) . 'onboarding' ) && ! class_exists( 'Product_Reviews_For_Woocommerce_Onboarding_Steps' ) ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-product-reviews-for-woocommerce-onboarding-steps.php';
			}

			if ( class_exists( 'Product_Reviews_For_Woocommerce_Onboarding_Steps' ) ) {
				$prfw_onboard_steps = new Product_Reviews_For_Woocommerce_Onboarding_Steps();
			}
		} else {

			// The class responsible for defining all actions that occur in the public-facing side of the site.
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-product-reviews-for-woocommerce-public.php';

		}

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'package/rest-api/class-product-reviews-for-woocommerce-rest-api.php';

		/**
		 * This class responsible for defining common functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'common/class-product-reviews-for-woocommerce-common.php';

		$this->loader = new Product_Reviews_For_Woocommerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Product_Reviews_For_Woocommerce_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_reviews_for_woocommerce_locale() {

		$plugin_i18n = new Product_Reviews_For_Woocommerce_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_reviews_for_woocommerce_admin_hooks() {

		$prfw_plugin_admin = new Product_Reviews_For_Woocommerce_Admin( $this->prfw_get_plugin_name(), $this->prfw_get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $prfw_plugin_admin, 'prfw_admin_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $prfw_plugin_admin, 'prfw_admin_enqueue_scripts' );

		// Add settings menu for Product Reviews for WooCommerce.
		$this->loader->add_action( 'admin_menu', $prfw_plugin_admin, 'prfw_options_page' );
		$this->loader->add_action( 'admin_menu', $prfw_plugin_admin, 'mwb_prfw_remove_default_submenu', 50 );

		// All admin actions and filters after License Validation goes here.
		$this->loader->add_filter( 'mwb_add_plugins_menus_array', $prfw_plugin_admin, 'prfw_admin_submenu_page', 15 );
		$this->loader->add_filter( 'prfw_general_settings_array', $prfw_plugin_admin, 'prfw_admin_general_settings_page', 10 );

		// Saving tab settings.
		$this->loader->add_action( 'admin_init', $prfw_plugin_admin, 'prfw_admin_save_tab_settings' );

		// Adding new tabs to the admin panel.
		$this->loader->add_filter( 'mwb_prfw_plugin_standard_admin_settings_tabs', $prfw_plugin_admin, 'mwb_prfw_create_custom_tab_admin', 20, 1 );

		// Create reminder tabs setting.
		$this->loader->add_filter( 'mwb_prfw_reminder_settings_array', $prfw_plugin_admin, 'mwb_prfw_reminder_setting' );

		// Creating Question and answer tab setting.
		$this->loader->add_filter( 'mwb_prfw_qa_settings_array', $prfw_plugin_admin, 'mwb_prfw_qa_setting_creation' );

		// Creating Integration Setting.
		$this->loader->add_filter( 'mwb_prfw_integration_settings_array', $prfw_plugin_admin, 'mwb_prfw_integration_setting_creation' );
		// hook to add submenu page in woocommerce.
		$mwb_prfw_active = get_option( 'mwb_prfw_enable' );
		if ( $mwb_prfw_active ) {

			$this->loader->add_action( 'admin_menu', $prfw_plugin_admin, 'mwb_prfw_add_menu_page' );

			$this->loader->add_action( 'wp_ajax_mwb_change_status_comment', $prfw_plugin_admin, 'mwb_prfw_update_comment' );

			$this->loader->add_action( 'wp_ajax_mwb_coment_reply_custom', $prfw_plugin_admin, 'mwb_prfw_custom_ajax_reply_comment' );

			// hook to show notice.
			$this->loader->add_action( 'mwb__bulk_action_success_notice', $prfw_plugin_admin, 'mwb_prfw_show_bulk_action_notice', 20 );

			$this->loader->add_action( 'mwb_show_review_notice', $prfw_plugin_admin, 'mwb_prfw_show_bulk_action_notice', 20 );
			$this->loader->add_action( 'wp_ajax_mwb_prfw_add_input_box', $prfw_plugin_admin, 'mwb_prfw_add_input_box' );

			// hook to del dynamic textbox.
			$this->loader->add_action( 'wp_ajax_mwb_prfw_delete_input_box', $prfw_plugin_admin, 'mwb_prfw_delete_input_box' );

			$this->loader->add_action( 'mwb_prfw_file_upload_review_csv', $prfw_plugin_admin, 'mwb_prfw_upload_csv_file_review_callback' );

			$this->loader->add_action( 'wp_ajax_mwb_prfw_download_dummy_csv_ajax', $prfw_plugin_admin, 'mwb_prfw_download_dummy_csv_ajax' );

			$this->loader->add_action( 'admin_init', $prfw_plugin_admin, 'mwb_prfw_upload_csv_reviews' );

			$this->loader->add_action( 'wp_ajax_mwb_prfw_export_csv_file', $prfw_plugin_admin, 'mwb_prfw_export_csv_file' );
			$this->loader->add_action( 'wp_ajax_mwb_prfw_send_manual_reminder', $prfw_plugin_admin, 'mwb_prfw_send_manual_reminder' );

			$this->loader->add_action( 'manage_shop_order_posts_custom_column', $prfw_plugin_admin, 'mwb_prfw_add_button_manual', 12 );

			$this->loader->add_action( 'woocommerce_product_options_sku', $prfw_plugin_admin, 'mwb_prfw_add_extra_fields_for_seo', 12 );
			// save custom meta fields value.
			$this->loader->add_action( 'woocommerce_process_product_meta', $prfw_plugin_admin, 'mwb_prfw_save_seo_fields_val', 12 );

		}

	}

	/**
	 * Register all of the hooks related to the common functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_reviews_for_woocommerce_common_hooks() {

		$prfw_plugin_common = new Product_Reviews_For_Woocommerce_Common( $this->prfw_get_plugin_name(), $this->prfw_get_version() );

		$mwb_prfw_active = get_option( 'mwb_prfw_enable' );
		if ( $mwb_prfw_active ) {

			$this->loader->add_action( 'wp_enqueue_scripts', $prfw_plugin_common, 'prfw_common_enqueue_styles' );

			$this->loader->add_action( 'wp_enqueue_scripts', $prfw_plugin_common, 'prfw_common_enqueue_scripts' );

			$this->loader->add_action( 'wp_ajax_mwb_create_custom_comment_qa', $prfw_plugin_common, 'mwb_prfw_create_custom_question' );

			$this->loader->add_action( 'wp_ajax_nopriv_mwb_create_custom_comment_qa', $prfw_plugin_common, 'mwb_prfw_create_custom_question' );

			// ajax to reply qstn.
			$this->loader->add_action( 'wp_ajax_mwb_reply_qa', $prfw_plugin_common, 'mwb_prfw_reply_qa' );

			$this->loader->add_action( 'wp_ajax_nopriv_mwb_reply_qa', $prfw_plugin_common, 'mwb_prfw_reply_qa' );

			// Hook for voting on review.
			$this->loader->add_action( 'wp_ajax_mwb_review_voting', $prfw_plugin_common, 'mwb_prfw_review_voting' );

			$this->loader->add_action( 'wp_ajax_nopriv_mwb_review_voting', $prfw_plugin_common, 'mwb_prfw_review_voting' );

			$this->loader->add_action( 'plugins_loaded', $prfw_plugin_common, 'mwb_prfw_create_shortcode_display_review' );

			// Hook for voting on review.
			$this->loader->add_action( 'wp_ajax_mwb_prfw_upload_images', $prfw_plugin_common, 'mwb_prfw_upload_images' );

			$this->loader->add_action( 'wp_ajax_nopriv_mwb_prfw_upload_images', $prfw_plugin_common, 'mwb_prfw_upload_images' );

			$this->loader->add_action( 'wp_ajax_mwb_prfw_submit_ajax_review_form', $prfw_plugin_common, 'mwb_prfw_submit_ajax_review_form' );

			$this->loader->add_action( 'wp_ajax_nopriv_mwb_prfw_submit_ajax_review_form', $prfw_plugin_common, 'mwb_prfw_submit_ajax_review_form' );

			$this->loader->add_filter( 'wp_mail_content_type', $prfw_plugin_common, 'mwb_prfw_set_type_wp_mail' );
			// // Hooks to schedule cron and send email.
			$this->loader->add_action( 'init', $prfw_plugin_common, 'mwb_prfw_schedule_daily_review_cron' );
			$this->loader->add_action( 'mwb_prfw_daily_cron_schedule', $prfw_plugin_common, 'mwb_prfw_daily_cron_callback' );
			// hooks to schedule daily cron.
			$this->loader->add_action( 'init', $prfw_plugin_common, 'mwb_prfw_review_checking_cron' );

			$this->loader->add_action( 'mwb_prfw_review_checking_cron_daily', $prfw_plugin_common, 'mwb_prfw_schedule_check_review_daily' );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_reviews_for_woocommerce_public_hooks() {

		$prfw_plugin_public = new Product_Reviews_For_Woocommerce_Public( $this->prfw_get_plugin_name(), $this->prfw_get_version() );

		$mwb_prfw_active = get_option( 'mwb_prfw_enable' );
		if ( $mwb_prfw_active ) {

			$this->loader->add_action( 'wp_enqueue_scripts', $prfw_plugin_public, 'prfw_public_enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $prfw_plugin_public, 'prfw_public_enqueue_scripts' );

			// Add custom field in review form.

				$this->loader->add_action( 'comment_form_top', $prfw_plugin_public, 'mwb_prfw_add_cutom_review_field' );

			// Hook to verify the captcha.
			$this->loader->add_action( 'preprocess_comment', $prfw_plugin_public, 'mwb_prfw_captcha_verify' );

			// Save custom review fields settings.
			$this->loader->add_action( 'comment_post', $prfw_plugin_public, 'mwb_prfw_save_data_review' );

			$this->loader->add_filter( 'woocommerce_product_tabs', $prfw_plugin_public, 'mwb_prfw_add_qna_tab', 50 );

			// Used to remove question and answer from review tab.
			$this->loader->add_filter( 'woocommerce_product_review_list_args', $prfw_plugin_public, 'mwb_prfw_unset_qna', 50 );

			// Show custom fields value in review also.
			$this->loader->add_action( 'woocommerce_review_after_comment_text', $prfw_plugin_public, 'mwb_prfw_show_meta_values', 20 );
			$this->loader->add_action( 'woocommerce_review_after_comment_text', $prfw_plugin_public, 'mwb_prfw_get_review_voting', 20 );
			$this->loader->add_filter( 'comments_template', $prfw_plugin_public, 'mwb_prfw_add_custom_button', 10 );

			$this->loader->add_filter( 'comments_template', $prfw_plugin_public, 'mwb_prfw_show_review_bar', 10 );
			$this->loader->add_filter( 'woocommerce_structured_data_product', $prfw_plugin_public, 'mwb_prfw_add_seo_field_to_json_ld', 15, 2 );


		}

	}

	/**
	 * Register all of the hooks related to the api functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function product_reviews_for_woocommerce_api_hooks() {

		$prfw_plugin_api = new Product_Reviews_For_Woocommerce_Rest_Api( $this->prfw_get_plugin_name(), $this->prfw_get_version() );

		$this->loader->add_action( 'rest_api_init', $prfw_plugin_api, 'mwb_prfw_add_endpoint' );

	}


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function prfw_run() {
		$this->loader->prfw_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function prfw_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Product_Reviews_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function prfw_get_loader() {
		return $this->loader;
	}


	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Product_Reviews_For_Woocommerce_Onboard    Orchestrates the hooks of the plugin.
	 */
	public function prfw_get_onboard() {
		return $this->prfw_onboard;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function prfw_get_version() {
		return $this->version;
	}

	/**
	 * Predefined default mwb_prfw_plug tabs.
	 *
	 * @return  Array       An key=>value pair of Product Reviews for WooCommerce tabs.
	 */
	public function mwb_prfw_plug_default_tabs() {

		$prfw_default_tabs = array();

		$prfw_default_tabs['product-reviews-for-woocommerce-general'] = array(
			'title'       => esc_html__( 'General Setting', 'product-reviews-for-woocommerce' ),
			'name'        => 'product-reviews-for-woocommerce-general',
		);
		$prfw_default_tabs = apply_filters( 'mwb_prfw_plugin_standard_admin_settings_tabs', $prfw_default_tabs );

		$prfw_default_tabs['product-reviews-for-woocommerce-system-status'] = array(
			'title'       => esc_html__( 'System Status', 'product-reviews-for-woocommerce' ),
			'name'        => 'product-reviews-for-woocommerce-system-status',
		);
		$prfw_default_tabs['product-reviews-for-woocommerce-overview'] = array(
			'title'       => esc_html__( 'Overview', 'product-reviews-for-woocommerce' ),
			'name'        => 'product-reviews-for-woocommerce-overview',
		);
		$prfw_default_tabs = apply_filters( 'mwb_prfw_pro_license_tab', $prfw_default_tabs );

		return $prfw_default_tabs;
	}

	/**
	 * Locate and load appropriate tempate.
	 *
	 * @since   1.0.0
	 * @param string $path path file for inclusion.
	 * @param array  $params parameters to pass to the file for access.
	 */
	public function mwb_prfw_plug_load_template( $path, $params = array() ) {

		$prfw_file_path = PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . $path;
		$prfw_file_path  = apply_filters( 'mwb_prfw_tab_pro_path', $prfw_file_path, $path );

		if ( file_exists( $prfw_file_path ) ) {

			include $prfw_file_path;
		} else {

			/* translators: %s: file path */
			$prfw_notice = sprintf( esc_html__( 'Unable to locate file at location "%s". Some features may not work properly in this plugin. Please contact us!', 'product-reviews-for-woocommerce' ), $prfw_file_path );
			$this->mwb_prfw_plug_admin_notice( $prfw_notice, 'error' );
		}
	}

	/**
	 * Show admin notices.
	 *
	 * @param  string $prfw_message    Message to display.
	 * @param  string $type       notice type, accepted values - error/update/update-nag.
	 * @since  1.0.0
	 */
	public static function mwb_prfw_plug_admin_notice( $prfw_message, $type = 'error' ) {

		$prfw_classes = 'notice ';

		switch ( $type ) {

			case 'update':
				$prfw_classes .= 'updated is-dismissible';
				break;
			case 'update-nag':
				$prfw_classes .= 'update-nag is-dismissible';
				break;
			case 'success':
				$prfw_classes .= 'notice-success is-dismissible';
				break;
			default:
				$prfw_classes .= 'notice-error is-dismissible';
		}

		$prfw_notice  = '<div class="' . esc_attr( $prfw_classes ) . ' mwb-errorr">';
		$prfw_notice .= '<p>' . esc_html( $prfw_message ) . '</p>';
		$prfw_notice .= '</div>';

		echo wp_kses_post( $prfw_notice );
	}


	/**
	 * Show wordpress and server info.
	 *
	 * @return  Array $prfw_system_data       returns array of all wordpress and server related information.
	 * @since  1.0.0
	 */
	public function mwb_prfw_plug_system_status() {
		global $wpdb;
		$prfw_system_status = array();
		$prfw_wordpress_status = array();
		$prfw_system_data = array();

		// Get the web server.
		$prfw_system_status['web_server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

		// Get PHP version.
		$prfw_system_status['php_version'] = function_exists( 'phpversion' ) ? phpversion() : __( 'N/A (phpversion function does not exist)', 'product-reviews-for-woocommerce' );

		// Get the server's IP address.
		$prfw_system_status['server_ip'] = isset( $_SERVER['SERVER_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_ADDR'] ) ) : '';

		// Get the server's port.
		$prfw_system_status['server_port'] = isset( $_SERVER['SERVER_PORT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) ) : '';

		// Get the uptime.
		$prfw_system_status['uptime'] = function_exists( 'exec' ) ? @exec( 'uptime -p' ) : __( 'N/A (make sure exec function is enabled)', 'product-reviews-for-woocommerce' );

		// Get the server path.
		$prfw_system_status['server_path'] = defined( 'ABSPATH' ) ? ABSPATH : __( 'N/A (ABSPATH constant not defined)', 'product-reviews-for-woocommerce' );

		// Get the OS.
		$prfw_system_status['os'] = function_exists( 'php_uname' ) ? php_uname( 's' ) : __( 'N/A (php_uname function does not exist)', 'product-reviews-for-woocommerce' );

		// Get WordPress version.
		$prfw_wordpress_status['wp_version'] = function_exists( 'get_bloginfo' ) ? get_bloginfo( 'version' ) : __( 'N/A (get_bloginfo function does not exist)', 'product-reviews-for-woocommerce' );

		// Get and count active WordPress plugins.
		$prfw_wordpress_status['wp_active_plugins'] = function_exists( 'get_option' ) ? count( get_option( 'active_plugins' ) ) : __( 'N/A (get_option function does not exist)', 'product-reviews-for-woocommerce' );

		// See if this site is multisite or not.
		$prfw_wordpress_status['wp_multisite'] = function_exists( 'is_multisite' ) && is_multisite() ? __( 'Yes', 'product-reviews-for-woocommerce' ) : __( 'No', 'product-reviews-for-woocommerce' );

		// See if WP Debug is enabled.
		$prfw_wordpress_status['wp_debug_enabled'] = defined( 'WP_DEBUG' ) ? __( 'Yes', 'product-reviews-for-woocommerce' ) : __( 'No', 'product-reviews-for-woocommerce' );

		// See if WP Cache is enabled.
		$prfw_wordpress_status['wp_cache_enabled'] = defined( 'WP_CACHE' ) ? __( 'Yes', 'product-reviews-for-woocommerce' ) : __( 'No', 'product-reviews-for-woocommerce' );

		// Get the total number of WordPress users on the site.
		$prfw_wordpress_status['wp_users'] = function_exists( 'count_users' ) ? count_users() : __( 'N/A (count_users function does not exist)', 'product-reviews-for-woocommerce' );

		// Get the number of published WordPress posts.
		$prfw_wordpress_status['wp_posts'] = wp_count_posts()->publish >= 1 ? wp_count_posts()->publish : __( '0', 'product-reviews-for-woocommerce' );

		// Get PHP memory limit.
		$prfw_system_status['php_memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'product-reviews-for-woocommerce' );

		// Get the PHP error log path.
		$prfw_system_status['php_error_log_path'] = ! ini_get( 'error_log' ) ? __( 'N/A', 'product-reviews-for-woocommerce' ) : ini_get( 'error_log' );

		// Get PHP max upload size.
		$prfw_system_status['php_max_upload'] = function_exists( 'ini_get' ) ? (int) ini_get( 'upload_max_filesize' ) : __( 'N/A (ini_get function does not exist)', 'product-reviews-for-woocommerce' );

		// Get PHP max post size.
		$prfw_system_status['php_max_post'] = function_exists( 'ini_get' ) ? (int) ini_get( 'post_max_size' ) : __( 'N/A (ini_get function does not exist)', 'product-reviews-for-woocommerce' );

		// Get the PHP architecture.
		if ( PHP_INT_SIZE == 4 ) {
			$prfw_system_status['php_architecture'] = '32-bit';
		} elseif ( PHP_INT_SIZE == 8 ) {
			$prfw_system_status['php_architecture'] = '64-bit';
		} else {
			$prfw_system_status['php_architecture'] = 'N/A';
		}

		// Get server host name.
		$prfw_system_status['server_hostname'] = function_exists( 'gethostname' ) ? gethostname() : __( 'N/A (gethostname function does not exist)', 'product-reviews-for-woocommerce' );

		// Show the number of processes currently running on the server.
		$prfw_system_status['processes'] = function_exists( 'exec' ) ? @exec( 'ps aux | wc -l' ) : __( 'N/A (make sure exec is enabled)', 'product-reviews-for-woocommerce' );

		// Get the memory usage.
		$prfw_system_status['memory_usage'] = function_exists( 'memory_get_peak_usage' ) ? round( memory_get_peak_usage( true ) / 1024 / 1024, 2 ) : 0;

		// Get CPU usage.
		// Check to see if system is Windows, if so then use an alternative since sys_getloadavg() won't work.
		if ( stristr( PHP_OS, 'win' ) ) {
			$prfw_system_status['is_windows'] = true;
			$prfw_system_status['windows_cpu_usage'] = function_exists( 'exec' ) ? @exec( 'wmic cpu get loadpercentage /all' ) : __( 'N/A (make sure exec is enabled)', 'product-reviews-for-woocommerce' );
		}

		// Get the memory limit.
		$prfw_system_status['memory_limit'] = function_exists( 'ini_get' ) ? (int) ini_get( 'memory_limit' ) : __( 'N/A (ini_get function does not exist)', 'product-reviews-for-woocommerce' );

		// Get the PHP maximum execution time.
		$prfw_system_status['php_max_execution_time'] = function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : __( 'N/A (ini_get function does not exist)', 'product-reviews-for-woocommerce' );
		$prfw_system_data['php'] = $prfw_system_status;
		$prfw_system_data['wp'] = $prfw_wordpress_status;

		return $prfw_system_data;
	}

	/**
	 * Generate html components.
	 *
	 * @param  string $prfw_components    html to display.
	 * @since  1.0.0
	 */
	public function mwb_prfw_plug_generate_html( $prfw_components = array() ) {
		if ( is_array( $prfw_components ) && ! empty( $prfw_components ) ) {
			foreach ( $prfw_components as $prfw_component ) {
				if ( ! empty( $prfw_component['type'] ) && ! empty( $prfw_component['id'] ) ) {
					switch ( $prfw_component['type'] ) {

						case 'hidden':
						case 'number':
						case 'email':
						case 'text':
							?>

						<div class="mwb-form-group mwb-prfw-<?php echo esc_attr( $prfw_component['type'] ); ?>" style="<?php echo esc_attr( isset( $prfw_component['parent-style'] ) ? $prfw_component['parent-style'] : '' ); ?>">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $prfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<?php if ( 'number' != $prfw_component['type'] ) { ?>
												<span class="mdc-floating-label" id="my-label-id" ><?php echo ( isset( $prfw_component['placeholder'] ) ? esc_attr( $prfw_component['placeholder'] ) : '' ); ?></span>
											<?php } ?>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input
									class="mdc-text-field__input <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>"
									name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $prfw_component['id'] ); ?>"
									type="<?php echo esc_attr( $prfw_component['type'] ); ?>"
									value="<?php echo ( isset( $prfw_component['value'] ) ? esc_attr( $prfw_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $prfw_component['placeholder'] ) ? esc_attr( $prfw_component['placeholder'] ) : '' ); ?>"
									<?php
									if ( 'number' === $prfw_component['type'] ) {
										?>
										min = "<?php echo ( isset( $prfw_component['min'] ) ? esc_attr( $prfw_component['min'] ) : '' ); ?>"
										max = "<?php echo ( isset( $prfw_component['max'] ) ? esc_attr( $prfw_component['max'] ) : '' ); ?>"
										<?php
									}
									?>
									>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $prfw_component['description'] ) ? esc_attr( $prfw_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							if ( isset( $prfw_component['parent-div-close'] ) ) {
								?>
								</div>
								<?php
							}
							break;
						case 'password':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $prfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<input
									class="mdc-text-field__input <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?> mwb-form__password"
									name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $prfw_component['id'] ); ?>"
									type="<?php echo esc_attr( $prfw_component['type'] ); ?>"
									value="<?php echo ( isset( $prfw_component['value'] ) ? esc_attr( $prfw_component['value'] ) : '' ); ?>"
									placeholder="<?php echo ( isset( $prfw_component['placeholder'] ) ? esc_attr( $prfw_component['placeholder'] ) : '' ); ?>"
									>
									<i class="material-icons mdc-text-field__icon mdc-text-field__icon--trailing mwb-password-hidden" tabindex="0" role="button">visibility</i>
								</label>
								<div class="mdc-text-field-helper-line">
									<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $prfw_component['description'] ) ? esc_attr( $prfw_component['description'] ) : '' ); ?></div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'textarea':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr( $prfw_component['id'] ); ?>"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea"  	for="text-field-hero-input">
									<span class="mdc-notched-outline">
										<span class="mdc-notched-outline__leading"></span>
										<span class="mdc-notched-outline__notch">
											<span class="mdc-floating-label"><?php echo ( isset( $prfw_component['placeholder'] ) ? esc_attr( $prfw_component['placeholder'] ) : '' ); ?></span>
										</span>
										<span class="mdc-notched-outline__trailing"></span>
									</span>
									<span class="mdc-text-field__resizer">
										<textarea class="mdc-text-field__input <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>" rows="2" cols="25" aria-label="Label" name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>" id="<?php echo esc_attr( $prfw_component['id'] ); ?>" placeholder="<?php echo ( isset( $prfw_component['placeholder'] ) ? esc_attr( $prfw_component['placeholder'] ) : '' ); ?>"><?php echo ( isset( $prfw_component['value'] ) ? esc_textarea( $prfw_component['value'] ) : '' ); // WPCS: XSS ok. ?></textarea>
									</span>
								</label>

							</div>
						</div>

							<?php
							break;

						case 'wp_editor':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label class="mwb-form-label" for="<?php echo esc_attr( $prfw_component['id'] ); ?>"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">

										<span class="mdc-text-field__resizer">
												<?php echo wp_kses_post( wp_editor( esc_attr( $prfw_component['value'] ), esc_attr( $prfw_component['id'] ), array() ) ); ?>
										</span>
								</div>
							</div>
							<?php
							break;

						case 'select':
						case 'multiselect':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label class="mwb-form-label" for="<?php echo esc_attr( $prfw_component['id'] ); ?>"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div class="mwb-form-select">
									<select id="<?php echo esc_attr( $prfw_component['id'] ); ?>" name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : '' ); ?><?php echo ( 'multiselect' === $prfw_component['type'] ) ? '[]' : ''; ?>" id="<?php echo esc_attr( $prfw_component['id'] ); ?>" class="mdl-textfield__input <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>" <?php echo 'multiselect' === $prfw_component['type'] ? 'multiple="multiple"' : ''; ?> >
										<?php
										foreach ( $prfw_component['options'] as $prfw_key => $prfw_val ) {
											?>
											<option value="<?php echo esc_attr( $prfw_key ); ?>"
												<?php
												if ( is_array( $prfw_component['value'] ) ) {
													selected( in_array( (string) $prfw_key, $prfw_component['value'], true ), true );
												} else {
													selected( $prfw_component['value'], (string) $prfw_key );
												}
												?>
												>
												<?php echo esc_html( $prfw_val ); ?>
											</option>
											<?php
										}
										?>
									</select>
									<label class="mdl-textfield__label" for="octane"><?php echo ( isset( $prfw_component['description'] ) ? esc_attr( $prfw_component['description'] ) : '' ); ?></label>
								</div>
							</div>
						</div>

							<?php
							break;

						case 'checkbox':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $prfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mdc-form-field">
									<div class="mdc-checkbox">
										<input
										name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $prfw_component['id'] ); ?>"
										type="checkbox"
										class="mdc-checkbox__native-control <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>"
										value="<?php echo ( isset( $prfw_component['value'] ) ? esc_attr( $prfw_component['value'] ) : '' ); ?>"
										<?php checked( $prfw_component['value'], '1' ); ?>
										/>
										<div class="mdc-checkbox__background">
											<svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
												<path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
											</svg>
											<div class="mdc-checkbox__mixedmark"></div>
										</div>
										<div class="mdc-checkbox__ripple"></div>
									</div>
									<label for="checkbox-1"><?php echo ( isset( $prfw_component['description'] ) ? esc_attr( $prfw_component['description'] ) : '' ); ?></label>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio':
							if ( isset( $prfw_component['parent-div-start'] ) ) {
								?>
								<div class="prfw-show-hide__wrapper" style="<?php echo esc_attr( isset( $prfw_component['parent-style'] ) ? $prfw_component['parent-style'] : '' ); ?>">
								<?php
							}
							?>
						<div class="mwb-form-group" >
							<div class="mwb-form-group__label">
								<label for="<?php echo esc_attr( $prfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control mwb-pl-4">
								<div class="mwb-flex-col">
									<?php
									foreach ( $prfw_component['options'] as $prfw_radio_key => $prfw_radio_val ) {
										?>
										<div class="mdc-form-field">
											<div class="mdc-radio">
												<input
												name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>"
												value="<?php echo esc_attr( $prfw_radio_key ); ?>"
												type="radio"
												class="mdc-radio__native-control <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>"
												<?php checked( $prfw_radio_key, $prfw_component['value'] ); ?>
												>
												<div class="mdc-radio__background">
													<div class="mdc-radio__outer-circle"></div>
													<div class="mdc-radio__inner-circle"></div>
												</div>
												<div class="mdc-radio__ripple"></div>
											</div>
											<label for="radio-1"><?php echo esc_html( $prfw_radio_val ); ?></label>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'radio-switch':
							?>

						<div class="mwb-form-group" style="<?php echo esc_attr( isset( $prfw_component['parent-style'] ) ? $prfw_component['parent-style'] : '' ); ?>">
							<div class="mwb-form-group__label">
								<label for="" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
							</div>
							<div class="mwb-form-group__control">
								<div>
									<div class="mdc-switch">
										<div class="mdc-switch__track"></div>
										<div class="mdc-switch__thumb-underlay">
											<div class="mdc-switch__thumb"></div>
											<input name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>" type="checkbox" id="<?php echo esc_html( $prfw_component['id'] ); ?>" value="on" class="mdc-switch__native-control <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>" role="switch" aria-checked="
																	<?php
																	if ( 'on' == $prfw_component['value'] ) {
																		echo 'true';
																	} else {
																		echo 'false';
																	}
																	?>
											"
											<?php checked( $prfw_component['value'], 'on' ); ?>
											>
										</div>
									</div>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $prfw_component['description'] ) ? esc_attr( $prfw_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
						</div>
							<?php
							break;

						case 'shortcode-display':
							?>
							<div class="mwb-form-group">
								<div class="mwb-form-group__label">
									<label for="" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<div>
									<?php echo ( isset( $prfw_component['description'] ) ? esc_html( $prfw_component['description'] ) : '' ); ?>
									</div>
									<table>
										<tr><th><?php esc_html_e( 'Description', 'product-reviews-for-woocommerce' ); ?></th><th><?php esc_html_e( 'ShortCode', 'product-reviews-for-woocommerce' ); ?></th></tr>
										<?php
										$sub_prfw_component_arr = $prfw_component['value'];
										foreach ( $sub_prfw_component_arr as $key => $val ) {
											?>
											<tr><td><?php echo esc_html( $key ); ?></td><td><?php echo esc_html( $val ); ?></td></tr>
											<?php
										}
										?>
									</table>
								</div>
							</div>

							<?php
							break;

						case 'button':
							?>
						<div class="mwb-form-group">
							<div class="mwb-form-group__label"></div>
							<div class="mwb-form-group__control">
								<button class="mdc-button mdc-button--raised" name= "<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>"
									id="<?php echo esc_attr( $prfw_component['id'] ); ?>"> <span class="mdc-button__ripple"></span>
									<span class="mdc-button__label <?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>"><?php echo ( isset( $prfw_component['button_text'] ) ? esc_html( $prfw_component['button_text'] ) : '' ); ?></span>
								</button>
							</div>
						</div>

							<?php
							break;

						case 'multi':
							?>
							<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $prfw_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $prfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
									</div>
									<div class="mwb-form-group__control">
									<span class="mwb_prfw_dynamic_field_storage">
									<?php
									$i = 0;
									foreach ( $prfw_component['value'] as $component ) {
										?>
										<span class="mwb_prfw_dynamic_label">
											<label class="mdc-text-field mdc-text-field--outlined">
												<span class="mdc-notched-outline">
													<span class="mdc-notched-outline__leading"></span>
													<span class="mdc-notched-outline__notch">
														<?php if ( 'number' != $component['type'] ) { ?>
															<span class="mdc-floating-label" id="my-label-id"><?php echo ( isset( $component['placeholder'] ) ? esc_attr( $component['placeholder'] ) : '' ); ?></span>
														<?php } ?>
													</span>
													<span class="mdc-notched-outline__trailing"></span>
												</span>
												<input
												class="mdc-text-field__input <?php echo ( isset( $component['class'] ) ? esc_attr( $component['class'] ) : '' ); ?>"
												name="<?php echo ( isset( $component['name'] ) ? esc_html( $component['name'] ) : esc_html( $component['id'] ) ); ?>"
												id="<?php echo esc_attr( $component['id'] ); ?>"
												type="<?php echo esc_attr( $component['type'] ); ?>"
												value="<?php echo ( isset( $component['value'] ) ? esc_attr( $component['value'] ) : '' ); ?>"
												placeholder="<?php echo ( isset( $component['placeholder'] ) ? esc_attr( $component['placeholder'] ) : '' ); ?>"
												<?php echo esc_attr( ( 'number' === $component['type'] ) ? 'max=10 min=0' : '' ); ?>
												>
											</label>

											<?php
											if ( 0 !== $i ) {
												?>
												<button class="mwb_prfw_delete_button_feature_review_field" data-index-input="<?php echo esc_attr( $i ); ?>" >X</button>
												<?php
											}
											?>
											</span>

										<?php
										$i++;
										?>
								<?php } ?>
								</span>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $prfw_component['description'] ) ? esc_attr( $prfw_component['description'] ) : '' ); ?></div>
									</div>
								<button class="mwb_prfw_add_review_feature_field">+</button>
								</div>
							</div>
								<?php
							break;
						case 'color':
						case 'date':
						case 'file':
							?>
							<div class="mwb-form-group mwb-isfw-<?php echo esc_attr( $prfw_component['type'] ); ?>">
								<div class="mwb-form-group__label">
									<label for="<?php echo esc_attr( $prfw_component['id'] ); ?>" class="mwb-form-label"><?php echo ( isset( $prfw_component['title'] ) ? esc_html( $prfw_component['title'] ) : '' ); // WPCS: XSS ok. ?></label>
								</div>
								<div class="mwb-form-group__control">
									<label class="mdc-text-field mdc-text-field--outlined">
										<input
										class="<?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>"
										name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>"
										id="<?php echo esc_attr( $prfw_component['id'] ); ?>"
										type="<?php echo esc_attr( $prfw_component['type'] ); ?>"
										value="<?php echo ( isset( $prfw_component['value'] ) ? esc_attr( $prfw_component['value'] ) : '' ); ?>"
										<?php echo esc_html( ( 'date' === $prfw_component['type'] ) ? 'max=' . gmdate( 'Y-m-d', strtotime( gmdate( 'Y-m-d', mktime() ) . ' + 365 day' ) ) . 'min=' . gmdate( 'Y-m-d' ) . '' : '' ); ?>
										>
									</label>
									<div class="mdc-text-field-helper-line">
										<div class="mdc-text-field-helper-text--persistent mwb-helper-text" id="" aria-hidden="true"><?php echo ( isset( $prfw_component['description'] ) ? esc_attr( $prfw_component['description'] ) : '' ); ?></div>
									</div>
								</div>
							</div>
							<?php
							break;

						case 'submit':
							?>
						<tr valign="top">
							<td scope="row">
								<input type="submit" class="button button-primary"
								name="<?php echo ( isset( $prfw_component['name'] ) ? esc_html( $prfw_component['name'] ) : esc_html( $prfw_component['id'] ) ); ?>"
								id="<?php echo esc_attr( $prfw_component['id'] ); ?>"
								class="<?php echo ( isset( $prfw_component['class'] ) ? esc_attr( $prfw_component['class'] ) : '' ); ?>"
								value="<?php echo esc_attr( $prfw_component['button_text'] ); ?>"
								/>
							</td>
						</tr>
							<?php
							break;

						default:
							break;
					}
				}
			}
		}
	}
}
