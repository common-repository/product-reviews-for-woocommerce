<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/admin/onboarding
 */

global $prfw_mwb_prfw_obj;
$prfw_onboarding_form_fields = apply_filters( 'mwb_prfw_on_boarding_form_fields', array() );
?>

<?php if ( ! empty( $prfw_onboarding_form_fields ) ) : ?>
	<div class="mdc-dialog mdc-dialog--scrollable">
		<div class="mwb-prfw-on-boarding-wrapper-background mdc-dialog__container">
			<div class="mwb-prfw-on-boarding-wrapper mdc-dialog__surface" role="alertdialog" aria-modal="true" aria-labelledby="my-dialog-title" aria-describedby="my-dialog-content">
				<div class="mdc-dialog__content">
					<div class="mwb-prfw-on-boarding-close-btn">
						<a href="#"><span class="prfw-close-form material-icons mwb-prfw-close-icon mdc-dialog__button" data-mdc-dialog-action="close">clear</span></a>
					</div>

					<h3 class="mwb-prfw-on-boarding-heading mdc-dialog__title"><?php esc_html_e( 'Welcome to MakeWebBetter', 'product-reviews-for-woocommerce' ); ?> </h3>
					<p class="mwb-prfw-on-boarding-desc"><?php esc_html_e( 'We love making new friends! Subscribe below and we promise to keep you up-to-date with our latest new plugins, updates, awesome deals and a few special offers.', 'product-reviews-for-woocommerce' ); ?></p>

					<form action="#" method="post" class="mwb-prfw-on-boarding-form">
						<?php
						$prfw_onboarding_html = $prfw_mwb_prfw_obj->mwb_prfw_plug_generate_html( $prfw_onboarding_form_fields );
						echo esc_html( $prfw_onboarding_html );
						?>
						<div class="mwb-prfw-on-boarding-form-btn__wrapper mdc-dialog__actions">
							<div class="mwb-prfw-on-boarding-form-submit mwb-prfw-on-boarding-form-verify ">
								<input type="submit" class="mwb-prfw-on-boarding-submit mwb-on-boarding-verify mdc-button mdc-button--raised" value="Send Us">
							</div>
							<div class="mwb-prfw-on-boarding-form-no_thanks">
								<a href="#" class="mwb-prfw-on-boarding-no_thanks mdc-button" data-mdc-dialog-action="discard"><?php esc_html_e( 'Skip For Now', 'product-reviews-for-woocommerce' ); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="mdc-dialog__scrim"></div>
	</div>
<?php endif; ?>