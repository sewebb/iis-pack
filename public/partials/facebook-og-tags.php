<?php
/**
 * Provide a public-facing view Facebook og-taggar
 *
 * @link       https://www.iis.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

$default_og_image = get_option( 'iis_pack_default_og_image', 'https://static.iis.se/images/iis-logo-featured.png' );
$protocol         = get_option( 'iis_pack_protocol', 'https' );
$fbappid          = get_option( 'iis_pack_fbappid' );
$fbadmins         = get_option( 'iis_pack_fbadmins', array() );

if ( empty( $default_og_image ) ) {
	$default_og_image = 'https://static.iis.se/images/iis-logo-featured.png';
}
$ogprint = '';
$servername = esc_attr( strip_tags( $_SERVER['SERVER_NAME'] ) );

if ( ! empty( $fbadmins ) ) {
	$fbadmins  = explode( ',', $fbadmins );
	$arrlength = count( $fbadmins );
	for ( $x = 0; $x < $arrlength; $x++ ) {
	    $ogprint .= '<meta property="fb:admins" content="' . $fbadmins[ $x ] .'" />';
	}
	$ogprint .= "\n";
}

if ( ! empty( $fbappid ) ) {
	$ogprint .= '<meta property="fb:app_id" content="' . $fbappid . '" />';
	$ogprint .= "\n";
}

// Bättre med SERVER-variabler än get_permalink så att og:url alltid får ett korrelt värde även på arkivsidor
$ogprint .= '<meta property="og:url" content="' . $protocol . '://' . $servername . esc_attr( strip_tags( $_SERVER['REQUEST_URI'] ) ) . '" />';
$ogprint .= "\n";
// Ersätts om möjligt längre ner
$str_excerpt            = '';
$str_title              = '';
$site_description       = get_bloginfo( 'description' );
$before_filter_og_image = '';
$og_image_width         = '';
$og_image_height        = '';

if ( is_singular() || is_home() || is_archive() || is_front_page() ) {

	global $post;
	$og_img_set = false;
	$no_og_type = false;

	// Problem som hittades på IIS Academy reinvented
	if ( isset( $post->ID ) && '' !== trim( $post->ID ) ) {

		if ( has_post_thumbnail( $post->ID ) && ! is_home() && ! is_archive() ) {
			$arr_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			// En del bilder verkar ha sparats med hela sökvägen
			if ( false === strpos( $arr_thumb[0], 'http' ) ) {
				$og_image = $protocol . '://' . $servername . $arr_thumb[0];
			} else {
				$og_image = $arr_thumb[0];
			}
			// Om vi kan använda widt & height så kommer fb att visa bilden även vid första delningen
			$og_image_width  = $arr_thumb[1];
			$og_image_height = $arr_thumb[2];

			$before_filter_og_image = $og_image;
			$og_img_set      = true;
		} else {
			$og_image = $default_og_image;
		}

		$og_image        = apply_filters( 'iis_og_image' , $og_image, $post->ID, $og_img_set );
		$og_image_width  = apply_filters( 'iis_og_image_width' , $og_image_width, $post->ID );
		$og_image_height = apply_filters( 'iis_og_image_height' , $og_image_height, $post->ID );

		if ( is_front_page() || is_home() || is_archive() ) {
			$og_type = 'website';

		} elseif ( is_404() ) {
			$no_og_type = true;

		} else {
			$og_type = 'article';

			$og_meta_description = get_post_meta( $post->ID, 'facebook_description', true );
			if ( ! empty( $og_meta_description ) ) {
				$meta = $og_meta_description;
			} else {
				$meta = get_post_meta( $post->ID, 'iis_meta_description', true );
			}

			if ( ! empty( $meta ) ) {
				$site_description = esc_attr( $meta );

			} else {
				$str_excerpt = strip_tags( $post->post_excerpt );
			}

			$og_meta_title = get_post_meta( $post->ID, 'facebook_title', true );
			if ( ! empty( $og_meta_title ) ) {
				$str_title = $og_meta_title;
			}
		}

		if ( ! $no_og_type ) {
			$ogprint .= '<meta property="og:type" content="' . $og_type . '" />';
			$ogprint .= "\n";
		}

		$str_excerpt = ( strlen( $str_excerpt ) > 0 && ! is_home() ) ? str_replace( '"', '&quot;', $str_excerpt ) : $site_description;

		$str_excerpt = apply_filters( 'iis_og_description', $str_excerpt, $post->ID );


		if ( empty( $str_title ) ) {
			$str_title = trim( wp_title( ' ', false, 'right' ) );
			// If site wants to modify title
			// @since      1.4.3
			$str_title = apply_filters( 'pre_get_document_title', $str_title, $post->ID );
		}

		$str_title = (strlen( $str_title ) > 0 && ! is_404() ) ? $str_title : get_bloginfo( 'name' );

		$ogprint .= '<meta property="og:image" content="' . $og_image . '" />';
		$ogprint .= "\n";

		if ( '' !== $og_image_width && '' !== $og_image_height ){
			$ogprint .= '<meta property="og:image:width" content="' . $og_image_width . '" /><meta property="og:image:height" content="' . $og_image_height . '" />';
			$ogprint .= "\n";
		}
		$ogprint .= '<meta property="og:title" content="' . $str_title . '" />';
		$ogprint .= "\n";
		$ogprint .= '<meta property="og:description" content="' . $str_excerpt . '" />';
		$ogprint .= "\n";
	} else {
		// Skicka aldrig utan og:taggar
		$ogprint .= '<meta property="og:image" content="' . $default_og_image . '" />';
		$ogprint .= "\n";
		$ogprint .= '<meta property="og:title" content="' . $servername . '" />';
		$ogprint .= "\n";
		$ogprint .= '<meta property="og:description" content="" />';
		$ogprint .= "\n";
	}

} else {
	// Skicka aldrig utan og:taggar
	$ogprint .= '<meta property="og:image" content="' . $default_og_image . '" />';
	$ogprint .= "\n";
	$ogprint .= '<meta property="og:title" content="' . $servername . '" />';
	$ogprint .= "\n";
	$ogprint .= '<meta property="og:description" content="" />';
	$ogprint .= "\n";
}

echo $ogprint;
