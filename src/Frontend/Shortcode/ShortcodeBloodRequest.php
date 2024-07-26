<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

namespace ThemeAtelier\Idonate\Frontend\Shortcode;

use ThemeAtelier\Idonate\Frontend\Helpers\RequestLoopHtml;

// Blocking direct access
if (!defined('ABSPATH')) {
    die(esc_html(IDONATE_ALERT_MSG));
}

class ShortcodeBloodRequest
{
    public function shortcode_blood_request()
    {
        $options = get_option('idonate_settings');

        ob_start();
        RequestLoopHtml::request_html_show($options);
        return ob_get_clean();
    }
}
