<?php

/**
 * Profile
 *
 * @package Idonate
 * @subpackage Dashboard\Settings
 * @author ThemeAtelier<themeatelierbd@gmail.com>
 * @link https://themeum.com
 * @since 1.6.2
 */

use ThemeAtelier\Idonate\Helpers\Countries\Countries;
use ThemeAtelier\Idonate\Helpers\DonorFunctions;

$userID         = get_current_user_id();
$userData       = get_userdata($userID);
$options        = get_option('idonate_settings');
$donor_peft     = isset($options['donor_peft']) ? $options['donor_peft'] : '';
$idonate_countryhide = isset($options['idonate_countryhide']) ? $options['idonate_countryhide'] : '';
$enable_single_country = isset($options['enable_single_country']) ? $options['enable_single_country'] : false;
$idonate_country = isset($options['idonate_country']) ? $options['idonate_country'] : '';

$user = wp_get_current_user();
$msg = '';
if (isset($_POST['donor_submit'])) {
    $res = DonorFunctions::idonate_donor_address();
    $msg =  DonorFunctions::idonate_response_msg($res, 'update');
}
?>
<div class="idonate">
    <div class="idonate__wrapper">
        <h3 class="dashboard_content_title"><?php echo esc_html__('Address', 'idonate'); ?></h3>
        <?php
        idonate_load_template('dashboard.settings.nav-bar', array('active_setting_nav' => 'address'));
        ?>
        <div class="request-form">
            <div id="donorPanelForm">
                <?php
                echo wp_kses_post($msg);
                ?>
                <form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
                    <div id="address" class="tabcontent">
                        <?php if ($idonate_countryhide) : ?>
                            <div class="idonate_row idonate_col">
                                <?php if (!$enable_single_country || empty($idonate_country)) : ?>
                                    <div class="idonate_col_item">
                                        <label for="country"><?php esc_html_e('Select Country', 'idonate'); ?></label>
                                        <select id="country" class="form-control country" name="country">
                                            <?php
                                            $allowed_html = array(
                                                'option' => array(
                                                    'value' => array(),
                                                    'selected' => array(),  // Allow the selected attribute
                                                ),
                                            );
                                            $SelectedCounCode = get_user_meta($userID, 'idonate_donor_country', true);
                                            echo wp_kses(Countries::IDONATE_COUNTRIES_options($SelectedCounCode), $allowed_html);
                                            ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="idonate_col_item">
                                    <label for="state"><?php esc_html_e('Select State', 'idonate'); ?></label>
                                    <?php 
                                    if ($enable_single_country && !empty($idonate_country)) {
                                        $selected_country = $idonate_country;
                                    } else {
                                        $selected_country = get_user_meta($userID, 'idonate_donor_country',  true);
                                    }
                                    $path = IDONATE_COUNTRIES . 'states/' . $selected_country . '.php';
                                    if (file_exists($path)) {
                                        include($path);
                                    }
                                    global $states;
                                    $states = !empty($states[$selected_country]) ? $states[$selected_country] : [];
                                    ?>
                                    <select class="form-control state" name="state">
                                        <?php
                                        $selected_state = get_user_meta($userID, 'idonate_donor_state', true);
                                        foreach ($states as $key => $option) {
                                            if ($selected_state == $key) {
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            echo '<option value="' . esc_attr($key) . '"' . esc_attr($selected) . '>' . esc_attr($option) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="idonate_row idonate_col">
                            <div class="idonate_col_item">
                                <label><?php esc_html_e('City', 'idonate'); ?></label>
                                <input id="city" name="city" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_city', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('City', 'idonate'); ?>" type="text">
                            </div>
                        </div>
                        <div class="idonate_row idonate_col">
                            <div class="idonate_col_item">
                                <label><?php esc_html_e('Address', 'idonate'); ?></label>
                                <textarea rows="4" name="address" class="form-control"><?php echo esc_html(get_user_meta($userID, 'idonate_donor_address', true)); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" value="<?php echo esc_html($userID); ?>" name="donor_id" />
                    <?php
                    // WP Nonce
                    wp_nonce_field('request_nonce_action', 'request_submit_nonce_check');
                    ?>
                    <input class="idonate_submit_btn" type="submit" name="donor_submit" value="<?php echo esc_attr('Submit', 'idonate') ?>" />
                </form>
            </div>
        </div>
    </div>
</div>