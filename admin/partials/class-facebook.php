<?php
/**
 * Lägger till box i admin för att få möjlighet att adda FB description
 *
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/partials
 */

/**
 * Calls the class on the post edit screen.
 */
function call_facebook() {
	new FacebookMeta();
}

/**
 * The Class.
 */
class FacebookMeta {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_facebook_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_facebook_meta' ) );
	}

	/**
	 * Lägger till metaboxen i admin
	 * @since 1.0.0
	 * @since 1.0.1 Visa inte i bilagesidan
	 * @param string $post_type sätt till de typer vi behöver
	 */
	public function add_facebook_meta_box( $post_type ) {
		$post_types = array( 'attachment', 'acf-field-group', 'acf-field', 'nav_menu_item' );   // Visa inte i redigera media
		if ( ! in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'facebook_meta_box' // $id
				,__( 'FaceBook og: tags', 'iis-pack' ) // $title
				,array( $this, 'show_facebook_meta_box' ) // $callback
				,$post_type // överallt
				,'normal' // $context
				,'high' // $priority
			);
		}
	}

	public function add_facebook_fields() {
		// Field Array
		$prefix = 'facebook_';
		$facebook_meta_fields = array(
			array(
				'label' => __( 'Alternative og:title', 'iis-pack' ),
				'desc'  => __( 'If you want a different title for the page when shared on FaceBook', 'iis-pack' ),
				'id'    => $prefix . 'title',
				'type'  => 'text',
			),
			array(
				'label' => __( 'og:description', 'iis-pack' ),
				'desc'  => __( 'Add a nice descriptive text then page is shared on Facebook', 'iis-pack' ),
				'id'    => $prefix . 'description',
				'type'  => 'textarea',
			),
			array(
				'label' => __( 'FB App id', 'iis-pack' ),
				'desc'  => __( 'If this page belongs to a special App ID (for example internetguider) - add idnumber', 'iis-pack' ),
				'id'    => $prefix . 'page_app_id',
				'type'  => 'text',
			),
		);
		return $facebook_meta_fields;
	}
	/**
	 * Visa i admin
	 * @since 1.0.0
	 */
	public function show_facebook_meta_box() {
		$facebook_meta_fields = $this->add_facebook_fields();
		global $post;
		// Use nonce for verification
		wp_nonce_field( basename( __FILE__ ), 'facebook_meta_box_nonce' );

		// Begin the field table and loop
		echo '<table class="form-table">';
		foreach ( $facebook_meta_fields as $field ) {
			// get value of this field if it exists for this post
			$meta = get_post_meta( $post->ID, $field['id'], true );
			// begin a table row with
			echo '<tr>
			<th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
			<td>';
			switch ( $field['type'] ) {
				// text
				case 'text':
				echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" class="regular-text" />
				<br /><span class="description">'.$field['desc'].'</span>';
				break;
				// textarea
				case 'textarea':
				echo '<textarea name="' . $field['id'] .'" id="' . $field['id'] . '" cols="60" rows="4" class="large-text">' . $meta . '</textarea>
				<br /><span class="description">' . $field['desc'] . '</span>';
				break;
			} //end switch
			echo '</td></tr>';
		} // end foreach
		    echo '</table>'; // end table
	}

	/**
	 * Spara fälten
	 * @since 1.0.0
	 * @param  integer $post_id postens id
	 */
	public function save_facebook_meta( $post_id ) {
		$facebook_meta_fields = $this->add_facebook_fields();
		// verify nonce
		if ( ! isset( $_POST['facebook_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['facebook_meta_box_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// check permissions
		if ( 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// loop through fields and save the data
		foreach ( $facebook_meta_fields as $field ) {
			$old = get_post_meta( $post_id, $field['id'], true );
			$new = $_POST[ $field['id'] ];

			if ( $new && $new != $old ) {
				update_post_meta( $post_id, $field['id'], $new );
			} elseif ( '' === $new && $old ) {
				delete_post_meta( $post_id, $field['id'], $old );
			}
		} // end foreach
	}

} // END class
