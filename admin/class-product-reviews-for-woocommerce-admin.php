<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Product_Reviews_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $action   bulk-action.
	 */
	public $action;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      string    $column_val   contains-column-val.
	 */
	public $column_val;

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function prfw_admin_enqueue_styles( $hook ) {
		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_product_reviews_for_woocommerce_menu' == $screen->id ) {

			wp_enqueue_style( 'mwb-prfw-select2-css', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/product-reviews-for-woocommerce-select2.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-prfw-meterial-css', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-prfw-meterial-css2', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.css', array(), time(), 'all' );
			wp_enqueue_style( 'mwb-prfw-meterial-lite', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.css', array(), time(), 'all' );

			wp_enqueue_style( 'mwb-prfw-meterial-icons-css', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/icon.css', array(), time(), 'all' );

			wp_enqueue_style( $this->plugin_name . '-admin-global', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/product-reviews-for-woocommerce-admin-global.css', array( 'mwb-prfw-meterial-icons-css' ), time(), 'all' );

			wp_enqueue_style( $this->plugin_name, PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/scss/product-reviews-for-woocommerce-admin.scss', array(), $this->version, 'all' );
			wp_enqueue_style( 'mwb-admin-min-css', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin.min.css', array(), $this->version, 'all' );
		}
		wp_enqueue_style( 'mwb-admin-prfw-css-admin', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/css/mwb-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook      The plugin page slug.
	 */
	public function prfw_admin_enqueue_scripts( $hook ) {

		$screen = get_current_screen();
		if ( isset( $screen->id ) && 'makewebbetter_page_product_reviews_for_woocommerce_menu' == $screen->id ) {
			wp_enqueue_script( 'mwb-prfw-select2', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/select-2/product-reviews-for-woocommerce-select2.js', array( 'jquery' ), time(), false );

			wp_enqueue_script( 'mwb-prfw-metarial-js', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-prfw-metarial-js2', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-components-v5.0-web.min.js', array(), time(), false );
			wp_enqueue_script( 'mwb-prfw-metarial-lite', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'package/lib/material-design/material-lite.min.js', array(), time(), false );

		}
		wp_register_script( $this->plugin_name . 'admin-js', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/js/product-reviews-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name . 'admin-js',
			'prfw_admin_param',
			array(
				'ajaxurl'             => admin_url( 'admin-ajax.php' ),
				'reloadurl'           => admin_url( 'admin.php?page=product_reviews_for_woocommerce_menu' ),
				'prfw_gen_tab_enable' => get_option( 'mwb_prfw_enable' ),
				'nonce'               => wp_create_nonce( 'review_admin' ),
				'reminder_msg'        => __( 'Reminder Has been sent successfully', 'product-reviews-for-woocommerce' ),
				'mwb_prfw_sent'       => __( 'Sent Successfully', 'product-reviews-for-woocommerce' ),
				'mwb_prfw_sending'    => __( 'Sending..', 'product-reviews-for-woocommerce' ),
			)
		);
		wp_enqueue_script( $this->plugin_name . 'admin-js' );
		wp_enqueue_script( $this->plugin_name . 'admin-sweet-alert', PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . '/package/lib/sweet-alert.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Adding settings menu for Product Reviews for WooCommerce.
	 *
	 * @since    1.0.0
	 */
	public function prfw_options_page() {
		global $submenu;
		if ( empty( $GLOBALS['admin_page_hooks']['mwb-plugins'] ) ) {
			add_menu_page( 'MakeWebBetter', 'MakeWebBetter', 'manage_options', 'mwb-plugins', array( $this, 'mwb_plugins_listing_page' ), PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/src/images/MWB_Grey-01.svg', 15 );
			$prfw_menus = apply_filters( 'mwb_add_plugins_menus_array', array() );
			if ( is_array( $prfw_menus ) && ! empty( $prfw_menus ) ) {
				foreach ( $prfw_menus as $prfw_key => $prfw_value ) {
					add_submenu_page( 'mwb-plugins', $prfw_value['name'], $prfw_value['name'], 'manage_options', $prfw_value['menu_link'], array( $prfw_value['instance'], $prfw_value['function'] ) );
				}
			}
		}
	}

	/**
	 * Removing default submenu of parent menu in backend dashboard
	 *
	 * @since   1.0.0
	 */
	public function mwb_prfw_remove_default_submenu() {
		global $submenu;
		if ( is_array( $submenu ) && array_key_exists( 'mwb-plugins', $submenu ) ) {
			if ( isset( $submenu['mwb-plugins'][0] ) ) {
				unset( $submenu['mwb-plugins'][0] );
			}
		}
	}


	/**
	 * Product Reviews for WooCommerce prfw_admin_submenu_page.
	 *
	 * @since 1.0.0
	 * @param array $menus Marketplace menus.
	 */
	public function prfw_admin_submenu_page( $menus = array() ) {
		$menus[] = array(
			'name'      => __( 'Product Reviews for WooCommerce', 'product-reviews-for-woocommerce' ),
			'slug'      => 'product_reviews_for_woocommerce_menu',
			'menu_link' => 'product_reviews_for_woocommerce_menu',
			'instance'  => $this,
			'function'  => 'prfw_options_menu_html',
		);
		return $menus;
	}


	/**
	 * Product Reviews for WooCommerce mwb_plugins_listing_page.
	 *
	 * @since 1.0.0
	 */
	public function mwb_plugins_listing_page() {
		$active_marketplaces = apply_filters( 'mwb_add_plugins_menus_array', array() );
		if ( is_array( $active_marketplaces ) && ! empty( $active_marketplaces ) ) {
			require PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/welcome.php';
		}
	}

	/**
	 * Product Reviews for WooCommerce admin menu page.
	 *
	 * @since    1.0.0
	 */
	public function prfw_options_menu_html() {

		include_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . 'admin/partials/product-reviews-for-woocommerce-admin-dashboard.php';
	}


	/**
	 * Product Reviews for WooCommerce admin menu page.
	 *
	 * @since    1.0.0
	 * @param array $prfw_settings_general Settings fields.
	 */
	public function prfw_admin_general_settings_page( $prfw_settings_general ) {

		$mwb_prfw_enable_seo_boost = get_option( 'mwb_prfw_enable_seo_boost' );
		$mwb_prfw_enable_custom_gtin = get_option( 'mwb_prfw_enable_custom_gtin' );
		$mwb_prfw_enable_brand = get_option( 'mwb_prfw_enable_brand' );

		$prfw_settings_general = array(
			array(
				'title'       => __( 'Enable plugin', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable plugin to start the functionality.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable',
				'value'       => get_option( 'mwb_prfw_enable' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enable Seo Boost', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to start seo boost functionality.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_seo_boost',
				'value'       => $mwb_prfw_enable_seo_boost,
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title' => __( 'Choose SEO boost type', 'product-reviews-for-woocommerce' ),
				'type'  => 'radio',
				'description'  => __( 'This is radio field demo follow same structure for further use.', 'product-reviews-for-woocommerce' ),
				'id'    => 'mwb_prfw_choose_seo_boost_type',
				'value' => get_option( 'mwb_prfw_choose_seo_boost_type' ),
				'class' => 'prfw-radio-class',
				'parent-div-start' => true,
				'parent-style' => ( 'on' !== $mwb_prfw_enable_seo_boost ) ? 'display:none;' : '',
				'options' => array(
					'MPN' => __( 'MPN', 'product-reviews-for-woocommerce' ),
					'GTIN' => __( 'GTIN', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Create custom MPN/GTIN', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to create custom MPN/GTIN.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_custom_gtin',
				'value'       => $mwb_prfw_enable_custom_gtin,
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enter Custom Prefix', 'product-reviews-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter Prefix for custom GTIN/MPN.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_prefix_mpn',
				'value'       => get_option( 'mwb_prfw_prefix_mpn' ),
				'class'       => 'prfw-text-class',
				'parent-style' => ( 'on' !== $mwb_prfw_enable_custom_gtin ) ? 'display:none;' : '',
				'placeholder' => __( 'Enter MPN/GTIN Prefix', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Enable Brand', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to enter brand-name in each product for seo use.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_brand',
				'value'       => $mwb_prfw_enable_brand,
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enter Brand Name', 'product-reviews-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter Brand Name.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_brand_name',
				'value'       => get_option( 'mwb_prfw_brand_name' ),
				'class'       => 'prfw-text-class',
				'parent-style' => ( 'on' !== $mwb_prfw_enable_brand ) ? 'display:none;' : '',
				'parent-div-close' => true,
				'placeholder' => __( 'Enter Brand Name', 'product-reviews-for-woocommerce' ),
			),		
			array(
				'title'       => __( 'Show Form On', 'product-reviews-for-woocommerce' ),
				'type'        => 'select',
				'description' => __( 'Please select where you want to show review form', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_show_form_on',
				'name'        => 'mwb_prfw_show_form_on',
				'value'       => get_option( 'mwb_prfw_show_form_on' ),
				'class'       => 'prfw-select-class',
				'placeholder' => __( 'Select Demo', 'product-reviews-for-woocommerce' ),
				'options'     => array(
					''      => __( 'Select option', 'product-reviews-for-woocommerce' ),
					'page'  => __( 'Page', 'product-reviews-for-woocommerce' ),
					'popup' => __( 'Pop-up', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Form ajax submission', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Allow submitting form through ajax', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_form_submit_ajax',
				'value'       => get_option( 'mwb_prfw_form_submit_ajax' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Approval required for review', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Approval required for review', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_approval_required',
				'value'       => get_option( 'mwb_prfw_approval_required' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enable Voting', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable voting for review', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_review_voting',
				'value'       => get_option( 'mwb_prfw_enable_review_voting' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Give discount on review', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to give discount on review.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_review_discount',
				'value'       => get_option( 'mwb_prfw_enable_review_discount' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Give discount one time', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to create coupon one time usable.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_review_disc_frequency',
				'value'       => get_option( 'mwb_prfw_review_disc_frequency' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enter Coupon Prefix', 'product-reviews-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter Coupon Code Prefix.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_coupon_prefix',
				'value'       => get_option( 'mwb_prfw_coupon_prefix' ),
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Enter Prefix', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Enter Coupon Expiry', 'product-reviews-for-woocommerce' ),
				'type'        => 'number',
				'description' => __( 'Enter Coupon Expiry In Days.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_coupon_expiry',
				'value'       => get_option( 'mwb_prfw_coupon_expiry' ),
				'min'         => '1',
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Enter expiry', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Enter Coupon Discount', 'product-reviews-for-woocommerce' ),
				'type'        => 'number',
				'description' => __( 'Enter Coupon Discount In Percentage.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_coupon_discount',
				'value'       => get_option( 'mwb_prfw_coupon_discount' ),
				'min'         => '0',
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Enter expiry', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Review Reminder', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to send review reminder', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_review_reminder',
				'value'       => get_option( 'mwb_prfw_enable_review_reminder' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Short-Code', 'product-reviews-for-woocommerce' ),
				'type'        => 'shortcode-display',
				'description' => __( 'Use these shortcode\'s to display reviews in different way\'s', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_review_reminder',
				'value'       => array(
					__( 'Show review\'s in grid view', 'product-reviews-for-woocommerce' ) => '[MWB_SHOW_REVIEW_GRID]',
					__( 'Show review\'s in list view', 'product-reviews-for-woocommerce' ) => '[MWB_SHOW_REVIEW_LIST]',
					__( 'Show review\'s in slider view', 'product-reviews-for-woocommerce' ) => '[MWB_SHOW_REVIEW_SLIDER]',
				),
			),

		);
		$mwb_prfw_dynamic_input_count    = get_option( 'mwb_prfw_dynamic_input_count', array() );
		$mwb_prfw_dynamic_fields_details = get_option( 'mwb_prfw_dynamic_fields_details', array() );
		$multi_field_array               = array(
			array(
				'title'       => __( 'Easy to use', 'product-reviews-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter reminder subject for sending in email', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_input_field',
				'value'       => isset( $mwb_prfw_dynamic_fields_details[0] ) ? $mwb_prfw_dynamic_fields_details[0] : '',
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Product Feature', 'product-reviews-for-woocommerce' ),
			),
		);
		if ( is_array( $mwb_prfw_dynamic_input_count ) && count( $mwb_prfw_dynamic_input_count ) > 0 ) {
			$i = 1;
			foreach ( $mwb_prfw_dynamic_input_count as $arr ) {
				$saved_data          = isset( $mwb_prfw_dynamic_fields_details[ $i ] ) ? $mwb_prfw_dynamic_fields_details[ $i ] : '';
				$arr['value']        = $saved_data;
				$multi_field_array[] = $arr;
				$i++;
			}
		}
		$prfw_settings_general[] = array(
			'title'       => __( 'Review features', 'product-reviews-for-woocommerce' ),
			'type'        => 'multi',
			'description' => __( 'Product Features', 'product-reviews-for-woocommerce' ),
			'class'       => 'prfw-text-class',
			'id'          => 'mwb_prfw_dynamic_fields_details',
			'value'       => $multi_field_array,
			'placeholder' => __( 'Product Feature', 'product-reviews-for-woocommerce' ),
		);
		$prfw_settings_general   = apply_filters( 'mwb_prfw_update_review_setting', $prfw_settings_general );
		$prfw_settings_general[] = array(
			'type'        => 'button',
			'id'          => 'mwb_prfw_save_setting',
			'button_text' => __( 'Save Settings', 'product-reviews-for-woocommerce' ),
			'class'       => 'prfw-button-class',
		);
		return $prfw_settings_general;
	}
	/**
	 * Function name mwb_prfw_add_input_box
	 * this function is used to add input box
	 *
	 * @return void
	 */
	public function mwb_prfw_add_input_box() {
		check_ajax_referer( 'review_admin', 'nonce' );

		$mwb_prfw_dynamic_input_count   = get_option( 'mwb_prfw_dynamic_input_count', array() );
		$count                          = count( $mwb_prfw_dynamic_input_count );
		$new_array                      = array(
			'title' => __( 'dynamic field', 'product-reviews-for-woocommerce' ),
			'type'  => 'text',
			'id'    => 'mwb_prfw_input_field' . $count,
			'value' => '',
			'class' => 'prfw-text-class',
			'name'  => 'mwb_prfw_input_field' . $count,
		);
		$mwb_prfw_dynamic_input_count[] = $new_array;
		update_option( 'mwb_prfw_dynamic_input_count', $mwb_prfw_dynamic_input_count );
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . '/admin/template/product-reviews-for-woocommerce-dyanmic-fetaure-html.php';
		wp_die();
	}
	/**
	 * Function name mwb_prfw_reminder_setting
	 * this function is used to craete rminder tab setting
	 *
	 * @param array $prfw_settings_reminder_tab contains settings.
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_prfw_reminder_setting( $prfw_settings_reminder_tab ) {

		$prfw_settings_reminder_tab = array(
			array(
				'title'       => __( 'Reminder day', 'product-reviews-for-woocommerce' ),
				'type'        => 'number',
				'description' => __( 'Enter in days, After this days review reminder will be sent to customer.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_reminder_after_days',
				'value'       => get_option( 'mwb_prfw_reminder_after_days' ),
				'min'         => '2',
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Reminder day', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Reminder for each product in order', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'If this is enabled then separate reminder will be send to customer for each product in the order.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_reminder_each_product',
				'value'       => get_option( 'mwb_prfw_enable_reminder_each_product' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Reminder Subject', 'product-reviews-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter reminder subject for sending in email', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_reminder_subject',
				'value'       => get_option( 'mwb_prfw_reminder_subject' ),
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Reminder Subject', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Reminder email', 'product-reviews-for-woocommerce' ),
				'type'        => 'wp_editor',
				'description' => __( 'Enter reminder Content for sending in email', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_reminder_email',
				'value'       => get_option( 'mwb_prfw_reminder_email' ),
				'class'       => 'prfw-text-class',
			),
			array(
				'title'       => __( 'Coupon Mail Subject', 'product-reviews-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter subject for sending in coupon email', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_coupon_mail_subject',
				'value'       => get_option( 'mwb_prfw_coupon_mail_subject' ),
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Coupon Mail Subject', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Coupon email', 'product-reviews-for-woocommerce' ),
				'type'        => 'wp_editor',
				'description' => __( 'Enter content for sending in coupon email', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_reminder_email_coupon_content',
				'value'       => get_option( 'mwb_prfw_reminder_email_coupon_content' ),
				'class'       => 'prfw-text-class',
			),
		);
		$prfw_settings_reminder_tab = apply_filters( 'mwb_prfw_update_reminder_setting', $prfw_settings_reminder_tab );
		$prfw_settings_reminder_tab[] = array(
			'type'        => 'button',
			'id'          => 'mwb_prfw_save_reminder_setings_button',
			'button_text' => __( 'Save Settings', 'product-reviews-for-woocommerce' ),
			'class'       => 'prfw-button-class',
		);
		return $prfw_settings_reminder_tab;
	}

	/**
	 * Product Reviews for WooCommerce save tab settings.
	 *
	 * @since 1.0.0
	 */
	public function prfw_admin_save_tab_settings() {
		global $prfw_mwb_prfw_obj, $error_notice;
		$prfw_post_check = false;

		if( wp_doing_ajax() ) {
			return;
		}
		if ( ! isset( $_POST['review_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['review_nonce'] ) ), 'review_nonce' ) ) {
			return;
		}
		if ( isset( $_POST['mwb_prfw_save_setting'] ) ) {
			$prfw_genaral_settings = apply_filters( 'prfw_general_settings_array', array() );
			$prfw_post_check       = true;
		} elseif ( isset( $_POST['mwb_prfw_save_reminder_setings_button'] ) ) {
			$prfw_genaral_settings = apply_filters( 'mwb_prfw_reminder_settings_array', array() );
			$prfw_post_check       = true;
		} elseif ( isset( $_POST['mwb_prfw_save_integration_setings_button'] ) ) {
			$prfw_genaral_settings = apply_filters( 'mwb_prfw_integration_settings_array', array() );
			$prfw_post_check       = true;
		} elseif ( isset( $_POST['mwb_prfw_save_qa_setings_button'] ) ) {
			$prfw_genaral_settings = apply_filters( 'mwb_prfw_qa_settings_array', array() );
			$prfw_post_check       = true;

		}
		if ( $prfw_post_check ) {
			$mwb_prfw_gen_flag = false;
			$prfw_button_index = array_search( 'submit', array_column( $prfw_genaral_settings, 'type' ) );
			if ( isset( $prfw_button_index ) && ( null == $prfw_button_index || '' == $prfw_button_index ) ) {
				$prfw_button_index = array_search( 'button', array_column( $prfw_genaral_settings, 'type' ) );
			}
			if ( isset( $prfw_button_index ) && '' !== $prfw_button_index ) {
				unset( $prfw_genaral_settings[ $prfw_button_index ] );
				if ( is_array( $prfw_genaral_settings ) && ! empty( $prfw_genaral_settings ) ) {
					foreach ( $prfw_genaral_settings as $prfw_genaral_setting ) {
						if ( isset( $prfw_genaral_setting['id'] ) && '' !== $prfw_genaral_setting['id'] ) {
							if ( 'multi' === $prfw_genaral_setting['type'] ) {
								$prfw_general_settings_sub_arr = $prfw_genaral_setting['value'];
								$settings_general_arr = array();
								foreach ( $prfw_general_settings_sub_arr as $prfw_genaral_sub_setting ) {
									if ( isset( $_POST[ $prfw_genaral_sub_setting['id'] ] ) ) {
										$value                  = sanitize_text_field( wp_unslash( $_POST[ $prfw_genaral_sub_setting['id'] ] ) );
										$settings_general_arr[] = $value;
									}
								}
								update_option( $prfw_genaral_setting['id'], $settings_general_arr );
							} else {
								if ( isset( $_POST[ $prfw_genaral_setting['id'] ] ) ) {
									update_option( $prfw_genaral_setting['id'], is_array( $_POST[ $prfw_genaral_setting['id'] ] ) ? map_deep( wp_unslash( $_POST[ $prfw_genaral_setting['id'] ] ), 'sanitize_text_field' ) : wp_kses_post( wp_unslash( $_POST[ $prfw_genaral_setting['id'] ] ) ) );
								} else {
									update_option( $prfw_genaral_setting['id'], '' );
								}
							}
						} else {
							$mwb_prfw_gen_flag = true;
						}
					}
				}
				if ( $mwb_prfw_gen_flag ) {
					$mwb_prfw_error_text = esc_html__( 'Id of some field is missing', 'product-reviews-for-woocommerce' );
					$prfw_mwb_prfw_obj->mwb_prfw_plug_admin_notice( $mwb_prfw_error_text, 'error' );
				} else {
					$error_notice = false;
					do_action( 'mwb_prfw_save_acf_fields' );
					$mwb_prfw_error_text = esc_html__( 'Settings saved !', 'product-reviews-for-woocommerce' );
				}
			}
		}
	}

	/**
	 * Fucntion name mwb_prfw_create_custom_tab_admin
	 * this function is used to add new rtabs in the admin panel.
	 *
	 * @param array $prfw_default_tabs contains default tabs array.
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_prfw_create_custom_tab_admin( $prfw_default_tabs ) {
		$prfw_default_tabs['product-reviews-for-woocommerce-reminder-settings'] = array(
			'title' => esc_html__( 'Reminder Settings', 'product-reviews-for-woocommerce' ),
			'name'  => 'product-reviews-for-woocommerce-reminder-settings',
		);
		$prfw_default_tabs['product-reviews-for-woocommerce-qa-setting'] = array(
			'title' => esc_html__( 'Q & A Settings', 'product-reviews-for-woocommerce' ),
			'name'  => 'product-reviews-for-woocommerce-qa-setting',
		);
		$prfw_default_tabs['product-reviews-for-woocommerce-integration-settings'] = array(
			'title' => esc_html__( 'Integration Settings', 'product-reviews-for-woocommerce' ),
			'name'  => 'product-reviews-for-woocommerce-integration-settings',
		);
		$prfw_default_tabs['product-reviews-for-woocommerce-review-qna-display'] = array(
			'title' => esc_html__( 'Question And Answer', 'product-reviews-for-woocommerce' ),
			'name'  => 'product-reviews-for-woocommerce-review-qna-display',
		);
		return $prfw_default_tabs;
	}

	/**
	 * Function name mwb_prfw_integration_setting_creation
	 * this function will be used to create integration settings
	 *
	 * @param array $prfw_settings_integration contains setting array.
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_prfw_integration_setting_creation( $prfw_settings_integration ) {
		$prfw_settings_integration = array(
			array(
				'title'       => __( 'Enable Google- reCAPTCHA v3 Verification on from', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable Captcha Verification on from', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_captcha',
				'value'       => get_option( 'mwb_prfw_enable_captcha' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enter v3 Site Key', 'product-reviews-for-woocommerce' ),
				'type'        => 'text',
				'description' => __( 'Enter Google- reCAPTCHA v3 Site Key', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_captcha_site_key',
				'value'       => get_option( 'mwb_prfw_captcha_site_key' ),
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Site Key', 'product-reviews-for-woocommerce' ),
			),
			array(
				'title'       => __( 'Enter v3 Secret Key', 'product-reviews-for-woocommerce' ),
				'type'        => 'password',
				'description' => __( 'Enter Google- reCAPTCHA v3 Secret Key', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_captcha_secret_key',
				'value'       => get_option( 'mwb_prfw_captcha_secret_key' ),
				'class'       => 'prfw-text-class',
				'placeholder' => __( 'Secret Key', 'product-reviews-for-woocommerce' ),
			),
		);
		$prfw_settings_integration   = apply_filters( 'mwb_prfw_update_integration_setting', $prfw_settings_integration );
		$prfw_settings_integration[] = array(
			'type'        => 'button',
			'id'          => 'mwb_prfw_save_integration_setings_button',
			'button_text' => __( 'Save Settings', 'product-reviews-for-woocommerce' ),
			'class'       => 'prfw-button-class',

		);
		return $prfw_settings_integration;
	}

	/**
	 * Function name mwb_prfw_qa_setting_creation
	 *
	 * @param array $prfw_settings_qa contains setting array.
	 * @since 1.0.0
	 * @return array
	 */
	public function mwb_prfw_qa_setting_creation( $prfw_settings_qa ) {
		$prfw_settings_qa   = array(
			array(
				'title'       => __( 'Enable Q & A', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to show a tab q&a', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_qna',
				'value'       => get_option( 'mwb_prfw_enable_qna' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Approval required for Q&A', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Approval required for Q&A', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_qna_approval_required',
				'value'       => get_option( 'mwb_prfw_qna_approval_required' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
			array(
				'title'       => __( 'Enable Voting', 'product-reviews-for-woocommerce' ),
				'type'        => 'radio-switch',
				'description' => __( 'Enable this to allow voting on Question and answer.', 'product-reviews-for-woocommerce' ),
				'id'          => 'mwb_prfw_enable_qna_vote',
				'value'       => get_option( 'mwb_prfw_enable_qna_vote' ),
				'class'       => 'prfw-radio-switch-class',
				'options'     => array(
					'yes' => __( 'YES', 'product-reviews-for-woocommerce' ),
					'no'  => __( 'NO', 'product-reviews-for-woocommerce' ),
				),
			),
		);
		$prfw_settings_qa   = apply_filters( 'mwb_prfw_update_qa_setting', $prfw_settings_qa );
		$prfw_settings_qa[] = array(
			'type'        => 'button',
			'id'          => 'mwb_prfw_save_qa_setings_button',
			'button_text' => __( 'Save Settings', 'product-reviews-for-woocommerce' ),
			'class'       => 'prfw-button-class',

		);
		return $prfw_settings_qa;
	}

	/**
	 * Function name mwb_prfw_add_menu_page
	 * this function is used to add a sub menu inside woocommerce
	 *
	 * @return void
	 */
	public function mwb_prfw_add_menu_page() {
			add_submenu_page(
				'edit.php?post_type=product',
				'Reviews',
				'Reviews',
				'manage_options',
				'reviews',
				array( $this, 'mwb_prfw_submenu_callback' )
			);
	}

	/**
	 * Function name mwb_prfw_submenu_callback
	 *
	 * @return void
	 */
	public function mwb_prfw_submenu_callback() {
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . '/admin/partials/product-reviews-for-woocommerce-review-display.php';
	}

	/**
	 * Function name mwb_prfw_update_comment
	 * thisw function is used to update comment
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_update_comment() {
		check_ajax_referer( 'review_admin', 'nonce' );
		$id  = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';
		$type = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		if ( $id && $type ) {
			$comment_update_arr = array(
				'comment_ID' => $id,
			);
			if ( 'unapprove' === $type || 'unspam' === $type ) {
				$comment_update_arr['comment_approved'] = 0;
			} elseif ( 'spam' === $type ) {
				$comment_update_arr['comment_approved'] = 'spam';
			} elseif ( 'approve' === $type || 'mwb_prfw_restore_comment' === $type ) {
				$comment_update_arr['comment_approved'] = 1;
			} elseif ( 'trash' === $type ) {
				$trash_comment = array(
					'comment_ID'       => $id,
					'comment_approved' => $type,
				);
				$mwb_prfw_trash_comment = wp_update_comment( $trash_comment );
				if ( $mwb_prfw_trash_comment ) {
					update_comment_meta( $id, '_wp_trash_meta_status', 1 );
					update_comment_meta( $id, '_wp_trash_meta_time', time() );
				}
			} elseif ( 'mwb_prfw_permanent_delete' === $type ) {
				$del_commment = wp_delete_comment( $id );
				if ( $del_commment ) {
					delete_comment_meta( $id, 'rating' );
					delete_comment_meta( $id, 'mwb_add_review_title' );
					delete_comment_meta( $id, 'verified' );
				}
			}
			wp_update_comment( $comment_update_arr );
		}

		wp_die();
	}

	/**
	 * Funcrtion name mwb_prfw_custom_ajax_reply_comment
	 * this function is used to reply the comment
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_custom_ajax_reply_comment() {

		check_ajax_referer( 'review_admin', 'nonce' );
		$name             = isset( $_POST['name_val'] ) ? sanitize_text_field( wp_unslash( $_POST['name_val'] ) ) : '';
		$pid              = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash( $_POST['id'] ) ) : '';
		$reply            = isset( $_POST['reply'] ) ? sanitize_text_field( wp_unslash( $_POST['reply'] ) ) : '';
		$c_id             = isset( $_POST['c_id'] ) ? sanitize_text_field( wp_unslash( $_POST['c_id'] ) ) : '';
		$comment_type     = isset( $_POST['comment_type'] ) ? sanitize_text_field( wp_unslash( $_POST['comment_type'] ) ) : '';
		$user             = wp_get_current_user();
		$uname            = $user->user_login;
		$uemail           = $user->user_email;
		$u_url            = $user->user_url;
		$pid              = isset( $_POST['pid'] ) ? sanitize_text_field( wp_unslash( $_POST['pid'] ) ) : '';
		$comment_agent    = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
		$ip               = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
		$customer_user_id = get_current_user_id();

			$commentdata = array(
				'comment_author'       => $uname,
				'comment_author_email' => $uemail,
				'comment_author_url'   => $u_url,
				'user_id'              => $customer_user_id,
				'comment_content'      => $reply,
				'comment_karma'        => 0,
				'comment_agent'        => $comment_agent,
				'comment_post_ID'      => $pid,
				'comment_author_IP'    => $ip,
				'comment_parent'       => $c_id,
				'comment_approved'     => 1,
				'comment_type'         => $comment_type,
			);
			$review_id = wp_insert_comment( $commentdata );
			wp_die();
	}

	/**
	 * Function name mwb_prfw_show_bulk_action_notice
	 * this function is used to show method
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function mwb_prfw_show_bulk_action_notice() {

		if ( isset( $_GET['deleted'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
			$this->action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			if ( $this->action ) {
				require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . '/admin/template/product-reviews-for-woocommerce-bulk-notice.php';
			}
		}
	}

	/**
	 * Function name mwb_prfw_delete_input_box
	 * this function is used to delte the dynamic fields
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_delete_input_box() {
		check_ajax_referer( 'review_admin', 'nonce' );
		$input_index = array_key_exists( 'input_index', $_POST ) ? sanitize_text_field( wp_unslash( $_POST['input_index'] ) ) : '';
		$mwb_prfw_dynamic_fields_details = get_option( 'mwb_prfw_dynamic_fields_details', array() );
		if ( isset( $mwb_prfw_dynamic_fields_details[ $input_index ] ) ) {
			unset( $mwb_prfw_dynamic_fields_details[ $input_index ] );
			update_option( 'mwb_prfw_dynamic_fields_details', array_values( $mwb_prfw_dynamic_fields_details ) );
		}

		$mwb_prfw_dynamic_input_count = get_option( 'mwb_prfw_dynamic_input_count', array() );
		if ( isset( $mwb_prfw_dynamic_input_count[ $input_index - 1 ] ) ) {
			unset( $mwb_prfw_dynamic_input_count[ $input_index - 1 ] );
			update_option( 'mwb_prfw_dynamic_input_count', array_values( $mwb_prfw_dynamic_input_count ) );
		}
		wp_die();
	}

	/**
	 * Function name mwb_prfw_upload_csv_file_review_callback
	 * this function is used to upload the csv file.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_upload_csv_file_review_callback() {
		require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . '/admin/template/product-reviews-for-woocommerce-upload-csv-reviews.php';
	}

	/**
	 * Function name mwb_prfw_download_dummy_csv_ajax
	 * this function is used to download the dummy data csv file
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_download_dummy_csv_ajax() {

		check_ajax_referer( 'review_admin', 'nonce' );
		$userdata             = array();
		$userdata[] = array( 'post_id', 'email', 'author_name', 'comment_content', 'rating', 'title' );
		$userdata[] = array( 16, 'demo@demo.com', 'Demo author', 'Dummy Review_data From Csv Exploded', 4, 'Dummy Csv Data Title' );
		wp_send_json( $userdata );
		wp_die();
	}

	/**
	 * Function name mwb_prfw_export_csv_file
	 * this function is used to download the dummy data csv file
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_export_csv_file() {

		check_ajax_referer( 'review_admin', 'nonce' );

		$userdata    = array();
		$userdata[] = array( 'post_id', 'email', 'author_name', 'comment_content', 'rating', 'title' );
		$args       = array(
			'type__in' => 'review',
			'status'   => 'hold,approve',

		);
		$comments_query = new WP_Comment_Query();
		$result         = $comments_query->query( $args );
		foreach ( $result as $key => $value ) {
			$c_id    = $value->comment_ID;
			$pid     = $value->comment_post_ID;
			$author  = $value->comment_author;
			$email   = $value->comment_author_email;
			$content = $value->comment_content;
			$rating  = get_comment_meta( $c_id, 'rating', true );
			$prfw_title   = get_comment_meta( $c_id, 'mwb_add_review_title', true );

			$userdata[] = array( $pid, $email, $author, $content, $rating, $prfw_title );

		}
		wp_send_json( $userdata );
		wp_die();
	}

	/**
	 * Function name mwb_prfw_upload_csv_reviews
	 * this funciton is used to upload csv file reviews.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_upload_csv_reviews() {

		if ( isset( $_POST['upload_csv_review_button'] ) ) {

			if ( isset( $_POST['upload_csv_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['upload_csv_nonce'] ) ), 'upload_csv_nonce' ) ) {
				if ( isset( $_FILES['upload_csv_review']['name'] ) && isset( $_FILES['upload_csv_review']['tmp_name'] ) ) {
					$file_name_to_upload = wp_kses_post( $_FILES['upload_csv_review']['name'] );
					$file_to_upload      = wp_kses_post( $_FILES['upload_csv_review']['tmp_name'] );
					$upload_dir          = wp_upload_dir();
					$upload_basedir      = $upload_dir['basedir'] . '/upload_csv_reviews/';
					if ( ! file_exists( $upload_basedir ) ) {
						wp_mkdir_p( $upload_basedir );
					}
					$target_file       = $upload_basedir . basename( $file_name_to_upload );
					$image_file_type   = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );

					if ( 'csv' === $image_file_type ) {
						if ( ! file_exists( $target_file ) ) {
							move_uploaded_file( $file_to_upload, $target_file );
						}
						$upload_baseurl = $upload_dir['baseurl'] . '/upload_csv_reviews/';
						$mwb_image_url  = $upload_baseurl . $file_name_to_upload;
						$mwb_prfw_csv_path = $upload_basedir . $file_name_to_upload;
						$data = array();
						$files = glob( $mwb_prfw_csv_path );

						foreach ( $files as $file ) {
							if ( ! is_readable( $file ) ) {
								chmod( $file, 0744 );
							}
							if ( is_readable( $file ) ) {
								$_file = fopen( $file, 'r' );
								if ( $_file ) {
									$post = array();
									$header = fgetcsv( $_file );
									while ( $row = fgetcsv( $_file ) ) {
										foreach ( $header as $i => $key ) {
											$post[ $key ] = $row [ $i ];
										}
										$data[] = $post;
									}
									fclose( $_file );
								}
							} else {
								$message = __( 'Files Could Not Be uploaded', 'product-reviews-for-woocommerce' );
								wp_die( esc_html( $message ) );
							}
							foreach ( $data as $k => $csv_val ) {

									$post_id = $csv_val['post_id'];

									$email = $csv_val['email'];

									$author = $csv_val['author_name'];
									$content = $csv_val['comment_content'];
									$rating = $csv_val['rating'];
									$prfw_title = $csv_val['title'];

								if ( $post_id && $email && $author && $content ) {

									$commentdata = array(
										'comment_author' => $author,
										'comment_author_email' => $email,
										'comment_content' => $content,
										'comment_post_ID' => $post_id,
										'comment_approved' => 1,
										'comment_type'    => 'review',
									);
									$comment_done = wp_insert_comment( $commentdata );
									if ( $comment_done ) {
										if ( $rating ) {

											update_comment_meta( $comment_done, 'rating', $rating );
										}
										if ( $prfw_title ) {
											update_comment_meta( $comment_done, 'mwb_add_review_title', $prfw_title );
										}
										wp_delete_file( $mwb_prfw_csv_path );

										wp_safe_redirect(
											add_query_arg(
												array(
													'page'     => 'reviews',
													'action'   => __( 'CSV Reviews Uploaded', 'product-reviews-for-woocommerce' ),
													'deleted'  => true,
												),
												admin_url( 'admin.php' )
											)
										);
									}
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Function name mwb_prfw_add_button_manual
	 * this function will add a button in the order panel.
	 *
	 * @param string $column contains column name.
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_add_button_manual( $column ) {
		if ( 'order_number' === $column ) {
			global $post;
			$p_id = $post->ID;
			$order_status = get_post_status( $p_id );
			if ( 'wc-completed' === $order_status ) {
				require PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . '/admin/template/product-reviews-for-woocommerce-manual-reminder-button.php';
			}
		}
	}

	/**
	 * Function name mwb_prfw_send_manual_reminder
	 * this function is used to send manual reminder
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function mwb_prfw_send_manual_reminder() {
		check_ajax_referer( 'review_admin', 'nonce' );
		$order_id              = isset( $_POST['order_id'] ) ? sanitize_text_field( wp_unslash( $_POST['order_id'] ) ) : '';
		$order_details         = wc_get_order( $order_id );
		$mwb_particular_mail   = get_option( 'mwb_prfw_enable_reminder_each_product' );
		$mwb_prfw_mail_subject = get_option( 'mwb_prfw_reminder_subject' );
		$mwb_prfw_mail         = get_option( 'mwb_prfw_reminder_email' );
		$html                  = '';
		$order_id              = $order_details->get_id();
		$fname                 = $order_details->get_billing_first_name();
		$lname                 = $order_details->get_billing_last_name();

		$fullname = $fname . ' ' . $lname;
		do_action( 'mwb_prfw_send_manual_sms', $order_details );
			$email = $order_details->get_billing_email();
		foreach ( $order_details->get_items() as $item_id => $item ) {
			$product_id = $item->get_product_id();
			$name       = $item->get_name();
			$html      .= '<p><a href= "' . get_permalink( $product_id ) . '">' . $name . '</a></p>';
			$single     = '<p><a href= "' . get_permalink( $product_id ) . '">' . $name . '</a></p>';

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
					echo esc_html( 'success' );
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
			$sent_revimder = wp_mail( $email, $mwb_prfw_mail_subject, $mwb_prfw_mail_content );
			if ( $sent_revimder ) {
				echo esc_html( 'success' );

			}
		}

	}

	/**
	 * Function name mwb_prfw_add_extra_fields_for_seo
	 * this function is used to add extra fields in the product edit page for seo.
	 *
	 * @since 1.0.2
	 * @return void
	 */
	public function mwb_prfw_add_extra_fields_for_seo() {

		$rand = substr( md5( microtime() ), wp_rand( 0, 26 ), 5 );

		if ( get_option( 'mwb_prfw_enable_custom_gtin' ) ) {
			if ( get_option( 'mwb_prfw_prefix_mpn' )  ) {
				$mpn_val = get_option( 'mwb_prfw_prefix_mpn' ) . $rand;
			}
		} else {
			$mpn_val = get_bloginfo( 'name' ) . $rand;
		}
		if ( get_option( 'mwb_prfw_enable_seo_boost' ) ) {
			woocommerce_wp_text_input(
				array(
					'id'          => 'mwb_prfw_seo_nonce',
					'type'        => 'hidden',
					'value'       => wp_create_nonce( 'mwb_prfw_seo_nonce' ),
				)
			);

			if ( 'GTIN' === get_option( 'mwb_prfw_choose_seo_boost_type' ) ) {
				$desc = __( 'GTIN refers to a Global Trade Item Number which uniquely identifies the trade items that are ordered, priced, or invoiced.', 'product-reviews-for-woocommerce' );
				$label = '<abbr title="' . esc_attr__( 'Enter Global Trade Item Number', 'product-reviews-for-woocommerce' ) . '">' . esc_html__( 'Enter GTIN', 'product-reviews-for-woocommerce' ) . '</abbr>';
			} elseif ( 'MPN' === get_option( 'mwb_prfw_choose_seo_boost_type' ) ) {
				$desc = __( 'A unique number issued by manufacturers for identifying individual products.', 'product-reviews-for-woocommerce' );
				$label = '<abbr title="' . esc_attr__( 'Enter Manufacturer Part Number', 'product-reviews-for-woocommerce' ) . '">' . esc_html__( 'Enter MPN', 'product-reviews-for-woocommerce' ) . '</abbr>';

			}
			$gtn_val = get_post_meta( get_the_ID(), 'mwb_prfw_gtin_mpn', true );

				woocommerce_wp_text_input(
					array(
						'id'          => 'mwb_prfw_gtin_mpn',
						'value'       => ! empty( $gtn_val ) ? $gtn_val : $mpn_val,
						'label'       => $label,
						'desc_tip'    => true,
						'description' => $desc,
					)
				);

			if ( get_option( 'mwb_prfw_enable_brand' ) ) {

				woocommerce_wp_text_input(
					array(
						'id'          => 'mwb_prfw_brand',
						'value'       => ! empty( get_post_meta( get_the_ID(), 'mwb_prfw_brand', true ) ) ? get_post_meta( get_the_ID(), 'mwb_prfw_brand', true ) : get_option('mwb_prfw_brand_name'),
						'label'       => '<abbr title="' . esc_attr__( 'Enter Brand Name Here', 'product-reviews-for-woocommerce' ) . '">' . esc_html__( 'Enter Brand', 'product-reviews-for-woocommerce' ) . '</abbr>',
						'desc_tip'    => true,
						'description' => __( 'A name or term that identifies a seller\'s goods or services as distinct from those of other sellers.', 'product-reviews-for-woocommerce' ),
					)
				);
			}
		}
	}

	/**
	 * Function name mwb_prfw_save_seo_fields_val
	 *
	 * @param int $post_id contains post id.
	 * @since 1.0.2
	 * @return void
	 */
	public function mwb_prfw_save_seo_fields_val( $post_id ) {

		if ( ! isset( $_POST['mwb_prfw_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mwb_prfw_seo_nonce'] ) ), 'mwb_prfw_seo_nonce' ) ) {
			return;
		}

		$mwb_prfw_gtin_mpn = isset( $_POST['mwb_prfw_gtin_mpn'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_prfw_gtin_mpn'] ) ) : '';
		$mwb_prfw_brand = isset( $_POST['mwb_prfw_brand'] ) ? sanitize_text_field( wp_unslash( $_POST['mwb_prfw_brand'] ) ) : '';

		update_post_meta( $post_id, 'mwb_prfw_brand', $mwb_prfw_brand );
		update_post_meta( $post_id, 'mwb_prfw_gtin_mpn', $mwb_prfw_gtin_mpn );

	}


}
