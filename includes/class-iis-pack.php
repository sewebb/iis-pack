<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://internetstiftelsen.se
 * @since      1.0.0
 *
 * @package    Iis_Pack
 * @subpackage Iis_Pack/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Iis_Pack
 * @subpackage Iis_Pack/includes
 * @author     The Swedish Internet Foundation <webmaster@internetstiftelsen.se>
 */
class Iis_Pack {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Iis_Pack_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected string $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected string $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'iis-pack';
		$this->version     = '2.4.7';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Iis_Pack_Loader. Orchestrates the hooks of the plugin.
	 * - Iis_Pack_i18n. Defines internationalization functionality.
	 * - Iis_Pack_Admin. Defines all hooks for the admin area.
	 * - Iis_Pack_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iis-pack-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iis-pack-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-iis-pack-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-iis-pack-public.php';

		$this->loader = new Iis_Pack_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Iis_Pack_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Iis_Pack_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @since    1.2.2 add_support_for_page_excerpt
	 * @since    1.4   ta bort interna pingar pre_ping
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Iis_Pack_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'iis_pack_add_options_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_setting' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'iis_pack_add_support_for_featured_image' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'iis_pack_add_support_for_page_excerpt' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'iis_pack_in_user_profile' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'iis_pack_comment_stuff' );
		$this->loader->add_action( 'plugins_loaded', $plugin_admin, 'iis_pack_sanitize_filename' );
		$this->loader->add_filter( 'site_status_tests', $plugin_admin, 'site_status_tests' );
		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'custom_core_messages', 11 );

		$plugin_admin->acf_hooks();
	}

	/**
	 * Register all the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks(): void {

		$plugin_public = new Iis_Pack_Public( $this->get_plugin_name(), $this->get_version() );

		// Register hooks for functions in /public/partials
		// Called in the Iis_Plugins_Public class
		$this->loader->add_action( 'wp_head', $plugin_public, 'iis_pack_include_in_head' );
		$this->loader->add_action( 'wp_body_open', $plugin_public, 'iis_pack_include_in_body' );
		$this->loader->add_action( 'init', $plugin_public, 'iis_pack_disable_all_emojis' );
		$this->loader->add_filter( 'embed_oembed_html', $plugin_public, 'iis_nocookie', 10, 2 );
		$this->loader->add_filter( 'imagify_picture_attributes', $plugin_public, 'keep_attributes_off_picture_tags', 10, 0 );
		$this->loader->add_filter( 'imagify_picture_img_attributes', $plugin_public, 'prep_attributes_for_img_tags', 10, 2 );
	}

	/**
	 * Run the loader to execute all the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Iis_Pack_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
