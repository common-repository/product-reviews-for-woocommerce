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

echo '<div><a class="button  mwb_prfw_manual_reminder" href="javascript:void(0)" data-id = "' . esc_html( $p_id ) . '" title= "' . esc_html__( 'Click Here to send the Review-Reminder.', 'product-reviews-for-woocommerce' ) . '" >' . esc_html__( 'Send Reminder', 'product-reviews-for-woocommerce' ) . '</a></div>';

