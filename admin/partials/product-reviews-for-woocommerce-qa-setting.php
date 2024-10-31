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
$prfw_settings_qa_tab = apply_filters( 'mwb_prfw_qa_settings_array', array() );
?>
<!--  template file for admin settings. -->
<form action="" method="POST" class="mwb-prfw-gen-section-form">
	<div class="prfw-secion-wrap">
	<input type="hidden" name="review_nonce" value="<?php echo esc_html( wp_create_nonce( 'review_nonce' ) ); ?>">
		<?php
		$mwb_prfw_qa_html = $prfw_mwb_prfw_obj->mwb_prfw_plug_generate_html( $prfw_settings_qa_tab );
		echo esc_html( $mwb_prfw_qa_html );
		?>
	</div>
</form>
