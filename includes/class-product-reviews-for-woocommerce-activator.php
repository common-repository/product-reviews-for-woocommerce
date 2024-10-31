<?php
/**
 * Fired during plugin activation
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Product_Reviews_For_Woocommerce_Activator {

	/**
	 * Function name product_reviews_for_woocommerce_activate
	 *
	 * This function is used when plugin will be activated
	 *
	 * @since    1.0.0
	 */
	public static function product_reviews_for_woocommerce_activate() {
		global $wpdb;

		update_option( 'mwb_prfw_enable', 'on' );
		update_option( 'mwb_prfw_show_form_on', 'page' );
		update_option( 'mwb_prfw_enable_review_voting', 'on' );
		update_option( 'mwb_prfw_review_disc_frequency', 'on' );
		update_option( 'mwb_prfw_enable_review_discount', 'on' );

		$mwb_prfw_review_mail_subject = 'Just wanted to hear about your recent shopping experience';
		$mwb_prfw_coupon_mail_subject = 'Tell us how you feel and receive a small reward';

		update_option( 'mwb_prfw_reminder_subject', $mwb_prfw_review_mail_subject );
		update_option( 'mwb_prfw_coupon_mail_subject', $mwb_prfw_coupon_mail_subject );

		update_option( 'mwb_prfw_reminder_after_days', 5 );

		$mwb_prfw_review_mail_content = 'Hey {customer}
		We’re dying to know your feedback on your recent purchase. Please spare a second to spread the love by clicking on the link below to review your shopping experience
		{product} ';
		$mwb_prfw_coupon_mail_content = 'Hey {customer}
		Tell us about your recent shopping experience and earn this coupon for your first review. Share with us your honest feedback and get this exclusive coupon code for your next purchase.
		Coupon Code:';

		update_option( 'mwb_prfw_reminder_email', $mwb_prfw_review_mail_content );

		update_option( 'mwb_prfw_reminder_email_coupon_content', $mwb_prfw_coupon_mail_content );

		$charset_collate = $wpdb->get_charset_collate();
		$sql = 'CREATE TABLE ' . $wpdb->prefix . "mwb_review_vote (
			id INT(9) NOT NULL AUTO_INCREMENT,
			comment_id varchar(100),
			vote_value varchar(100),
			ip_address varchar(50),
			PRIMARY KEY  (id)
		) $charset_collate;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

	}

}
