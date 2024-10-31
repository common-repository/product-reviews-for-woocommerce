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
$prfw_template_settings = apply_filters( 'prfw_template_settings_array', array() );
?>
<!--  template file for admin settings. -->
<div class="prfw-section-wrap">
	<?php
		$prfw_template_html = $prfw_mwb_prfw_obj->mwb_prfw_plug_generate_html( $prfw_template_settings );
		echo esc_html( $prfw_template_html );
	?>
</div>
