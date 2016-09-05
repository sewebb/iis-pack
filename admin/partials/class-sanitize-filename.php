<?php
/**
 * Fix filenames that will cause problems if keept as is
 *
 * @since      1.4.1
 * @package    Iis_Pack
 * @subpackage Iis_Pack/partials
 */

/**
 * Calls the class at admin_init (in class-iis-pack-admin.php)
 */
function call_sanitize_filename() {
	new SanitizeFilename();
}

/**
 * The Class.
 */
class SanitizeFilename {

	/**
	 * Hook into the appropriate filters when the class is constructed.
	 */
	public function __construct() {
		add_filter( 'wp_handle_upload_prefilter', array( $this, 'sanitize_decomposed_utf8_file' ) );
	}

	/**
	 * Sanitize the filename in a file object
	 *
	 * @param  array $file In file
	 * @return array       Out file
	 */
	public function sanitize_decomposed_utf8_file( $file ) {
		$file['name'] = $this->sanitize_decomposed_utf8_string( $file['name'] );
		return $file;
	}

	/**
	 * Sanitize an decomposed UTF8 string (NFD)
	 *
	 * @param  string $str Input string
	 * @return string      Converted string
	 */
	public function sanitize_decomposed_utf8_string( $str ) {
		$chars = array(
			chr( 0xCC ) . chr( 0x88 ) => '', // ¨
			chr( 0xCC ) . chr( 0x8a ) => '', // °
			chr( 0xCC ) . chr( 0x81 ) => '', // ´
		);
		$new_str = strtr( $str, $chars );
		return $new_str;
	}
} // END class
