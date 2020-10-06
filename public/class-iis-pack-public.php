<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.iis.se
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
 * @author     The IIS Team <webbgruppen@iis.se>
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
	 * HTML som skrivs ut i wp_head()
	 * Koden som innehåller funktioner för OG:-taggar & Twitter cards som skrivs ut i <head>
	 *
	 * @since 1.0
	 */
	public function iis_pack_include_in_head() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/google-tag-manager.php';
	}

	/**
	 * HTML som skrivs ut i wp_footer()
	 * För koden i google analytics-filen nedan kollar om man är inloggad och om dett id finns angivet
	 * skrivs ut i footern, kolla i define_public_hooks()
	 * Javascriptet som behövs finns inbakat i iis-pack-public.js
	 *
	 * @since 1.0
	 *
	 */
	public function iis_pack_include_in_footer() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/google-analytics.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/browserwarning.php';
	}

	/**
	 * Åtgärder som filtrerar the_content
	 *
	 * @since 1.0.1 Kod som lägger till licensdata på bilder
	 *
	 */
	public function iis_pack_filter_the_content() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/add-license-to-images.php';
	}

	/**
	 * Ta bort alla emojisar
	 *
	 * @since 1.0.1
	 *
	 */
	public function iis_pack_disable_all_emojis() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/disable-emojis.php';
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function iis_pack_enqueue_scripts() {
		// Settings transfered to javascript, and language
		$defs = array(
			'pluginsUrl'  => plugin_dir_url( __FILE__ ),
		);
		wp_localize_script(
			$this->plugin_name,
			'iispackDefs',
			$defs
		);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function iis_pack_enqueue_styles() {
		// Sammanslagen css för samtliga plugin
		// Inte använd ännu
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iis-pack-public.064f9a57.min.css', array(), null, 'screen' );

	}
}
