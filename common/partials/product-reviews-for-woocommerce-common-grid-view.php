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
 * @subpackage Product_Reviews_For_Woocommerce/common/partials
 */

$args = array(

	'type__in' => 'review',
	'status' => 'approve',
	'number' => 6,
);

	$comments_query  = new WP_Comment_Query();
	$comment_details = $comments_query->query( $args );
echo '<div class="mwb_prfw_grid-review_container_wrapper">';
if ( $comment_details ) {
	foreach ( $comment_details as $k => $value ) {

		$comment_id = $value->comment_ID;
		$current_post_id = $value->comment_post_ID;
		$author = $value->comment_author;
		$content = $value->comment_content;
		$uid = $value->user_id;
		if ( '0' !== $uid ) {

			$user = get_user_by( 'ID', $uid );
			$u_role = $user->roles[0];
		} else {
			$u_role = __( 'Guest', 'product-reviews-for-woocommerce' );
		}
		$rating = get_comment_meta( $comment_id, 'rating', true );
		$prfw_title  = get_comment_meta( $comment_id, 'mwb_add_review_title', true );
		$comment_avatar = get_comment( $comment_id );
		$avatar = get_avatar( $comment_avatar, 32, 'mystery' );
		$product = wc_get_product( $current_post_id );
		$product_title = $product->get_title();
		$product_link = get_permalink( $current_post_id );
		$p_image = $product->get_image();
		$get_positive_count_val = get_comment_meta( $comment_id, 'mwb_prfw_positive_vote_count', true );
		$get_negative_count_val = get_comment_meta( $comment_id, 'mwb_prfw_negative_vote_count', true );
		if ( $get_positive_count_val ) {
			$get_positive_count = $get_positive_count_val;
		} else {
			$get_positive_count = 0;
		}
		if ( $get_negative_count_val ) {
			$get_negative_count = $get_negative_count_val;
		} else {
			$get_negative_count = 0;
		}
		$img        = get_comment_meta( $comment_id, 'mwb_review_image', true );

		?>

	<div class="mwb_prfw_grid-review_container_all">
		<ul class="mwb_prfw_grid-review_container">
			<li class="mwb_prfw_grid-review_content_head">
				<div class="mwb_prfw_grid-review_content_head_content">
					<div class="mwb_prfw_grid-review_content_head_img">
						<?php echo esc_url( $avatar ); ?>
					</div>
					<div class="mwb_prfw_grid-review_content_head_other">
						<div class="mwb_prfw_grid-review_content_head_title">
							<?php echo esc_html( $author ); ?>
						</div>
						<div class="mwb_prfw_grid-review_content_head_subtitle">
							<?php echo esc_html( $u_role ); ?>
						</div>
					</div>
				</div>
				<div class="mwb_prfw_grid-review_content_star">
					<div class="mwb_prfw_grid-review_content_star_icons">
					<?php
					for ( $i = 1; $i <= $rating; $i++ ) {
						?>
						<svg class="mwb_prfw_grid-review_content_star_icon" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.10326 0.816985C6.47008 0.0737389 7.52992 0.0737404 7.89674 0.816986L9.11847 3.29249C9.26413 3.58763 9.5457 3.7922 9.87141 3.83953L12.6033 4.2365C13.4235 4.35568 13.751 5.36365 13.1575 5.94219L11.1807 7.8691C10.945 8.09884 10.8375 8.42984 10.8931 8.75423L11.3598 11.4751C11.4999 12.292 10.6424 12.9149 9.90881 12.5293L7.46534 11.2446C7.17402 11.0915 6.82598 11.0915 6.53466 11.2446L4.09119 12.5293C3.35756 12.9149 2.50013 12.292 2.64024 11.4751L3.1069 8.75423C3.16254 8.42984 3.05499 8.09884 2.81931 7.8691L0.842496 5.94219C0.248979 5.36365 0.576491 4.35568 1.39671 4.2365L4.12859 3.83953C4.4543 3.7922 4.73587 3.58763 4.88153 3.29249L6.10326 0.816985Z" fill="#FFB515" />
						</svg>
						<?php
					}
					?>
					</div>
					<div class="mwb_prfw_grid-review_content_star_count">
						<?php echo esc_html( $rating ) . ' / 5'; ?>
					</div>
				</div>
			</li>
			<li class="mwb_prfw_grid-review_content_body">
				<div class="mwb_prfw_grid-review_body_content">
					<p class="mwb_prfw_grid-review_body_title">
						<?php
						if ( $prfw_title ) {
							echo esc_html( $prfw_title );
						}
						?>
					</p>
					<div class="mwb_prfw_grid-review_body_para mwb_prfw-review_body_para">
					<?php
					if ( $content ) {
						echo esc_html( $content );
					}
					?>
					<div class="mwb_prfw_extra-feature-grid">
					<?php
					$dynamic_feature = get_comment_meta( $comment_id, 'mwb_prfw_dynamic_review_features', true );
					if ( $dynamic_feature ) {
						echo "<div class='mwb_prfw-main_review_extra'>";
						foreach ( $dynamic_feature as $key => $value ) {
							$v = str_replace( '_', ' ', trim( $key ) );
							echo esc_html( $v );
							if ( $value > 0 ) {
								?>
								<div>
								<?php
								for ( $i = 1; $i <= $value; $i++ ) {
									?>
									<svg class="mwb_prfw_grid-review_content_star_icon" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M6.10326 0.816985C6.47008 0.0737389 7.52992 0.0737404 7.89674 0.816986L9.11847 3.29249C9.26413 3.58763 9.5457 3.7922 9.87141 3.83953L12.6033 4.2365C13.4235 4.35568 13.751 5.36365 13.1575 5.94219L11.1807 7.8691C10.945 8.09884 10.8375 8.42984 10.8931 8.75423L11.3598 11.4751C11.4999 12.292 10.6424 12.9149 9.90881 12.5293L7.46534 11.2446C7.17402 11.0915 6.82598 11.0915 6.53466 11.2446L4.09119 12.5293C3.35756 12.9149 2.50013 12.292 2.64024 11.4751L3.1069 8.75423C3.16254 8.42984 3.05499 8.09884 2.81931 7.8691L0.842496 5.94219C0.248979 5.36365 0.576491 4.35568 1.39671 4.2365L4.12859 3.83953C4.4543 3.7922 4.73587 3.58763 4.88153 3.29249L6.10326 0.816985Z" fill="#FFB515" />
									</svg>
									<?php
								}
								?>
									</div>
								<?php
							}
						}
						echo '</div>';
					}
					?>

					</div>
					<div class="mwb_prfw-review_body_para_img_wrapper">
						<ul class="mwb_prfw-review_body_para_img_container">
						<?php
						if ( $img ) {
							foreach ( $img as $k => $value ) {
								$mwb_prfw_file_type_check = wp_check_filetype( $value )['ext'];
								?>
								<li class="mwb_prfw-review_body_para_img">
								<?php
								if ( 'jpg' === $mwb_prfw_file_type_check || 'jpeg' === $mwb_prfw_file_type_check || 'png' === $mwb_prfw_file_type_check || 'svg' === $mwb_prfw_file_type_check || 'gif' === $mwb_prfw_file_type_check || 'tiff' === $mwb_prfw_file_type_check || 'bmp' === $mwb_prfw_file_type_check || 'raw' === $mwb_prfw_file_type_check || 'eps' === $mwb_prfw_file_type_check ) {
									?>
									<img src="<?php echo esc_url( $value ); ?> " width='100px' height='100px' >
									<?php
								} else {
									?>

									<video width="100" controls ><source src='<?php echo esc_url( $value ); ?> '></video>
										<?php
								}
								?>

								</li>
								<?php
							}
						}

						?>
						</ul>
					</div>
				</div>
			</li>
			<li class="mwb_prfw_grid-review_content_footer">
				<div class="mwb_prfw_grid-review_footer_content">
					<span class="mwb_prfw-review_footer_more">
					<?php esc_html_e( 'See More..', 'product-reviews-for-woocommerce' ); ?>
					</span>
					<div class="mwb_prfw_grid-review_footer_reactions">
						<span class="mwb_prfw-review_footer_like">
							<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2 14.75H2.75V5H2C1.60218 5 1.22064 5.15804 0.93934 5.43934C0.658035 5.72064 0.5 6.10218 0.5 6.5V13.25C0.5 13.6478 0.658035 14.0294 0.93934 14.3107C1.22064 14.592 1.60218 14.75 2 14.75ZM14 5H8.75L9.5915 2.474C9.66659 2.24856 9.68704 2.00851 9.65118 1.77362C9.61532 1.53872 9.52417 1.31571 9.38523 1.12295C9.2463 0.930182 9.06356 0.773182 8.85206 0.664877C8.64056 0.556572 8.40636 0.500062 8.16875 0.5H8L4.25 4.5785V14.75H12.5L15.434 8.303L15.5 8V6.5C15.5 6.10218 15.342 5.72064 15.0607 5.43934C14.7794 5.15804 14.3978 5 14 5Z" fill="#C7C7C7" />
							</svg>
							<span class="mwb_prfw-like_count"><?php echo esc_html( $get_positive_count ); ?></span>
						</span>
						<span class="mwb_prfw-review_footer_dislike">
							<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2 0.25L2.75 0.25L2.75 10L2 10C1.60217 10 1.22064 9.84196 0.939339 9.56066C0.658035 9.27936 0.5 8.89782 0.499999 8.5L0.499999 1.75C0.499999 1.35218 0.658034 0.970645 0.939339 0.689341C1.22064 0.408035 1.60217 0.25 2 0.25ZM14 10L8.75 10L9.5915 12.526C9.66659 12.7514 9.68704 12.9915 9.65118 13.2264C9.61532 13.4613 9.52417 13.6843 9.38523 13.8771C9.2463 14.0698 9.06356 14.2268 8.85206 14.3351C8.64056 14.4434 8.40636 14.4999 8.16875 14.5L8 14.5L4.25 10.4215L4.25 0.25L12.5 0.249999L15.434 6.697L15.5 7L15.5 8.5C15.5 8.89782 15.342 9.27935 15.0607 9.56066C14.7794 9.84196 14.3978 10 14 10Z" fill="#C7C7C7" />
							</svg>
							<span class="mwb_prfw-dislike_count"><?php echo esc_html( $get_negative_count ); ?></span>
						</span>
					</div>
				</div>
			</li>
			<li class="mwb_prfw_list-review__product_link">
			<a href="<?php echo esc_html( $product_link ); ?>">
				<div class="mwb_prfw_list-review__product_img">
					<?php echo esc_url( $p_image ); ?>
				</div>
				<span class="mwb_prfw_list-review__product_title">
					<?php echo esc_html( $product_title ); ?>
				</span>
			</a>
			</li>
		</ul>
	</div>
		<?php
	}
	echo '</div>';
}
