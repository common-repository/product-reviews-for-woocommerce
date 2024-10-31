<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://makewebbetter.com/
 * @since             1.0.0
 * @package           Product_Reviews_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Product Reviews for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/product-reviews-for-woocommerce/
 * Description:       Product Reviews For WooCommerce allows the merchants to enhance the review section of a product. The customers can upload images, rate product attributes, ask product-specific questions, and much more.
 * Version:           1.0.3
 * Author:            MakeWebBetter
 * Author URI:        https://makewebbetter.com/
 * Text Domain:       product-reviews-for-woocommerce
 * Domain Path:       /languages
 *
 * Requires at least: 4.6
 * Tested up to:      5.8.2
 *
 * WC requires at least: 4.0.0
 * WC tested up to:    5.9.0
 *
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}



/**
 * Checking for activation of Woocommerce
 */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {

	/**
	 * Define plugin constants.
	 *
	 * @since             1.0.0
	 */
	function define_product_reviews_for_woocommerce_constants() {

		product_reviews_for_woocommerce_constants( 'PRODUCT_REVIEWS_FOR_WOOCOMMERCE_VERSION', '1.0.3' );
		product_reviews_for_woocommerce_constants( 'PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH', plugin_dir_path( __FILE__ ) );
		product_reviews_for_woocommerce_constants( 'PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL', plugin_dir_url( __FILE__ ) );
		product_reviews_for_woocommerce_constants( 'PRODUCT_REVIEWS_FOR_WOOCOMMERCE_SERVER_URL', 'https://makewebbetter.com' );
		product_reviews_for_woocommerce_constants( 'PRODUCT_REVIEWS_FOR_WOOCOMMERCE_ITEM_REFERENCE', 'Product Reviews for WooCommerce' );
	}


	/**
	 * Callable function for defining plugin constants.
	 *
	 * @param   String $key    Key for contant.
	 * @param   String $value   value for contant.
	 * @since             1.0.0
	 */
	function product_reviews_for_woocommerce_constants( $key, $value ) {

		if ( ! defined( $key ) ) {

			define( $key, $value );
		}
	}

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-product-reviews-for-woocommerce-activator.php
	 */
	function activate_product_reviews_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-reviews-for-woocommerce-activator.php';
		Product_Reviews_For_Woocommerce_Activator::product_reviews_for_woocommerce_activate();
		$mwb_prfw_active_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_prfw_active_plugin ) && ! empty( $mwb_prfw_active_plugin ) ) {
			$mwb_prfw_active_plugin['product-reviews-for-woocommerce'] = array(
				'plugin_name' => __( 'Product Reviews for WooCommerce', 'product-reviews-for-woocommerce' ),
				'active' => '1',
			);
		} else {
			$mwb_prfw_active_plugin = array();
			$mwb_prfw_active_plugin['product-reviews-for-woocommerce'] = array(
				'plugin_name' => __( 'Product Reviews for WooCommerce', 'product-reviews-for-woocommerce' ),
				'active' => '1',
			);
		}
		update_option( 'mwb_all_plugins_active', $mwb_prfw_active_plugin );
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-product-reviews-for-woocommerce-deactivator.php
	 */
	function deactivate_product_reviews_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-reviews-for-woocommerce-deactivator.php';
		Product_Reviews_For_Woocommerce_Deactivator::product_reviews_for_woocommerce_deactivate();
		$mwb_prfw_deactive_plugin = get_option( 'mwb_all_plugins_active', false );
		if ( is_array( $mwb_prfw_deactive_plugin ) && ! empty( $mwb_prfw_deactive_plugin ) ) {
			foreach ( $mwb_prfw_deactive_plugin as $mwb_prfw_deactive_key => $mwb_prfw_deactive ) {
				if ( 'product-reviews-for-woocommerce' === $mwb_prfw_deactive_key ) {
					$mwb_prfw_deactive_plugin[ $mwb_prfw_deactive_key ]['active'] = '0';
				}
			}
		}
		update_option( 'mwb_all_plugins_active', $mwb_prfw_deactive_plugin );
	}

	register_activation_hook( __FILE__, 'activate_product_reviews_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_product_reviews_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-product-reviews-for-woocommerce.php';


	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_product_reviews_for_woocommerce() {
		define_product_reviews_for_woocommerce_constants();

		$prfw_plugin_standard = new Product_Reviews_For_Woocommerce();
		$prfw_plugin_standard->prfw_run();
		$GLOBALS['prfw_mwb_prfw_obj'] = $prfw_plugin_standard;
		$GLOBALS['error_notice']      = true;

	}
	run_product_reviews_for_woocommerce();


	// Add settings link on plugin page.
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'product_reviews_for_woocommerce_settings_link' );

	/**
	 * Settings link.
	 *
	 * @since    1.0.0
	 * @param   Array $links    Settings link array.
	 */
	function product_reviews_for_woocommerce_settings_link( $links ) {

		$my_link = array(
			'<a href="' . admin_url( 'admin.php?page=product_reviews_for_woocommerce_menu' ) . '">' . __( 'Settings', 'product-reviews-for-woocommerce' ) . '</a>',
		);

		$my_link_2 = array(
			'<a id="mwb_prfw_go_pro" href="https://makewebbetter.com/product/product-reviews-for-woocommerce-pro/?utm_source=MWB-reviewspro-org&utm_medium=MWB-org-page&utm_campaign=MWB-reviewspro-org">' . __( 'Go Pro', 'product-reviews-for-woocommerce' ) . '</a>',
		);
		return array_merge( $my_link, $my_link_2, $links );

	}

	/**
	 * Adding custom setting links at the plugin activation list.
	 *
	 * @param array  $links_array array containing the links to plugin.
	 * @param string $plugin_file_name plugin file name.
	 * @return array
	 */
	function product_reviews_for_woocommerce_custom_settings_at_plugin_tab( $links_array, $plugin_file_name ) {
		if ( strpos( $plugin_file_name, basename( __FILE__ ) ) ) {
			$links_array[] = '<a href="https://demo.makewebbetter.com/product-review-for-woocommerce/?utm_source=MWB-reviews-org&utm_medium=MWB-org-backend&utm_campaign=MWB-reviews-demo" target="_blank"><img src="' . esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Demo.svg" class="mwb-info-img" alt="Demo image">' . __( 'Demo', 'product-reviews-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href="https://docs.makewebbetter.com/product-reviews-for-woocommerce/?utm_source=MWB-reviews-org&utm_medium=MWB-org-backend&utm_campaign=MWB-reviews-doc" target="_blank"><img src="' . esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Documentation.svg" class="mwb-info-img" alt="documentation image">' . __( 'Documentation', 'product-reviews-for-woocommerce' ) . '</a>';
			$links_array[] = '<a href="https://makewebbetter.com/submit-query/?utm_source=MWB-reviews-org&utm_medium=MWB-org-backend&utm_campaign=MWB-reviews-support" target="_blank"><img src="' . esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/Support.svg" class="mwb-info-img" alt="support image">' . __( 'Support', 'product-reviews-for-woocommerce' ) . '</a>';
		}
		return $links_array;
	}
	add_filter( 'plugin_row_meta', 'product_reviews_for_woocommerce_custom_settings_at_plugin_tab', 10, 2 );

} else {

	add_action( 'admin_notices', 'mwb_prfw_plugin_error_notice' );
	add_action( 'admin_init', 'mwb_prfw_plugin_deactivate_dependency' );


	// Checking the existance of the same name function in this file.
	if ( ! function_exists( 'mwb_prfw_plugin_error_notice' ) ) {
		/**
		 * Function name  mwb_prfw_plugin_error_notice
		 * This function will show notice while deactivating without woocommerce
		 *
		 * @return void
		 * @since             1.0.0
		 */
		function mwb_prfw_plugin_error_notice() {
			require_once plugin_dir_path( __FILE__ ) . '/common/partials/product-reviews-for-woocommerce-common-deactivation-notice.php';
		}
	}

	// Checking the Existance of the same name funciton in the file.
	if ( ! function_exists( 'mwb_prfw_plugin_deactivate_dependency' ) ) {
		/**
		 * Function Name : mwb_prfw_plugin_deactivate_dependency.
		 * This Function will Be called at the deactivation time.
		 *
		 * @return void
		 * @since             1.0.0
		 */
		function mwb_prfw_plugin_deactivate_dependency() {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			unset( $_GET['activate'] );
		}
	}
}


