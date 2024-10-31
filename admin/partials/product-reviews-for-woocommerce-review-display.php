<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}
?>


<div class="wpg-secion-wrap">
	<?php
	require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . '/includes/class-product-reviews-for-woocommerce-review-data.php';

	do_action( 'mwb_show_review_notice' );
	$obj = new Product_Reviews_For_Woocommerce_Review_Data();
	$obj->views();
	$obj->prepare_items();
	echo '<form method="POST">';
	echo '<input type="hidden" name="nonce" value=' . esc_html( wp_create_nonce() ) . '>';
	$obj->display();
	echo '</form>';
	do_action( 'mwb_prfw_file_upload_review_csv' );
	?>
</div>
