<?php
/**
 * Add social buttons on pages / posts based on settings
 *
 * @link       https://www.iis.se
 * @since      1.0.2
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

add_shortcode( 'fastsocial', 'fast_social' );

// Before content, after content or with shortcode
$iis_remove_fss_from_type     = '';
$iis_remove_fss_from_template = '';

$do_not_show_on_this_type     = array();
$do_not_show_on_this_template = array();

$excludefrom_type             = false;
$excludefrom_template         = false;

$options = get_option( 'iis_pack_show_fast_social_share' );
$iis_show_fss_beforecontent   = isset( $options['iis_pack_fss_beforecontent'] ) ? $options['iis_pack_fss_beforecontent'] : '';
$iis_show_fss_aftercontent    = isset( $options['iis_pack_fss_aftercontent'] ) ? $options['iis_pack_fss_aftercontent'] : '';

$iis_remove_fss_from_type     = get_option( 'iis_pack_remove_fss_from_type', array() );
$iis_remove_fss_from_template = get_option( 'iis_pack_remove_fss_from_template', array() );


if ( '' !== $iis_remove_fss_from_type || '' !== $iis_remove_fss_from_template ) {

	if ( '' !== $iis_remove_fss_from_type ) {
		$iis_remove_fss_from_type  = explode( ',', $iis_remove_fss_from_type );
		$arrlength = count( $iis_remove_fss_from_type );
		for ( $x = 0; $x < $arrlength; $x++ ) {
			array_push( $do_not_show_on_this_type, $iis_remove_fss_from_type[ $x ] );
		}
		$excludefrom_type = is_singular( $do_not_show_on_this_type );
	}

	if ( '' !== $iis_remove_fss_from_template ) {
		$iis_remove_fss_from_template  = explode( ',', $iis_remove_fss_from_template );
		$arrlength = count( $iis_remove_fss_from_template );
		for ( $x = 0; $x < $arrlength; $x++ ) {
			array_push( $do_not_show_on_this_template, $iis_remove_fss_from_template[ $x ] );
		}
		$excludefrom_template = is_page_template( $do_not_show_on_this_template );
	}
}

if ( ! $excludefrom_type && ! $excludefrom_template ) {
	if ( $iis_show_fss_beforecontent ) {

		if ( ! is_archive() && ! is_home() ) {
			add_filter( 'the_content', 'share_buttons_before_content' );
		}
	}
	if ( $iis_show_fss_aftercontent ) {

		if ( ! is_archive() && ! is_home() ) {
			add_filter( 'the_content', 'share_buttons_after_content' );
		}
	}
}

/**
 * [share_buttons_before_content description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function share_buttons_before_content( $content ) {
	// kollar om det redan finns shortcode i content - isf lägger vi inte ut igen
	if ( ! has_shortcode( $content, 'fastsocial' ) ) {
		$content = do_shortcode( '[fastsocial position=beforecontent]' ) . $content;
	}
	return $content;
}

/**
 * [share_buttons_after_content description]
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function share_buttons_after_content( $content ) {
	if ( ! has_shortcode( $content, 'fastsocial' ) ) {
		$content .= do_shortcode( '[fastsocial position=aftercontent]' );
	}
	return $content;
}

/**
 * [fast_social description]
 *
 * @since  1.4.2  Check hashtags for wrong format (#tagg #taggtwo -> tagg,taggtwo)
 * @param  [type] $atts [description]
 * @return [type]       [description]
 */
function fast_social( $atts ) {
	global $post;
	//Labels and defaults from options page get_options()
	$options = get_option( 'iis_pack_choose_social_share' );

	// $option_sharelabel    = isset( $options['sharelabel'] ) ? $options['sharelabel'] : '';
	$option_facebook      = isset( $options['iis_pack_enable_facebook'] ) ? $options['iis_pack_enable_facebook'] : '';
	$option_twitter       = isset( $options['iis_pack_enable_twitter'] ) ? $options['iis_pack_enable_twitter'] : '';
	$option_linkedin      = isset( $options['iis_pack_enable_linkedin'] ) ? $options['iis_pack_enable_linkedin'] : '';
	$option_pinterest     = isset( $options['iis_pack_enable_pinterest'] ) ? $options['iis_pack_enable_pinterest'] : '';
	$hashtags             = '';
	$fbappid              = '';
	// extract atts
	//shortcode atts replaces default values from settings per share bar
	extract(
		shortcode_atts(
			array(
				// 'sharelabel'    => ''. $option_sharelabel . '',
				'facebook'      => ''. $option_facebook . '',
				'twitter'       => ''. $option_twitter . '',
				'linkedin'      => ''. $option_linkedin . '',
				'pinterest'     => ''. $option_pinterest . '',
				'hashtags'      => ''. $hashtags . '',
				'fbappid'       => ''. $fbappid . '',
				'position'      => '',
				'margintop'     => '',
				'marginbottom'  => '',
				'remove'        => 'no',
			),
			$atts
		)
	);

	// Check if any social is active, then draw html
	if ( 'yes' == $facebook || 1 == $facebook ) {
		$facebook_enabled = true;
	} else {
		$facebook_enabled = false;
	}
	if ( 'yes' == $twitter || 1 == $twitter ) {
		$twitter_enabled  = true;
	} else {
		$twitter_enabled  = false;
	}
	if ( 'yes' == $linkedin || 1 == $linkedin ) {
		$linkedin_enabled = true;
	} else {
		$linkedin_enabled = false;
	}
	if ( 'yes' == $pinterest || 1 == $pinterest ) {
		$pinterest_enabled = true;  //OBS! Selected or large image must exist per page for Pinterest to work
	} else {
		$pinterest_enabled = false;
	}

	if ( ( $facebook_enabled or $twitter_enabled or $linkedin_enabled  or $pinterest_enabled) && 'no' === $remove ) {
		ob_start();

		if ( '' === $hashtags ) {
			$hashtags = get_post_meta( $post->ID, 'twitter_page_hashtags', true );
			if ( '' !== $hashtags ) {
				$hashtags = str_replace( '#', '', $hashtags );
				$hashtags = str_replace( ' ', ',', $hashtags );
			}
			_log( $hashtags );
		}
		if ( '' === $fbappid ) {
			$fbappid = get_post_meta( $post->ID, 'facebook_page_app_id', true );
		}
		if ( '' === $fbappid ) {
			$fbappid = get_option( 'iis_pack_fbappid' );
		}
		// Så att vi inte av misstag får ut det numeriska värdet 0 som sparas i options
		if ( empty( $fbappid ) ) {
			$fbappid = '';
		}
		if ( function_exists( 'iis_get_current_language' ) ) {
			$lang = iis_get_current_language();
		} else {
			// en pytte namnändring ifall att
			$lang = iis_pack_get_current_language();
		}
		$share = ( 'se' === $lang ) ? 'Dela' : 'Share';
		$tweet = ( 'se' === $lang ) ? 'Twittra' : 'Tweet';

		$output = '<ul class="fast-social-share" data-hashtags="' . esc_attr( $hashtags ) . '" data-fbappid="' . esc_attr( $fbappid ) . '">';

			if ( $facebook_enabled ) {
				$output .= '<li class="fss-button fss-share-facebook"><span class="fss-btn"><span class="ip-fa ip-fa-lg ip-fa-facebook"></span> <span>' . $share . '</span></span>';
				$output .= '</li>';
			}

			if ( $twitter_enabled ) {
				$output .= '<li class="fss-button fss-share-twitter"><span class="fss-btn"><span class="ip-fa ip-fa-lg ip-fa-twitter"></span> <span>' . $tweet . '</span></span>';
				$output .= '</li>';
			}

			if ( $linkedin_enabled ) {
				$output .= '<li class="fss-button fss-share-linkedin"><span class="fss-btn"><span class="ip-fa ip-fa-lg va-no ip-fa-linkedin"></span> <span>' . $share . '</span></span>';
				$output .= '</li>';
			}

			if ( $pinterest_enabled ) {
				$output .= '<li class="fss-button fss-share-pinterest"><span class="fss-btn"><span class="ip-fa ip-fa-lg va-no ip-fa-pinterest"></span> <span>Pin it</span></span>';
				$output .= '</li>';
			}

		$output .= '</ul>';

		$extraclass = '';
		if ( '' !== $position ) {
			$extraclass = ' ' . $position;
		}
		$style = '';
		if ( '' !== $margintop || '' !== $marginbottom ) {
			$style = ' style="';
			if ( '' !== $margintop ) {
				$style .= 'margin-top:' . $margintop . ';';
			}
			if ( '' !== $marginbottom ) {
				$style .= 'margin-bottom:' . $marginbottom . ';';
			}
			$style .= '"';
		}

		$innerhtml = '<div class="iis-fss' . $extraclass . '">' . $output . '</div>';
		echo $innerhtml;
		return ob_get_clean();
	}
}

/**
 * [iis_pack_get_current_languag]
 * En dålig dubblering av koden för att kolla språk. Möjligen borde
 * det vara en gemensam funktion för alla sajter - också flyttas till ett bättre ställe
 * och innehålla alla översättningar för pluggen, och alla sökvägar på olika sajter
 * @return string språk
 */
function iis_pack_get_current_language() {
	if ( substr( $_SERVER['REQUEST_URI'], 0, 8 ) == '/english' ) {
		return 'en';
	}

	if ( function_exists( 'get_queried_object' ) ) {
		$obj = get_queried_object();
		if ( ! is_null( $obj ) && ( 'se-tech' === $obj->name ) ) {
			return 'en';
		}
	}

	$lang        = isset( $_GET['lang'] ) ? strip_tags( $_GET['lang'] ) : '';
	$sessionlang = isset( $_SESSION['lang'] ) ? strip_tags( $_SESSION['lang'] ) : '';
	if ( strlen( $lang ) > 0 ) {
		return $lang;
	}
	if ( strlen( $sessionlang ) > 0 ) {
		return $sessionlang;
	} else {
		return 'se';
	}
}
