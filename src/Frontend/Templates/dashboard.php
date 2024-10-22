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

Helpers::idonate_custom_header();

global $wp_query;
$user_id                   = get_current_user_id();
$user                      = get_user_by('ID', $user_id);

$dashboard_page_slug = '';
$dashboard_page_name = '';
if (isset($wp_query->query_vars['idonate_dashboard_page']) && $wp_query->query_vars['idonate_dashboard_page']) {
    $dashboard_page_slug = $wp_query->query_vars['idonate_dashboard_page'];

    $dashboard_page_name = $wp_query->query_vars['idonate_dashboard_page'];
}


/**
 * Getting dashboard sub pages
 */
if (isset($wp_query->query_vars['idonate_dashboard_sub_page']) && $wp_query->query_vars['idonate_dashboard_sub_page']) {
    $dashboard_page_name = $wp_query->query_vars['idonate_dashboard_sub_page'];
    if ($dashboard_page_slug) {
        $dashboard_page_name = $dashboard_page_slug . '/' . $dashboard_page_name;
    }
}
$dashboard_page_name = apply_filters('idonate_dashboard_sub_page_template', $dashboard_page_name);


?>
<div class="idonate dashboard section-padding">
    <div class="ta-container">
        <div class="ta-row justify-between align-items-center px-2">
            <div class="dashboard__header_left">
                <div class="dashboard__header_left__logo">
                    <?php
                    echo Helpers::get_idonate_avatar($user, 'xl')
                    ?>
                </div>
                <div class="dashboard__header_left__info">
                    <?php
                    $current_user = wp_get_current_user();
                    $user_roles = $current_user->roles;

                    $bloodgroup = get_user_meta($user->ID, 'idonate_donor_bloodgroup', true);
                    if (in_array('administrator', $user_roles) || in_array('donor', $user_roles)) {
                    ?>
                        <div class="dashboard__header_left__info__name">
                            <?php echo esc_html($user->display_name); ?>
                        </div>
                        <?php if ($bloodgroup) { ?>
                            <div class="dashboard__header_left__info__content">
                                <?php echo  esc_html('Blood Group: ', 'idonate')  . esc_html($bloodgroup); ?>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="idonate-dashboard-header-display-name idonate-color-black">
                            <div class="idonate-fs-5 idonate-dashboard-header-greetings">
                                <?php esc_html_e('Hello', 'idonate'); ?>,
                            </div>
                            <div class="idonate-fs-4 idonate-fw-medium idonate-dashboard-header-username">
                                <?php echo esc_html($user->display_name); ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="dashboard_left_menu">
                <div class="icon"><i class="icofont-navigation-menu dashboard-navigation"></i></div>
            </div>
        </div>
        <div class="ta-row dashboard_menu">
            <div class="ta-col-xs-1 ta-col-sm-1 ta-col-md-1 ta-col-lg-3 ta-col-xl-3">
                <ul class="dashboard__menu">
                    <?php
                    $dashboard_pages = Helpers::idonate_dashboard_nav_ui_items();
                    // get reviews settings value.
                    $disable = ! get_idonate_option('enable_course_review');
                    foreach ($dashboard_pages as $dashboard_key => $dashboard_page) {
                        /**
                         * If not enable from settings then quit
                         *
                         *  @since v2.0.0
                         */
                        if ($disable && 'reviews' === $dashboard_key) {
                            continue;
                        }

                        $menu_title = $dashboard_page;
                        $menu_link  = Helpers::idonate_dashboard_page_permalink($dashboard_key);
                        $separator  = false;
                        $menu_icon  = '';
                        if (is_array($dashboard_page)) {
                            $menu_title     = Helpers::array_get('title', $dashboard_page);
                            $menu_icon_name = Helpers::array_get('icon', $dashboard_page, (isset($dashboard_page['icon']) ? $dashboard_page['icon'] : ''));
                            if ($menu_icon_name) {
                                $menu_icon = "<i class='{$menu_icon_name}'></i>";
                            }
                            // Add new menu item property "url" for custom link
                            if (isset($dashboard_page['url'])) {
                                $menu_link = $dashboard_page['url'];
                            }
                            if (isset($dashboard_page['type']) && $dashboard_page['type'] == 'separator') {
                                $separator = true;
                            }
                        }
                        if ($separator) {
                            echo '<li class="dashboard_menu__divider"></li>';
                            if ($menu_title) {
                    ?>
                                <li>
                                    <?php echo esc_html($menu_title); ?>
                                </li>
                            <?php
                            }
                        } else {
                            if ('index' === $dashboard_key) {
                                $dashboard_key = '';
                            }
                            $active_class    = $dashboard_key == $dashboard_page_name ? 'active' : '';
                            $menu_link = apply_filters('idonate_dashboard_menu_link', $menu_link, $menu_title);
                            $data_no_instant = 'logout' == $dashboard_key ? wp_logout_url() : $menu_link;
                            ?>

                            <li class='<?php echo esc_attr($active_class); ?>'>
                                <a href="<?php echo esc_url($data_no_instant); ?>">

                                    <?php
                                    echo wp_kses(
                                        $menu_icon,
                                        Helpers::allowed_icon_tags()
                                    );
                                    ?>
                                    <span class='idonate-dashboard-menu-item-text idonate-ml-12'>
                                        <?php echo esc_html($menu_title); ?>
                                    </span>
                                </a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>

            <div class="ta-col-xs-1 ta-col-sm-1 ta-col-md-1 ta-col-lg-2-3 ta-col-xl-2-3">
                <div class="idonate-dashboard-content">
                    <?php
                    if ($dashboard_page_name) {
                        do_action('idonate_load_dashboard_template_before', $dashboard_page_name);

                        /**
                         * Load dashboard template part from other location
                         *
                         * This filter is basically added for adding templates from respective addons
                         *
                         * @since version 2.0.0
                         */
                        $other_location      = '';
                        $from_other_location = apply_filters('load_dashboard_template_part_from_other_location', $other_location);

                        if ('' == $from_other_location) {
                            idonate_load_template('dashboard.' . $dashboard_page_name);
                        } else {
                            // Load template from other location full abspath.
                            include_once $from_other_location;
                        }

                        do_action('idonate_load_dashboard_template_before', $dashboard_page_name);
                    } else {
                        idonate_load_template('dashboard.dashboard');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Helpers::idonate_custom_footer();
