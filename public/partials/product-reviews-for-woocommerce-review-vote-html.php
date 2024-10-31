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
<div class="mwb_prfw-voting_main_review" id="button_review_div<?php esc_html( $comment_id ); ?>">
		<a href="javascript:void(0)" data-comment-id="<?php echo esc_html( $comment_id ); ?>" data-vote-value="yes" class="mwb_prfw_review_vote"><?php echo '<img src ="' . esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . '/public/images/like.svg">'; ?></a><span><?php echo esc_html( $mwb_positive_count ); ?></span>
		<a href="javascript:void(0)" data-comment-id="<?php echo esc_html( $comment_id ); ?>" data-vote-value="no" class="mwb_prfw_review_vote"><?php echo '<img src ="' . esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . '/public/images/dislike.svg">'; ?></a><span><?php echo esc_html( $mwb_negative_count ); ?></span>
</div>
