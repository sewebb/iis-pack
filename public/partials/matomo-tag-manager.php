<?php
/**
 * Add Matomo Tag Manager tracking scripts
 *
 * @link       https://internetstiftelsen.se
 * @since      2.4.2
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) || die;

$iis_mtm_option_trackingid = get_option( 'iis_pack_mtm_id' );

if ( '' !== $iis_mtm_option_trackingid ) {
	add_action( 'wp_head', 'add_iis_matomo_tag_manager_script', 100 );
}

function add_iis_matomo_tag_manager_script() {
	if ( ! current_user_can( 'edit_others_pages' ) ) {
		global $post;

		$iis_mtm_option_trackingid = get_option( 'iis_pack_mtm_id' );

		$printscript = "
			<!-- Matomo Tag Manager -->
			<script>
				var _mtm = window._mtm = window._mtm || [];
                var _otag = window.OnetrustActiveGroups || '';
                if (_otag.includes('C0002')) {
					_mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
					(function() {
						var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
						g.async=true; g.src='https://matomo.internetstiftelsen.se/js/container_{$iis_mtm_option_trackingid}.js'; s.parentNode.insertBefore(g,s);
					})();
                }
			</script>
			<!-- End Matomo Tag Manager -->
		";

		echo apply_filters( 'iis_mtm_script', $printscript );
	}
}
