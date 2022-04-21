<?php
/**
 * Tar bort pingbacks genererade innifrån webbplatsen (interna) https://paulund.co.uk/how-to-disable-self-trackbacks
 * @since      1.4
 * @package    Iis_Pack
 * @subpackage Iis_Pack/partials
 */

/**
 * Calls the class after theme setup (tror detta borde är korrekt /Thomas)
 */
function call_disable_internal_pingbacks() {
	new DisableInternalPingbacks();
}

/**
 * The Class.
 */
class DisableInternalPingbacks {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'pre_ping', array( $this, 'disable_self_trackback' ) );
	}

	/**
	 * [disable_self_trackback description]
	 * @param  [type] $links [description]
	 * @return void
	 */
	function disable_self_trackback( &$links ) {
        $home_url = get_option( 'home' );

		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, $home_url ) ) {
				unset( $links[ $l ] );
			}
		}
	}



} // END class
