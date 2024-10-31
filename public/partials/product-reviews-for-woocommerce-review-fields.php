<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/public/partials
 */

?>
<?php
global $product;

if ( $product ) {
	?>
<p class="comment-form-title uk-margin-top"><label for="title"> <?php esc_html_e( 'Review title', 'product-reviews-for-woocommerce' ); ?></label><input class="uk-input uk-width-large uk-display-block" type="text" name="mwb_title_product_review" id="title"/></p>
<input type="hidden" id="token" name="token">
<input type="hidden" name="review_submit_nonce" value= "<?php echo esc_html( wp_create_nonce( 'review_submit_nonce' ) ); ?>">
<p class="comment-form-image uk-margin-top">
	<?php
	$mwb_prfw_file_type = '<label for="mwb_review_image">' . esc_html__( 'Choose Image to Upload', 'product-reviews-for-woocommerce' ) . '</label><input type="file" id="mwb_review_image" name="mwb_review_image[]" multiple="multiple" accept="image/*" >';
	$mwb_prfw_file_type = apply_filters( 'mwb_prfw_pro_upload_review', $mwb_prfw_file_type );
	$allowed_html       = array(
		'label' => array(
			'for' => array(),
		),
		'input' => array(
			'type'     => array(),
			'id'       => array(),
			'name'     => array(),
			'multiple' => array(),
			'accept'   => array(),
			'class'    => array(),
		),
	);
	echo wp_kses( $mwb_prfw_file_type, $allowed_html );


	?>
</p>

<input type="hidden" name="mwb_prfw_ajax_file_url" id="mwb_prfw_ajax_url_uploaded_image">
<div id="mwb_prfw_show_upload_images">
</div>
	<?php

	$dynamic_fields = get_option( 'mwb_prfw_dynamic_fields_details', array() );
	foreach ( $dynamic_fields as $k => $val ) {
		if ( '' !== $val ) {
			echo '<span class="mwb_prfw-extra_feature_wrapper">';
			echo '<label class="mwb_prfw-extra_feature">' . esc_html( $val ) . '</label>';
			echo '<span class="mwb_prfw-inner_extra_feature">';
			for ( $i = 1; $i <= 5; $i++ ) {
				echo '<svg class="mwb_prfw-star_before_input" width="20" height="20" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M10.7125 0.83497L7.78319 7.04122L1.22918 8.03966C0.053853 8.21779 -0.417174 9.73185 0.435161 10.599L5.17683 15.4272L4.05534 22.2475C3.85347 23.4803 5.09609 24.4037 6.13683 23.8272L12 20.6069L17.8632 23.8272C18.9039 24.399 20.1465 23.4803 19.9447 22.2475L18.8232 15.4272L23.5648 10.599C24.4172 9.73185 23.9461 8.21779 22.7708 8.03966L16.2168 7.04122L13.2875 0.83497C12.7626 -0.271281 11.2419 -0.285343 10.7125 0.83497Z" fill="#FF7A00"/>
						</svg>';
				echo '<input type="radio" name="' . esc_html( str_replace( ' ', '_', trim( $val ) ) ) . '" id="' . esc_html( $val ) . esc_html( $i ) . '" value="' . esc_html( $i ) . '"';
				echo ' /><span class="mwb_prfw-extra_feature_count">' . esc_html( $i ) . '</span>';
			}
			echo '</span>';
			echo '</span>';
		}
	}
	?>
	<?php do_action( 'mwb_prfw_add_attr_slider_fields' ); ?>

</p>
	<?php
}
