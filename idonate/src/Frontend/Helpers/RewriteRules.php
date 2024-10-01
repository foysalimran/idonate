<?php

/**
 * Manage rewrite rules for Idonate
 *
 * @package Idonate\RewriteRules
 * @author ThemeAtelier <themeatelierbd@gmail.com>
 * @link https://themeatelier.net
 * @since 4.0.0
 */

namespace ThemeAtelier\Idonate\Frontend\Helpers;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Generate and manage rewrite rules 
 *
 * @since 2.0.0
 */
class RewriteRules
{
    public function __construct()
    {
        add_filter('query_vars', array($this, 'idonate_register_query_vars'));

        add_action('generate_rewrite_rules', [$this, 'add_rewrite_rules']);
    }


    /**
     * Prepare query vars
     *
     * @since 1.0.0
     *
     * @param sting $vars url structure.
     *
     * @return array
     */
    public function idonate_register_query_vars($vars)
    {
        $vars[] = 'idonate_dashboard_page';
        $vars[] = 'idonate_dashboard_sub_page';

        $vars[] = 'idonate_profile_username';
        return $vars;
    }

    function add_rewrite_rules(\WP_Rewrite $wp_rewrite)
    {

        $options = get_option('idonate_settings');
		$donor_view_slug = isset($options['donor_view_slug']) ? $options['donor_view_slug'] : 'donor';
        $dashboard_page = isset($options['dashboard_page']) ? $options['dashboard_page'] : '';
                
        if(!empty($dashboard_page)) {
            $dashboard_page_slug = get_post_field('post_name', $dashboard_page);
        } else {
            $dashboard_page_slug = 'dashboard';
        }

        $new_rules = array(
            $donor_view_slug .'/(.+?)/?$'   => 'index.php?idonate_profile_username=' . $wp_rewrite->preg_index(1),
            "({$dashboard_page_slug})/(.+?)/?$" => 'index.php?pagename=' . $wp_rewrite->preg_index(1) . '&idonate_dashboard_page&idonate_dashboard_sub_page=' . $wp_rewrite->preg_index(2),
        );


        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    }
}
