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
 * @subpackage Product_Reviews_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $prfw_mwb_prfw_obj;
$prfw_settings_reminder_tab = apply_filters( 'mwb_prfw_reminder_settings_array', array() );
?>

<div class="m-section-wrap">
<div class="m-section-note">

<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/note.svg'; ?>" alt="">

<?php esc_html_e( 'Use Placeholders', 'product-reviews-for-woocommerce' ); ?> <span><?php echo esc_html( '{customer}' ); ?></span> <?php esc_html_e( 'for customer name', 'product-reviews-for-woocommerce' ); ?><span> <?php echo esc_html( ' {product} ' ); ?></span> <?php esc_html_e( 'for displaying the product link', 'product-reviews-for-woocommerce' ); ?>
</div>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-prfw-gen-section-form">
	<div class="prfw-secion-wrap">
	<input type="hidden" name="review_nonce" value="<?php echo esc_html( wp_create_nonce( 'review_nonce' ) ); ?>">
		<?php
		$mwb_prfw_reminder_html = $prfw_mwb_prfw_obj->mwb_prfw_plug_generate_html( $prfw_settings_reminder_tab );
		echo esc_html( $mwb_prfw_reminder_html );
		?>
	</div>
</form>
