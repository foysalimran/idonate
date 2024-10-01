<?php

/**
 * The admin-facing functionality of the plugin.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package idonate
 * @subpackage idonate/Admin/Views
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\Idonate\Admin;

use ThemeAtelier\Idonate\Admin\DBUpdates;
use ThemeAtelier\Idonate\Admin\Views\Views;
use ThemeAtelier\Idonate\Admin\Settings\Settings;
use ThemeAtelier\Idonate\Helpers\DonorFunctions;
use ThemeAtelier\Idonate\Helpers\IDonateAjaxHandler;
use ThemeAtelier\Idonate\Admin\Views\IdonateDashboardwidgets;

/**
 * The admin class
 */
class Admin
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
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The class constructor.
     *
     * @param string $plugin_slug The slug of the plugin.
     * @param string $version Current version of the plugin.
     */
    function __construct($plugin_slug, $version)
    {
        $this->plugin_slug = $plugin_slug;
        $this->version     = $version;
        $this->min         = defined('WP_DEBUG') && WP_DEBUG ? '' : '.min';
        $donorFunctions    = new DonorFunctions();
        $IDonateAjaxHandler    = new IDonateAjaxHandler();
        new DBUpdates();
        Views::metaboxes('idonate_metaboxes'); // Generator metaboxes.
        add_action('admin_menu', array($this, 'add_plugin_page'));
        Settings::options('idonate_settings'); // Setting options.
        add_action('admin_post_donor_delete', array($donorFunctions, 'idonate_donor_delete'));

        add_action('wp_ajax_admin_donor_profile_view', array($IDonateAjaxHandler, 'admin_donor_profile_view'));
        add_action('wp_ajax_country_to_states_ajax', array($IDonateAjaxHandler, 'idonate_country_to_states_ajax'));
        add_action('wp_ajax_nopriv_country_to_states_ajax', array($IDonateAjaxHandler, 'idonate_country_to_states_ajax'));
        add_action('wp_ajax_idonate_country_to_states_ajax', array($IDonateAjaxHandler, 'idonate_country_to_states_ajax'));
        add_action('wp_ajax_nopriv_idonate_country_to_states_ajax', array($IDonateAjaxHandler, 'idonate_country_to_states_ajax'));

        add_filter('manage_blood_request_posts_columns', array($this, 'add_custom_columns_blood_request'));
        add_action('manage_blood_request_posts_custom_column', array($this, 'custom_column_content_blood_request'), 10, 2);

        add_filter('manage_edit-blood_request_sortable_columns', array($this, 'custom_columns_sortable_blood_request'));
    }

    /**
     * Donor Admin Page Callback
     */

    public function idonate_donor_settings_page()
    {
        //Load donor panel template
        load_template(IDONATE_DIR_PATH . 'src/Admin/Helpers/donor-panel.php');
    }

    /**
     * Options page callback
     */
    public function idonate_settings()
    {
    }
    /**
     * Options page callback
     */
    public function dashboard_page()
    {
        $current_user = wp_get_current_user();
        $current_user_display_name = $current_user->display_name;
        echo '<div class="idonate_page_content">';
        echo '<div class="idonate-user-heading-bar">';
        echo '<div class="idoante-user-heading-bar-left">';
        echo '<h1>' . esc_html('Welcome', 'idonate') . ' ' . esc_html($current_user_display_name) . '</h1>';
        echo '<p>Thank you for using IDonatePro - Blood Donation, Request And Donor Management System.</p>';
        echo ' </div>';
        echo '<div class="idoante-user-heading-bar-right">';
        echo '<a target="_blank" class="idonate-btn-primary" href="https://themeatelier.net/contact">' . esc_html('Support', 'idonat-pro') . '</a>';
        echo '<a target="_blank" class="idonate-btn-secondary" href="https://docs.themeatelier.net/docs/idonate/overview/">' . esc_html('Docs', 'idonat-pro') . '</a>';
        echo '<a target="_blank" class="idonate-btn-primary idonate-btn-pro" href="https://1.envato.market/idonate">' . esc_html('Get Pro', 'idonat-pro') . '</a>';
        echo ' </div>';
        echo '</div>';
        IdonateDashboardwidgets::dashboard_widget_function();
        echo '<div class="idonate_pending_list_wrapper">';
        IdonateDashboardwidgets::panding_donor_callback();
        IdonateDashboardwidgets::blood_request_panding_callback();
?>
        </div>
        <div class="idonate_shortcodes_wrapper">
            <div class="idonate_shortcodes">
                <h2 class="idonate_shortcodes_heading"><?php esc_html_e('Shortcodes', 'idonate'); ?></h2>
                <p class="mb-20">
                    <?php esc_html_e('Use following shortcodes on anywhere your site to get your desire output', 'idonate'); ?>
                </p>
                <ul>
                    <li class="idonate_shortcodes_list">
                        <span><?php esc_html_e('Donor Table', 'idonate'); ?></span>
                        <span class="idonate_shortcode"><i class="icofont-ui-copy"></i>[donortable]</span>
                    </li>
                    <li class="idonate_shortcodes_list">

                        <span><?php esc_html_e('Blood Requests', 'idonate'); ?></span>
                        <span class="idonate_shortcode"><i class="icofont-ui-copy"></i>[blood-request]</span>
                    </li>
                    <li class="idonate_shortcodes_list">
                        <span><?php esc_html_e('Donors', 'idonate'); ?></span>
                        <span class="idonate_shortcode"><i class="icofont-ui-copy"></i>[donors]</span>
                    </li>
                    <li class="idonate_shortcodes_list">
                        <span><?php esc_html_e('Blood request form', 'idonate'); ?></span>
                        <span class="idonate_shortcode"><i class="icofont-ui-copy"></i>[post-blood-request]</span>
                    </li>
                    <li class="idonate_shortcodes_list">
                        <span><?php esc_html_e('Donor registration form', 'idonate'); ?></span>
                        <span class="idonate_shortcode"><i class="icofont-ui-copy"></i>[register-donor]</span>
                    </li>
                    <li class="idonate_shortcodes_list">
                        <span><?php esc_html_e('Idoante statistics', 'idonate'); ?></span>
                        <span class="idonate_shortcode"><i class="icofont-ui-copy"></i>[idonate-statistics]</span>
                    </li>
                </ul>
                <div class="idonate-after-copy-shortcode"><i class="icofont-check-circled"></i><?php esc_html_e('Shortcode Copied to Clipboard!', 'idonate'); ?></div>
            </div>
            <div class="idonate_shortcodes" style="padding:0px">
                <iframe width="100%" height="315" style="border-radius: 6px" src="https://www.youtube.com/embed/S7s7MBen6-E" title="<?php echo esc_attr('YouTube video player', 'idoante-pro'); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
<?php
        echo '</div>';
    }

    /**
     * Register idonate custom post type
     *
     * @since    1.0.0
     */
    public function blood_request_post_type()
    {
        $labels     = array(
            'name'               => esc_html__('Blood Requests', 'idonate'),
            'singular_name'      => esc_html__('Blood Request', 'idonate'),
            'add_new'            => esc_html__('Add New Request', 'idonate'),
            'add_new_item'       => esc_html__('Add New Blood Request', 'idonate'),
            'edit_item'          => esc_html__('Edit Request', 'idonate'),
            'new_item'           => esc_html__('New Request', 'idonate'),
            'all_items'          => esc_html__('Blood Request', 'idonate'),
            'view_item'          => esc_html__('View Blood Request', 'idonate'),
            'search_items'       => esc_html__('Search Blood Request', 'idonate'),
            'not_found'          => esc_html__('No Blood Request Found', 'idonate'),
            'not_found_in_trash' => esc_html__('No Blood Request Found in Trash', 'idonate'),
            'parent_item_colon'  => null,
            'menu_name'          => esc_html__('Blood Request', 'idonate'),
        );
        $menu_icon  = 'dashicons-universal-access';
        $capability = apply_filters('idonate_ui_permission', 'manage_options');
        $show_ui    = current_user_can($capability) ? true : false;
        register_post_type(
            'blood_request',
            array(
                'hierarchical'      => true,
                'labels'              => $labels,
                'capability_type'     => 'post',
                'supports'            => array('title', 'thumbnail'),
                'show_in_menu'        => false,
                'menu_position'       => 56,
                'menu_icon'           => $menu_icon,
                'public'              => true,
                'publicly_queryable'  => true,
                'show_ui'             => $show_ui,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'has_archive'         => false,
                'rewrite'             => array('slug' =>  'blood-request'),
                'show_in_rest'        => true,
            )
        );
    }

    // Add custom column to blood_request post type
    public function add_custom_columns_blood_request($columns)
    {
        $columns['blood_group'] = esc_html__('Blood Group', 'idonate');
        $columns['blood_purpose'] = esc_html__('Purpose', 'idonate');
        $columns['blood_needed_date'] = esc_html__('When Need Blood?', 'idonate');
        $columns['hospital_name'] = esc_html__('Hospital name', 'idonate');
        return $columns;
    }

    // Populate custom column in blood_request post type
    public function custom_column_content_blood_request($column, $post_id)
    {
        switch ($column) {
            case 'blood_group':
                $blood_group = get_post_meta($post_id, 'idonatepatient_bloodgroup', true);
                echo $blood_group ? esc_html($blood_group) : esc_html__('Unknown', 'idonate');
                break;
            case 'blood_purpose':
                $blood_purpose = get_post_meta($post_id, 'idonatepurpose', true);
                echo $blood_purpose ? esc_html($blood_purpose) : esc_html__('Not set', 'idonate');
                break;
            case 'blood_needed_date':
                $blood_needed = get_post_meta($post_id, 'idonatepatient_bloodneed', true);
                echo $blood_needed ? esc_html($blood_needed) : esc_html__('Not set', 'idonate');
                break;
            case 'hospital_name':
                $blood_needed = get_post_meta($post_id, 'idonatehospital_name', true);
                echo $blood_needed ? esc_html($blood_needed) : esc_html__('Not set', 'idonate');
                break;
        }
    }

    // Make custom columns sortable
    public function custom_columns_sortable_blood_request($columns)
    {
        $columns['blood_group'] = 'blood_group';
        $columns['blood_purpose'] = 'blood_purpose';
        $columns['blood_needed_date'] = 'blood_needed_date';
        $columns['hospital_name'] = 'hospital_name';
        return $columns;
    }


    /**
     * Customize idonate taxonomies update messages.
     *
     * @param array $messages The idonate taxonomy message.
     * @since 1.0.0
     * @return bool
     */
    public static function update_idonate_term_messages($messages)
    {
        $messages['idonate'] = array(
            0 => '',
            1 => esc_html__('Blood Request added.', 'idonate'),
            2 => esc_html__('Blood Request deleted.', 'idonate'),
            3 => esc_html__('Blood Request updated.', 'idonate'),
        );

        return $messages;
    }


    /**
     * Post update messages for ShortCode Generator.
     *
     * @param string $message The post update message for the post type idonate.
     * @return statement
     */
    public function post_update_message($message)
    {
        $screen = get_current_screen();
        if ('idonate' === $screen->post_type) {
            $message['post'][1] = esc_html__('View updated.', 'idonate');
            $message['post'][6] = esc_html__('View published.', 'idonate');
        }

        return $message;
    }

    /**
     * Register the styles for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook)
    {
        if ($hook === 'toplevel_page_dashboard') {
            wp_enqueue_style('magnific-popup');
        }
        if ($hook === 'toplevel_page_dashboard' || 'widgets.php') {
            wp_enqueue_style('icofont');
        }
        if ($hook === 'idonate_page_idonate-donor') {
            wp_enqueue_style('datatables');
        }


        if ('idonate_page_idonate-settings' == $hook) {
            wp_enqueue_style('idonate-settings-admin');
        }

        wp_enqueue_style('idonate-admin');
    }
    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook)
    {
        if ($hook === 'toplevel_page_dashboard') {
            wp_enqueue_script('magnific-popup');
        }
        if ($hook === 'idonate_page_idonate-donor') {
            wp_enqueue_script('validate');
            wp_enqueue_script('datatables');
        }

        wp_enqueue_script('wp-util');

        wp_enqueue_script('idonate-admin');

        // Scripts
        $data = array(
            'statesurl' => admin_url('admin-ajax.php')
        );
        wp_localize_script(
            'idonate-admin',
            'localData',
            $data
        );
    }

    function parent_menu_callback_func()
    {
        echo 'parent_menu_callback_func';
    }

    function sub_menu2_callback_func()
    {
        echo 'sub_menu2_callback_func';
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_menu_page(
            esc_html__('IDonate', 'idonate'),
            esc_html__('IDonate', 'idonate'),
            'manage_options',
            'dashboard',
            array($this, 'dashboard_page'),
            'dashicons-universal-access',
            6
        );
        // dashboard page.
        add_submenu_page(
            'dashboard',
            esc_html__('Dashboard', 'idonate'),
            esc_html__('Dashboard', 'idonate'),
            'manage_options',
            'dashboard',
            array($this, 'dashboard_page'),
        );
        // Add blood request post type into the sub menu of Idonate Settings menu.
        add_submenu_page(
            'dashboard',
            esc_html__('Blood Request', 'idonate'),
            esc_html__('Blood Request', 'idonate'),
            'manage_options',
            'edit.php?post_type=blood_request',
            NULL
        );
        // Blood Donor Page.
        add_submenu_page(
            'dashboard',
            esc_html__('Blood Donor', 'idonate'),
            esc_html__('Blood Donor', 'idonate'),
            'manage_options',
            'idonate-donor',
            array($this, 'idonate_donor_settings_page')
        );
        // Idonate Settings Page.
        add_submenu_page(
            'dashboard',
            esc_html__('Settings', 'idonate'),
            esc_html__('Settings', 'idonate'),
            'manage_options',
            'idonate-settings',
            array($this, 'idonate_settings')
        );
        add_submenu_page('dashboard', __('👑 Upgrade to Pro!', 'idonate'), sprintf('<span class="idonate-get-pro-text">%s</span>', __('👑 Upgrade to Pro!', 'idonate')), 'manage_options', 'https://1.envato.market/idonate');
    }
}
