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
?>

<div class="mwb-overview__wrapper">
	<div class="mwb-overview__banner">
		<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ); ?>admin/image/banner.png" alt="Overview banner image">
	</div>
	<div class="mwb-overview__content">
		<div class="mwb-overview__content-description">
			<h2><?php echo esc_html_e( 'What Is Product Reviews For WooCommerce?', 'product-reviews-for-woocommerce' ); ?></h2>
			<p>
				<?php
				esc_html_e( 'Product Reviews For WooCommerce is a solution to enhance and optimize the review section of the product page. With the help of this plugin, you can make the review section more engaging and substantially increase the number of customer feedback on your eCommerce website. The vendor can easily manage the review on an eCommerce store and send email reminders to the customers to collect feedback on their recent purchases.', 'product-reviews-for-woocommerce' );
				?>
			</p>
			<h3><?php esc_html_e( 'With Our Product Reviews For WooCommerce, You Can:', 'product-reviews-for-woocommerce' ); ?></h3>
			<ul class="mwb-overview__features">
				<li><?php esc_html_e( 'Send email reminders to customers and collect their feedback on their recent purchases.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Give an exclusive discount to customers on their first review.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Ability to show popup forms for collecting reviews on the product page.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'You can allow submitting a review form through Ajax.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Present reviews on the product page in the form of a grid, list, or slider.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Allow the customers to upload images of their products.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'The customer can also ask questions about the product and get answers to make an informed purchase decision', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'Collect reviews from your customers based on various features of a product by dynamically adding them through your plugin.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'The customers can interact with the reviews, questions, and answers by upvoting them.', 'product-reviews-for-woocommerce' ); ?></li>
				<li><?php esc_html_e( 'The admin can import and export the reviews in a CSV file format.', 'product-reviews-for-woocommerce' ); ?></li>
			</ul>
		</div>
		<h2> <?php esc_html_e( 'The Free Plugin Benefits', 'product-reviews-for-woocommerce' ); ?></h2>
		<div class="mwb-overview__keywords">
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Enhance-The-Rating-System.png' ); ?>" alt="The-Rating-System">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( ' Enhance The Rating System', 'product-reviews-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'The vendors can optimize the default WooCommerce product rating system for their eCommerce websites. The vendor can allow the customers to rate the products on the basis of their attributes.',
								'product-reviews-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Upload-Image.png' ); ?>" alt="Upload-Image">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Upload Image', 'product-reviews-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description"><?php echo esc_html_e( 'The plugin makes your review section interactive by allowing the customers to upload images of their recent purchases. This also helps fellow customers to figure out how the products work in real life.', 'product-reviews-for-woocommerce' ); ?></p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Send-Automated-Reminders.png' ); ?>" alt="Send-Automated-Reminders">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Send Automated Reminders', 'product-reviews-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							echo esc_html_e(
								'You can send automated email reminders to your customers and ask them to review their recent orders. Thus, letting you substantially increase the number of customer reviews on your store.',
								'product-reviews-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Exclusive-Discounts.png' ); ?>" alt="Exclusive-Discounts">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Exclusive Discounts', 'product-reviews-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							echo esc_html_e(
								'Welcome your customers by giving them an exclusive discount on their first product review. Thus, motivating the shoppers to interact with your store more often.',
								'product-reviews-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Customer--Questions.png' ); ?>" alt="Customer--Questions">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( 'Customer  Questions', 'product-reviews-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							echo esc_html_e(
								'The customers can ask questions about the product and get answered to all their queries. Thus, allowing the shoppers to make an informed purchase decision.',
								'product-reviews-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
			<div class="mwb-overview__keywords-item">
				<div class="mwb-overview__keywords-card mwb-card-support">
					<div class="mwb-overview__keywords-image">
						<img src="<?php echo esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL . 'admin/image/Interactive-Representation.png' ); ?>" alt="Interactive-Representation">
					</div>
					<div class="mwb-overview__keywords-text">
						<h3 class="mwb-overview__keywords-heading"><?php echo esc_html_e( ' Interactive Representation', 'product-reviews-for-woocommerce' ); ?></h3>
						<p class="mwb-overview__keywords-description">
							<?php
							esc_html_e(
								'Provide an interactive representation of your customers’ precious words on the product page. The customers can interact with the review section by either upvoting or downvoting the reviews, questions, and answers by fellow shoppers.',
								'product-reviews-for-woocommerce'
							);
							?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
