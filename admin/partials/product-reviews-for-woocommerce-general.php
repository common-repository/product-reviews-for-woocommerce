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
$prfw_genaral_settings = apply_filters( 'prfw_general_settings_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-prfw-gen-section-form">
	<div class="prfw-secion-wrap">
	<input type="hidden" name="review_nonce" value="<?php echo esc_html( wp_create_nonce( 'review_nonce' ) ); ?>">
		<?php
		$prfw_general_html = $prfw_mwb_prfw_obj->mwb_prfw_plug_generate_html( $prfw_genaral_settings );
		echo esc_html( $prfw_general_html );
		?>
	</div>
</form>
