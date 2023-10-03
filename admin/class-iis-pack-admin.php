<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://internetstiftelsen.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/admin
 */

/**
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/admin
 * @author     IIS Web Team <webbgruppen@iis.se>
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
	 * @param string $plugin_name 	The name of this plugin.
	 * @param string $version       The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * The option name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'iis_pack';

	/**
	 * Add support for WordPress featured images
	 * @since 1.0.0
	 */
	public function iis_pack_add_support_for_featured_image() {
		$has_featured_image_support = get_theme_support( 'post-thumbnails' );

		if ( false === $has_featured_image_support ) {
			add_theme_support( 'post-thumbnails' );
		}
	}

	/**
	 * Add excerpts to page post type
	 * @since 1.2.2
	 */
	public function iis_pack_add_support_for_page_excerpt() {
		$has_page_excerpts_support = post_type_supports( 'page', 'excerpt' );

		if ( false === $has_page_excerpts_support ) {
			add_post_type_support( 'page', 'excerpt' );
		}
	}

	/**
	 * Add support for local avatars
	 * @since 1.1
	 */
	public function iis_pack_in_user_profile() {
		include_once 'partials/class-local-avatars.php';

		call_simple_local_avatars();
	}

	/**
	 * Remove internal pingbacks
	 *
	 * @since 1.4  Ta bort interna pingbacks iis_pack_comment_stuff
	 */
	public function iis_pack_comment_stuff() {
		include_once 'partials/class-disable-internal-pingbacks.php';

		call_disable_internal_pingbacks();
	}

	/**
	 * Sanitize filenames
	 *
	 * @since 1.4.1  Santize filenames, gets called from class-iis-pack.php
	 */
	public function iis_pack_sanitize_filename() {
		include_once 'partials/class-sanitize-filename.php';

		call_sanitize_filename();
	}

	/**
	 * Add settings in wp-admin
	 * @since 1.0.0
	 */
	public function iis_pack_add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'IIS Pack Settings', 'iis-pack' ),
			__( 'IIS Pack', 'iis-pack' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}

	/**
	 * Create settings page
	 * @since 1.0.0
	 * @since 1.0.2
	 */
	public function display_options_page() {
		include_once 'partials/iis-pack-admin-display.php';
	}

	/**
	 * [register_setting description]
	 * @since 1.0.0
	 * @since 1.6.0 Settings for password strength script
	 */
	public function register_setting() {
		register_setting( $this->plugin_name, $this->option_name . '_mtm_id', 'sanitize_text_field' );
		register_setting( $this->plugin_name, $this->option_name . '_gtm_id', 'sanitize_text_field' );

		// Add settings section for Matomo Tag Manager
		add_settings_section(
			$this->option_name . '_matomo_tag_manager',
			'<hr>' . __( 'Matomo Tag Manager', 'iis-pack' ),
			array( $this, $this->option_name . '_matomo_tag_manager_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_mtm_id',
			__( 'Matomo Tag Manager ID', 'iis-pack' ),
			array( $this, $this->option_name . '_mtm_id_cb' ),
			$this->plugin_name,
			$this->option_name . '_matomo_tag_manager',
			array( 'label_for' => $this->option_name . '_mtm_id' )
		);

        // Add settings section for Google Tag Manager
        add_settings_section(
            $this->option_name . '_google_tag_manager',
            '<hr>' . __( 'Google Tag Manager', 'iis-pack' ),
            array( $this, $this->option_name . '_google_tag_manager_cb' ),
            $this->plugin_name
        );

        add_settings_field(
            $this->option_name . '_gtm_id',
            __( 'Google Tag Manager ID', 'iis-pack' ),
            array( $this, $this->option_name . '_gtm_id_cb' ),
            $this->plugin_name,
            $this->option_name . '_google_tag_manager',
            array( 'label_for' => $this->option_name . '_gtm_id' )
        );

        // Add settings section for header alert messages
        add_settings_section(
            $this->option_name . '_alert',
            '<hr>' . __( 'Alert message', 'iis-pack' ),
            array( $this, $this->option_name . '_alert_cb' ),
            $this->plugin_name
        );

        add_settings_field(
            $this->option_name . '_alert_type',
            __( 'Message type', 'iis-pack' ),
            array( $this, $this->option_name . '_alert_type_cb' ),
            $this->plugin_name,
            $this->option_name . '_alert',
            array( 'label_for' => $this->option_name . '_alert_type' )
        );

        add_settings_field(
            $this->option_name . '_alert_text',
            __( 'Message text', 'iis-pack' ),
            array( $this, $this->option_name . '_alert_text_cb' ),
            $this->plugin_name,
            $this->option_name . '_alert',
            array( 'label_for' => $this->option_name . '_alert_text' )
        );

		register_setting( $this->plugin_name, $this->option_name . '_alert_type', array( $this, $this->option_name . '_sanitize_true_false', false ) );
		register_setting( $this->plugin_name, $this->option_name . '_alert_text', array( $this, $this->option_name . '_sanitize_true_false', false ) );

		// Add settings for emoji scripts and local avatars
		add_settings_section(
			$this->option_name . '_other_stuff',
			'<hr>' . __( 'Other stuff', 'iis-pack' ),
			array( $this, $this->option_name . '_other_stuff_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_disable_emojis',
			__( 'Remove emoji scripts', 'iis-pack' ),
			array( $this, $this->option_name . '_disable_emojis_cb' ),
			$this->plugin_name,
			$this->option_name . '_other_stuff',
			array( 'label_for' => $this->option_name . '_disable_emojis' )
		);

		add_settings_field( $this->option_name . 'simple_local_avatars_caps',
			__( 'Local Profile Picture', 'iis-pack' ),
			array( $this, $this->option_name . '_avatar_settings_field_cb' ),
			$this->plugin_name,
			$this->option_name . '_other_stuff',
			array( $this->option_name . '_simple_local_avatars_caps', __( 'Only allow users with file upload capabilities to upload local profile pictures (Authors and above)', 'iis-pack' ), 'label_for' => $this->option_name . '_simple_local_avatars_caps' )
		);

        add_settings_field( $this->option_name . '_disable_password_change_notifications',
            __( 'Disable user password change notifications', 'iis-pack' ),
            array( $this, $this->option_name . '_disable_password_notifications_cb' ),
            $this->plugin_name,
            $this->option_name . '_other_stuff',
	        array( 'label_for' => $this->option_name . '_disable_password_change_notifications' )
        );

		register_setting( $this->plugin_name, $this->option_name . '_disable_emojis', array( $this, $this->option_name . '_sanitize_true_false' ) );
		register_setting( $this->plugin_name, $this->option_name . '_disable_password_change_notifications', array( $this, $this->option_name . '_sanitize_true_false' ) );
		register_setting(
			$this->plugin_name, // Option group
			$this->option_name . '_simple_local_avatars_caps', // Option name
			array( $this, $this->option_name . '_sanitize_checkbox' ) // Sanitize
		);
	}

	/**
	 * Subtitle Matomo Tag Manager
	 *
	 * @since  2.4.2
	 */
	public function iis_pack_matomo_tag_manager_cb() {
		return false;
	}

	/**
     * Subtitle Google Tag Manager
     *
     * @since  1.0.0
     */
    public function iis_pack_google_tag_manager_cb() {
        return false;
    }

	/**
     * Subtitle Alert
     *
     * @since  2.1.2
     */
    public function iis_pack_alert_cb() {
        echo '<p>' . __( 'Message shown above site content.', 'iis-pack' ) . '</p>';
    }

	/**
	 * Subtitle Other stuff
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_other_stuff_cb() {
		return false;
	}



	// #### Input fields

	/**
	 * Input fields for Matomo Tag Manager ID
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_mtm_id_cb() {
		$mtm_id = get_option( $this->option_name . '_mtm_id' );
		echo '<input type="text" class="" name="' . $this->option_name . '_mtm_id' . '" id="' . $this->option_name . '_mtm_id' . '" value="' . $mtm_id . '"> ';
	}

	/**
     * Input fields for Google Tag Manager ID
     *
     * @since  1.0.0
     */
    public function iis_pack_gtm_id_cb() {
        $gtm_id = get_option( $this->option_name . '_gtm_id' );
        echo '<input type="text" class="" name="' . $this->option_name . '_gtm_id' . '" id="' . $this->option_name . '_gtm_id' . '" value="' . $gtm_id . '"> ';
    }

	/**
     * Textarea for alert message
     *
     * @since  2.1.2
     */
    public function iis_pack_alert_text_cb() {
        $alert_text = get_option( $this->option_name . '_alert_text' );

		$content   = $alert_text;
		$editor_id = $this->option_name . '_alert_text';

		wp_editor( $content, $editor_id );
	}

	/**
     * Alert type select for alert message styling
     *
     * @since  2.3.1
     */
    public function iis_pack_alert_type_cb() {
        $alert_type = get_option( $this->option_name . '_alert_type' );

		?>
			<fieldset>
				<label>
					<select name="<?php echo $this->option_name . '_alert_type' ?>">
						<option value="info" <?php selected( $alert_type, 'info' ); ?>><?php _e( 'Info (blue)', 'iis-pack' ); ?></option>
						<option value="warning" <?php selected( $alert_type, 'warning' ); ?>><?php _e( 'Warning (yellow)', 'iis-pack' ); ?></option>
						<option value="error" <?php selected( $alert_type, 'error' ); ?>><?php _e( 'Error (red)', 'iis-pack' ); ?></option>
					</select>
					<?php _e( 'Choose Alert message type', 'iis-pack' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Input show/hide emojis
	 *
	 * @since  1.0.1
	 */
	public function iis_pack_disable_emojis_cb() {
		$disable_emojis = get_option( $this->option_name . '_disable_emojis' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_disable_emojis' ?>" id="<?php echo $this->option_name . '_disable_emojis' ?>" value="true" <?php checked( $disable_emojis, 'true' ); ?>>
					<?php _e( 'Remove emojis (default)', 'iis-pack' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_disable_emojis' ?>" value="false" <?php checked( $disable_emojis, 'false' ); ?>>
					<?php _e( 'Use emojis', 'iis-pack' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Add setting for local avatar role scope
	 * @param array $args
	 * @since  1.1
	 */
	public function iis_pack_avatar_settings_field_cb( $args ) {
		$options = get_option( $this->option_name . '_simple_local_avatars_caps' ); ?>
		<input id="<?php echo $args[0]; ?>" name="iis_pack_simple_local_avatars_caps[<?php echo $args[0]; ?>]"  type="checkbox" value="1" <?php
		if ( isset( $options[ $args[0] ] ) ) {
			checked( $options[ $args[0] ], 1 );
		} ?> />
		<?php
		if ( '' != $args[1] ) {
			echo $args[1];
		}
	}

    /**
     * Input show/hide emojis
     *
     * @since  1.0.1
     */
    public function iis_pack_disable_password_notifications_cb() {
        $disable_notifications = get_option( $this->option_name . '_disable_password_change_notifications' ); ?>
        <input
            id="<?php echo $this->option_name . '_disable_password_change_notifications' ?>"
            name="<?php echo $this->option_name . '_disable_password_change_notifications' ?>"
            type="checkbox"
            value="true"
	        <?php checked( $disable_notifications, 'true' ); ?>
        >
        <?php
    }


	/**
	 * Sanitize checkboxes
	 *
	 * @param  string $input Check for numeric values
	 * @since  1.0.2
	 * @return string           Sanitized value
	 */
	public function iis_pack_sanitize_checkbox( $input ) {
		$new_input = array();

		// Lokala avatarer / profile picture
		if ( isset( $input[ $this->option_name . '_simple_local_avatars_caps' ] ) ) {
			$new_input[ $this->option_name . '_simple_local_avatars_caps' ] = absint( $input[ $this->option_name . '_simple_local_avatars_caps' ] );
		}

		return $new_input;
	}
	/**
	 * Sanitize true/false input
	 *
	 * @param  string $true_false $_POST value
	 * @since  1.0.0
	 * @since  1.0.1 Change for sanitizing true/false
	 * @return string           Sanitized value
	 */
	public function iis_pack_sanitize_true_false( $true_false ) {
		if ( in_array( $true_false, array( 'true', 'false' ), true ) ) {
	        return $true_false;
	    }
	}

	public function site_status_tests( $tests ) {
		unset(
			$tests['async']['background_updates'],
			$tests['direct']['theme_version']
		);
		return $tests;
	}

}
