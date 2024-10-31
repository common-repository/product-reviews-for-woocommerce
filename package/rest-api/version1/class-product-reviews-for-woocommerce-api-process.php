<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/package/rest-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Product_Reviews_For_Woocommerce_Api_Process' ) ) {

	/**
	 * The plugin API class.
	 *
	 * This is used to define the functions and data manipulation for custom endpoints.
	 *
	 * @since      1.0.0
	 * @package    Product_Reviews_For_Woocommerce
	 * @subpackage Product_Reviews_For_Woocommerce/package/rest-api
	 * @author     makewebbetter <webmaster@makewebbetter.com>
	 */
	class Product_Reviews_For_Woocommerce_Api_Process {

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {

		}

		/**
		 * Define the function to process data for custom endpoint.
		 *
		 * @since    1.0.0
		 * @param   Array $prfw_request  data of requesting headers and other information.
		 * @return  Array $mwb_prfw_rest_response    returns processed data and status of operations.
		 */
		public function mwb_prfw_default_process( $prfw_request ) {
			$mwb_prfw_rest_response = array();

			// Write your custom code here.

			$mwb_prfw_rest_response['status'] = 200;
			$mwb_prfw_rest_response['data'] = $prfw_request->get_headers();
			return $mwb_prfw_rest_response;
		}
	}
}
