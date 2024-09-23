<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 *
 */

// Blocking direct access
if (!defined('ABSPATH')) {
    die(esc_html(IDONATE_ALERT_MSG));
}

$options        = get_option('idonate_settings');
$donor_peft     = isset($options['donor_peft']) ? $options['donor_peft'] : '';

?>

<div class="idonate">
    <div class="idonate__wrapper">
        <h3 class="dashboard_content_title"><?php echo esc_html($donor_peft); ?></h3>

        <div class="idonate-dashboard-content-inner">
            <?php
            idonate_load_template('dashboard.settings.nav-bar', array('active_setting_nav' => 'profile'));
            ?>
        </div>

        <?php
        if (isset($GLOBALS['idonate_setting_nav']['profile'])) {
            idonate_load_template('dashboard.settings.profile');
        } else {
            foreach ($GLOBALS['idonate_setting_nav'] as $page) {
                echo '<script>window.location.replace("', esc_url($page['url']), '");</script>';
                break;
            }
        }
        ?>
    </div>
</div>