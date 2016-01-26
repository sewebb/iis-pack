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
function call_twitter() {
	new TwitterMeta();
}

/**
 * The Class.
 */
class TwitterMeta {

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_twitter_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_twitter_meta' ) );
	}

	/**
	 * Lägger till metaboxen i admin
	 * @since 1.0.0
	 * @since 1.0.1 Visa inte i bilagesidan
	 * @param string $post_type sätt till de typer vi behöver
	 */
	public function add_twitter_meta_box( $post_type ) {
		$post_types = array( 'attachment', 'acf-field-group', 'acf-field', 'nav_menu_item' );   // Visa inte i redigera media
		if ( ! in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'twitter_meta_box' // $id
				,__( 'Twitter Cards', 'iis-pack' ) // $title
				,array( $this, 'show_twitter_meta_box' ) // $callback
				,$post_type // överallt
				,'normal' // $context
				,'high' // $priority
			);
		}
	}

	public function add_twitter_fields() {
		// Field Array
		$prefix = 'twitter_';
		$twitter_meta_fields = array(
			array(
				'label' => __( 'Alternative twitter:title', 'iis-pack' ),
				'desc'  => __( 'If you want a different title for the page when shared on Twitter. If you want the same as on Facebook - just leave it empty', 'iis-pack' ),
				'id'    => $prefix . 'title',
				'type'  => 'text',
			),
			array(
				'label' => __( 'twitter:description', 'iis-pack' ),
				'desc'  => __( 'Add a nice descriptive text then page is shared on Twitter. If you want the same as on Facebook - just leave it empty', 'iis-pack' ),
				'id'    => $prefix . 'description',
				'type'  => 'textarea',
			),
			array(
				'label' => __( 'Hashtags', 'iis-pack' ),
				'desc'  => __( 'Add hashtags for this page. If more than one - seperate with comma, no spaces. (internetguider,iis)', 'iis-pack' ),
				'id'    => $prefix . 'page_hashtags',
				'type'  => 'text',
			),
		);
		return $twitter_meta_fields;
	}
	/**
	 * Visa i admin
	 * @since 1.0.0
	 */
	public function show_twitter_meta_box() {
		$twitter_meta_fields = $this->add_twitter_fields();
		global $post;
		// Use nonce for verification
		wp_nonce_field( basename( __FILE__ ), 'twitter_meta_box_nonce' );

		// Begin the field table and loop
		echo '<table class="form-table">';
		foreach ( $twitter_meta_fields as $field ) {
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
	public function save_twitter_meta( $post_id ) {
		$twitter_meta_fields = $this->add_twitter_fields();
		// verify nonce
		if ( ! isset( $_POST['twitter_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['twitter_meta_box_nonce'], basename( __FILE__ ) ) ) {
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
		foreach ( $twitter_meta_fields as $field ) {
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
