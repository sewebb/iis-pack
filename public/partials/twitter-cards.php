<?php
/**
 * Provide a public-facing view of Twitter Cards
 *
 * @link       https://www.iis.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

// Ingen mening att skriva ut korten utan en specificerad site / huvudkonto (ex. @iis eller @internetmuseum)
// https://dev.twitter.com/cards/types/summary-large-image
$twitter_site = get_option( 'iis_pack_twitter_site' );

if ( ! empty( $twitter_site ) ) {

	//Eftersom det är rätt viktigt att det blir rätt
	if ( false === strpos( $twitter_site, '@' ) ) {
		$twitter_site = '@' . $twitter_site;
	}

	$twitter_card        = 'summary_large_image';
	$twitter_title       = '';
	$twitter_description = '';
	$twitter_image       = '';
	// Samma som använd för facebook og-taggar
	$protocol            = get_option( 'iis_pack_protocol', 'https' );
	$servername          = esc_attr( strip_tags( $_SERVER['SERVER_NAME'] ) );

	$show_twitter_card   = false;
	$twitterprint        = '';

	if ( is_singular() || is_home() || is_archive() || is_front_page() ) {

		global $post;
		// Det finns just nu ingen anledning att använda twitter:image eftersom Twitter kommer ta og:image när den saknas
		// Vi avvaktiverar det för tillfället
		// $twitter_image_set = false;

		// if ( has_post_thumbnail( $post->ID ) && ! is_home() && ! is_archive() ) {
		// 	$arr_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		// 	// En del bilder verkar ha sparats med hela sökvägen
		// 	if ( false === strpos( $arr_thumb[0], 'http' ) ) {
		// 		$twitter_image = $protocol . '://' . $servername . $arr_thumb[0];
		// 	} else {
		// 		$twitter_image = $arr_thumb[0];
		// 	}

		// 	$twitter_image_set = true;

		// }
		// $twitter_image = apply_filters( 'iis_twitter_image' , $twitter_image, $post->ID, $twitter_image_set );

		if ( ! is_404() ) {
			$show_twitter_card = true;
			$twitterprint .= '<meta name="twitter:card" content="' . $twitter_card . '">';
			$twitterprint .= "\n";
			$twitterprint .= '<meta name="twitter:site" content="' . $twitter_site . '">';
			$twitterprint .= "\n";
			// Twitter använder og-taggar för twitter: description, title & image om dessa saknas
			// https://dev.twitter.com/cards/markup
			// Så vi behöver inte göra tester fram och tillbaka på vad som ska visas, om twitter:-fälten
			// inte är ifyllda så låter vi Twitter ta från det vi räknat ut gällade Facebook open graph
			$twitter_description = get_post_meta( $post->ID, 'twitter_description', true );
			$twitter_title       = get_post_meta( $post->ID, 'twitter_title', true );

			// Det finns just nu ingen anledning att använda twitter:image eftersom Twitter kommer ta og:image när den saknas
			// Vi avvaktiverar det för tillfället
			// if ( $twitter_image_set ) {
			// 	$twitterprint .= '<meta name="twitter:image" content="' . $twitter_image . '" />';
			// 	$twitterprint .= "\n";
			// }
			if ( ! empty( $twitter_title ) ) {
				$twitterprint .= '<meta name="twitter:title" content="' . $twitter_title . '" />';
				$twitterprint .= "\n";
			}
			if ( ! empty( $twitter_description ) ) {
				$twitterprint .= '<meta name="twitter:description" content="' . $twitter_description . '" />';
				$twitterprint .= "\n";
			}
		}
	}

	if ( $show_twitter_card ) {
		echo $twitterprint;
	}
} // END koll om $twitter_site är satt

