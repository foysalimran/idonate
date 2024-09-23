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

use ThemeAtelier\Idonate\Helpers\Helpers;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}


$userID 	= get_current_user_id();
$user   	= get_user_by('ID', $userID);
$userData 	= get_userdata($userID);
$countrycode = get_user_meta($userID, 'idonate_donor_country', true);
$statecode  = get_user_meta($userID, 'idonate_donor_state', true);
$country = Countries::idonate_country_name_by_code($countrycode);
$state = Countries::idonate_states_name_by_code($countrycode, $statecode);

?>
<div class="idonate">
	<div class="idonate__wrapper">
		<h3 class="dashboard_content_title"><?php echo esc_html__('My Profile', 'idonate'); ?></h3>
		<div class="donor-profile">

			<div class="donor-img">
				<?php
				echo Helpers::get_idonate_avatar($user, 'xl')
				?>
			</div>
			<div class="personal-info">
				<?php
				$full_name = get_user_meta($userID, 'idonate_donor_full_name', true);
				$mobile = get_user_meta($userID, 'idonate_donor_mobile', true);
				$availability = get_user_meta($userID, 'idonate_donor_availability', true);
				$bloodgroup = get_user_meta($userID, 'idonate_donor_bloodgroup', true);
				$lastdonate = get_user_meta($userID, 'idonate_donor_lastdonate', true);
				$gender = get_user_meta($userID, 'idonate_donor_gender', true);
				$dob = get_user_meta($userID, 'idonate_donor_date_birth', true);
				$landline = get_user_meta($userID, 'idonate_donor_landline', true);
				$city = get_user_meta($userID, 'idonate_donor_city', true);
				$address = get_user_meta($userID, 'idonate_donor_address', true);
				$userName = $userData->user_login;

				echo '<ul>';
				if ($full_name) {
					echo '<li><strong>' . esc_html__('Name:', 'idonate') . ' </strong>' . esc_html($full_name) . '</li>';
				}
				if ($userName) {
					echo '<li><strong>' . esc_html__('User Name:', 'idonate') . ' </strong>' . esc_html($userName) . '</li>';
				}
				if ($userData->user_email) {
					echo '<li><strong>' . esc_html__('Email:', 'idonate') . ' </strong>' . esc_html($userData->user_email) . '</li>';
				}
				if ($mobile) {
					echo '<li><strong>' . esc_html__('Mobile:', 'idonate') . ' </strong>' . esc_html($mobile) . '</li>';
				}
				if ($availability) {
					echo '<li><strong>' . esc_html__('Availability:', 'idonate') . ' </strong>' . esc_html($availability) . '</li>';
				}
				if ($bloodgroup) {
					echo '<li><strong>' . esc_html__('Blood group:', 'idonate') . ' </strong>' . esc_html($bloodgroup) . '</li>';
				}
				if ($lastdonate) {
					echo '<li><strong>' . esc_html__('Last Donate:', 'idonate') . ' </strong>' . esc_html($lastdonate) . '</li>';
				}
				if ($gender) {
					echo '<li><strong>' . esc_html__('Gender:', 'idonate') . ' </strong>' . esc_html($gender) . '</li>';
				}
				if ($dob) {
					echo '<li><strong>' . esc_html__('Date Of Birth:', 'idonate') . ' </strong>' . esc_html($dob) . '</li>';
				}
				if ($landline) {
					echo '<li><strong>' . esc_html__('Land Line Number:', 'idonate') . ' </strong>' . esc_html($landline) . '</li>';
				}
				if ($country) {
					echo '<li><strong>' . esc_html__('Country:', 'idonate') . ' </strong>' . esc_html($country) . '</li>';
				}
				if ($state) {
					echo '<li><strong>' . esc_html__('State:', 'idonate') . ' </strong>' . esc_html($state) . '</li>';
				}
				if ($city) {
					echo '<li><strong>' . esc_html__('City:', 'idonate') . ' </strong>' . esc_html($city) . '</li>';
				}
				if ($address) {
					echo '<li><strong>' . esc_html__('Address:', 'idonate') . ' </strong>' . esc_html($address) . '</li>';
				}
				echo '</ul>'
				?>
			</div>
			<?php
			$fb = get_user_meta($userID, 'idonate_donor_fburl', true);
			$twitter = get_user_meta($userID, 'idonate_donor_twitterurl', true);
			$linkedin = get_user_meta($userID, 'idonate_donor_linkedin', true);
			$website = get_user_meta($userID, 'idonate_donor_website', true);
			?>
			<?php
			if ($fb || $twitter || $linkedin || $website) :
			?>
				<p class="social-icon"><strong><?php esc_html_e('Social Media :', 'idonate'); ?></strong>
					<?php
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
				</p>
			<?php
			endif;
			?>
		</div>
	</div>
</div>