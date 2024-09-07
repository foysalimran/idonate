<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package idonate
 * @subpackage idonate/Helpers
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\Idonate\Helpers;

/**
 * The Helpers class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Helpers
{
	/**
	 * The min of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $min   The slug of this plugin.
	 */
	private $min;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct()
	{
		$this->min   = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
	}

	/**
	 * Register the All scripts for the public-facing side of the site.
	 *
	 * @since    2.0
	 */
	public function register_all_scripts()
	{
		wp_register_style('datatables', IDONATE_ASSETS . 'css/datatables' . $this->min . '.css', array(), IDONATE_VERSION, 'all');
		wp_register_style('magnific-popup', IDONATE_ASSETS . 'css/magnific-popup' . $this->min . '.css', array(), IDONATE_VERSION, 'all');


		wp_register_style('idonate-admin', IDONATE_ASSETS . 'css/idonate-admin' . $this->min . '.css', array(), IDONATE_VERSION, 'all');
		wp_register_style('idonate-settings-admin', IDONATE_ASSETS . 'css/idonate-settings-admin' . $this->min . '.css', array(), IDONATE_VERSION, 'all');

		wp_register_style('icofont', IDONATE_ASSETS . 'css/icofont' . $this->min . '.css', array(), IDONATE_VERSION, 'all');

		wp_register_style('idonate-grid', IDONATE_ASSETS . 'css/idonate-grid' . $this->min . '.css', array(), IDONATE_VERSION, 'all');
		wp_register_style('idonate-frontend', IDONATE_ASSETS . 'css/idonate-frontend' . $this->min . '.css', array(), IDONATE_VERSION, 'all');

		wp_register_script('datatables', IDONATE_ASSETS . 'js/datatables' . $this->min . '.js', array('jquery'), IDONATE_VERSION, true);
		wp_register_script('magnific-popup', IDONATE_ASSETS . 'js/jquery.magnific-popup' . $this->min . '.js', array('jquery'), '1.1.0', true);
		wp_register_script('validate', IDONATE_ASSETS . 'js/jquery.validate' . $this->min . '.js', array('jquery'), IDONATE_VERSION, true);

		wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js', array('jquery'), '1.0', true);
		wp_register_script('idonate-admin', IDONATE_ASSETS . 'js/idonate-admin.js', array('jquery', 'jquery-ui-datepicker'), IDONATE_VERSION, true);
		wp_register_script('idonate-main', IDONATE_ASSETS . 'js/idonate-frontend' . $this->min . '.js', array('jquery'), IDONATE_VERSION, true);
		wp_localize_script(
			'idonate-main',
			'idonate',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce'   => wp_create_nonce('idonate_nonce'),
			)
		);
		wp_localize_script(
			'idonate-admin',
			'idonate',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce'   => wp_create_nonce('idonate_nonce'),
			)
		);
	}
}
