<?php
/**
 * Provide a public-facing view Google Tag Manager
 *
 * @link       https://www.iis.se
 * @since      2.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

$iis_gtm_option_trackingid = get_option( 'iis_pack_gtm_id' );

if ( '' !== $iis_gtm_option_trackingid ) {
	add_action( 'wp_head', 'add_iis_google_tag_manager_script', 100 );
    add_action( 'wp_footer', 'add_iis_google_tag_manager_noscript', 100 );
}

function add_iis_google_tag_manager_script() {

	if ( ! current_user_can( 'edit_others_pages' ) ) {

		global $post;

		$iis_gtm_option_trackingid = get_option( 'iis_pack_gtm_id' );
		$printscript = "
		    <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{$iis_gtm_option_trackingid}');</script>
            <!-- End Google Tag Manager -->
		";

		echo $printscript;
	}
}

function add_iis_google_tag_manager_noscript() {

    if ( ! current_user_can( 'edit_others_pages' ) ) {

        global $post;

        $iis_gtm_option_trackingid = get_option( 'iis_pack_gtm_id' );
        $printscript = "
		    <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id={$iis_gtm_option_trackingid}\"
            height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
		";

        echo $printscript;
    }
}
