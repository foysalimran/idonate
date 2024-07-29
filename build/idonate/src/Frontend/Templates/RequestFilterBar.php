<?php

/**
 * The file of query insides.
 *
 * @package idonate
 * @subpackage idonate/public
 *
 * @since 2.0.0
 */

namespace ThemeAtelier\Idonate\Frontend\Templates;

use ThemeAtelier\Idonate\Frontend\Manager;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;

class RequestFilterBar
{
    public static function request_filter($loop)
    {
        $option = get_option('idonate_settings');

        $bgroups = array();
        $countries = array();
        $states = array();

        $big = 999999999;
        $pagenum_link = str_replace($big, '%#%', esc_url(get_pagenum_link($big)));

        $args = array(
            'post_type'      => 'blood_request',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => 'idonate_status',
                    'value'   => '1',
                    'compare' => '='
                ),
            ),
        );

        $search_loop =  new \WP_Query($args);

        foreach ($search_loop->posts as $post) {
            $bgroup         = get_post_meta($post->ID, 'idonatepatient_bloodgroup', true);
            $countryCode    = get_post_meta($post->ID, 'idonatecountry', true);
            $stateCode      = get_post_meta($post->ID, 'idonatestate', true);
            $country        = Countries::idonate_country_name_by_code($countryCode);
            $state          = Countries::idonate_states_name_by_code($countryCode, $stateCode);

            if (!empty($bgroup)) {
                $bgroups[] = $bgroup;
            }

            if (!empty($country)) {
                $countries[$countryCode] = $country;
            }

            if (!empty($state)) {
                $states[$stateCode] = $state;
            }
        };

        $bgroups = array_unique($bgroups);
        sort($bgroups);

        $countries = array_unique($countries);
        asort($countries);
        $states = array_unique($states);
        asort($states);

        $states = wp_json_encode($states);

?>
        <form id="idonate-filter-form">
            <div class="search_area">
                <input type="text" name="name" id="name" placeholder="<?php esc_html_e('Enter Request Title', 'idonate'); ?>" />
                <select name="bloodgroup" id="bloodgroup">
                    <option value=""><?php esc_html_e('Select Blood Group', 'idonate'); ?></option>
                    <?php foreach ($bgroups as $group) : ?>
                        <option value="<?php echo esc_attr($group); ?>"><?php echo esc_html($group); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="date" name="start_date" id="start_date" placeholder="<?php esc_html_e('Start Date', 'idonate'); ?>" />
                <input type="date" name="end_date" id="end_date" placeholder="<?php esc_html_e('End Date', 'idonate'); ?>" />
            </div>
            <div class="search_area">
                <?php
                if (!empty($country)) : ?>
                    <select name="country" id="country" class="country">
                        <option value=""><?php esc_html_e('Select Country', 'idonate'); ?></option>
                        <?php foreach ($countries as $key => $country) : ?>
                            <option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($country); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif;
                if (!empty($state)) :
                ?>
                    <select name="state" id="state" class="state" data-state="<?php echo esc_attr($states); ?>">
                        <option value=""><?php esc_html_e('Select State', 'idonate'); ?></option>
                    </select>
                <?php
                endif; ?>

                <input type="text" name="city" id="city" placeholder="<?php esc_html_e('Enter City', 'idonate'); ?>" />
                <button type="button" id="reset-button"><i class="icofont-undo"></i></button>
            </div>
        </form>
        <div class="request">
            <?php Manager::request_views_html($loop, $pagenum_link); ?>
        </div>
<?php
    }
}
