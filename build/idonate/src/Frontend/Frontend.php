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
 * @subpackage idonate/Frontend
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\Idonate\Frontend;

use ThemeAtelier\Idonate\Frontend\Manager;
use ThemeAtelier\Idonate\Helpers\IDonateAjaxHandler;

/**
 * The Frontend class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Frontend
{
	/**
	 * The slug of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_slug   The slug of this plugin.
	 */
	private $plugin_slug;

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
	public function __construct($plugin_name, $version)
	{

		$this->idonate_public_action();
		$this->min   = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
	}


	private function idonate_public_action()
	{
		$IDonateAjaxHandler    = new IDonateAjaxHandler();
		add_action('wp_ajax_idonate_post_popup', array($IDonateAjaxHandler, 'idonate_post_popup'));
		add_action('wp_ajax_nopriv_idonate_post_popup', array($IDonateAjaxHandler, 'idonate_post_popup'));

		add_action('wp_ajax_idonate_post_admin_popup_next_prev', array($IDonateAjaxHandler, 'idonate_post_admin_popup_next_prev'));
		add_action('wp_ajax_nopriv_idonate_post_admin_popup_next_prev', array($IDonateAjaxHandler, 'idonate_post_admin_popup_next_prev'));

		add_action('wp_ajax_idonate_search_donors', array($IDonateAjaxHandler, 'idonate_search_donors'));
		add_action('wp_ajax_nopriv_idonate_search_donors', array($IDonateAjaxHandler, 'idonate_search_donors'));

		add_action('wp_ajax_idonate_search_request', array($IDonateAjaxHandler, 'idonate_search_request'));
		add_action('wp_ajax_nopriv_idonate_search_request', array($IDonateAjaxHandler, 'idonate_search_request'));

		add_action('wp_ajax_idonate_country_to_states_ajax', array($IDonateAjaxHandler, 'idonate_country_to_states_ajax'));
		add_action('wp_ajax_nopriv_idonate_country_to_states_ajax', array($IDonateAjaxHandler, 'idonate_country_to_states_ajax'));
	}

	/**
	 * Gets the existing shortcode-id, page-id and option-key from the current page.
	 *
	 * @return array
	 */
	public static function get_page_data()
	{
		$current_page_id    = get_queried_object_id();
		$option_key         = 'idonate_page_id' . $current_page_id;
		$found_generator_id = get_option($option_key);
		if (is_multisite()) {
			$option_key         = 'idonate_page_id' . get_current_blog_id() . $current_page_id;
			$found_generator_id = get_site_option($option_key);
		}
		$get_page_data = array(
			'page_id'      => $current_page_id,
			'generator_id' => $found_generator_id,
			'option_key'   => $option_key,
		);
		return $get_page_data;
	}

	/**
	 * If the option does not exist, it will be created.
	 *
	 * It will be serialized before it is inserted into the database.
	 *
	 * @param  string $post_id existing shortcode id.
	 * @param  array  $get_page_data get current page-id, shortcode-id and option-key from the page.
	 * @return void
	 */
	public static function db_options_update($post_id, $get_page_data)
	{
		$found_generator_id = $get_page_data['generator_id'];
		$option_key         = $get_page_data['option_key'];
		$current_page_id    = $get_page_data['page_id'];
		if ($found_generator_id) {
			$found_generator_id = is_array($found_generator_id) ? $found_generator_id : array($found_generator_id);
			if (!in_array($post_id, $found_generator_id) || empty($found_generator_id)) {
				// If not found the shortcode id in the page options.
				array_push($found_generator_id, $post_id);
				if (is_multisite()) {
					update_site_option($option_key, $found_generator_id);
				} else {
					update_option($option_key, $found_generator_id);
				}
			}
		} else {
			// If option not set in current page add option.
			if ($current_page_id) {
				if (is_multisite()) {
					add_site_option($option_key, array($post_id));
				} else {
					add_option($option_key, array($post_id));
				}
			}
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		$options = get_option('idonate_settings');
		$idoante_custom_css = isset($options['idoante_custom_css']) ? $options['idoante_custom_css'] : true;
		$idoante_custom_js = isset($options['idoante_custom_js']) ? $options['idoante_custom_js'] : true;
		$load_magnific_popup_css = isset($options['load_magnific_popup_css']) ? $options['load_magnific_popup_css'] : true;
		$load_magnific_popup_js = isset($options['load_magnific_popup_js']) ? $options['load_magnific_popup_js'] : true;
		$load_icofont = isset($options['load_icofont']) ? $options['load_icofont'] : true;
		$datatables_css = isset($options['datatables_css']) ? $options['datatables_css'] : true;
		$datatables_js = isset($options['datatables_js']) ? $options['datatables_js'] : true;
		$validate_js = isset($options['validate_js']) ? $options['validate_js'] : true;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WBP_Category_Slider_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WBP_Category_Slider_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if (!wp_script_is('magnific-popup', 'enqueued') && $load_magnific_popup_css) {
			wp_enqueue_style('magnific-popup');
		}
		if ($load_icofont) {
			wp_enqueue_style('icofont');
		}

		if ($datatables_css) {
			wp_enqueue_style('datatables');
		}
		wp_enqueue_style('idonate-grid');
		wp_enqueue_style('idonate-frontend');

		$custom_css = '';
		include 'dynamic-css/dynamic-css.php';
		wp_add_inline_style('idonate-frontend', $custom_css);

		wp_add_inline_style('idonate-frontend', $idoante_custom_css);
		

		if (!wp_script_is('magnific-popup', 'enqueued') && $load_magnific_popup_js) {
			wp_enqueue_script('magnific-popup');
		}
		if ($options['idonate_recaptcha_active']) {
			wp_enqueue_script('recaptcha');
		}
		// wp_enqueue_script('idonate-admin');
		if ($datatables_js) {
			wp_enqueue_script('datatables');
		}
		if ($validate_js) {
			wp_enqueue_script('validate');
		}
		wp_enqueue_script('idonate-main');
		wp_add_inline_script('idonate-main', $idoante_custom_js);
	}
}
