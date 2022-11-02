<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://internetstiftelsen.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/public
 * @author     The Swedish Internet Foundation <webmaster@internetstiftelsen.se>
 */
class Iis_Pack_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Markup output with wp_head()
	 *
	 * @since 1.0
	 */
	public function iis_pack_include_in_head() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/google-tag-manager.php';
	}

	/**
	 * Markup output after wp_body_open()
	 * The alert message is output first
	 *
	 * @since 1.0
	 */
	public function iis_pack_include_in_body() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/alert.php';
	}

	/**
	 * Remove emojis
	 *
	 * @since 1.0.1
	 *
	 */
	public function iis_pack_disable_all_emojis() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/disable-emojis.php';
	}
}
