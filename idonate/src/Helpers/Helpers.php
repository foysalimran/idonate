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

	/**
	 * Option recursive
	 *
	 * @since 1.0.0
	 *
	 * @param array  $array array.
	 * @param string $key option key.
	 *
	 * @return mixed
	 */
	private static function option_recursive($array, $key)
	{
		foreach ($array as $option) {
			$is_array = is_array($option);

			if ($is_array && isset($option['key'], $option['default']) && $option['key'] == $key) {
				$value                                = $option['default'];
				'on' === $option['default'] ? $value  = true : 0;
				'off' === $option['default'] ? $value = false : 0;

				return $value;
			}

			$value = $is_array ? self::option_recursive($option, $key) : null;

			if (! (null === $value)) {
				return $value;
			}
		}

		return null;
	}

	/**
	 * Get default value for a idonate pro option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key option key.
	 * @param mixed  $fallback fallback value.
	 * @param mixed  $from_options from option.
	 *
	 * @return mixed
	 */
	private static function get_option_default($key, $fallback, $from_options)
	{
		if (! $from_options) {
			// Avoid infinity recursion.
			return $fallback;
		}

		$idonate_options_array                                      = (new Options_V2(false))->get_setting_fields();
		! is_array($idonate_options_array) ? $idonate_options_array = array() : 0;

		$default_value = self::option_recursive($idonate_options_array, $key);

		return null === $default_value ? $fallback : $default_value;
	}

	/**
	 * Get option data
	 *
	 * @since 1.0.0
	 *
	 * @param string $key key.
	 * @param bool   $default default.
	 * @param bool   $type if false return string.
	 * @param bool   $from_options from option.
	 *
	 * @return array|bool|mixed
	 */
	public static function get_option($key, $default = false, $type = true, $from_options = false)
	{
		$option = (array) maybe_unserialize(get_option('idonate_settings'));

		if (empty($option) || ! is_array($option)) {
			// If the option array is not yet stored on database, then return default/fallback.
			return self::get_option_default($key, $default, $from_options);
		}

		// Get option value by option key.
		if (array_key_exists($key, $option)) {
			// Convert off/on switch values to boolean.
			$value = $option[$key];

			if (true == $type) {
				'off' === $value ? $value = false : 0;
				'on' === $value ? $value  = true : 0;
			}

			return apply_filters($key, $value);
		}

		// Access array value via dot notation, such as option->get('value.subvalue').
		if (strpos($key, '.')) {
			$option_key_array = explode('.', $key);

			$new_option = $option;
			foreach ($option_key_array as $dot_key) {
				if (isset($new_option[$dot_key])) {
					$new_option = $new_option[$dot_key];
				} else {
					return self::get_option_default($key, $default, $from_options);
				}
			}

			// Convert off/on switch values to boolean.
			$value = $new_option;

			if (true == $type) {
				'off' === $value ? $value = false : 0;
				'on' === $value ? $value  = true : 0;
			}

			return apply_filters($key, $value);
		}

		return self::get_option_default($key, $default, $from_options);
	}

	/**
	 * Get array value by dot notation
	 *
	 * @since 1.0.0
	 * @since 1.4.1 default parameter added
	 *
	 * @param null  $key option key.
	 * @param array $array array.
	 * @param mixed $default default value.
	 *
	 * @return array|bool|mixed
	 */
	public static function avalue_dot($key = null, $array = array(), $default = false)
	{
		$array = (array) $array;
		if (! $key || ! count($array)) {
			return $default;
		}
		$option_key_array = explode('.', $key);

		$value = $array;

		foreach ($option_key_array as $dot_key) {
			if (isset($value[$dot_key])) {
				$value = $value[$dot_key];
			} else {
				return $default;
			}
		}
		return $value;
	}

	/**
	 * Alias of avalue_dot method of utils
	 * Get array value by key and recursive array value by dot notation key
	 *
	 * Ex: $this->array_get('key.child_key', $array);
	 *
	 * @since 1.3.3
	 *
	 * @param null  $key key name.
	 * @param array $array array.
	 * @param mixed $default default value.
	 *
	 * @return array|bool|mixed
	 */
	public static function array_get($key = null, $array = array(), $default = false)
	{
		return self::avalue_dot($key, $array, $default);
	}

	/**
	 * Get current user ID or given user ID
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $user_id user ID.
	 *
	 * @return int  when $user_id = 0, return 0 or current user ID
	 *              otherwise return given ID
	 */
	public static function get_user_id($user_id = 0)
	{
		if (! $user_id) {
			return get_current_user_id();
		}

		return $user_id;
	}

	public static function profile_url($user = 0)
	{
		$options = get_option('idonate_settings');
		$donor_view_slug = isset($options['donor_view_slug']) ? $options['donor_view_slug'] : '';
		$site_url = trailingslashit(home_url()) . $donor_view_slug . '/';
		if (! is_object($user)) {
			$user = get_userdata(self::get_user_id($user));
		}

		$user_name = (is_object($user) && isset($user->user_nicename)) ? $user->user_nicename : 'user_name';
		return $site_url . $user_name;
	}

	/**
	 * Get user by user login
	 *
	 * @since 1.0.0
	 *
	 * @param string $user_nicename user nicename.
	 *
	 * @return array|null|object
	 */
	public static function get_user_by_login($user_nicename = '')
	{
		global $wpdb;
		$user_nicename = sanitize_text_field($user_nicename);
		$user          = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT *
							FROM 	{$wpdb->users}
							WHERE 	user_nicename = %s;
							",
				$user_nicename
			)
		);
		return $user;
	}

	/**
	 * Split string regardless of ASCI, Unicode
	 *
	 * @since 1.0.0
	 *
	 * @param string $string string.
	 *
	 * @return string
	 */
	public static function str_split($string)
	{
		$strlen = mb_strlen($string);
		while ($strlen) {
			$array[] = mb_substr($string, 0, 1, 'UTF-8');
			$string  = mb_substr($string, 1, $strlen, 'UTF-8');
			$strlen  = mb_strlen($string);
		}
		return $array;
	}

	/**
	 * Get allowed tags for avatar, useful while using wp_kses
	 *
	 * @since 2.1.4
	 *
	 * @param array $tags additional tags.
	 *
	 * @return array allowed tags
	 */
	public static function allowed_avatar_tags(array $tags = array()): array
	{
		$defaults = array(
			'a'    => array(
				'href'   => true,
				'class'  => true,
				'id'     => true,
				'target' => true,
			),
			'img'  => array(
				'src'   => true,
				'class' => true,
				'id'    => true,
				'title' => true,
				'alt'   => true,
			),
			'div'  => array(
				'class' => true,
				'id'    => true,
			),
			'span' => array(
				'class' => true,
				'id'    => true,
			),
		);
		return wp_parse_args($tags, $defaults);
	}

	/**
	 * Generate avatar for user
	 *
	 * @since 1.0.0
	 * @since 2.1.7   changed param $user_id to $user for reduce query.
	 * @since 2.1.8   Get user data using get_userdata API
	 *
	 * @param integer|object $user user id or object.
	 * @param string         $size size of avatar like sm, md, lg.
	 * @param bool           $echo whether to echo or return.
	 *
	 * @return string
	 */
	public static function get_idonate_avatar($user = null, $size = '', $echo = false)
	{

		if (! $user) {
			return '';
		}

		if (! is_object($user)) {
			$user = get_userdata($user);
		}

		if (is_a($user, 'WP_User')) {
			// Get & set user profile photo.
			$profile_photo             = get_user_meta($user->ID, 'idonate_donor_profilepic', true);
			$user->idonate_profile_photo = isset($profile_photo->errors) ? '' : $profile_photo;
		}

		$name  = is_object($user) ? $user->display_name : '';
		$arr   = explode(' ', trim($name));
		$class = $size ? ' idonate-avatar-' . $size : '';
		$output  = '';

		if (is_object($user) && $user->idonate_profile_photo) {
			$output .= '<img src="' . wp_get_attachment_image_url($user->idonate_profile_photo, 'thumbnail') . '" alt="' . esc_attr($name) . '" /> ';
		} else {
			$first_char     = ! empty($arr[0]) ? self::str_split($arr[0])[0] : '';
			$second_char    = ! empty($arr[1]) ? self::str_split($arr[1])[0] : '';
			$initial_avatar = strtoupper($first_char . $second_char);
			$output        .= '<span class="idonate-avatar-text">' . $initial_avatar . '</span>';
		}

		if ($echo) {
			echo wp_kses($output, self::allowed_avatar_tags());
		} else {
			return apply_filters('idonate_text_avatar', $output);
		}
	}

	/**
	 * Idonate Dashboard Pages, supporting for the URL rewriting
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 */
	public static function idonate_dashboard_pages()
	{
		$nav_items = apply_filters('idonate_dashboard/nav_items', self::default_menus());

		$new_navs      = array(
			'separator-2' => array(
				'title' => '',
				'type'  => 'separator',
			),
			'settings'    => array(
				'title' => __('Settings', 'idonate'),
				'icon'  => 'icofont-gear',
			),
			'logout'      => array(
				'title' => __('Logout', 'idonate'),
				'icon'  => 'icofont-logout',
			),
		);
		$all_nav_items = array_merge($nav_items, $new_navs);
		return apply_filters('idonate_dashboard/nav_items_all', $all_nav_items);
	}

	/**
	 * Idonate Dashboard UI nav, only for using in the nav, it's handling user permission based
	 * Dashboard nav items
	 *
	 * @since 1.3.4
	 *
	 * @return mixed
	 */
	public static function idonate_dashboard_nav_ui_items()
	{
		$nav_items = self::idonate_dashboard_pages();
		foreach ($nav_items as $key => $nav_item) {
			if (is_array($nav_item)) {

				if (isset($nav_item['show_ui']) && ! self::array_get('show_ui', $nav_item)) {
					unset($nav_items[$key]);
				}
				if (isset($nav_item['auth_cap']) && ! current_user_can($nav_item['auth_cap'])) {
					unset($nav_items[$key]);
				}
			}
		}
		return apply_filters('idonate_dashboard/nav_ui_items', $nav_items);
	}

	/**
	 * Separation of all menu items for providing ease of usage
	 *
	 * @since 2.0.0
	 *
	 * @return array array of menu items.
	 */
	public static function default_menus(): array
	{
		return array(
			'index'            => array(
				'title' => __('Dashboard', 'idonate'),
				'icon'  => 'icofont-dashboard',
			),
			'my-profile'       => array(
				'title' => __('My Profile', 'idonate'),
				'icon'  => 'icofont-ui-user',
			),
		);
	}

	/**
	 * Get idonate pro dashboard page single URL
	 *
	 * @since 1.0.0
	 *
	 * @param string $page_key page key.
	 * @param int    $page_id page id.
	 *
	 * @return string
	 */
	public static function idonate_dashboard_page_permalink($page_key = '', $page_id = 0)
	{
		if ('index' === $page_key) {
			$page_key = '';
		}
		if (! $page_id) {
			$page_id = (int) self::get_option('idonate_dashboard_page_id');
		}
		return trailingslashit(get_permalink($page_id)) . $page_key;
	}

	/**
	 * Get allowed tags for avatar, useful while using wp_kses
	 *
	 * @since 2.1.4
	 *
	 * @param array $tags additional tags.
	 *
	 * @return array allowed tags
	 */
	public static function allowed_icon_tags(array $tags = array()): array
	{
		$defaults = array(
			'span' => array(
				'class' => true,
				'id'    => true,
			),
			'i'    => array(
				'class' => true,
				'id'    => true,
			),
		);
		return wp_parse_args($tags, $defaults);
	}

	/**
	 * Idonate custom header.
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public static function idonate_custom_header()
	{
		global $wp_version;
		if (version_compare($wp_version, '5.9', '>=') && function_exists('wp_is_block_theme') && wp_is_block_theme()) {
?>
			<!doctype html>
			<html <?php language_attributes(); ?>>

			<head>
				<meta charset="<?php bloginfo('charset'); ?>">
				<?php wp_head(); ?>
			</head>

			<body <?php body_class(); ?>>
				<?php wp_body_open(); ?>
				<div class="wp-site-blocks">
		<?php
			$theme      = wp_get_theme();
			$theme_slug = $theme->get('TextDomain');
			echo do_blocks('<!-- wp:template-part {"slug":"header","theme":"' . $theme_slug . '","tagName":"header","className":"site-header","layout":{"inherit":true}} /-->');
		} else {
			get_header();
		}
	}

	/**
	 * Idonate Custom Footer
	 *
	 * @since 2.0.0
	 */
	public static function idonate_custom_footer()
	{
		global $wp_version;
		if (version_compare($wp_version, '5.9', '>=') && function_exists('wp_is_block_theme') && true === wp_is_block_theme()) {
			$theme      = wp_get_theme();
			$theme_slug = $theme->get('TextDomain');
			echo do_blocks('<!-- wp:template-part {"slug":"footer","theme":"' . $theme_slug . '","tagName":"footer","className":"site-footer","layout":{"inherit":true}} /-->');
			echo '</div>';
			wp_footer();
			echo '</body>';
			echo '</html>';
		} else {
			get_footer();
		}
	}
	public static function reset_password($user, $new_pass)
	{
		ob_start();
		do_action('password_reset', $user, $new_pass);

		wp_set_password($new_pass, $user->ID);

		$rp_cookie = 'wp-resetpass-' . COOKIEHASH;
		$rp_path   = isset($_SERVER['REQUEST_URI']) ? current(explode('?', wp_unslash($_SERVER['REQUEST_URI']))) : '';

		setcookie($rp_cookie, ' ', idonate_time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true);
		wp_password_change_notification($user);

		ob_get_clean();
	}
}
