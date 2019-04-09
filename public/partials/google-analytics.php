<?php
/**
 * Provide a public-facing view Google Analytics
 *
 * @link       https://www.iis.se
 * @since      1.0.0
 * @since      1.5.2 Changed from analyzing is_user_logged_in() -> current_user_can( 'edit_others_pages' )
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

$iis_ga_option_trackingid = get_option( 'iis_pack_ga_id' );

if ( '' !== $iis_ga_option_trackingid ) {
	add_action( 'wp_footer', 'add_iis_google_analytics', 100 );
}

/**
 * Om det är en inloggad (IIS-medarbetare) så lägg inte ut GA-scriptet
 */
function add_iis_google_analytics() {

	if ( ! current_user_can( 'edit_others_pages' ) ) {

		global $post;

		$iis_ga_option_trackingid = get_option( 'iis_pack_ga_id' );
		$printscript = '';

		$printscript .= "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');";
		$printscript .= "ga('create', '" . $iis_ga_option_trackingid . "', 'auto');";
		$printscript .= "ga('set', 'anonymizeIp', true);";
		$printscript .= "ga('send', 'pageview');";



		$printscript .= '</script>';

		echo $printscript;
	}
}
