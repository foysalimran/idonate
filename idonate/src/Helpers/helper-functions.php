<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

use ThemeAtelier\Idonate\Helpers\Helpers;

// Idonate blood request single page table helper
function idonate_blood_request_table($class, $label, $val, $html = '')
{
	if (!empty($html)) {
		$val = wp_kses_post($val);
	} else {
		$val = esc_html($val);
	}

	$html = '';
	$html .= '<tr>';
	$html .= '<td class="tbllabel ' . esc_attr($class) . '">' . esc_html($label) . '</td>';
	$html .= '<td class="' . esc_attr($class) . '">' . esc_html($val) . '</td>';
	$html .= '</tr>';
	return $html;
}

// Single page template
add_filter('single_template', 'idonate_custom_post_type_single_template');
function idonate_custom_post_type_single_template($single_template)
{
	global $post;

	if ($post->post_type == 'blood_request') {
		$single_template = IDONATE_DIR_NAME . '/src/Frontend/Templates/single-blood_request.php';
	}
	return $single_template;
}

// Template Include
add_filter('template_include', 'idonate_custom_post_type_template');
function idonate_custom_post_type_template($template)
{
	global $post;
	$option = get_option('idonate_settings');
	$donor_register_page = isset($option['donor_register_page']) ? $option['donor_register_page'] : '';
	$donor_page = isset($option['donor_page']) ? $option['donor_page'] : 'donors';
	$donor_table_page = isset($option['donor_table_page']) ? $option['donor_table_page'] : 'donor-table';
	$dashboard_page = isset($option['dashboard_page']) ? $option['dashboard_page'] : '';

	// Request page
	if ($option['rp_request_page']) {
		$requestPage = $option['rp_request_page'];
	} else {
		$requestPage = 'request';
	}

	// Request post form page
	if ($option['rf_form_page']) {
		$requestPostPage = $option['rf_form_page'];
	} else {
		$requestPostPage = 'post-request';
	}

	// Blood Request

	if (is_page($requestPage)) {
		$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/blood-request.php';
	}
	// Post blood request
	if (is_page($requestPostPage)) {

		$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/post-blood-request.php';
	}


	/*************
			Donor 
	 **************/
	// Register Donor
	$registerDonor = 'donor-register';
	if (!empty($donor_register_page)) {
		$page = $donor_register_page;
		$registerDonor = $page;
	}

	if (is_page($registerDonor)) {
		$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/register-donor.php';
	}

	// Donor Table Page
	$donorTable = 'donor-table';
	if (!empty($donor_table_page)) {
		$page = $donor_table_page;
		$donorTable = $page;
	}

	if (is_page($donorTable)) {
		$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/donor-table.php';
	}

	// Show Donor
	$donor = 'donors';
	if (!empty($donor_page)) {
		$page = $donor_page;
		$donor = $page;
	}

	if (is_page($donor)) {

		$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/donors.php';
	}

	// Dashboard
	$dashboard = 'dashboard';
	if (!empty($dashboard_page)) {
		$page = $dashboard_page;
		$dashboard = $page;
	}

	if (is_page($dashboard)) {
		if (is_user_logged_in()) {
			$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/dashboard.php';
		} else {
			$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/donor-login.php';
		}
	}

	return $template;
}


// Create page when plugin activated
function idonate_create_page_plugin_activated()
{
	// Default Pages to Create
	$pages = array(
		'Post Request',
		'Donor Table',
		'Request',
		'Donors',
		'Donor Register',
		'Dashboard',
	);

	foreach ($pages as $page) {
		// Check if the page already exists by title using WP_Query
		$args = array(
			'post_type'   => 'page',
			'title'       => $page,
			'post_status' => 'any',
			'numberposts' => 1,
		);

		$existing_page = get_posts($args);

		// If the page doesn't exist, create it
		if (empty($existing_page)) {
			$Requestargs = array(
				'post_type'   => 'page',
				'post_title'  => wp_strip_all_tags($page),
				'post_status' => 'publish',
			);
			wp_insert_post($Requestargs);
		}
	}
}
// Delete page when plugin deactivated
function idonate_delete_page_plugin_deactivated()
{

	// Pages to Delete
	$pages = array(
		'Post Request',
		'Donor Table',
		'Request',
		'Donors',
		'Donor Register',
		'Dashboard',
	);

	foreach ($pages as $page) {
		// Check if the page exists by title using WP_Query
		$args = array(
			'post_type'   => 'page',
			'title'       => $page,
			'post_status' => 'any',
			'numberposts' => 1,
		);

		$existing_page = get_posts($args);

		// If the page exists, delete it permanently
		if (!empty($existing_page)) {
			wp_delete_post($existing_page[0]->ID, true);
		}
	}
}

/**
 * Embed JS Template With ID
 *
 *
 */
function idonate_get_js_template($file_path, $id)
{
	if (file_exists($file_path)) {
		echo '<script type="text/html" id="tmpl-' . esc_attr($id) . '">' . "\n";
		include_once($file_path);
		echo '</script>' . "\n";
	}
}

/**
 * Blood Group
 *
 */
function idonate_blood_group()
{
	$blood_group = array(
		'A+',
		'A-',
		'B+',
		'B-',
		'O+',
		'O-',
		'AB+',
		'AB-',
		'A1+',
		'A1-',
		'A1B+',
		'A1B-',
		'A2+',
		'A2-',
		'A2B+',
		'A2B-'
	);

	return $blood_group;
}

// blood group as assosiative
function idonate_blood_group_assosiative()
{

	$blood_group = idonate_blood_group();
	$assoc_blood_group = array();
	foreach ($blood_group as $group) {
		$assoc_blood_group[$group] = $group;
	}

	return $assoc_blood_group;
}

/**
 * Media Uploader
 *
 */
function idonate_media_upload($user_id)
{
	$attachment_id = media_handle_upload('profileimg', $user_id);
	//media upload
	update_user_meta($user_id, 'idonate_donor_profilepic', $attachment_id);
}

/**
 * Donor Profile Image
 *
 */
function idonate_profile_img($id = '')
{
	$attachmentID =  get_user_meta($id, 'idonate_donor_profilepic', true);
	$img = '';
	if (!is_wp_error($attachmentID)) {
		$img = wp_get_attachment_image_url($attachmentID, 'donor-img');
		$img = !empty($img) ? $img : IDONATE_DIR_URL . 'src/assets/images/idonate-preview-image.jpg';
		$img = '<img class="upload-preview" src="' . esc_url($img) . '" />';
	}
	return $img;
}

/**
 * Donor login redirect
 **/
function idonate_redirect_login_page($redirect_to, $request, $user)
{

	$option = get_option('idonate_settings');
	$page = $option['login_redirect'];
	$login_page  = '/';

	if (!empty($page)) {
		$login_page  = $page;
	}

	//is there a user to check?
	if (isset($user->roles) && is_array($user->roles)) {
		if (in_array('donor', $user->roles)) {
			if (!empty($page)) {
				return get_permalink($login_page);
			} else {
				return home_url($login_page);
			}
		} else {
			return $redirect_to;
		}
	} else {
		return $redirect_to;
	}
}
add_action('login_redirect', 'idonate_redirect_login_page', 10, 3);

/**
 * Donor login failed redirect
 *
 */
function idonate_login_failed()
{
	$options = get_option('idonate_settings');
	$login_page = $options['login_page'];
	$login_page_url  = home_url('/');

	if ($login_page) {
		$login_page_url  = get_permalink($options);
	}

	wp_redirect($login_page_url . '?login=failed');
	exit;
}
add_action('wp_login_failed', 'idonate_login_failed');

/**
 * Donor logout redirect
 **/
function idonate_logout_page()
{

	$options = get_option('idonate_settings');
	$logout_redirectpage = $options['logout_redirectpage'];

	$login_page  = home_url('/');

	if (!empty($logout_redirectpage)) {
		$login_page  = get_permalink($logout_redirectpage);
	}

	wp_redirect($login_page . "?loggedout=true");
	exit();
}
add_action('wp_logout', 'idonate_logout_page');

/**
 * Profile edit permalink
 **/
function idonate_profile_edit_permalink()
{
	$options = get_option('idonate_settings');
	$donor_edit_page = $options['donor_edit_page'];
	$getpage = 'donor-edit';

	if ($donor_edit_page) {
		$getpage = get_permalink($options['donor_edit_page']);
	}
	return $getpage;
}
/**
 * profile permalink
 **/
function idonate_profile_permalink()
{
	$options = get_option('idonate_settings');
	$donor_profile_page = $options['donor_profile_page'];
	$getpage = 'donor-profile';

	if ($donor_profile_page) {
		$getpage = get_permalink($options['donor_profile_page']);
	}
	return $getpage;
}

/**
 * Donor logged in 
 **/
function idonate_is_user_logged_in()
{
	if (is_user_logged_in()) {
		$options = get_option('idonate_settings');
		$donor_profile_page = $options['donor_profile_page'];
		$getpage = 'donor-profile';

		if ($donor_profile_page) {
			$getpage = $options['donor_profile_page'];
		}

		wp_redirect($getpage);
	}
}

/**
 * Auto request Delete after pass data
 *
 */
function idonate_auto_request_delete()
{
	$options = get_option('idonate_settings');
	$auto_delete_expired_requests = isset($options['auto_delete_expired_requests']) ? $options['auto_delete_expired_requests'] : '';
	if ($auto_delete_expired_requests !== 'never_delete') {
		$args = array(
			'post_type' => 'blood_request',
			'posts_per_page' => '-1'
		);
		$requests = get_posts($args);
		$currentDate =  strtotime(gmdate(get_option('date_format'), current_time('timestamp', 1)));
		$oneWeekAgo = strtotime('-1 week', $currentDate);


		foreach ($requests as $request) {

			$neededdate = get_post_meta($request->ID, 'idonatepatient_bloodneed', true);
			if ($auto_delete_expired_requests == 'current_date') {
				if ($currentDate > strtotime($neededdate)) {
					wp_delete_post($request->ID);
				}
			} else if ($auto_delete_expired_requests == 'one_week') {
				if ($oneWeekAgo > strtotime($neededdate)) {
					wp_delete_post($request->ID);
				}
			}
		}
	}
}
add_action('init', 'idonate_auto_request_delete');

/**
 * Custom Post pagination
 *
 */
function idonate_pagination($custom_query, $pagenum_link)
{
	if (is_front_page()) {
		$paged = 'page';
	} else {
		$paged = 'paged';
	}

	$total_pages = $custom_query->max_num_pages;
	$big = 999999999; // need an unlikely integer

	if ($total_pages > 1) {
		$current_page = max(1, get_query_var($paged));

		echo '<div class="row"><div class="col-sm-12"><div class="idonate-pagination">';
		echo wp_kses_post(paginate_links(array(
			'base' => $pagenum_link,
			'format' => '?' . $paged . '=%#%',
			'current' => $current_page,
			'total' => $total_pages,
			'prev_text'	=> '«',
			'next_text'	=> '»',
			'mid_size'           => 2,
		)));
		echo '</div></div></div>';
	}
}
/**
 * Donor pagination
 *
 */
function idonate_donor_pagination($total_users, $number, $paged, $pagenum_link)
{
	if ($total_users > $number) :

		$pl_args = array(
			'base'     => add_query_arg('paged', '%#%'),
			'format'   => '',
			'total'    => ceil($total_users / $number),
			'current'  => max(1, $paged),
			'prev_text'	=> '«',
			'next_text'	=> '»',
			'mid_size'           => 1,
			'end_size'           => 1,
		);

		// for ".../page/n"
		if ($GLOBALS['wp_rewrite']->using_permalinks())
			$pl_args['base'] = $pagenum_link;

		echo '<div class="ta-row"><div class="ta-col-xs-1"><div class="idonate-pagination">';
		echo wp_kses_post(paginate_links($pl_args));
		echo '</div></div></div>';
	endif;
}

// Add image size
add_action('after_setup_theme', 'idonate_add_image_size');
function idonate_add_image_size()
{
	add_image_size('donor-img', 360, 240, true);
	add_image_size('request--img', 300, 210, true);
}


function idonate_get_total_donor()
{
	$args = array(
		'role'    => 'donor',
		'meta_query' => array(
			array(
				'key'     => 'idonate_donor_status',
				'value'   => '1',
				'compare' => '='
			),
		),
		'fields'  => 'ID', // Only retrieve IDs to save memory
	);

	$users_query = new \WP_User_Query($args);
	$total_donor = $users_query->get_total();
	return $total_donor;
}

function idonate_get_available_donor()
{
	$args = array(
		'role' => 'donor',
		'meta_query' => array(
			array(
				'key' => 'idonate_donor_status',
				'value' => '1',
				'compare' => '='
			),
			array(
				'key' => 'idonate_donor_availability',
				'value' => 'available',
				'compare' => '='
			)
		),
		'count_total' => true,
		'fields' => 'ID', // Only retrieve IDs to save memory
	);

	$users_query = new \WP_User_Query($args);
	$available_donor = $users_query->get_total();

	return $available_donor;
}

function idonate_get_current_request()
{
	// Assuming current requests are stored in a custom post type called 'blood_request'
	$args = array(
		'post_type'      => 'blood_request',
		'posts_per_page' => -1, // Retrieve all requests
		'meta_query'     => array(
			array(
				'key'     => 'idonate_status',
				'value'   => '1',
				'compare' => '='
			),
		),
	);

	$query = new \WP_Query($args);
	$current_request = $query->found_posts;

	return $current_request;
}

/**
 * @param null $key
 * @param bool $default
 *
 * @return array|bool|mixed
 *
 * Get idonate pro option by this helper function
 *
 * @since v.1.3.6
 */
if (! function_exists('get_idonate_option')) {
	function get_idonate_option($key = null, $default = false)
	{
		return Helpers::get_option($key, $default);
	}
}

if (! function_exists('idonate_get_template')) {
	/**
	 * Load template with override file system
	 *
	 * @since 1.0.0
	 *
	 * @param null $template template.
	 *
	 * @return bool|string
	 */
	function idonate_get_template($template = null)
	{
		if (! $template) {
			return false;
		}
		$template = str_replace('.', DIRECTORY_SEPARATOR, $template);

		/**
		 * Get template first from child-theme if exists
		 * If child theme not exists, then get template from parent theme
		 */
		$template_location = trailingslashit(idonate_function()->path) . "src/Frontend/Templates/{$template}.php";

		return apply_filters('idonate_get_template_path', $template_location, $template);
	}
}

if (! function_exists('idonate_load_template')) {
	/**
	 * Load template for TUTOR
	 *
	 * @since 1.0.0
	 * @since 1.1.2 updated
	 *
	 * @param null  $template template.
	 * @param array $variables variables.
	 *
	 * @return void
	 */
	function idonate_load_template($template = null, $variables = array())
	{
		$variables = (array) $variables;
		$variables = apply_filters('get_idonate_load_template_variables', $variables);
		extract($variables);
		$isLoad = apply_filters('should_idonate_load_template', true, $template, $variables);
		if (! $isLoad) {
			return;
		}

		do_action('idonate_load_template_before', $template, $variables);
		$template_file = idonate_get_template($template);

		if (file_exists($template_file)) {
			include idonate_get_template($template);
		} else {
			do_action('idonate_after_template_not_found', $template);
		}
		do_action('idonate_load_template_after', $template, $variables);
	}
}

if (! function_exists('idonate_function')) {
	/**
	 * Idonate helper function.
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	function idonate_function()

	{
		if (isset($GLOBALS['idonate_plugin_info'])) {
			return $GLOBALS['idonate_plugin_info'];
		}
		$path    = plugin_dir_path(IDONATE_FILE);

		// Prepare the basepath.
		$home_url  = get_home_url();
		$parsed    = parse_url($home_url);
		$base_path = (is_array($parsed) && isset($parsed['path'])) ? $parsed['path'] : '/';
		$base_path = rtrim($base_path, '/') . '/';
		// Get current URL.
		$current_url = trailingslashit($home_url) . substr($_SERVER['REQUEST_URI'], strlen($base_path)); //phpcs:ignore

		$info = array(
			'path'                   => $path,
			'url'                    => plugin_dir_url(IDONATE_FILE),
			'icon_dir'               => plugin_dir_url(IDONATE_FILE) . 'assets/images/images-v2/icons/',
			'v2_img_dir'             => plugin_dir_url(IDONATE_FILE) . 'assets/images/images-v2/',
			'current_url'            => $current_url,
			'basename'               => plugin_basename(IDONATE_FILE),
			'basepath'               => $base_path,
			'version'                => IDONATE_VERSION,
			'nonce_action'           => 'idonate_nonce_action',
			'nonce'                  => '_idonate_nonce',
		);

		$GLOBALS['idonate_plugin_info'] = (object) $info;
		return $GLOBALS['idonate_plugin_info'];
	}
}

if (! function_exists('idonate_time')) {
	/**
	 * Return current Time from WordPress time
	 *
	 * @return int|string
	 * @since v.1.4.3
	 */
	function idonate_time()
	{
		$gmt_offset = get_option('gmt_offset');
		return time() + ($gmt_offset * HOUR_IN_SECONDS);
	}
}
