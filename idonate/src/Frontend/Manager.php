<?php

/**
 * The file to manage all public-facing functionality of the plugin.
 *
 * @link       https://themeatelier.net
 *
 * @since      1.0.0
 *
 * @package idonate
 * @subpackage idonate/Frontend
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\Idonate\Frontend;

use ThemeAtelier\Idonate\Helpers\Helpers;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;
use ThemeAtelier\Idonate\Frontend\Helpers\SocialShare;

/**
 * The Manager class to manage all public facing stuffs.
 *
 * @since 1.0.0
 */
class Manager
{

    /**
     * The function to process views HTML.
     *
     * @param  integer $views_id The views generator ID.
     * @param  array   $views_meta The array of the generator serialized meta.
     * @return void
     */
    public static function views_html($users, $total_donor, $number, $paged, $pagenum_link)
    {
        $options = get_option('idonate_settings');
        $donor_view_button = isset($options['donor_view_button']) ? $options['donor_view_button'] : 'donor';
        $hide_mobile_number = isset($options['hide_mobile_number']) ? $options['hide_mobile_number'] : '';

        if (is_array($users) && count($users) > 0) :
            echo '<div class="donors"><div class="ta-row">';
            foreach ($users as $user) :
                // availability
                $availability = get_user_meta($user->ID, 'idonate_donor_availability', true);

                if ('available' == $availability) {
                    $abclass = 'available';
                    $signal  = ' <i class="icofont-close-circled"></i>';
                } else {
                    $abclass = 'unavailable';
                    $signal = '<i class="icofont-check-circled"></i>';
                }
?>
                <div class=" ta-col-sm-1 ta-col-md-2 ta-col-lg-3 ta-col-xl-3">
                    <div class="donor_info" data-id="<?php echo esc_attr($user->ID); ?>">
                        <div class="donor_image">
                            <?php if (idonate_profile_img($user->ID)) : ?>
                                <?php
                                echo wp_kses_post(idonate_profile_img($user->ID));
                                ?>
                            <?php else :
                                echo '<img src="' . esc_url(IDONATE_DIR_URL) . 'src/assets/images/donorplaceholder.jpeg"  alt="' . esc_html__('request image', 'idonate') . '"/>';
                            endif;
                            ?>
                        </div>
                        <div class="donor_content">
                            <p><i class="icofont-user"></i><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_full_name', true)); ?></p>

                            <p><i class="icofont-blood-test"></i><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_bloodgroup', true)); ?></p>

                            <p><i class="icofont-blood-drop"></i><span class="<?php echo esc_attr($abclass); ?>"><?php echo esc_html($availability) . wp_kses_post($signal); ?></span></p>

                            <p><i class="icofont-location-pin"></i><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_city', true)); ?></p>
                            <?php
                            if (!$hide_mobile_number) { ?>
                                <p><i class="icofont-smart-phone"></i><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_mobile', true)); ?></p>
                            <?php
                            }
                            $popup_link =  $donor_view_button === 'popup' ? 'idonate_popup_modal' : '';
                            ?>
                            <a href="<?php echo esc_url(Helpers::profile_url($user->ID, true)); ?>" class='idonate_button <?php echo esc_attr($popup_link) ?>'><?php esc_html_e('View Details', 'idonate'); ?></a>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            echo '</div></div>';

            idonate_donor_pagination($total_donor, $number, $paged, $pagenum_link);
        else :
            echo '<h3 class="notmatch">' . esc_html__('Sorry. Not match anyone !!!.', 'idonate') . '</h3>';
        endif;
    }
    public static function request_views_html($loop, $pagenum_link)
    {
        $options = get_option('idonate_settings');
        $post_request_number_of_columns = $options['post_request_number_of_columns'] ? $options['post_request_number_of_columns'] : 0;

        if ($loop->have_posts()) :
            echo '<div class="ta-row">';
            while ($loop->have_posts()) :
                $loop->the_post();

                $bgroup     = get_post_meta(get_the_ID(), 'idonatepatient_bloodgroup', true);
                $need     = get_post_meta(get_the_ID(), 'idonatepatient_bloodneed', true);
                $units     = get_post_meta(get_the_ID(), 'idonatepatient_bloodunit', true);
                $mobnumber     = get_post_meta(get_the_ID(), 'idonatepatient_mobnumber', true);
                $status     = get_post_meta(get_the_ID(), 'idonatepatient_status', true);

                $image = get_the_post_thumbnail(get_the_ID());
            ?>

                <div class="ta-col-xs-1 ta-col-sm-1 ta-col-md-1 ta-col-lg-3 ta-col-xl-3">
                    <div class="single-request" data-id="<?php echo esc_attr(get_the_ID()) ?>">
                        <div class="profile">
                            <div class="profile-img">
                                <div class="image">
                                    <div class="circle-1"></div>
                                    <div class="circle-2"></div>
                                    <i class="icofont-heart-beat"></i>
                                </div>
                            </div>

                            <div class="name"><?php esc_html(the_title()); ?></div>
                            <div class="job"><?php echo esc_html__('Post Date: ', 'idonate') . esc_html(get_the_date()); ?></div>
                        </div>
                        <div class="request-info-area">
                            <?php
                            // Blood Group
                            if ($bgroup) {
                                echo '<div class="request-info"><i class="icofont-blood-test"></i>' . esc_html($bgroup) . '</div>';
                            }
                            // units
                            if ($units) {
                                echo '<div class="request-info"><i class="icofont-blood"></i>' . esc_html__('Unit/Bag (S): ', 'idonate') . esc_html($units) . '</div>';
                            }
                            // When Need
                            if ($need) {
                                echo '<div class="request-info"><i class="icofont-ui-calendar"></i>' . esc_html($need) . '</div>';
                            }
                            // Mobile Number
                            if ($mobnumber) {
                                echo '<div class="request-info"><i class="icofont-smart-phone"></i>' . esc_html($mobnumber) . '</div>';
                            }

                            $popup_link = '';
                            ?>
                        </div>
                        <a href="<?php echo esc_url(get_the_permalink(get_the_ID())); ?>" class="btn-default btn <?php echo esc_attr($popup_link) ?>"><?php esc_html_e('Details', 'idonate'); ?></a>
                    </div>

                </div>
        <?php
            endwhile;
            echo '</div>';
            idonate_pagination($loop, $pagenum_link);
            wp_reset_postdata();
        endif;
    }
    public static function donor_popup_views_html()
    {
        $user_id = stripslashes($_POST['user_id']);

        $countryCode = get_user_meta($user_id, 'idonate_donor_country', true);
        $statecode   = get_user_meta($user_id, 'idonate_donor_state', true);
        $country = Countries::idonate_country_name_by_code($countryCode);
        $state      = Countries::idonate_states_name_by_code($countryCode, $statecode);
        // availability
        $availability = get_user_meta($user_id, 'idonate_donor_availability', true);
        if ('available' == $availability) {
            $abclass = 'available';
            $signal  = '<i class="icofont-check-circled"></i>';
        } else {
            $abclass = 'unavailable';
            $signal = '<i class="icofont-close-circled"></i>';
        }
        $user_info = get_userdata($user_id);
        $user_email = $user_info->user_email; // Get user email

        $option = get_option('idonate_settings');
        $donor_social_share = isset($option['donor_social_share']) ? $option['donor_social_share'] : '';
        $social_sharing_media = isset($donor_social_share['social_sharing_media']) ? $donor_social_share['social_sharing_media'] : '';
        $name = get_user_meta($user_id, 'idonate_donor_full_name', true);
        $permalink = add_query_arg(
            array(
                'donor_id' => $user_id
            ),
            get_permalink()
        );

        ?>
        <div class="idonate-donor-modal_wrapper" id="idonate_popup_ajax_content">
            <div class="donor_info">
                <div class="donor_info_image">
                    <?php if (idonate_profile_img($user_id)) : ?>
                        <?php
                        echo wp_kses_post(idonate_profile_img($user_id));
                        ?>
                    <?php else :
                        echo '<img src="' . esc_html(IDONATE_DIR_URL) . 'src/assets/images/donorplaceholder.jpeg"  alt="' . esc_html(get_user_meta($user_id, 'idonate_donor_full_name', true)) . '"/>';
                    endif; ?>
                </div>
                <div class="donor_content">
                    <h3><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_full_name', true)); ?></h3>
                    <p><?php echo esc_html($user_email); ?></p>
                    <p><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_mobile', true)); ?></p>
                    <?php if ($availability) : ?>
                        <p><span class="<?php echo esc_attr($abclass); ?>"><?php echo esc_html($availability) . wp_kses_post($signal); ?></span></p>
                    <?php endif; ?>
                    <p><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_bloodgroup', true)); ?></p>
                    <?php
                    $fb = get_user_meta($user_id, 'idonate_donor_fburl', true);
                    $twitter = get_user_meta($user_id, 'idonate_donor_twitterurl', true);
                    if ($fb || $twitter) {
                    ?>
                        <p class="social-icon">
                            <?php
                            // FB Url 
                            if ($fb) {
                                echo '<a target="_blank" href="' . esc_url($fb) . '"><i class="icofont-facebook"></i></a>';
                            }
                            // Twitter
                            if ($twitter) {
                                echo '<a target="_blank" href="' . esc_url($twitter) . '"><i class="icofont-twitter"></i></a>';
                            }
                            ?>
                        </p>
                    <?php
                    }
                    ?>

                    <div class="address">
                        <?php
                        $lastdonate = get_user_meta($user_id, 'idonate_donor_lastdonate', true);
                        if ($lastdonate) :
                        ?>
                            <p><strong><?php esc_html_e('Last Donate: ', 'idonate'); ?></strong> <?php echo esc_html($lastdonate); ?></p>
                        <?php endif; ?>

                        <?php
                        $gender = get_user_meta($user_id, 'idonate_donor_gender', true);
                        if ($gender) :
                        ?>
                            <p><strong><?php esc_html_e('Gender: ', 'idonate'); ?></strong> <?php echo esc_html($gender); ?></p>
                        <?php endif; ?>

                        <?php
                        $dob = get_user_meta($user_id, 'idonate_donor_date_birth', true);
                        if ($dob) : ?>
                            <p><strong><?php esc_html_e('Date Of Birth: ', 'idonate'); ?></strong> <?php echo esc_html($dob); ?></p>
                        <?php endif; ?>

                        <?php
                        $landline = get_user_meta($user_id, 'idonate_donor_landline', true);
                        if ($landline) : ?>
                            <p><strong><?php esc_html_e('Land Line Number: ', 'idonate'); ?></strong> <?php echo esc_html($landline); ?></p>
                        <?php endif; ?>

                        <?php
                        if ($country) :
                        ?>
                            <p><strong><?php esc_html_e('Country: ', 'idonate'); ?></strong> <?php echo esc_html($country); ?></p>
                        <?php
                        endif;
                        if ($state) :
                        ?>
                            <p><strong><?php esc_html_e('State: ', 'idonate'); ?></strong> <?php echo esc_html($state); ?></p>
                        <?php
                        endif;
                        ?>
                        <p><strong><?php esc_html_e('City: ', 'idonate'); ?></strong> <?php echo esc_html(get_user_meta($user_id, 'idonate_donor_city', true)); ?></p>
                        <p><strong><?php esc_html_e('Address: ', 'idonate'); ?></strong> <?php echo esc_html(get_user_meta($user_id, 'idonate_donor_address', true)); ?></p>

                        <?php
                        if ($social_sharing_media) {
                            SocialShare::idonate_social_sharing_buttons($name, $permalink, $donor_social_share);
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            // if ($popup_close_button) {
            ?>
            <button title="<?php esc_html_e('Close (Esc)', 'idonate') ?>" type="button" class="mfp-close idonate-popup-close">&#215;</button>
            <?php
            // }
            ?>

            <div id="preloader" style="display: none;">
                <div class="spinner"></div>
            </div>
        </div>
    <?php
    }
    public static function donor_request_popup_views_html()
    {
        $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';

        $post = get_post($post_id);

        $image             = get_the_post_thumbnail($post_id);
        $name             = get_post_meta($post_id, 'idonatepatient_name', true);
        $bgroup         = get_post_meta($post_id, 'idonatepatient_bloodgroup', true);
        $age             = get_post_meta($post_id, 'idonatepatient_age', true);
        $need             = get_post_meta($post_id, 'idonatepatient_bloodneed', true);
        $units             = get_post_meta($post_id, 'idonatepatient_bloodunit', true);
        $mobnumber         = get_post_meta($post_id, 'idonatepatient_mobnumber', true);
        $email             = get_post_meta($post_id, 'email', true);
        $purpose         = get_post_meta($post_id, 'idonatepurpose', true);
        $hospital         = get_post_meta($post_id, 'idonatehospital_name', true);
        $statecode         = get_post_meta($post_id, 'idonatestate', true);
        $city             = get_post_meta($post_id, 'idonatecity', true);
        $location         = get_post_meta($post_id, 'idonateaddress', true);
        $countrycode    = get_post_meta($post_id, 'idonatecountry', true);
        $details         = get_post_meta($post_id, 'idonatedetails', true);
        $permalink         = get_the_permalink($post_id);

        $options = get_option('idonate_settings');
        $donor_social_share = isset($options['donor_social_share']) ? $options['donor_social_share'] : '';
    ?>
        <div class="idonate-donor-modal_wrapper" id="idonate_popup_ajax_content" style="opacity: 1;">
            <div class="donor_info">
                <div class="donor_info_image">
                    <?php
                    if ($image) {
                        echo wp_kses_post($image);
                    } else {
                        echo '<img src="' . esc_html(IDONATE_DIR_URL) . 'src/assets/images/request.jpg"  alt="' . esc_html__('request image', 'idonate') . '"/>';
                    }
                    ?>
                </div>
                <div class="donor_content">
                    <h3><?php echo esc_html($post->post_title); ?></h3>
                    <p><?php echo esc_html($details); ?></p>

                    <div class="address">
                        <?php
                        if ($email) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Email: ', 'idonate') . '</strong>', esc_html($email);
                            echo '</p>';
                        }
                        if ($mobnumber) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Mobile Number: ', 'idonate') . '</strong>', esc_html($mobnumber);
                            echo '</p>';
                        }
                        if ($bgroup) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Blood Group: ', 'idonate') . '</strong>', esc_html($bgroup);
                            echo '</p>';
                        }
                        if ($name) {
                            echo '<p>';
                            echo  '<strong>' . esc_html__('Patient Name: ', 'idonate') . '</strong>', esc_html($name);
                            echo '</p>';
                        }
                        // Age
                        if ($age) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Patient Age: ', 'idonate') . '</strong>', esc_html($age);
                            echo '</p>';
                        }
                        // Blood Group
                        if ($bgroup) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Blood Group: ', 'idonate') . '</strong>', esc_html($bgroup);
                            echo '</p>';
                        }
                        // When Need Blood ?
                        if ($need) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('When Need Blood?: ', 'idonate') . '</strong>', esc_html($need);
                            echo '</p>';
                        }
                        // Blood Units
                        if ($units) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Blood Unit / Bag (S): ', 'idonate') . '</strong>', esc_html($units);
                            echo '</p>';
                        }
                        // Purpose
                        if ($purpose) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Purpose: ', 'idonate') . '</strong>', esc_html($purpose);
                            echo '</p>';
                        }
                        // Mobile Number
                        if ($mobnumber) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Mobile Number: ', 'idonate') . '</strong>', esc_html($mobnumber);
                            echo '</p>';
                        }
                        // Email
                        if ($email) {
                            echo '<strong>' . esc_html__('Email: ', 'idonate') . '</strong>', esc_html($email);
                        }
                        // Hospital Name
                        if ($hospital) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Hospital Name: ', 'idonate') . '</strong>', esc_html($hospital);
                            echo '</p>';
                        }
                        // Country
                        $country = Countries::idonate_country_name_by_code($countrycode);

                        if ($country) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Country: ', 'idonate') . '</strong>', esc_html($country);
                            echo '</p>';
                        }
                        // State
                        $state = Countries::idonate_states_name_by_code($countrycode, $statecode);
                        if ($state) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('State: ', 'idonate') . '</strong>', esc_html($state);
                            echo '</p>';
                        }
                        // City
                        if ($city) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('City: ', 'idonate') . '</strong>', esc_html($city);
                            echo '</p>';
                        }
                        // Location/Address
                        if ($location) {
                            echo '<p>';
                            echo '<strong>' . esc_html__('Address: ', 'idonate') . '</strong>', esc_html($location);
                            echo '</p>';
                        }
                        ?>
                    </div>
                    <?php
                    // Social share
                    SocialShare::idonate_social_sharing_buttons($name, $permalink, $donor_social_share);
                    ?>
                </div>
            </div>
            <button title="<?php echo esc_attr('Close (Esc)', 'idoante-pro'); ?>" type="button" class="mfp-close idonate-popup-close">×</button>

            <div id="preloader" style="display: none;">
                <div class="spinner"></div>
            </div>
        </div>
<?php
    }

    /**
     * Minify output
     *
     * @param  string $html output minifier.
     * @return statement
     */
    public static function minify_output($html)
    {
        $html = preg_replace('/<!--(?!s*(?:[if [^]]+]|!|>))(?:(?!-->).)*-->/s', '', $html);
        $html = str_replace(array("\r\n", "\r", "\n", "\t"), '', $html);
        while (stristr($html, '  ')) {
            $html = str_replace('  ', ' ', $html);
        }
        return $html;
    }
}
