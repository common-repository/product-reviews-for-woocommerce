<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the html field for general tab.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/admin/template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="notice notice-success is-dismissible">
	<p>
		<?php echo esc_html__( 'Record ', 'product-reviews-for-woocommerce' ) . esc_html( $this->action ) . esc_html__( ' successfully', 'product-reviews-for-woocommerce' ); ?>
	</p>
</div>
<br/>
