<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.iis.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/admin
 * @author     The IIS Team <webbgruppen@iis.se>
 */


class Iis_Pack_Admin {
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
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'iis_pack';

	/**
	 * Lägger till inställningar för vårt plugin under menyn Inställningar
	 * @since 1.0.0
	 */
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'IIS Pack Settings', 'iis-pack' ),
			__( 'IIS Pack', 'iis-pack' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}
	/**
	 * En viktig sak med facebook & twitter är möjligheten att lägga till en unik bild.
	 * Så det gör vi om temat missat det
	 * @since 1.0.0
	 */
	public function add_support_for_featured_image() {
		$has_featured_image_support = get_theme_support( 'post-thumbnails' );

		if ( false === $has_featured_image_support ) {
			add_theme_support( 'post-thumbnails' );
		}
	}

	/**
	 * Skapa inställningssidan
	 * @since 1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/iis-pack-admin-display.php';
	}

	public function register_setting() {
		// Lägg till sektion för Foto-credits
		add_settings_section(
			$this->option_name . '_object_credits',
			__( 'Object attribution', 'iis-pack' ),
			array( $this, $this->option_name . '_object_credits_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_show_object_credits',
			__( 'Print Object attribution?', 'iis-pack' ),
			array( $this, $this->option_name . '_show_object_credits_cb' ),
			$this->plugin_name,
			$this->option_name . '_object_credits',
			array( 'label_for' => $this->option_name . '_show_object_credits' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_show_object_credits', array( $this, $this->option_name . '_sanitize_true_false' ) );

		// Lägg till sektion för Facebook OG taggar
		add_settings_section(
			$this->option_name . '_og_tags',
			__( 'Facebook open graph', 'iis-pack' ),
			array( $this, $this->option_name . '_og_tags_cb' ),
			$this->plugin_name
		);

		// Fälten för Facebook
		add_settings_field(
			$this->option_name . '_default_og_image',
			__( 'Default og:image', 'iis-pack' ),
			array( $this, $this->option_name . '_default_og_image_cb' ),
			$this->plugin_name,
			$this->option_name . '_og_tags',
			array( 'label_for' => $this->option_name . '_default_og_image' )
		);

		add_settings_field(
			$this->option_name . '_protocol',
			__( 'Protocol', 'iis-pack' ),
			array( $this, $this->option_name . '_protocol_cb' ),
			$this->plugin_name,
			$this->option_name . '_og_tags',
			array( 'label_for' => $this->option_name . '_protocol' )
		);

		add_settings_field(
			$this->option_name . '_fbappid',
			__( 'ev. Facebook AppId', 'iis-pack' ),
			array( $this, $this->option_name . '_fbappid_cb' ),
			$this->plugin_name,
			$this->option_name . '_og_tags',
			array( 'label_for' => $this->option_name . '_fbappid' )
		);

		add_settings_field(
			$this->option_name . '_fbadmins',
			__( 'ev. Facebook Admin(s)', 'iis-pack' ),
			array( $this, $this->option_name . '_fbadmins_cb' ),
			$this->plugin_name,
			$this->option_name . '_og_tags',
			array( 'label_for' => $this->option_name . '_fbadmins' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_default_og_image', 'sanitize_text_field' );
		register_setting( $this->plugin_name, $this->option_name . '_protocol', array( $this, $this->option_name . '_sanitize_protocol' ) );
		register_setting( $this->plugin_name, $this->option_name . '_fbappid', 'intval' );
		register_setting( $this->plugin_name, $this->option_name . '_fbadmins', 'sanitize_text_field' );

		// Lägg till sektion för Twitter Cards
		add_settings_section(
			$this->option_name . '_twitter_cards',
			__( 'Twitter Cards', 'iis-pack' ),
			array( $this, $this->option_name . '_twitter_cards_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_twitter_site',
			__( 'Twitter site', 'iis-pack' ),
			array( $this, $this->option_name . '_twitter_site_cb' ),
			$this->plugin_name,
			$this->option_name . '_twitter_cards',
			array( 'label_for' => $this->option_name . '_twitter_site' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_twitter_site', 'sanitize_text_field' );

		// Lägg till sektion för Google Analytics
		add_settings_section(
			$this->option_name . '_google_analytics',
			__( 'Google Analytics', 'iis-pack' ),
			array( $this, $this->option_name . '_google_analytics_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_ga_id',
			__( 'Google Analytics ID', 'iis-pack' ),
			array( $this, $this->option_name . '_ga_id_cb' ),
			$this->plugin_name,
			$this->option_name . '_google_analytics',
			array( 'label_for' => $this->option_name . '_ga_id' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_ga_id', 'sanitize_text_field' );

		// Lägg till sektion för Fox menu
		add_settings_section(
			$this->option_name . '_fox_menu',
			__( 'Fox Menu', 'iis-pack' ),
			array( $this, $this->option_name . '_fox_menu_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_show_fox_menu',
			__( 'Use Fox menu?', 'iis-pack' ),
			array( $this, $this->option_name . '_show_fox_menu_cb' ),
			$this->plugin_name,
			$this->option_name . '_fox_menu',
			array( 'label_for' => $this->option_name . '_show_fox_menu' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_show_fox_menu', array( $this, $this->option_name . '_sanitize_true_false' ) );
	}

	/**
	 * Underrubrik Bildattribution
	 *
	 * @since  1.0.1
	 */
	public function iis_pack_object_credits_cb() {
		echo '<p>' . __( 'Should this site fetch and print attachement credits ', 'iis-pack' ) . '</p>';
	}

	/**
	 * Underrubrik Facebook OG-taggar
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_og_tags_cb() {
		echo '<p>' . __( 'Settings for Facebook open graph tags per site ', 'iis-pack' ) . '</p>';
	}

	/**
	 * Underrubrik Twitter cards
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_twitter_cards_cb() {
		echo '<p>' . __( 'Global settings for Twitter Cards', 'iis-pack' ) . '</p>';
	}

	/**
	 * Underrubrik Google Analytics
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_google_analytics_cb() {
		echo '<p>' . __( 'Settings for Google Analytics', 'iis-pack' ) . '</p>';
	}

	/**
	 * Underrubrik Fox menyn
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_fox_menu_cb() {
		echo '<p>' . __( 'Should this site show the Fox menu on top of pages?', 'iis-pack' ) . '</p>';
	}

	// INPUT FÄLT
	/**
	 * Input för radioknappar visa /dölj utskrift av Bildattribution
	 *
	 * @since  1.0.1
	 */
	public function iis_pack_show_object_credits_cb() {
		$show_object_credits = get_option( $this->option_name . '_show_object_credits' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_object_credits' ?>" id="<?php echo $this->option_name . '_show_object_credits' ?>" value="true" <?php checked( $show_object_credits, 'true' ); ?>>
					<?php _e( 'Show Object Attribution', 'iis-pack' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_object_credits' ?>" value="false" <?php checked( $show_object_credits, 'false' ); ?>>
					<?php _e( 'Hide Object Attribution', 'iis-pack' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Input för standard og:image
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_default_og_image_cb() {
		$default_og_image = get_option( $this->option_name . '_default_og_image' );
		echo '<input type="text" class="large-text" name="' . $this->option_name . '_default_og_image' . '" id="' . $this->option_name . '_default_og_image' . '" value="' . $default_og_image . '"> ';
		echo '<p class="description">' . __( 'Complete url. Try to get from static.iis.se Default image is IIS logo', 'iis-pack' ) . '</p>';
	}

	/**
	 * Input för radioknappar protokoll
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_protocol_cb() {
		$protocol = get_option( $this->option_name . '_protocol' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_protocol' ?>" id="<?php echo $this->option_name . '_protocol' ?>" value="https" <?php checked( $protocol, 'https' ); ?>>
					<?php _e( 'https (SSL)', 'iis-pack' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_protocol' ?>" value="http" <?php checked( $protocol, 'http' ); ?>>
					<?php _e( 'http', 'iis-pack' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Input för facebook app id
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_fbappid_cb() {
		$fbappid = get_option( $this->option_name . '_fbappid' );
		echo '<input type="text" name="' . $this->option_name . '_fbappid' . '" id="' . $this->option_name . '_fbappid' . '" value="' . $fbappid . '"> ';
	}

	/**
	 * Input för facebook admins
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_fbadmins_cb() {
		$fbadmins = get_option( $this->option_name . '_fbadmins' );
		echo '<input type="text" class="regular-text code" name="' . $this->option_name . '_fbadmins' . '" id="' . $this->option_name . '_fbadmins' . '" value="' . $fbadmins . '"> ';
		echo '<p class="description">' . __( 'If the site has more than one admin, seperate them with comma (,)', 'iis-pack' ) . '</p>';
	}

	/**
	 * Input för Twitter sajtövergripande handle
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_twitter_site_cb() {
		$twitter_site = get_option( $this->option_name . '_twitter_site' );
		echo '<input type="text" class="" name="' . $this->option_name . '_twitter_site' . '" id="' . $this->option_name . '_twitter_site' . '" value="' . $twitter_site . '"> ';
		echo '<p class="description">' . __( 'The sites main account, for example @iis on www.iis.se', 'iis-pack' ) . '</p>';
	}

	/**
	 * Input för Google Analytics ID
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_ga_id_cb() {
		$ga_id = get_option( $this->option_name . '_ga_id' );
		echo '<input type="text" class="" name="' . $this->option_name . '_ga_id' . '" id="' . $this->option_name . '_ga_id' . '" value="' . $ga_id . '"> ';
	}

	/**
	 * Input för radioknappar visa /dölj Foxmenyn
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_show_fox_menu_cb() {
		$show_fox_menu = get_option( $this->option_name . '_show_fox_menu' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_fox_menu' ?>" id="<?php echo $this->option_name . '_show_fox_menu' ?>" value="true" <?php checked( $show_fox_menu, 'true' ); ?>>
					<?php _e( 'Show Fox menu', 'iis-pack' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_fox_menu' ?>" value="false" <?php checked( $show_fox_menu, 'false' ); ?>>
					<?php _e( 'Hide Fox menu', 'iis-pack' ); ?>
				</label>
			</fieldset>
		<?php
	}

	// SANERA
	/**
	 * Sanitize protokoll value https / http (mest för att man kan :-)
	 *
	 * @param  string $protocol $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function iis_pack_sanitize_protocol( $protocol ) {
		if ( in_array( $protocol, array( 'https', 'http' ), true ) ) {
	        return $protocol;
	    }
	}

	/**
	 * Sanera true / false för Foxmenyn, Bildattribution
	 *
	 * @param  string $true_false $_POST value
	 * @since  1.0.0
	 * @since  1.0.1 Ändrat för att sanera true / false allmännt
	 * @return string           Sanitized value
	 */
	public function iis_pack_sanitize_true_false( $true_false ) {
		if ( in_array( $true_false, array( 'true', 'false' ), true ) ) {
	        return $true_false;
	    }
	}

	/**
	 * Inkludera klasser för extrafält på post & page // extrafält attachements
	 * @since  1.0.0
	 * @since  1.0.1 CC-fält på images (class-images-meta.php)
	 */
	public function include_meta_fields() {
		include_once 'partials/class-facebook.php';
		include_once 'partials/class-twitter.php';
		include_once 'partials/class-images-meta.php';

		call_facebook();
		call_twitter();
		call_images_media();
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iis-pack-admin.js', array( 'jquery' ), $this->version, false );

	}


}
