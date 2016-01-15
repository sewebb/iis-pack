<?php
/**
 * Filtrerar oembed (YT just nu)
 *
 * @link       https://www.iis.se
 * @since      1.0.1
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

/**
 * Lägg iframe:en från standard-embedfunktionen i en div för att kunna göra den responsiv med CSS.
 * @param string $code CSS-klass för Youtube-embeds.
 */
function iis_pack_custom_youtube_oembed( $code ) {
	if ( stripos( $code, 'youtube.com' ) !== false && stripos( $code, 'iframe' ) !== false ) {
		$code = str_replace( '<iframe', '<div class="embed-container"><iframe ', $code );
		$code = str_replace( '</iframe>', '</iframe></div>', $code );
		return $code;
	}
	return $code;
}

add_filter( 'the_content', 'iis_pack_custom_youtube_oembed' );
