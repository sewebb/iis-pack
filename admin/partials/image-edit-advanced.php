<?php

/**
 * Plugin Name: Image Edit Advanced
 * Author: Gregory Cornelius
 * Description: Example plugin demonstrating how to extend the image
 * details modal
 * Version: 0.1
 *
 */

class GC_Image_Edit_Advanced {

	function init() {
		add_action( 'wp_enqueue_editor', array( $this, 'enqueue' ) );
		add_action( 'print_media_templates', array( $this, 'template' ) );
	}

	function enqueue() {
		wp_enqueue_script( 'image-edit-advanced', plugins_url( '../js/image-edit.js', __FILE__ ), array( 'jquery', 'media-views' ), '0.1', true );
	}

	function template() {
?>
		<script type="text/html" id="tmpl-image-details-extended">
			<# console.log( data ); #>
			<label class="setting border-width">
				<span><?php _e('Border Width'); ?></span>
				<input type="text" data-setting="borderWidth" value="{{ data.borderWidth }}" />
			</label>
			<label class="setting border-color">
				<span><?php _e('Border Color'); ?></span>
				<input type="text" data-setting="borderColor" value="{{ data.borderColor }}" />
			</label>
		</script>

<?php

	}

}

$gc_edit_image_advanced = new GC_Image_Edit_Advanced();
add_action( 'init', array( $gc_edit_image_advanced, 'init' ) );
