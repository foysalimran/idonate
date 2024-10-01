<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

use ThemeAtelier\Idonate\Helpers\Helpers;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;
use ThemeAtelier\Idonate\Frontend\Helpers\SocialShare;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

$option = get_option('idonate_settings');
$donor_social_share = isset($option['donor_social_share']) ? $option['donor_social_share'] : '';
$social_sharing_media = isset($donor_social_share['social_sharing_media']) ? $donor_social_share['social_sharing_media'] : '';


Helpers::idonate_custom_header();
?>

<div class="request_single_page section-padding">
	<?php
	if (have_posts()) :
		while (have_posts()) :
			the_post();

			$image 			= get_the_post_thumbnail(get_the_ID());
			$name     		= get_post_meta(get_the_ID(), 'idonatepatient_name', true);
			$bgroup     	= get_post_meta(get_the_ID(), 'idonatepatient_bloodgroup', true);
			$age     		= get_post_meta(get_the_ID(), 'idonatepatient_age', true);
			$need     		= get_post_meta(get_the_ID(), 'idonatepatient_bloodneed', true);
			$units     		= get_post_meta(get_the_ID(), 'idonatepatient_bloodunit', true);
			$mobnumber     	= get_post_meta(get_the_ID(), 'idonatepatient_mobnumber', true);
			$email     		= get_post_meta(get_the_ID(), 'email', true);
			$purpose     	= get_post_meta(get_the_ID(), 'idonatepurpose', true);
			$hospital     	= get_post_meta(get_the_ID(), 'idonatehospital_name', true);
			$statecode     	= get_post_meta(get_the_ID(), 'idonatestate', true);
			$city     		= get_post_meta(get_the_ID(), 'idonatecity', true);
			$location     	= get_post_meta(get_the_ID(), 'idonateaddress', true);
			$countrycode    = get_post_meta(get_the_ID(), 'idonatecountry', true);
			$details 		= get_post_meta(get_the_ID(), 'idonatedetails', true);
			$permalink 		= get_the_permalink(get_the_permalink(get_the_ID()));
	?>
			<div class="ta-container">
				<div class="ta-row align-items-center">
					<div class="ta-col-xs-1 ta-col-sm-1 ta-col-md-6 ta-col-lg-6 ta-col-xl-3 p-0">
						<?php
						if ($image) {
							echo wp_kses_post($image);
						} else {
							echo '<img src="' . esc_url(IDONATE_DIR_URL) . 'src/assets/images/request.jpg"  alt="' . esc_html__('request image', 'idonate') . '"/>';
						}
						?>
					</div>
					<div class="ta-col-xs-1 ta-col-sm-1 ta-col-md-6 ta-col-lg-6 ta-col-xl-2-3 p-0">
						<div class="request_info_wrapper">
							<div class="request_info text-left">
								<?php
								// Title
								if (get_the_title()) {
									echo '<h2>' . esc_html(get_the_title()) . '</h2>';
								}
								// Post Date
								if (get_the_date()) {
									echo '<p>' . esc_html__(' Post Date:', 'idonate') . ' ' . esc_html(get_the_date()) . '</p>';
								}
								// Post Details
								if ($details) {
									echo '<p>' . esc_html($details) . '</p>';
								}
								?>
							</div>
							<div class="infotable">
								<div class="table-responsive">
									<table class="table table-bordered">
										<?php
										// Name
										if ($name) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Patient Name', 'idonate'), $name));
										}
										// Age
										if ($age) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Patient Age', 'idonate'), $age));
										}
										// Blood Group
										if ($bgroup) {
											echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('Blood Group', 'idonate'), $bgroup));
										}
										// When Need Blood ?
										if ($need) {
											echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('When Need Blood ?', 'idonate'), $need));
										}
										// Blood Units
										if ($units) {
											echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('Blood Unit / Bag (S)', 'idonate'), $units));
										}
										// Purpose
										if ($purpose) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Purpose', 'idonate'), $purpose));
										}
										// Mobile Number
										if ($mobnumber) {
											echo wp_kses_post(idonate_blood_request_table('table-danger', esc_html__('Mobile Number', 'idonate'), $mobnumber));
										}
										// Email
										if ($email) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Email', 'idonate'), $email));
										}
										// Hospital Name
										if ($hospital) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Hospital Name', 'idonate'), $hospital));
										}
										// Country
										$country = Countries::idonate_country_name_by_code($countrycode);

										if ($country) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Country', 'idonate'), $country));
										}
										// State
										$state = Countries::idonate_states_name_by_code($countrycode, $statecode);
										if ($state) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('State', 'idonate'), $state));
										}
										// City
										if ($city) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('City', 'idonate'), $city));
										}
										// Location/Address
										if ($location) {
											echo wp_kses_post(idonate_blood_request_table('table-info', esc_html__('Address', 'idonate'), $location));
										}

										?>
									</table>
								</div>
								<?php
								// Social share
								SocialShare::idonate_social_sharing_buttons($name, $permalink, $donor_social_share);
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php
		endwhile;
	endif;
	?>
</div>

<?php
Helpers::idonate_custom_footer();