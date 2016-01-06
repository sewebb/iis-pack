<?php
/**
 * Lägger till box i admin för att få möjlighet att adda FB description
 *
 * @since      1.0.1
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/partials
 */

/**
 * Calls the class on the post edit screen.
 */
function call_images_media() {
	$langpack = 'iis-pack';
	$prefix   = 'iis_pack';
	$attchments_options = array(
		// Objekt (foto)-url är bäst att ha först, vi hämtar övriga värden om det är Flickr-bild
		$prefix . '_object_url' => array(
			'label'       => __( 'Object URL', $langpack ), //the field name that will be displayed
			'input'       => 'text',
		),
		$prefix . '_api_flickr' => array(
			'label'       => __( 'Fetch data from Flickr', $langpack ), //the field name that will be displayed
			'input'       => 'checkbox',
		),
		$prefix . '_object_name' => array(
			'label'       => __( 'Object name', $langpack ), //the field name that will be displayed
			'input'       => 'text',
		),
		// möjliga settings listade i Licence-fältet
		$prefix . '_license' => array(
			'label'       => __( 'License (ex. CC-BY)', $langpack ), //the field name that will be displayed
			'input'       => 'text', //the input type (e.g text, checkbox, ...)
			'helps'       => '', //information to help the user filling in the field
			// 'application' => 'image', //which attchment mime type to apply
			// 'exclusions'  => array(), //which attchment mime type to exclude
			'required'    => false, //is the field required? (default false)
			'error_text'  => __( 'License field is required', $langpack ),//optional field to describe the error (if required is set to true)
			// 'options'     => array (), //options - optional field for radio and select types
			'show_in_edit' => true, // Just nu syns fälten bara i "Redigera bild" (Default är "true")
			'show_in_modal' => true, // Detta är en setting som inte verkar ta. Får undersökas! (Default är "true")
		),
		$prefix . '_license_url' => array(
			'label'       => __( 'License URL', $langpack ), //the field name that will be displayed
			'input'       => 'text',
		),
		$prefix . '_license_holder_name' => array(
			'label'       => __( 'Licens holder name', $langpack ), //the field name that will be displayed
			'input'       => 'text',
		),
		$prefix . '_license_holder_url' => array(
			'label'       => __( 'Licens holder URL', $langpack ), //the field name that will be displayed
			'input'       => 'text',
		),

	);
	$cmf = new ImagesMediaMeta( $attchments_options );
}

/**
 * The Class.
 */
class ImagesMediaMeta {
	/**
	 * [$media_fields description]
	 * @var array
	 */
	private $media_fields = array();

	/**
	 * [__construct description]
	 * @param [type] $fields [description]
	 */
	function __construct( $fields ) {
		$this->media_fields = $fields;

		add_filter( 'attachment_fields_to_edit', array( $this, 'apply_filter' ), 11, 2 );
		add_filter( 'attachment_fields_to_save', array( $this, 'save_fields' ), null, 2 );

	}

	/**
	 * [apply_filter description]
	 * @param  [type] $form_fields [description]
	 * @param  [type] $post        [description]
	 * @return [type]              [description]
	 */
	public function apply_filter( $form_fields, $post = null ) {

		if ( ! empty( $this->media_fields ) ) {

			foreach ( $this->media_fields as $field => $values ) {
				// Om vi skulle särskilja var fälten visas
				// if ( preg_match( '/' . $values['application'] . '/', $post->post_mime_type ) && ! in_array( $post->post_mime_type, $values['exclusions'] ) ) {
					$meta = get_post_meta( $post->ID, '_' . $field, true );

					switch ( $values['input'] ) {

						case 'text':
							$values['input'] = 'text';
							break;

						case 'checkbox':
							// Checkbox type doesn't exist
							$values['input'] = 'html';

							// Set the checkbox checked or not
							if ( 'on' === $meta ) {
								$checked = ' checked="checked"';
							} else {
								$checked = '';
							}
							$html = '<input' . $checked . ' type="checkbox" name="attachments[' . $post->ID . '][' . $field . ']" id="attachments-' . $post->ID . '-' . $field . '" />';
							$values['html'] = $html;
							break;

						default:
							$values['input'] = 'text';
							break;

					}
					// And set it to the field before building it
					$values['value'] = $meta;
					// We add our field into the $form_fields array
					$form_fields[ $field ] = $values;
				// }
			}
		}

		// We return the completed $form_fields array
		return $form_fields;

	}

	/**
	 * [save_fields description]
	 * @param  [type] $post       [description]
	 * @param  [type] $attachment [description]
	 * @return [type]             [description]
	 */
	public function save_fields( $post, $attachment ) {
		if ( ! empty( $this->media_fields ) ) {

			$flickr_photo = false;
			$photourl     = '';
			$apiflickr    = isset( $attachment['iis_pack_api_flickr'] ) ? $attachment['iis_pack_api_flickr'] : '';
			$apiflickr    = sanitize_text_field( $apiflickr );

			// Vi kollar om man vill få hjälp av Flickr API. Tar en liten stund så det bör enligt min mening vara ett aktiv val
			if ( 'on' === $apiflickr ) {
				$flickr_photo = true;
				$photourl    = isset( $attachment['iis_pack_object_url'] ) ? $attachment['iis_pack_object_url'] : '';
				$photourl    = sanitize_text_field( $photourl );
			}

			if ( $flickr_photo && '' !== $photourl ) {

				$parts = parse_url( $photourl );
				$path_parts = explode( '/', $parts['path'] );
				$photo_id = $path_parts[3];

				$params = array(
					// Nyckeln är från Thomas Flickr-konto men går fint att byta ut
					'api_key'	=> '6c957bbf546dcd188615000edf2e7487',
					'method'	=> 'flickr.photos.getInfo',
					'photo_id'	=> $photo_id,
					'format'	=> 'php_serial',
				);

				$encoded_params = array();

				foreach ( $params as $k => $v ) {
					$encoded_params[] = urlencode( $k ).'='.urlencode( $v );
				}

				// Call the API and decode the response
				$url = 'https://api.flickr.com/services/rest/?'.implode( '&', $encoded_params );

				$rsp = file_get_contents( $url );

				$rsp_obj = unserialize( $rsp );

				if ( 'ok' === $rsp_obj['stat'] ) {
					$flickr_photo = true;

					$license = $rsp_obj['photo']['license'];

					switch ( $license ) {
						case 0:
							$license     = 'All Rights Reserved';
							$license_url = '';
							break;

						case 1:
							$license     = 'CC BY-NC-SA';//'Attribution-NonCommercial-ShareAlike License'
							$license_url = 'http://creativecommons.org/licenses/by-nc-sa/2.0/';
							break;

						case 2:
							$license     = 'CC BY-NC';//'Attribution-NonCommercial License'
							$license_url = 'http://creativecommons.org/licenses/by-nc/2.0/';
							break;

						case 3:
							$license     = 'CC BY-NC-ND';//'Attribution-NonCommercial-NoDerivs License'
							$license_url = 'http://creativecommons.org/licenses/by-nc-nd/2.0/';
							break;

						case 4:
							$license     = 'CC BY';//'Attribution License'
							$license_url = 'http://creativecommons.org/licenses/by/2.0/';
							break;

						case 5:
							$license     = 'CC BY-SA';//'Attribution-ShareAlike License'
							$license_url = 'http://creativecommons.org/licenses/by-sa/2.0/';
							break;

						case 6:
							$license     = 'CC BY-ND';//'Attribution-NoDerivs License'
							$license_url = 'http://creativecommons.org/licenses/by-nd/2.0/';
							break;

						case 7:
							$license     = 'No known copyright restrictions';
							$license_url = 'http://flickr.com/commons/usage/';
							break;

						case 8:
							$license     = 'United States Government Work';
							$license_url = 'http://www.usa.gov/copyright.shtml';
							break;

						case 9:
							$license     = 'Public Domain Dedication (CC0)';
							$license_url = 'https://creativecommons.org/publicdomain/zero/1.0/';
							break;

						case 10:
							$license     = 'Public Domain Mark';
							$license_url = 'https://creativecommons.org/publicdomain/mark/1.0/';
							break;

						default:
							$license = '';
							$license_url = '';
							break;
					}

					$license_holder_name = $rsp_obj['photo']['owner']['realname'];
					$license_holder_url  = $rsp_obj['photo']['owner']['path_alias'];
					$license_holder_url  = 'https://www.flickr.com/photos/' . $license_holder_url;

					$photo_title         = $rsp_obj['photo']['title']['_content'];

					//Uppdatera fälten mha API:et
					update_post_meta( $post['ID'], '_iis_pack_object_url', $photourl );
					update_post_meta( $post['ID'], '_iis_pack_object_name', $photo_title );

					update_post_meta( $post['ID'], '_iis_pack_license', $license );
					update_post_meta( $post['ID'], '_iis_pack_license_url', $license_url );

					update_post_meta( $post['ID'], '_iis_pack_license_holder_name', $license_holder_name );
					update_post_meta( $post['ID'], '_iis_pack_license_holder_url', $license_holder_url );

				} else {
					$flickr_photo = false;
				}

			}
			// OM det inte är en flickr-bild så kör igenom fälten och lägg in värdena som matats in (eller om API:et inte svarar)
			if ( ! $flickr_photo ) {
				foreach ( $this->media_fields as $field => $values ) {
					$attachment_field = isset( $attachment[ $field ] ) ? $attachment[ $field ] : '';
					$attachment_field = sanitize_text_field( $attachment_field );

					update_post_meta( $post['ID'], '_' . $field, $attachment_field );

				}
			}

		}

	return $post;
	}

} // END class

