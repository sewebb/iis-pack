<?php
/**
 * Filter images on post/pages and add credits
 *
 * @link       https://www.iis.se
 * @since      1.0.1
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public/partials
 */

defined( 'WPINC' ) or die;

// True or False
$iis_show_object_credits = '';
$iis_show_object_credits = get_option( 'iis_pack_show_object_credits' );

if ( 'true' === $iis_show_object_credits ) {
	if ( ( is_single() || is_page() ) && ! is_archive() )  {
		add_filter( 'the_content', 'find_images' );
		add_filter( 'post_thumbnail_html', 'filter_featured_image', 11, 3 );
	}

}

/**
 * Sök efter bilder i content
 * @param  string $content html i posten/sidan
 * @return string  bilderna förutom featured image
 */
function find_images( $content ) {
	return preg_replace_callback( '/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'attach_image_credit', $content );
}

/**
 * Hämta ut varje bilds extra metadata
 * @param  [type] $images [description]
 * @return [type]         [description]
 */
function attach_image_credit( $images ) {
	$return = $images[0];
	$langpack = 'iis-pack';

	// Get the image ID from the unique class added by insert to editor: "wp-image-ID"
	if ( preg_match( '/wp-image-([0-9]+)/', $return, $match ) ) {
		$license     = get_post_meta( $match[1] /* Captured image ID */, '_iis_pack_license', true );

		if ( ! empty( $license ) && '' !== $license ) {
			$return .= '<div class="iis-pack-credits-container">';

			$object_url  = get_post_meta( $match[1], '_iis_pack_object_url', true );
			$object_name = get_post_meta( $match[1], '_iis_pack_object_name', true );

			if ( '' !== $object_name ) {
				$return .= '<span class="iis-pack-object-name">' . __( 'Photo: ', $langpack );

				if ( '' !== $object_url ) {
					$return .= '<a href="' . $object_url . '" target="_blank">' . $object_name . '</a>';
				} else {
					$return .= $object_name;
				}
				$return .= '&nbsp;</span>';
			}

			$license_holder_name = get_post_meta( $match[1], '_iis_pack_license_holder_name', true );
			$license_holder_url  = get_post_meta( $match[1], '_iis_pack_license_holder_url', true );

			if ( '' !== $license_holder_name ) {
				$return .= '<span class="iis-pack-license-holder-name">';
				if ( '' !== $object_name ) {
					$return .= __( 'by ', $langpack );
				} else {
					$return .= __( 'Photo by ', $langpack );
				}


				if ( '' !== $license_holder_url ) {
					$return .= '<a href="' . $license_holder_url . '" target="_blank">' . $license_holder_name . '</a>';
				} else {
					$return .= $license_holder_name;
				}
				$return .= '&nbsp;</span>';
			}

			$license_url = get_post_meta( $match[1], '_iis_pack_license_url', true );
			$return      .= '<span class="iis-pack-license">(';

			if ( '' !== $license_url ) {
				$return .= '<a href="' . $license_url . '" target="_blank">' . $license . '</a>';
			} else {
				$return .= $license;
			}
			$return .= ')</span>';

			$return .= '</div>';
		}
	}

	return $return;
}

/**
 * Hämta featured image extra metadata
 * @param  [type] $html          [description]
 * @param  [type] $post_id       [description]
 * @param  [type] $post_image_id [description]
 * @return [type]                [description]
 */
function filter_featured_image( $html, $post_id, $post_image_id ) {
	$langpack = 'iis-pack';

	if ( has_post_thumbnail( $post_id ) ) {
		$license     = get_post_meta( $post_image_id, '_iis_pack_license', true );

		if ( ! empty( $license ) && '' !== $license ) {

			$return = $html; //före eller efter bilden?
			$return .= '<div class="iis-pack-credits-container">';
			// $return .= $html; //före eller efter bilden?
			$object_url  = get_post_meta( $post_image_id, '_iis_pack_object_url', true );
			$object_name = get_post_meta( $post_image_id, '_iis_pack_object_name', true );

			if ( '' !== $object_name ) {
				$return .= '<span class="iis-pack-object-name">' . __( 'Photo: ', $langpack );

				if ( '' !== $object_url ) {
					$return .= '<a href="' . $object_url . '" target="_blank">' . $object_name . '</a>';
				} else {
					$return .= $object_name;
				}
				$return .= '&nbsp;</span>';
			}

			$license_holder_name = get_post_meta( $post_image_id, '_iis_pack_license_holder_name', true );
			$license_holder_url  = get_post_meta( $post_image_id, '_iis_pack_license_holder_url', true );

			if ( '' !== $license_holder_name ) {
				$return .= '<span class="iis-pack-license-holder-name">';

				if ( '' !== $object_name ) {
					$return .= __( 'by ', $langpack );
				} else {
					$return .= __( 'Photo by ', $langpack );
				}


				if ( '' !== $license_holder_url ) {
					$return .= '<a href="' . $license_holder_url . '" target="_blank">' . $license_holder_name . '</a>';
				} else {
					$return .= $license_holder_name;
				}
				$return .= '&nbsp;</span>';
			}

			$license_url = get_post_meta( $post_image_id, '_iis_pack_license_url', true );
			$return .= '<span class="iis-pack-license">(';

			if ( '' !== $license_url ) {
				$return .= '<a href="' . $license_url . '" target="_blank">' . $license . '</a>';
			} else {
				$return .= $license;
			}
			$return .= ')</span>';

			$return .= '</div>';

			return $return;

		} else {

			return $html;
		}
	} else {

		return $html;
	}


}

