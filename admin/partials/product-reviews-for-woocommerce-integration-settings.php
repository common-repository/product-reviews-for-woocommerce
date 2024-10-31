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
$prfw_integration_settings = apply_filters( 'mwb_prfw_integration_settings_array', array() );
?>

<div class="m-section-wrap">
<div class="m-section-note">

<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . 'admin/image/note.svg'; ?>" alt="">

<?php esc_html_e( 'You Can Get The Secret key and Site Key by registration on google recaptcha click', 'product-reviews-for-woocommerce' ); ?> <span><a href="https://www.google.com/recaptcha/about/"><?php esc_html_e( 'here', 'product-reviews-for-woocommerce' ); ?></a></span>
<?php do_action( 'mwb_prffw_pro_twilio_intgration_notice' ); ?>
</div>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-prfw-gen-section-form">
	<div class="prfw-secion-wrap">
	<input type="hidden" name="review_nonce" value="<?php echo esc_html( wp_create_nonce( 'review_nonce' ) ); ?>">
		<?php
		$prfw_integration_html = $prfw_mwb_prfw_obj->mwb_prfw_plug_generate_html( $prfw_integration_settings );
		echo esc_html( $prfw_integration_html );
		?>
	</div>
</form>
