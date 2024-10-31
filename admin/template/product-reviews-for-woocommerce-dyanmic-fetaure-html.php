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
<span class="mwb_prfw_dynamic_label">
		<label class="mdc-text-field mdc-text-field--outlined">
		<span class="mdc-notched-outline">
			<span class="mdc-notched-outline__leading"></span>
			<span class="mdc-notched-outline__notch">
				<span class="mdc-floating-label" id="my-label-id"><?php echo ( isset( $new_array['placeholder'] ) ? esc_attr( $new_array['placeholder'] ) : '' ); ?></span>
			</span>
			<span class="mdc-notched-outline__trailing"></span>
		</span>
		<input
		class="mdc-text-field__input <?php echo ( isset( $new_array['class'] ) ? esc_attr( $new_array['class'] ) : '' ); ?>"
		name="<?php echo ( isset( $new_array['name'] ) ? esc_html( $new_array['name'] ) : esc_html( $new_array['id'] ) ); ?>"
		id="<?php echo esc_attr( $new_array['id'] ); ?>"
		type="<?php echo esc_attr( $new_array['type'] ); ?>"
		value="<?php echo ( isset( $new_array['value'] ) ? esc_attr( $new_array['value'] ) : '' ); ?>"
		placeholder="<?php echo ( isset( $new_array['placeholder'] ) ? esc_attr( $new_array['placeholder'] ) : '' ); ?>"
		>
	</label>
	<button class="mwb_prfw_delete_button_feature_review_field" data-index-input="<?php echo esc_attr( $count ); ?>" >X</button>
</span>
