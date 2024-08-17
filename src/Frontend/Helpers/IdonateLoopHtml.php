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

use ThemeAtelier\Idonate\Frontend\Templates\FilterBar;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class IdonateLoopHtml
{
    /**
     * Full html show.
     *
     */
    public static function idonate_html_show($options)
    {
        $pagenum_link = user_trailingslashit(trailingslashit(get_pagenum_link(1)) . 'page/%#%/', 'paged');

        $number = isset($options['donor_per_page']) ? $options['donor_per_page'] : 10;


        $totaldonor_args = array(
            'role' => 'donor',
            'meta_key' => 'idonate_donor_status',
            'meta_value' => '1'
        );
        $get_donor = get_users($totaldonor_args);
        $total_donor = $get_donor;

        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        // $args = array(
        //     'role' => 'donor',
        //     'meta_key' => 'idonate_donor_status',
        //     'meta_value' => '1',
        //     'order' => 'ASC',
        //     'offset' => ($paged - 1) * $number,
        //     'number' => $number,
        // );

        $args = array(
            'role'    => 'donor',
            'meta_query' => array(
                array(
                    'key'     => 'idonate_donor_status',
                    'value'   => '1',
                    'compare' => '='
                ),
            ),
            'order'   => 'ASC',
            'offset'  => ($paged - 1) * $number,
            'number'  => $number,
        );

        $users = get_users($args);
        if (!empty($users)) {
            echo "<div class='idonate donor_wrapper' data-pagenum_link=" . esc_attr($pagenum_link) . ">";

            FilterBar::donors_filter($users, $total_donor, $number, $paged, $pagenum_link);

            echo '</div>';
        } else {
?>
            <div class="idonate-alert idonate-alert-error"><?php echo esc_html('No donors available.', 'idonate') ?></div>
<?php
        }
    }
}
