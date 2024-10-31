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

global $product, $wpdb;
			$product_id = $product->get_id();
		echo '<div id="mwb_qstn_ask_button">';
		echo esc_html__( 'FAQ Module', 'product-reviews-for-woocommerce' );
		echo '<button id="mwb_ask_qa">Ask a Question</button>';
		$this->mwb_prfw_question_modal();
		echo '</div>';
		$args = array(
			'type__in' => 'mwb_qa',
			'parent'   => 0,
			'post_id'  => $product_id,
			'status'  => 'approve',
		);

		$author = '';
		$email_val = '';
		if ( is_user_logged_in() ) {
				$current_user_details = wp_get_current_user();
				$author               = $current_user_details->user_login;
				$email_val            = $current_user_details->user_email;

		}
		$comments_query = new WP_Comment_Query();
		$result = $comments_query->query( $args );
		echo '<div class="mwb_parent_div_qa">';
		if ( ! empty( $result ) ) {
			foreach ( $result as $key => $value ) {
						$que_comment_date = $value->comment_date;
						$q_date_time      = strtotime( $que_comment_date );
						$final_q_date     = gmdate( 'd/m/Y', $q_date_time );
				?>
					<div>
					<div class="mwb_asked_qstn">
						<p><?php echo esc_html( 'Question No: ' . ( $key + 1 ) ); ?></p>
						<p><strong><?php esc_html_e( 'Question : ', 'product-reviews-for-woocommerce' ); ?></strong>
							<?php echo esc_html( $value->comment_content ); ?></p>
						<p><?php esc_html_e( 'Asked By : ', 'product-reviews-for-woocommerce' ); ?>
						<?php
						echo esc_html( $value->comment_author );
						esc_html_e( '  on', 'product-reviews-for-woocommerce' );
						echo esc_html( ' ' . $final_q_date );
						?>
						</p>
						<button class="mwb_reply_qa_button" data-comment-id="<?php echo esc_html( $value->comment_ID ); ?>" ><?php esc_html_e( 'Reply to this question', 'product-reviews-for-woocommerce' ); ?></button>
						<div class="mwb_prfw-answer_reply_wrapper" >
						<?php
						$args2 = array(
							'type__in' => 'mwb_qa',
							'parent'   => $value->comment_ID,
							'status'  => 'approve',

						);
						$ans_result = $comments_query->query( $args2 );
						if ( ! empty( $ans_result ) ) {
							foreach ( $ans_result as $k => $ans_value ) {
									$ans_u_id = $ans_value->user_id;
									$user             = get_user_by( 'ID', $ans_u_id );
									$ans_comment_date = $ans_value->comment_date;
									$timestamp        = strtotime( $ans_comment_date );
									$final_date       = gmdate( 'd/m/Y', $timestamp );
								?>
								<div class="mwb_asnwerdqstn">
									<p class="mwb_asnwerdqstn_main"><strong>
									<?php
										esc_html_e( 'Answer : ', 'product-reviews-for-woocommerce' );
									?>
										</strong>
										<?php echo esc_html( $ans_value->comment_content ); ?>
									</p>
									<p>
									<?php
										esc_html_e( 'Answered By : ', 'product-reviews-for-woocommerce' );
									?>
									<?php
											echo esc_html( $ans_value->comment_author ) . '"' . esc_html( $user->roles[0] ) . '"';
											esc_html_e( 'on', 'product-reviews-for-woocommerce' );
											echo esc_html( ' ' . $final_date );
									?>
								</p>
										<?php
										$comment_id = $ans_value->comment_ID;
										$mwb_positive_count = get_comment_meta( $comment_id, 'mwb_prfw_positive_vote_count', true );

										$mwb_negative_count = get_comment_meta( $comment_id, 'mwb_prfw_negative_vote_count', true );

										$count_meta_vote = get_comment_meta( $comment_id, 'mwb_prfw_review_vote_count', true );
										echo '<div class="mwb_prfw-review_like_see_more">';
										echo '<span class="mwb_prfw-review_see_more_button">' . esc_html__( 'See more..', 'product-reviews-for-woocommerce' ) . '</span>';
										$enable_qa_voting = get_option( 'mwb_prfw_enable_qna_vote' );
										if ( $enable_qa_voting ) {
												echo '<div class="mwb_prfw-review_ans_like_dislike" id="button_review_div' . esc_html( $comment_id ) . '">';
											?>
										<a href="javascript:void(0)" data-comment-id="<?php echo esc_html( $comment_id ); ?>" data-vote-value="yes" class="mwb_prfw_review_vote"><?php echo '<img src ="' . esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . '/public/images/like.svg">'; ?></a><span><?php echo esc_html( $mwb_positive_count ); ?></span>
										<a href="javascript:void(0)" data-comment-id="<?php echo esc_html( $comment_id ); ?>" data-vote-value="no" class="mwb_prfw_review_vote"><?php echo '<img src ="' . esc_html( PRODUCT_REVIEWS_FOR_WOOCOMMERCE_DIR_URL ) . '/public/images/dislike.svg">'; ?></a><span><?php echo esc_html( $mwb_negative_count ); ?></span>
										</div>
									</div>
								</div>
												<?php
										}
							}
						}
						?>
						</div>
					</div>

					<div id="mwb_answer_dialog<?php echo esc_html( $value->comment_ID ); ?>" class="mwb_prfw_custom_class" >
						<div id="mwb_answer_div_form">
							<div class="mwb_ans_form_reply_field_qstn">
							<label for="mwb_ans_form_name_field_qstn<?php echo esc_html( $value->comment_ID ); ?>"><?php esc_html_e( 'Question :', 'product-reviews-for-woocommerce' ); ?></label>
							<p id="mwb_ans_form_name_field_qstn<?php echo esc_html( $value->comment_ID ); ?>"><?php echo esc_html( $value->comment_content ); ?></p>
							<input type="hidden" id="answer_token<?php echo esc_html( $value->comment_ID ); ?>" name="answer_token" >
							</div>
							<div class="mwb_ans_form_reply_fiel_name" >
							<label for="mwb_ans_form_name_field<?php echo esc_html( $value->comment_ID ); ?>"><?php esc_html_e( 'Enter your Name', 'product-reviews-for-woocommerce' ); ?></label>
							<input type="text" class="mwb_prfw_text_qa" id="mwb_ans_form_name_field<?php echo esc_html( $value->comment_ID ); ?>" value="<?php echo esc_html( $author ); ?>">
							<span></span>
							</div>
							<div class="mwb_ans_form_reply_field_email" >
							<label for="mwb_ans_form_email_field<?php echo esc_html( $value->comment_ID ); ?>"><?php esc_html_e( 'Enter your Email', 'product-reviews-for-woocommerce' ); ?></label>
							<input type="text" class="mwb_prfw_email_qa" id="mwb_ans_form_email_field<?php echo esc_html( $value->comment_ID ); ?>"	value="<?php echo esc_html( $email_val ); ?>">
							<span></span>
							</div>
							<div class="mwb_ans_form_reply_field_answer" >
							<label for="mwb_ans_form_answer_field<?php echo esc_html( $value->comment_ID ); ?>"><?php esc_html_e( 'Enter your Answer', 'product-reviews-for-woocommerce' ); ?></label>
							<textarea id="mwb_ans_form_answer_field<?php echo esc_html( $value->comment_ID ); ?>" class="mwb_prfw_qa_field_text_area"></textarea>
							<span></span>
							</div>
							<div class="mwb_ans_form_reply_field_button" >
							<button class="mwb_submit_reply mwb_prfw_qa_submit" data-comment-id="<?php echo esc_html( $value->comment_ID ); ?>" data-product-id="<?php echo esc_html( $value->comment_post_ID ); ?>"  ><?php esc_html_e( 'Submit Answer', 'product-reviews-for-woocommerce' ); ?></button>
							</div>
						</div>
					</div>

				</div>
				<?php
			}
		}
		echo '</div>';
