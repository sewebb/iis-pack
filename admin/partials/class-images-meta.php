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
	$prefixandlangpack = "iis-pack";
	$attchments_options = array(
		// möjliga settings listade i första fältet
		$prefixandlangpack . '_license' => array(
			'label'       => __( 'License (ex. CC-BY)', $prefixandlangpack ), //the field name that will be displayed
			'input'       => 'text', //the input type (e.g text, select, radio, ...)
			'helps'       => '', //information to help the user filling in the field
			'application' => 'image', //which attchment mime type to apply
			'exclusions'  => array(), //which attchment mime type to exclude
			'required'    => false, //is the field required? (default false)
			'error_text'  => __( 'License field is required', $prefixandlangpack ),//optional field to describe the error (if required is set to true)
			// 'options'     => array (), //options - optional field for radio and select types
			'show_in_edit' => true, // Just nu syns fälten bara i "Redigera bild" (Default är "true")
			'show_in_modal' => true, // Detta är en setting som inte verkar ta. Får undersökas! (Default är "true")
		),
		$prefixandlangpack . '_license_url' => array(
			'label'       => __( 'License URL', $prefixandlangpack ), //the field name that will be displayed
			'input'       => 'text', //the input type (e.g text, select, radio, ...)
			'application' => 'image', //which attchment mime type to apply
			'exclusions'  => array(), //which attchment mime type to exclude
		),
		$prefixandlangpack . '_photographer_name' => array(
			'label'       => __( 'Photographer name', $prefixandlangpack ), //the field name that will be displayed
			'input'       => 'text', //the input type (e.g text, select, radio, ...)
			'application' => 'image', //which attchment mime type to apply
			'exclusions'  => array( 'audio' ), //which attchment mime type to exclude
		),
		$prefixandlangpack . '_photographer_url' => array(
			'label'       => __( 'Photographer URL', $prefixandlangpack ), //the field name that will be displayed
			'input'       => 'text', //the input type (e.g text, select, radio, ...)
			'application' => 'image', //which attchment mime type to apply
			'exclusions'  => array( 'audio' ), //which attchment mime type to exclude
		),
		$prefixandlangpack . '_picture_name' => array(
			'label'       => __( 'Picture / Video / Sound name', $prefixandlangpack ), //the field name that will be displayed
			'input'       => 'text', //the input type (e.g text, select, radio, ...)
			'application' => 'image', //which attchment mime type to apply
			'exclusions'  => array(), //which attchment mime type to exclude
		),
		$prefixandlangpack . '_picture_url' => array(
			'label'       => __( 'Picture / Video / Sound', $prefixandlangpack ), //the field name that will be displayed
			'input'       => 'text', //the input type (e.g text, select, radio, ...)
			'application' => 'image', //which attchment mime type to apply
			'exclusions'  => array(), //which attchment mime type to exclude
		),

	);
	$cmf = new ImagesMediaMeta( $attchments_options );
}

/**
 * The Class.
 */
class ImagesMediaMeta {

	private $media_fields = array();

	function __construct( $fields ) {
		$this->media_fields = $fields;

		add_filter( 'attachment_fields_to_edit', array( $this, 'applyFilter' ), 11, 2 );
		add_filter( 'attachment_fields_to_save', array( $this, 'saveFields' ), 11, 2 );

	}

	public function applyFilter( $form_fields, $post = null ) {

		// If our fields array is not empty
		if ( ! empty( $this->media_fields ) ) {
			// We browse our set of options
			foreach ( $this->media_fields as $field => $values ) {
				// If the field matches the current attachment mime type
				// and is not one of the exclusions
				// if ( preg_match( '/' . $values['application'] . '/', $post->post_mime_type ) && ! in_array( $post->post_mime_type, $values['exclusions'] ) ) {
				if ( ! in_array( $post->post_mime_type, $values['exclusions'] ) ) {
					// We get the already saved field meta value
					$meta = get_post_meta( $post->ID, '_' . $field, true );

					// Define the input type to 'text' by default
					$values['input'] = 'text';

					// And set it to the field before building it
					$values['value'] = $meta;

					// We add our field into the $form_fields array
					$form_fields[ $field ] = $values;
				}
			}
		}

		// We return the completed $form_fields array
		return $form_fields;

	}

	function saveFields( $post, $attachment ) {

	}

} // END class
