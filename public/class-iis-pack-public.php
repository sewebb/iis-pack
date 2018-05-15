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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/facebook-og-tags.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/twitter-cards.php';
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
	}

	/**
	 * Åtgärder som filtrerar the_content
	 *
	 * @since 1.0.1 Kod som lägger till licensdata på bilder
	 *
	 */
	public function iis_pack_filter_the_content() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/add-license-to-images.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/responsive-oembed.php';
	}

	/**
	 * Start shortcode for fast social
	 *
	 * @since 1.5.4 Changed to start on differen hook
	 *
	 */
	public function iis_pack_fast_social() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/fast-social-share-buttons.php';
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

		// Sammanslagen js för samtliga plugin
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iis-pack-public.3ddf7b7c.min.js', array( 'jquery' ), null, true );
		// Settings transfered to javascript, and language
		$defs = array(
			'pluginsUrl'  => plugin_dir_url( __FILE__ ),
		);
		wp_localize_script(
			$this->plugin_name,
			'iispackDefs',
			$defs
		);

		if ( $this->script_should_be_included() ) {
			// js/wp-password-strength-meter.js is built into this file during grunt
			wp_enqueue_script( 'iis-pack-password-strength-meter', plugin_dir_url( __FILE__ ) . 'js/iis-pack-password-strength-meter.5383b414.min.js', array( 'zxcvbn-async' ), null, true );

			// Fetch the blacklisted words
			$blacklist_arr = Iis_Pack_Security::iis_blacklist();
			$p_length      = absint( get_option( 'iis_pack_password_strength_length', '12' ) );

			wp_localize_script( 'iis-pack-password-strength-meter', 'iisPackJsPassw', array(
				'blacklist' => $blacklist_arr,
				'unknown' => __( 'Password strength unknown', 'iis-pack' ),
				'short' => __( 'Very weak', 'iis-pack' ),
				'bad' => __( 'Weak', 'iis-pack' ),
				'good' => __( 'Medium', 'iis-pack' ),
				'strong' => __( 'Strong', 'iis-pack' ),
				'mismatch' => __( 'Mismatch', 'iis-pack' ),
				'useUnsecure' => __( 'Use unsecure password', 'iis-pack' ),
				'pLength' => $p_length,
			) );
		}
	}

	private function script_should_be_included() {
		// ps => password_strength
		$activate_script     = get_option( 'iis_pack_show_password_strength' );

		if ( 'true' !== $activate_script ) {
			// _log( 'Script should not be used, return false directly');
			return false;
		}

		$show_on_this_type     = array();
		$show_on_this_template = array();

		$add_to_type           = false;
		$add_to_template       = false;

		$iis_add_pass_check_to_type     = get_option( 'iis_pack_add_pass_check_to_type', '' );
		$iis_add_pass_check_to_template = get_option( 'iis_pack_add_pass_check_to_template', '' );

		if ( '' !== $iis_add_pass_check_to_type || '' !== $iis_add_pass_check_to_template ) {

			if ( '' !== $iis_add_pass_check_to_type ) {
				$iis_add_pass_check_to_type  = explode( ',', $iis_add_pass_check_to_type );
				$arrlength = count( $iis_add_pass_check_to_type );
				for ( $x = 0; $x < $arrlength; $x++ ) {
					array_push( $show_on_this_type, $iis_add_pass_check_to_type[ $x ] );
				}
				$add_to_type = is_singular( $show_on_this_type );
			}

			if ( '' !== $iis_add_pass_check_to_template ) {
				$iis_add_pass_check_to_template  = explode( ',', $iis_add_pass_check_to_template );
				$arrlength = count( $iis_add_pass_check_to_template );
				for ( $x = 0; $x < $arrlength; $x++ ) {
					array_push( $show_on_this_template, $iis_add_pass_check_to_template[ $x ] );
				}
				$add_to_template = is_page_template( $show_on_this_template );
			}
		}

		if ( ! is_user_logged_in() ) {
			// _log( 'User not logged in, use script' );
			return true;
		}

		if ( is_user_logged_in() && ( $add_to_type || $add_to_template ) ) {
			// _log( 'Everything checks out, use script' );
			return true;
		}

		// _log( 'No hit in function, returns false by default' );
		return false;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function iis_pack_enqueue_styles() {
		// Sammanslagen css för samtliga plugin
		// Inte använd ännu
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iis-pack-public.b418ab95.min.css', array(), null, 'screen' );

	}
}
