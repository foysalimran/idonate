<?php

/**
 * The file of the Idonate class.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package idonate
 */

namespace ThemeAtelier\Idonate;

use ThemeAtelier\Idonate\Loader;
use ThemeAtelier\Idonate\Helpers\Helpers;
use ThemeAtelier\Idonate\Frontend\Helpers\RewriteRules;
use ThemeAtelier\Idonate\Frontend\Helpers\Template;
use ThemeAtelier\Idonate\Admin\Admin;
use ThemeAtelier\Idonate\Frontend\Frontend;
use ThemeAtelier\Idonate\Frontend\Shortcode\ShortcodeDonors;
use ThemeAtelier\Idonate\Frontend\Shortcode\DonorShortcode;
use ThemeAtelier\Idonate\Frontend\Shortcode\ShortcodeBloodRequest;
use ThemeAtelier\Idonate\Frontend\Shortcode\IdonateStatistics;
use ThemeAtelier\Idonate\Frontend\Shortcode\ShortcodePostBloodRequest;
use ThemeAtelier\Idonate\Frontend\Shortcode\ShortcodeRegisterDonor;

// don't call the file directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * The main class of the plugin.
 *
 * Handle all the class and methods of the plugin.
 *
 * @author     ThemeAtelier <themeatelierbd@gmail.com>
 */
class Idonate
{
	/**
	 * Plugin version
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var string
	 */
	protected $version;

	/**
	 * Plugin slug
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var string
	 */
	protected $plugin_slug;

	/**
	 * Main Loader.
	 *
	 * The loader that's responsible for maintaining and registering all hooks that empowers
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var object
	 */
	protected $loader;
	/**
	 * Constructor for the Idonate class.
	 *
	 * Sets up all the appropriate hooks and actions within the plugin.
	 */
	public function __construct()
	{
		$this->version     = IDONATE_VERSION;
		$this->plugin_slug = 'idonate';
		$this->load_dependencies();
		$this->define_constants();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->rewrite_rules         = new RewriteRules();
		 new Template();
		add_action('plugin_loaded', array($this, 'init_plugin'));
		add_action('activated_plugin', array($this, 'redirect_to'));
		$active_plugins = get_option('active_plugins');
		foreach ($active_plugins as $active_plugin) {
			$_temp = strpos($active_plugin, 'idonate.php');
			if (false != $_temp) {
				add_filter('plugin_action_links_' . $active_plugin, array($this, 'idonate_plugin_action_links'));
			}
		}
	}

	public function redirect_to($plugin)
	{
		if (IDONATE_BASENAME === $plugin) {
			$redirect_url = esc_url(admin_url('admin.php?page=idonate-settings'));
			exit(wp_kses_post(wp_safe_redirect($redirect_url)));
		}
	}

	public function idonate_plugin_action_links($links)
	{

		$new_links = array(
			sprintf('<a href="' . esc_url(admin_url('admin.php?page=idonate-settings')) . '">' . esc_html__('Settings', 'idonate') . '</a>'),
			sprintf('<a target="_blank" href="https://docs.themeatelier.net/docs/idonate/overview/">' . esc_html__('Docs', 'idonate') . '</a>'),
			sprintf('<a target="_blank" href="https://themeatelier.net/contact">' . esc_html__('Support', 'idonate') . '</a>'),
		);
		return array_merge($new_links, $links);
	}

	/**
	 * Define the constants
	 *
	 * @return void
	 */
	public function define_constants()
	{
		define('IDONATE_URL', plugins_url('', IDONATE_FILE));
		define('IDONATE_ASSETS', IDONATE_URL . '/src/assets/');
		define('IDONATE_ADMIN', IDONATE_URL . '/src/Admin');
	}

	/**
	 * Load the plugin after all plugins are loaded.
	 *
	 * @return void
	 */
	public function init_plugin()
	{
		do_action('idonate_loaded');
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Loader. Orchestrates the hooks of the plugin.
	 * - Teamproi18n. Defines internationalization functionality.
	 * - Admin. Defines all hooks for the admin area.
	 * - Frontend. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		$this->loader = new Loader();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{
		$plugin_public = new Frontend($this->get_plugin_slug(), $this->get_version());
		$plugin_helpers = new Helpers($this->get_plugin_slug(), $this->get_version());
		$this->loader->add_action('wp_loaded', $plugin_helpers, 'register_all_scripts');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

		$plugin_public 	= new ShortcodeDonors();
		$register_donor = new ShortcodeRegisterDonor();
		$donortable 	= new DonorShortcode();
		$shortcode_post_blood_request 	= new ShortcodePostBloodRequest();
		$shortcode_blood_request 	= new ShortcodeBloodRequest();
		$idonate_statistics 	= new IdonateStatistics();
		$this->loader->add_shortcode('donors', $plugin_public, 'render_donor_shortcode');
		$this->loader->add_shortcode('register-donor', $register_donor, 'shortcode_register_donor');
		$this->loader->add_shortcode('donortable', $donortable, 'idonate_donor_table');
		$this->loader->add_shortcode('post-blood-request', $shortcode_post_blood_request, 'shortcode_post_blood_request');
		$this->loader->add_shortcode('blood-request', $shortcode_blood_request, 'shortcode_blood_request');
		$this->loader->add_shortcode('idonate-statistics', $idonate_statistics, 'idonate_statistics');
	}

	/**
	 * Register all of the hooks related to the admin dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new Admin($this->get_plugin_slug(), $this->get_version());
		$this->loader->add_action('init', $plugin_admin, 'blood_request_post_type');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_filter('post_updated_messages', $plugin_admin, 'post_update_message');
		$this->loader->add_filter('term_updated_messages', $plugin_admin, 'update_idonate_term_messages');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The slug of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_slug()
	{
		return $this->plugin_slug;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
