<?php

/**
 * The file of query insides.
 *
 * @package idonate
 * @subpackage idonate/public
 *
 * @since 2.0.0
 */

namespace ThemeAtelier\Idonate\Frontend\Helpers;

use ThemeAtelier\Idonate\Frontend\Templates\RequestFilterBar;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class RequestLoopHtml
{
    /**
     * Full html show.
     *
     */
    public static function request_html_show($options)
    {
        $big = 999999999;
        $pagenum_link = str_replace($big, '%#%', esc_url(get_pagenum_link($big)));
        $rp_request_per_page = isset($options['rp_request_per_page']) ? $options['rp_request_per_page'] : '';
        
        // request per page
        if ($rp_request_per_page) {
            $rperpage =  $rp_request_per_page;
        } else {
            $rperpage = 10;
        }

        ob_start();

        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        $args = array(
            'post_type'      => 'blood_request',
            'paged'          => $paged,
            'posts_per_page' => $rperpage,
            'meta_query'     => array(
                array(
                    'key'     => 'idonate_status',
                    'value'   => '1',
                    'compare' => '='
                ),
            ),
        );

        $loop = new \WP_Query($args);

        if (!empty($loop->posts)) {
            echo "<div class='idonate request_wrapper' data-pagenum_link=" . esc_attr($pagenum_link) . ">";
            RequestFilterBar::request_filter($loop);
            echo '</div>';
        } else {
?>
            <div class="idonate-alert idonate-alert-error"><?php echo esc_html('No request available.', 'idonate') ?></div>
<?php
        }
    }
}
