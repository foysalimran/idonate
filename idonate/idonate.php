<?php
/*
Plugin Name:  IDonate - Blood Donation Management System
Plugin URI:   https://bloodwp.com/
Description:  Idonate is a complete solution for creating a Blood Request & Blood Donor Management System in WordPress way. The plugin is highly customizable and developer-friendly with top-notch support.
Version:      2.0.0
Author:       ThemeAtelier
Author URI:   https://themeatelier.net/
License:      GPL-2.0+
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  idonate
Domain Path:  /languages
*/

if (!defined('ABSPATH')) {
    exit;
}
require_once __DIR__ . '/vendor/autoload.php';

use ThemeAtelier\Idonate\Idonate;

define('IDONATE_VERSION', '2.0.0');
define('IDONATE_FILE', __FILE__);
define('IDONATE_DIR_URL', plugin_dir_url(__FILE__));
define('IDONATE_DIR_URL_ADMIN', IDONATE_DIR_URL . 'src/Admin/');
define('IDONATE_PATH', dirname(IDONATE_FILE));
define('IDONATE_DIR_PATH', plugin_dir_path(__FILE__));
define('IDONATE_ALERT_MSG', esc_html__('You should not access this file directly.!', 'idonate'));
define('IDONATE_BASENAME', plugin_basename(__FILE__));
define('IDONATE_DIR_NAME', dirname(__FILE__));
define('IDONATE_COUNTRIES', IDONATE_DIR_PATH . 'src/Helpers/Countries/');

function idonate()
{
    // Launch the plugin.
    $idonate = new Idonate();
    $idonate->run();
}

// kick-off the plugin
idonate();


// Create page after plugin activate
function idonate_plugin_activate()
{
    update_option('idonate_version', IDONATE_VERSION);
    update_option('idonate_activation_date', current_time('timestamp'));
    // Create page when plugin activated
    idonate_create_page_plugin_activated();
    // User Role
    add_role('donor', 'Donor', array('read' => true, 'level_0' => true));
}
register_activation_hook(__FILE__, 'idonate_plugin_activate');


// Delete page after plugin deactivate
function idonate_deactivation_activate()
{
    $options = get_option('idonate_settings');
    $idoante_pro_delte_page = isset($options['idonate_data_remove']) ? $options['idonate_data_remove'] : false;
    if ($idoante_pro_delte_page) {
        // Delete page when plugin deactivated
        idonate_delete_page_plugin_deactivated();
    }
}
register_deactivation_hook(__FILE__, 'idonate_deactivation_activate');


// Appsero init

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function idonate_appsero_init()
{

	if (!class_exists('IdonateAppSero\Insights')) {
		require_once IDONATE_DIR_PATH . 'src/Admin/appsero/Client.php';
	}

	$client = new IdonateAppSero\Client('23ff0b7b-9dde-4bcd-91c7-ab398aaa6ed6', 'iDonate', __FILE__);
	// Active insights
	$client->insights()->init();
}

idonate_appsero_init();