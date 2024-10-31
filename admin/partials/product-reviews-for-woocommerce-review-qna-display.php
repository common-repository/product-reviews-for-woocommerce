<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to show review-logs logs.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package   Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/admin/partials
 */

?>
<div class="wpg-secion-wrap">
	<?php
	require_once PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_PATH . '/includes/class-product-reviews-for-woocommerce-qna-data.php';

	do_action( 'mwb__bulk_action_success_notice' );
	$obj = new Product_Reviews_For_Woocommerce_Qna_Data();
	$obj->views();
	$obj->prepare_items();
	echo '<form method="POST">';
	echo '<input type="hidden" name="nonce" value=' . esc_html( wp_create_nonce() ) . '>';
	$obj->display();
	echo '</form>';
	?>
</div>
