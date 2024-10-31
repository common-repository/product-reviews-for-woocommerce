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
<div class="mwb_prfw_parent_avg_bar">
	<p><?php esc_html_e( 'Average rating', 'product-reviews-for-woocommerce' ); ?></p>
	<div class="mwb_prwf-all_review_avg">
		<div class="mwb_prfw_avg_rating">
			<?php
			$product = wc_get_product( $id );
			$rating  = $product->get_average_rating();
			echo '<div class="mwb_prfw-avg_rating_value">';
			echo '<span class="mwb_prfw-avg_rate">';
			echo esc_html( $rating );
			echo '</span>';
			$count   = $product->get_rating_count();
			echo wp_kses_post( wc_get_rating_html( $rating, $count ) );
			echo '<span class="mwb_prfw-count_value">' . esc_html__( 'Based On ', 'product-reviews-for-woocommerce' ) . esc_html( $get_count ) . esc_html__( ' reviews', 'product-reviews-for-woocommerce' ) . '</span>';
			echo '</div>';
			?>
		</div>
		<div class="mwb-prfw-product-summary">
		<?php
		for ( $i = 5; $i > 0; $i-- ) {
			if ( ! isset( $get_rating_count[ $i ] ) ) {
					$get_rating_count[ $i ] = 0;
			}
				$percentage = 0;
			if ( $get_rating_count[ $i ] > 0 ) {
				$percentage = round( ( $get_rating_count[ $i ] / $rating_ccc ) * 100 );
			}
			?>
			<div class="uk-flex uk-flex-between uk-flex-middle mwb-prfw-progressbar_container">
				<div class="rating-count">
				<div class="count"><?php echo esc_html( $get_rating_text[ $i ] ); ?><?php echo wp_kses_post( wc_get_rating_html( $i ) ); ?></div>
			</div>
			<div class="rating-stars">
			<div class="stars" title="<?php echo esc_html( $get_rating_text[ $i ] ); ?>"></div>
			</div>
			<div class="review-meter" title="<?php printf( '%s%%', esc_html( $percentage ) ); ?>">
			<div class="review-meter-bar"  style="width: <?php echo esc_html( $percentage . '%' ); ?>"></div> </div><div class="review-percent"><?php echo isset( $percentage ) ? esc_html( $percentage . '%' ) : 0; ?></div>
			</div>
			<?php
		}
		?>
		</div>
	</div>
</div>
