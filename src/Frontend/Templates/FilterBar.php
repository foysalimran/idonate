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

class FilterBar
{
    public static function donors_filter($users, $total_donor, $number, $paged, $pagenum_link)
    {
        $options = get_option('idonate_settings');
        $idonate_countryhide = isset($options['idonate_countryhide']) ? $options['idonate_countryhide'] : '';
        $show_donor_search = isset($options['show_donor_search']) ? $options['show_donor_search'] : '';
        $bloodgroups = array();
        $availabilitys = array();
        $countries = array();
        $states = array();

        foreach ($total_donor as $user) {
            $bloodgroup = get_user_meta($user->ID, 'idonate_donor_bloodgroup', true);
            $availability = get_user_meta($user->ID, 'idonate_donor_availability', true);
            $countryCode = get_user_meta($user->ID, 'idonate_donor_country', true);
            $stateCode = get_user_meta($user->ID, 'idonate_donor_state', true);
            $country = Countries::idonate_country_name_by_code($countryCode);
            $state = Countries::idonate_states_name_by_code($countryCode, $stateCode);

            if (!empty($bloodgroup)) {
                $bloodgroups[] = $bloodgroup;
            }
            if (!empty($availability)) {
                $availabilitys[] = $availability;
            }

            if (!empty($country)) {
                $countries[$countryCode] = $country;
            }

            if (!empty($state)) {
                $states[$stateCode] = $state;
            }
        }
     
        $bloodgroups = array_unique($bloodgroups);
        sort($bloodgroups);
        $availabilitys = array_unique($availabilitys);
        sort($availabilitys);
        $countries = array_unique($countries);
        asort($countries);
        $states = array_unique($states);
        asort($states);

        $states = wp_json_encode($states);
      
     if($show_donor_search) {
?>
        <form id="idonate-filter-form">
            <div class="search_area">
                <input type="text" name="name" id="name" placeholder="<?php esc_html_e('Enter Donor Name', 'idonate'); ?>" />
                <select name="bloodgroup" id="bloodgroup">
                    <option value=""><?php esc_html_e('Select Blood Group', 'idonate'); ?></option>
                    <?php foreach ($bloodgroups as $group) : ?>
                        <option value="<?php echo esc_attr($group); ?>"><?php echo esc_html($group); ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="availability" id="availability">
                    <option value=""><?php esc_html_e('Select Availability', 'idonate'); ?></option>
                    <?php foreach ($availabilitys as $availability) : ?>
                        <option value="<?php echo esc_attr($availability); ?>"><?php echo esc_html(ucfirst($availability)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="search_area">
                <?php
                if ($idonate_countryhide) :
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
                <?php endif;
                endif; ?>
                <input type="text" name="city" id="city" placeholder="<?php esc_html_e('Enter City', 'idonate'); ?>" />
                <button type="button" id="reset-button"><i class="icofont-undo"></i></button>
            </div>
        </form>
        <?php  } ?>
        <div class="donors">
            <?php Manager::views_html($users, count($total_donor), $number, $paged, $pagenum_link); ?>
        </div>
<?php
    }
}
