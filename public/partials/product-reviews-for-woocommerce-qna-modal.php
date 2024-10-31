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

$author    = '';
$email_val = '';
if ( is_user_logged_in() ) {
		$current_user_details = wp_get_current_user();
		$author               = $current_user_details->user_login;
		$email_val            = $current_user_details->user_email;

}
?>
<div id="mwb_qa_form_div" class="mwb_prfw_custom_class"  title="<?php esc_html_e( 'Ask A Question', 'product-reviews-for-woocommerce' ); ?>">
	<div id="mwb_qstn_div_form">
		<div>
		<label for="mwb_qa_form_name_field"><?php esc_html_e( 'Enter your Name', 'product-reviews-for-woocommerce' ); ?></label>
		<input type="text" class="mwb_prfw_text_qa" id="mwb_qa_form_name_field" value="<?php echo esc_html( $author ); ?>">
		<input type="hidden" id="qa_token" name="qa_token" >
		<span></span>
		</div>
		<div>
		<label for="mwb_qa_form_email_field"><?php esc_html_e( 'Enter your Email', 'product-reviews-for-woocommerce' ); ?></label>
		<input type="text" class="mwb_prfw_email_qa" id="mwb_qa_form_email_field" value="<?php echo esc_html( $email_val ); ?>">
		<span></span>
		</div>
		<div>
		<label for="mwb_qa_form_question_field"><?php esc_html_e( 'Enter your Question', 'product-reviews-for-woocommerce' ); ?></label>
		<textarea id="mwb_qa_form_question_field" class="mwb_prfw_qa_field_text_area"></textarea>
		<span></span>
		</div>

		<div>
		<input type="hidden" id="mwb_qa_form_comment_product_id" value="<?php echo esc_html( $pid ); ?>">
		<button id="submit_form_qa" class="mwb_prfw_qa_submit"><?php esc_html_e( 'Submit Question', 'product-reviews-for-woocommerce' ); ?></button>
		</div>
	</div>
</div>
