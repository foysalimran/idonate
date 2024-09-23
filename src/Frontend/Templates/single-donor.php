<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 * Template Name: User Details
 *
 */

use ThemeAtelier\Idonate\Helpers\Helpers;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;
use ThemeAtelier\Idonate\Frontend\Helpers\SocialShare;

$option = get_option('idonate_settings');
$donor_social_share = isset($option['donor_social_share']) ? $option['donor_social_share'] : '';
$social_sharing_media = isset($donor_social_share['social_sharing_media']) ? $donor_social_share['social_sharing_media'] : '';


// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

$user_name = sanitize_text_field(get_query_var('idonate_profile_username'));
$get_user = Helpers::get_user_by_login($user_name);

if (! is_object($get_user) || ! property_exists($get_user, 'ID')) {
	wp_safe_redirect(get_home_url());
	exit;
}

Helpers::idonate_custom_header();
?>

<section class="idonate donor-single-page section-padding">
	<div class="ta-container">
		<div class="ta-row">
			<?php
			$user_id = $get_user->ID;


			$permalink = add_query_arg(
				array(
					'donor_id' => $user_id
				),
				get_permalink()
			);

			$user = get_userdata($user_id);
			$countryCode = get_user_meta($user_id, 'idonate_donor_country', true);
			$statecode   = get_user_meta($user_id, 'idonate_donor_state', true);
			$country = Countries::idonate_country_name_by_code($countryCode);
			$state 	 = Countries::idonate_states_name_by_code($countryCode, $statecode);

			// availability
			$av = get_user_meta($user_id, 'idonate_donor_availability', true);

			if ('available' == $av) {
				$abclass = 'available';
				$signal  = '<i class="icofont-check-circled"></i>';
			} else {
				$abclass = 'unavailable';
				$signal = '<i class="icofont-close-circled"></i>';
			}

			// Social Link
			$fb = get_user_meta($user_id, 'idonate_donor_fburl', true);
			$twitter = get_user_meta($user_id, 'idonate_donor_twitterurl', true);
			$linkedin = get_user_meta($user_id, 'idonate_donor_linkedin', true);
			$website = get_user_meta($user_id, 'idonate_donor_website', true);
			?>

			<div class="ta-col-sm-1 ta-col-md-2 ta-col-lg-3 ta-col-xl-3 text-center">
				<div class="left__user">
					<div class="left__user__img">
						<?php if (idonate_profile_img($user_id)) : ?>
							<?php
							echo wp_kses_post(idonate_profile_img($user_id));
							?>
						<?php else : ?>
							<img src="<?php
										echo esc_url(IDONATE_DIR_URL) . 'src/assets/images/donorplaceholder.jpeg' ?>" />
						<?php endif; ?>
					</div>
					<?php

					// Name
					echo '<h2 class="mb-3">' . esc_html(get_user_meta($user_id, 'idonate_donor_full_name', true)) . '</h2>';
					echo '<p><b>' . esc_html('Blood Group:', 'idonate') . ' </b>' . esc_html(get_user_meta($user_id, 'idonate_donor_bloodgroup', true)) . '</p>';
					echo '<p class="blood-group"><i class="icofont-unity-hand"></i><span class="' . esc_attr($abclass) . '"><b>' . esc_html('Availablity: ', 'idonate') . '</b>' . esc_html(ucfirst($av)) . wp_kses_post($signal) . '</span></p>';

					$hide_email = isset($option['hide_email']) ? $option['hide_email'] : '';
					$hide_mobile_number = isset($option['hide_mobile_number']) ? $option['hide_mobile_number'] : '';
					if ($hide_email && !empty($user->user_email)) {
						echo '<p><b>' . esc_html('Email:', 'idonate') . ' </b>' . esc_html($user->user_email) . '</p>';
					}
					if ($hide_mobile_number && $user_id) {
						echo '<p><b>' . esc_html('Mobile:', 'idonate') . ' </b>' . esc_html(get_user_meta($user_id, 'idonate_donor_mobile', true)) . '</p>';
					}

					if ($fb || $twitter) :
					?>
						<p class="social-icon"><strong><?php esc_html_e('Social Media :', 'idonate'); ?></strong>
						<?php
					endif;
						?>
						<?php
						// Social media.
						// FB Url 
						if ($fb) {
							echo '<a target="_blank" href="' . esc_url($fb) . '"><i class="icofont-facebook"></i></a>';
						}
						// Twitter
						if ($twitter) {
							echo '<a target="_blank" href="' . esc_url($twitter) . '"><i class="icofont-twitter"></i></a>';
						}
						// Linkedin Url 
						if ($linkedin) {
							echo '<a target="_blank" href="' . esc_url($linkedin) . '"><i class="icofont-linkedin"></i></a>';
						}
						// Website
						if ($website) {
							echo '<a target="_blank" href="' . esc_url($website) . '"><i class="icofont-earth"></i></a>';
						}
						?>
				</div>
			</div>
			<div class="ta-col-sm-1 ta-col-md-2 ta-col-lg-2-3 ta-col-xl-2-3">
				<div class="single-page-donor">
					<div class="infotable">
						<div class="table-responsive">
							<table class="table table-bordered">
								<?php
								// Name
								$name = get_user_meta($user_id, 'idonate_donor_full_name', true);
								if ($name) {
									echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Donor Name', 'idonate'), esc_html($name)));
								}
								// Last Donate
								$lastdonate = get_user_meta($user_id, 'idonate_donor_lastdonate', true);
								if ($lastdonate) {
									echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('Last Donate', 'idonate'), esc_html($lastdonate)));
								}

								// Gender
								$gender = get_user_meta($user_id, 'idonate_donor_gender', true);
								if ($gender) {
									echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('Gender', 'idonate'), esc_html($gender)));
								}
								// Date of Birth
								$date_birth = get_user_meta($user_id, 'idonate_donor_date_birth', true);
								if ($date_birth) {
									echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('Date of Birth', 'idonate'), esc_html($date_birth)));
								}
								// Land Line Number
								$landline = get_user_meta($user_id, 'idonate_donor_landline', true);
								if ($landline) {
									echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Land Line Number', 'idonate'), esc_html($landline)));
								}
								// Country
								if ($country) {
									echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('Country', 'idonate'), esc_html($country)));
								}
								// State
								if ($state) {
									echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('State', 'idonate'), esc_html($state)));
								}
								// City
								$city = get_user_meta($user_id, 'idonate_donor_city', true);
								if ($city) {
									echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('City', 'idonate'), esc_html($city)));
								}
								// Address
								$address = get_user_meta($user_id, 'idonate_donor_address', true);

								if ($address) {
									echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Address', 'idonate'), esc_html($address)));
								}
								?>
							</table>
						</div>
						<?php
						// Social share
						if ($social_sharing_media) {
							echo '<span><i class="icofont-share"></i> </span>';
							SocialShare::idonate_social_sharing_buttons($name, $permalink, $donor_social_share);
						}
						?>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<?php
Helpers::idonate_custom_footer();