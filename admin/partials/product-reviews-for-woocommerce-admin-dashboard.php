<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Product_Reviews_For_Woocommerce
 * @subpackage Product_Reviews_For_Woocommerce/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {

	exit(); // Exit if accessed directly.
}

global $prfw_mwb_prfw_obj, $error_notice;
$prfw_active_tab   = isset( $_GET['prfw_tab'] ) ? sanitize_key( $_GET['prfw_tab'] ) : 'product-reviews-for-woocommerce-general';
$prfw_default_tabs = $prfw_mwb_prfw_obj->mwb_prfw_plug_default_tabs();

do_action( 'mwb_prfw_show_license_notice' );
?>
<header>

	<div class="mwb-header-container mwb-bg-white mwb-r-8">
		<h1 class="mwb-header-title"><?php echo esc_attr( strtoupper( str_replace( '-', ' ', $prfw_mwb_prfw_obj->prfw_get_plugin_name() ) ) ); ?></h1>
		<a href="https://docs.makewebbetter.com/" target="_blank" class="mwb-link"><?php esc_html_e( 'Documentation', 'product-reviews-for-woocommerce' ); ?></a>
		<span>|</span>
		<a href="https://makewebbetter.com/contact-us/" target="_blank" class="mwb-link"><?php esc_html_e( 'Support', 'product-reviews-for-woocommerce' ); ?></a>
	</div>
</header>
<?php

if ( ! $error_notice ) {
	$prfw_mwb_prfw_obj->mwb_prfw_plug_admin_notice( 'Settings saved !', 'success' );
}

?>

<main class="mwb-main mwb-bg-white mwb-r-8">
	<nav class="mwb-navbar">
		<ul class="mwb-navbar__items">
			<?php
			if ( is_array( $prfw_default_tabs ) && ! empty( $prfw_default_tabs ) ) {

				foreach ( $prfw_default_tabs as $prfw_tab_key => $prfw_default_tabs ) {

					$prfw_tab_classes = 'mwb-link ';

					if ( ! empty( $prfw_active_tab ) && $prfw_active_tab === $prfw_tab_key ) {
						$prfw_tab_classes .= 'active';
					}
					?>
					<li>
						<a id="<?php echo esc_attr( $prfw_tab_key ); ?>" href="<?php echo esc_url( admin_url( 'admin.php?page=product_reviews_for_woocommerce_menu' ) . '&prfw_tab=' . esc_attr( $prfw_tab_key ) ); ?>" class="<?php echo esc_attr( $prfw_tab_classes ); ?>"><?php echo esc_html( $prfw_default_tabs['title'] ); ?></a>
					</li>
					<?php
				}
			}
			?>
		</ul>
	</nav>
	<section class="mwb-section">
		<div>
	<?php
	do_action( 'mwb_prfw_before_general_settings_form' );
			// if submenu is directly clicked on woocommerce.
	if ( empty( $prfw_active_tab ) ) {
		$prfw_active_tab = 'mwb_prfw_plug_general';
	}

			// look for the path based on the tab id in the admin templates.
	$prfw_tab_content_path = 'admin/partials/' . $prfw_active_tab . '.php';

	$prfw_mwb_prfw_obj->mwb_prfw_plug_load_template( $prfw_tab_content_path );

	do_action( 'mwb_prfw_after_general_settings_form' );
	?>
		</div>
	</section>
