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
	 * @param string $plugin_name 	The name of this plugin.
	 * @param string $version    The version of this plugin.
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
	 * Vi tycker det är bra att kunna ha excerpts även på post_type page
	 * Lägger till om det saknas
	 * @since 1.2.2
	 */
	public function add_support_for_page_excerpt() {
		$has_page_excerpts_support = post_type_supports( 'page', 'excerpt' );

		if ( false === $has_page_excerpts_support ) {
			add_post_type_support( 'page', 'excerpt' );
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
	 * Lägger till möjlighet att ladda upp lokal avatar i Användarprofilen
	 * @since 1.1 Är en kopia av gamla IIS Simple Local Avatars
	 */
	public function in_user_profile() {
		include_once 'partials/class-local-avatars.php';

		call_simple_local_avatars();
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
	 * Lägger till hjälptexter för inställningssidan
	 * @since 1.0.2
	 */
	public function iis_pack_add_help_tab () {
		$alltemplates = '';
		$allposttypes = '';
		$screen       = get_current_screen();

		$screen->add_help_tab( array(
				'id'      => 'fss_share_buttons',
				'title'   => __( 'Share buttons', 'iis-pack' ),
				'content' => __( '<h4>How it works:</h4>
					<p>Default setting is no buttons showing on pages/posts without an added shortcode <code>[fastsocial]</code> either in the content or added with the page template.</p>
					<p>BUT - you can choose to print before or after the content and still avoide printing on certain post types.
					For example, if you dont want any buttons on normal pages add "<code>page</code>" to the <em>"Remove from"</em> field.
					Or if you use a special template to show for example Internetguider - add "<code>guide</code>" to the field. (Or a combination like "<code>page,guide</code>")</code></p>
					<p><em>"Activate"</em>-settings are default for the hole site. If you activate all networks you can still choose not to show a certain button on / in a post or template
					with for example <code>[fastsocial pinterest=no]</code> (or if a network is not choosen for all pages - activate it with <code>[fastsocial pinterest=yes]</code></p>
						<p>On each page / post you can also add a special Facebook App ID, <strong>different</strong> from the sitewide ID.
						Or you can add it to the do_shortcode in a template with <code>[fastsocial fbappid=<em>{idnumber}</em>]</code></p>
						<p>Hashtags for the Twitter-button could be added in the same manner (per post/page or by shortcode) <code>[fastsocial hashtags=internetguider,internetstiftelsen]</code></p>
						<p>To remove fastsocial for a specific page / post that would normaly magically add the buttons, add <code>[fastsocial remove=yes]</code> to post content (in editor)</p>', 'iis-pack' ),
				)
		);

		$templates = get_page_templates();
		foreach ( $templates as $template_name => $template_filename ) {
			$alltemplates .= "<em>$template_name:</em> <code>$template_filename</code>&nbsp;&nbsp;";
		}
		$screen->add_help_tab( array(
				'id'      => 'fss_template_files',
				'title'   => __( 'Choose from theese templates: ', 'iis-pack' ),
				'content' => '<p>' . $alltemplates . '</p>',
				)
		);

		$post_types = get_post_types();
		foreach ( $post_types as $post_type ) {
			$allposttypes .= '<code>' . $post_type . '</code>&nbsp;&nbsp;';
		}
		$screen->add_help_tab( array(
				'id'      => 'fss_post_types',
				'title'   => __( 'Choose from theese post types: ', 'iis-pack' ),
				'content' => '<p>' . $allposttypes . '</p>',
				)
		);

		$screen->add_help_tab( array(
				'id'      => 'fss_object_attribution',
				'title'   => __( 'Object attribution', 'iis-pack' ),
				'content' => __( '<h4>Adding license to images</h4>
					<p>In the media library there are fields for each object that can hold object attributions.</p>
					<p>If added to an image it could be printed automatically under each image - or you use your own function in your theme</p>', 'iis-pack' ),
				)
		);
	}

	/**
	 * Skapa inställningssidan
	 * @since 1.0.0
	 * @since 1.0.2 Fast Social Share buttons
	 */
	public function display_options_page() {
		include_once 'partials/iis-pack-admin-display.php';
	}

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

		add_settings_field(
			$this->option_name . '_show_object_credits_featured',
			__( 'Hide on featured image', 'iis-pack' ),
			array( $this, $this->option_name . '_show_object_credits_featured_cb' ),
			$this->plugin_name,
			$this->option_name . '_object_credits',
			array( $this->option_name . '_show_object_credits_featured', 'label_for' => $this->option_name . '_show_object_credits_featured' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_show_object_credits', array( $this, $this->option_name . '_sanitize_true_false' ) );
		register_setting( $this->plugin_name, $this->option_name . '_show_object_credits_featured', array( $this, $this->option_name . '_sanitize_checkbox' ) );

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

		add_settings_field( $this->option_name . 'simple_local_avatars_caps',
			__( 'Local Profile Picture', 'iis-pack' ),
			array( $this, $this->option_name . '_avatar_settings_field_cb' ),
			$this->plugin_name,
			$this->option_name . '_other_stuff',
			array( $this->option_name . '_simple_local_avatars_caps', __( 'Only allow users with file upload capabilities to upload local profile pictures (Authors and above)', 'iis-pack' ), 'label_for' => $this->option_name . '_simple_local_avatars_caps' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_disable_emojis', array( $this, $this->option_name . '_sanitize_true_false' ) );
		register_setting(
			$this->plugin_name, // Option group
			$this->option_name . '_simple_local_avatars_caps', // Option name
			array( $this, $this->option_name . '_sanitize_checkbox' ) // Sanitize
		);
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
	 * Input för checkboxar - var ska Fast Social Share -knapparna visas
	 * @param array $args knapparnas läge
	 * @since  1.0.2
	 */
	public function iis_pack_show_fast_social_share_cb( $args ) {
		$options = get_option( $this->option_name . '_show_fast_social_share' );
	?>
		<input id="<?php echo $args[0]; ?>" name="iis_pack_show_fast_social_share[<?php echo $args[0]; ?>]"  type="checkbox" value="1" <?php
		if ( isset( $options[ $args[0] ] ) ) {
			checked( $options[ $args[0] ], 1 );
		} ?> />
	<?php
	}

	/**
	 * Inställningsfält för extra finlir var knapparna ska hamna - TYPES
	 * Om det är inställt på att skrivas ut i content EXKLUDERAS värdena, om det är valt att skrivas med shortcode INKLUDERAS värdena
	 *
	 * @since  1.0.2 Anger fält för post types (page, post, custom post type)
	 */
	public function iis_pack_remove_fss_from_type_cb() {
		$args = array(
			'public'   => true,
		);
		$remove_fss_from_type = get_option( $this->option_name . '_remove_fss_from_type' );
		echo '<input type="text" class="large-text" name="' . $this->option_name . '_remove_fss_from_type' . '" id="' . $this->option_name . '_remove_fss_from_type' . '" value="' . $remove_fss_from_type . '"> ';
		echo '<p class="description">' . __( 'Add post types to be avoided if above setting is set to Print before or Print after content. (ex: se-tech,guide)', 'iis-pack' ) . '</p>';
		echo '<p>' . __( 'Choose from theese post types: ', 'iis-pack' ) . __( '( <em>see help menu</em> ) ', 'iis-pack' ) . '</p>';
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
		echo '<p class="description">' . __( 'Add templates to be avoided if above setting is set to Print before or Print after content.', 'iis-pack' ) . '</p>';
		echo '<p>' . __( 'Choose from theese templates: ', 'iis-pack' ) . __( '( <em>see help menu</em> ) ', 'iis-pack' ) . '</p>';
	}

	/**
	 * Checkbox var vilka nätverk ska visas
	 *
	 * @since 1.0.2
	 * @param array $args nätverken
	 */
	public function iis_pack_checkbox_enable_cb( $args ) {
		$options = get_option( $this->option_name . '_choose_social_share' ); ?>
		<input id="<?php echo $args[0]; ?>" name="iis_pack_choose_social_share[<?php echo $args[0]; ?>]"  type="checkbox" value="1"
		<?php
		if ( isset( $options[ $args[0] ] ) ) {
			checked( $options[ $args[0] ], 1 );
		} ?> />
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
	 * Input för checkbox för att dölja bildattribution på featured images (men visa i sidan)
	 * Används för de fall teman gör egna saker med featured image men ändån vill visa bildattr. på vanliga bilder i posten/sidan
	 * @param array $args knapparnas läge
	 * @since  1.1.1
	 */
	public function iis_pack_show_object_credits_featured_cb( $args ) {
		$options = get_option( $this->option_name . '_show_object_credits_featured' );
	?>
		<input id="<?php echo $args[0]; ?>" name="iis_pack_show_object_credits_featured[<?php echo $args[0]; ?>]"  type="checkbox" value="1" <?php
		if ( isset( $options[ $args[0] ] ) ) {
			checked( $options[ $args[0] ], 1 );
		} ?> />
		<?php _e( 'If you choose "Show" you can tick this to hide on featured image. <em>(Then your theme rolls its own variant)</em>', 'iis-pack' ); ?>
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

	/**
	 * Förhindra (om ikryssad) att någon annan än författare & uppåt får lägga till egen Profile Picture
	 * @param array $args på eller av
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
	 * @param  string $input kollar alla inkommamde värde så att de är numeriska
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

		// Lokala avatarer / profile picture
		if ( isset( $input[ $this->option_name . '_simple_local_avatars_caps' ] ) ) {
			$new_input[ $this->option_name . '_simple_local_avatars_caps' ] = absint( $input[ $this->option_name . '_simple_local_avatars_caps' ] );
		}

		// Bildattribution
		if ( isset( $input[ $this->option_name . '_show_object_credits_featured' ] ) ) {
			$new_input[ $this->option_name . '_show_object_credits_featured' ] = absint( $input[ $this->option_name . '_show_object_credits_featured' ] );
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
}
