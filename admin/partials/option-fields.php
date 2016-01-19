<?php
	/**
	 * [register_setting description]
	 * @since 1.0.0
	 * @since 1.0.2 Fast Social Share buttons
	 */
	public function register_setting() {
		// _cb = callback
		// Lägg till section för Fast Social Share
		add_settings_section(
			$this->option_name . '_fast_social_share',
			__( 'Share buttons', 'iis-pack' ),
			array( $this, $this->option_name . '_fast_social_share_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_fss_beforecontent',
			__( 'Print buttons before content', 'iis-pack' ),
			array( $this, $this->option_name . '_show_fast_social_share_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( $this->option_name . '_fss_beforecontent', 'label_for' => $this->option_name . '_fss_beforecontent' )
		);

		add_settings_field(
			$this->option_name . '_fss_aftercontent',
			__( 'Print buttons after content', 'iis-pack' ),
			array( $this, $this->option_name . '_show_fast_social_share_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( $this->option_name . '_fss_aftercontent', 'label_for' => $this->option_name . '_fss_aftercontent' )
		);

		add_settings_field(
			$this->option_name . '_remove_fss_from_type',
			__( 'Remove from types', 'iis-pack' ),
			array( $this, $this->option_name . '_remove_fss_from_type_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( 'label_for' => $this->option_name . '_remove_fss_from_type' )
		);

		add_settings_field(
			$this->option_name . '_remove_fss_from_template',
			__( 'Remove from templates', 'iis-pack' ),
			array( $this, $this->option_name . '_remove_fss_from_template_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( 'label_for' => $this->option_name . '_remove_fss_from_template' )
		);

		add_settings_field(
			$this->option_name . '_enable_facebook',
			__( 'Activate Facebook', 'iis-pack' ),
			array( $this, $this->option_name . '_checkbox_enable_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( $this->option_name . '_enable_facebook', 'facebook', 'label_for' => $this->option_name . '_enable_facebook' )
		);
		add_settings_field(
			$this->option_name . '_enable_twitter',
			__( 'Activate Twitter', 'iis-pack' ),
			array( $this, $this->option_name . '_checkbox_enable_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( $this->option_name . '_enable_twitter', 'twitter', 'label_for' => $this->option_name . '_enable_twitter' )
		);
		add_settings_field(
			$this->option_name . '_enable_linkedin',
			__( 'Activate LinkedIn', 'iis-pack' ),
			array( $this, $this->option_name . '_checkbox_enable_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( $this->option_name . '_enable_linkedin', 'linkedin', 'label_for' => $this->option_name . '_enable_linkedin' )
		);
		add_settings_field(
			$this->option_name . '_enable_pinterest',
			__( 'Activate Pinterest', 'iis-pack' ),
			array( $this, $this->option_name . '_checkbox_enable_cb' ),
			$this->plugin_name,
			$this->option_name . '_fast_social_share',
			array( $this->option_name . '_enable_pinterest', 'pinterest', 'label_for' => $this->option_name . '_enable_pinterest' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_show_fast_social_share', array( $this, $this->option_name . '_sanitize_checkbox' ) );
		register_setting( $this->plugin_name, $this->option_name . '_remove_fss_from_type', 'sanitize_text_field' );
		register_setting( $this->plugin_name, $this->option_name . '_remove_fss_from_template', 'sanitize_text_field' );
		register_setting(
			$this->plugin_name, // Option group
			$this->option_name . '_choose_social_share', // Option name
			array( $this, $this->option_name . '_sanitize_checkbox' ) // Sanitize
		);

		// Lägg till sektion för Foto-credits
		add_settings_section(
			$this->option_name . '_object_credits',
			'<hr>' . __( 'Object attribution', 'iis-pack' ),
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
			'<hr>' . __( 'Facebook open graph', 'iis-pack' ),
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
			'<hr>' . __( 'Twitter Cards', 'iis-pack' ),
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
			'<hr>' . __( 'Google Analytics', 'iis-pack' ),
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
			'<hr>' . __( 'Fox Menu', 'iis-pack' ),
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

		// Diverse av och på
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

		register_setting( $this->plugin_name, $this->option_name . '_disable_emojis', array( $this, $this->option_name . '_sanitize_true_false' ) );
	}
	/**
	 * Underrubrik Fast Social Share
	 *
	 * @since  1.0.2
	 */
	public function iis_pack_fast_social_share_cb() {
		echo '<p>' . __( 'Choose where social share buttons should be shown. See Help menu for more info (under "Hi, {logged in user}")', 'iis-pack' ) . '</p>';
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

	/**
	 * Underrubrik Other stuff
	 *
	 * @since  1.0.0
	 */
	public function iis_pack_other_stuff_cb() {
		echo '<p>' . __( 'Bits and pieces', 'iis-pack' ) . '</p>';
	}

	// INPUT FÄLT
	/**
	 * Input för radioknappar - var ska Fast Social Share -knapparna visas
	 *
	 * @since  1.0.2
	 */
	public function xxiis_pack_show_fast_social_share_cb() {
		$show_fast_social_share = get_option( $this->option_name . '_show_fast_social_share' );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_fast_social_share' ?>" id="<?php echo $this->option_name . '_show_fast_social_share' ?>" value="beforecontent" <?php checked( $show_fast_social_share, 'beforecontent' ); ?>>
					<?php _e( 'Print buttons before content', 'iis-pack' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_fast_social_share' ?>" value="aftercontent" <?php checked( $show_fast_social_share, 'aftercontent' ); ?>>
					<?php _e( 'Print buttons after content', 'iis-pack' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_show_fast_social_share' ?>" value="shortcode" <?php checked( $show_fast_social_share, 'shortcode' ); ?>>
					<?php _e( 'Do not print buttons (default) - use shortcode <code>[fastsocial]</code> in post content or page template', 'iis-pack' ); ?>
				</label>
			</fieldset>
		<?php
	}

	public function iis_pack_show_fast_social_share_cb( $args ) {
		$options = get_option( $this->option_name . '_show_fast_social_share' ); ?>
		<input id="<?php echo $args[0]; ?>" name="iis_pack_show_fast_social_share[<?php echo $args[0]; ?>]"  type="checkbox" value="1" <?php checked( $options[ $args[0] ], 1 ); ?> />
	<?php
	}

	/**
	 * Inställningsfält för extra finlir var knapparna ska hamna - TYPES
	 * Om det är inställt på att skrivas ut i content EXKLUDERAS värdena, om det är valt att skrivas med shortcode INKLUDERAS värdena
	 *
	 * @since  1.0.2 Anger fält för post types (page, post, custom post type)
	 */
	public function iis_pack_remove_fss_from_type_cb() {
		$remove_fss_from_type = get_option( $this->option_name . '_remove_fss_from_type' );
		echo '<input type="text" class="large-text" name="' . $this->option_name . '_remove_fss_from_type' . '" id="' . $this->option_name . '_remove_fss_from_type' . '" value="' . $remove_fss_from_type . '"> ';
		echo '<p class="description">' . __( 'Add post types to be avoided if above setting is set to Print before or Print after content. (ex: se-tech,guide)', 'iis-pack' ) . '</p>';
	}

	/**
	 * Inställningsfält för extra finlir var knapparna ska hamna - TEMPLATES
	 * Om det är inställt på att skrivas ut i content EXKLUDERAS värdena, om det är valt att skrivas med shortcode INKLUDERAS värdena
	 *
	 * @since  1.0.2 Anger fält för page template (tpl-guidelista.php, ect)
	 */
	public function iis_pack_remove_fss_from_template_cb() {
		$remove_fss_from_template = get_option( $this->option_name . '_remove_fss_from_template' );
		echo '<input type="text" class="large-text" name="' . $this->option_name . '_remove_fss_from_template' . '" id="' . $this->option_name . '_remove_fss_from_template' . '" value="' . $remove_fss_from_template . '"> ';
		echo '<p class="description">' . __( 'Add templates to be avoided if above setting is set to Print before or Print after content. (ex: <strong>tpl-guidelista.php</strong> or if template is in a folder: <strong>templates/template.php</strong>)', 'iis-pack' ) . '</p>';
	}

	/**
	 * Checkbox var ska Fast Social Share -knapparna visas
	 *
	 * @since  1.0.2
	 */
	public function iis_pack_checkbox_enable_cb( $args ) {
		$options = get_option( $this->option_name . '_choose_social_share' ); ?>
		<input id="<?php echo $args[0]; ?>" name="iis_pack_choose_social_share[<?php echo $args[0]; ?>]"  type="checkbox" value="1" <?php checked( $options[ $args[0] ], 1 ); ?> />
		<?php
		if ( '' != $args[1] ) { ?>
			<small>[fastsocial <?php echo $args[1]; ?>="yes"]</small>
		 <?php
		}

	}

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

	/**
	 * Input för radioknappar visa /dölj emojisar
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
					<?php _e( 'Use Emojis', 'iis-pack' ); ?>
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
	 * Sanera beforecontent / aftercontent / shortcode för ex. Fast Social Share
	 *
	 * @param  string $beforecontent_aftercontent_shortcode $_POST value
	 * @since  1.0.2
	 * @return string           Sanitized value
	 */
	public function iis_pack_sanitize_beforecontent_aftercontent_shortcode( $beforecontent_aftercontent_shortcode ) {
		if ( in_array( $beforecontent_aftercontent_shortcode, array( 'beforecontent', 'aftercontent', 'shortcode' ), true ) ) {
	        return $beforecontent_aftercontent_shortcode;
	    }
	}

	/**
	 * Sanera checkboxar Fast Social Share
	 *
	 * @param  string $input
	 * @since  1.0.2
	 * @return string           Sanitized value
	 */
	public function iis_pack_sanitize_checkbox( $input ) {
		$new_input = array();
		// Where to put the buttons
		if ( isset( $input[ $this->option_name . '_fss_beforecontent' ] ) ) {
			$new_input[ $this->option_name . '_fss_beforecontent' ] = absint( $input[ $this->option_name . '_fss_beforecontent' ] );
		}
		if ( isset( $input[ $this->option_name . '_fss_aftercontent' ] ) ) {
			$new_input[ $this->option_name . '_fss_aftercontent' ] = absint( $input[ $this->option_name . '_fss_aftercontent' ] );
		}
		// Activate networks
		if ( isset( $input[ $this->option_name . '_enable_facebook' ] ) ) {

			$new_input[ $this->option_name . '_enable_facebook' ] = absint( $input[ $this->option_name . '_enable_facebook' ] );
		} else {

			$new_input[ $this->option_name . '_enable_facebook' ] = 'no';
		}

		if ( isset( $input[ $this->option_name . '_enable_twitter' ] ) ) {

			$new_input[ $this->option_name . '_enable_twitter' ] = absint( $input[ $this->option_name . '_enable_twitter' ] );
		} else {

			$new_input[ $this->option_name . '_enable_twitter' ] = 'no';
		}

		if ( isset( $input[ $this->option_name . '_enable_linkedin' ] ) ) {

			$new_input[ $this->option_name . '_enable_linkedin' ] = absint( $input[ $this->option_name . '_enable_linkedin' ] );
		} else {

			$new_input[ $this->option_name . '_enable_linkedin' ] = 'no';
		}

		if ( isset( $input[ $this->option_name . '_enable_pinterest' ] ) ) {

			$new_input[ $this->option_name . '_enable_pinterest' ] = absint( $input[ $this->option_name . '_enable_pinterest' ] );
		} else {

			$new_input[ $this->option_name . '_enable_pinterest' ] = 'no';
		}

		return $new_input;
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
