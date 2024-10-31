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
<form action="#" method="POST" enctype="multipart/form-data" class="mwb_prfw-form_all_file_wrapper">
	<div class="mwb_prfw-upload_csv_file_wrapper">
		<label for="upload_csv"><?php esc_html_e( 'Upload csv file', 'product-reviews-for-woocommerce' ); ?>
		<input type="hidden" name="upload_csv_nonce" value="<?php echo esc_html( wp_create_nonce( 'upload_csv_nonce' ) ); ?>">
		<input type="file" name="upload_csv_review" id="upload_review_csv" ></label>
		<input type="submit" name="upload_csv_review_button" class="button primary" value="<?php esc_html_e( 'Upload Csv File', 'product-reviews-for-woocommerce' ); ?>">
	</div>

	<div class="mwb_prfw_download_dummy_csv">
		<button class="button" id="mwb_download_csv_file_dummy"><?php esc_html_e( 'Download Dummy CSV File', 'product-reviews-for-woocommerce' ); ?></button>
		<button class="button" id="mwb_export_csv_file"><?php esc_html_e( 'Export reviews', 'product-reviews-for-woocommerce' ); ?></button>
	</div>
</form>
