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

use ThemeAtelier\Idonate\Helpers\Countries\Countries;
use ThemeAtelier\Idonate\Helpers\DonorFunctions;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

if (!is_user_logged_in() || current_user_can('donor') != 1) {
	wp_safe_redirect(site_url());
}

$userID = get_current_user_id();
$userData = get_userdata($userID);
$options = get_option('idonate_settings');
$donor_peft = isset($options['donor_peft']) ? $options['donor_peft'] : 'Edit Donors Information';

$msg = '';
if (isset($_POST['donor_submit'])) {
	$res = DonorFunctions::idonate_donor_edit();
	$msg =  DonorFunctions::idonate_response_msg($res, 'update');
}

get_header();
?>

<div class="idonate donor_edit section-padding">
	<div class="ta-container">
		<div class="ta-row">
			<div class="ta-col-xs-1 ta-col-sm-1 ta-col-md-1 ta-col-lg-3 ta-col-xl-3">
				<div class="donor_profile_menu">
					<ul>
						<li><a href="<?php echo esc_html(idonatefile_permalink()); ?>"><?php esc_html_e('Back Profile', 'idonate'); ?></a></li>
						<li><a href="<?php echo esc_url(wp_logout_url()); ?>"><?php esc_html_e('Logout', 'idonate'); ?></a></li>
					</ul>
				</div>
			</div>
			<div class="ta-col-xs-1 ta-col-sm-1 ta-col-md-1 ta-col-lg-2-3 ta-col-xl-2-3">
				<div class="request-form">
					<div id="donorPanelForm">
						<div class="donor-edit-form-heading">
							<h3><?php echo esc_html($donor_peft); ?></h3>
						</div>
						<!-- Contact Us Form -->
						<hr>
						<?php
						echo wp_kses_post($msg);
						?>
						<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
							<div class="idonate_row idonate_col">
								<div class="idonate_col_item">
									<label for="full_name"><?php esc_html_e('Full Name', 'idonate'); ?></label>
									<input id="full_name" name="full_name" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_full_name', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Name', 'idonate') ?>" type="text">
								</div>
								<div class="idonate_col_item">
									<label><?php esc_html_e('User Name', 'idonate'); ?></label>
									<input disabled id="user_name" name="user_name" value="<?php echo esc_attr($userData->user_login); ?>" class="form-control" placeholder="<?php echo esc_attr('User Name', 'idonate') ?>" type="text">
								</div>
							</div>
							<div class="idonate_row idonate_col">
								<div class="idonate_col_item">
									<label><?php esc_html_e('E-Mail ID', 'idonate'); ?></label>
									<input id="email" name="email" value="<?php echo esc_attr($userData->user_email); ?>" class="form-control" placeholder="<?php echo esc_attr('E-Mail', 'idonate') ?>" type="text">
								</div>
								<div class="idonate_col_item">
									<label for="bloodgroup"><?php esc_html_e('Blood Group', 'idonate'); ?></label>
									<select id="bloodgroup" class="form-control" name="bloodgroup">
										<option value=""><?php esc_html_e('-----Select-----', 'idonate'); ?></option>
										<?php
										$selectedgroup = get_user_meta($userID, 'idonate_donor_bloodgroup', true);
										$GetBloodGroup = idonate_blood_group();
										$selectOptions = '';
										foreach ($GetBloodGroup as $bloodgroup) {
											if ($selectedgroup == $bloodgroup) {
												$selected = 'selected';
											} else {
												$selected = '';
											}

											$selectOptions .= '<option value="' . esc_attr($bloodgroup) . '" ' . esc_attr($selected) . '>' . esc_html($bloodgroup) . '</option>';
										}
										$allowed_html = array(
											'option' => array(
												'value' => array(),
												'selected' => array(),  // Allow the selected attribute
											),
										);
										echo wp_kses($selectOptions, $allowed_html);
										?>
									</select>
								</div>
							</div>
							<div class="idonate_row idonate_col">
								<div class="idonate_col_item">
									<label><?php esc_html_e('Availability to donate blood', 'idonate'); ?></label>
									<?php
									$selectOptions = array(
										'available' 	=> esc_html__('Available', 'idonate'),
										'unavailable' 	=> esc_html__('Unavailable', 'idonate'),
									);
									$selectedav = get_user_meta($userID, 'idonate_donor_availability', true);
									?>
									<select class="form-control" name="availability">
										<option value=""><?php esc_html_e('-----Select-----', 'idonate'); ?></option>
										<?php
										foreach ($selectOptions as $key => $option) {
											if ($selectedav == $key) {
												$selected = 'selected';
											} else {
												$selected = '';
											}
											echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_attr($option) . '</option>';
										}
										?>
									</select>
								</div>
								<div class="idonate_col_item">
									<label for="gender"><?php esc_html_e('Gender', 'idonate'); ?></label>
									<select id="gender" class="form-control gender" name="gender">
										<?php $gender = get_user_meta($userID, 'idonate_donor_gender', true); ?>
										<option value="Male" <?php selected($gender, 'Male') ?>><?php esc_html_e('Male', 'idonate'); ?></option>
										<option value="Female" <?php selected($gender, 'Female') ?>><?php esc_html_e('Female', 'idonate'); ?></option>
										<option value="Other" <?php selected($gender, 'Other') ?>><?php esc_html_e('Other', 'idonate'); ?></option>
									</select>
								</div>
							</div>
							<div class="idonate_row idonate_col">
								<div class="idonate_col_item">
									<label for="datebirth"><?php esc_html_e('Date Of Birth', 'idonate'); ?></label>
									<input id="datebirth" name="date_birth" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_date_birth', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Date Of Birth', 'idonate'); ?>" type="text">
								</div>
								<div class="idonate_col_item">
									<label for="mobile"><?php esc_html_e('Mobile Number', 'idonate'); ?></label>
									<input id="mobile" name="mobile" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_mobile', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Mobile Number', 'idonate') ?>" type="text">
								</div>
							</div>
							<div class="idonate_row idonate_col">
								<div class="idonate_col_item">
									<label for="landline"><?php esc_html_e('Land Line Number', 'idonate'); ?></label>
									<input id="landline" name="landline" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_landline', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Land Line Number', 'idonate') ?>" type="text">
								</div>
								<div class="idonate_col_item">
									<label><?php esc_html_e('Last Donate', 'idonate'); ?></label>
									<input type="date" class="form-control date-picker" id="lastdonate" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_lastdonate', true)); ?>" name="lastdonate" placeholder="<?php echo esc_attr('Last Donate Date', 'idonate'); ?>">
								</div>
							</div>
							<?php $idonate_countryhide = isset($options['idonate_countryhide']) ? $options['idonate_countryhide'] : '';
							if ($idonate_countryhide) :
							?>
								<div class="idonate_row idonate_col">
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
									<div class="idonate_col_item">
										<label for="state"><?php esc_html_e('Select State', 'idonate'); ?></label>
										<?php $stateCode = get_user_meta($userID, 'idonate_donor_state', true); ?>
										
										<?php
										$selected_country = get_user_meta($userID, 'idonate_donor_country',  true);
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

							<div class="idonate_row idonate_col">
								<div class="idonate_col_item">
									<label><?php esc_html_e('New Password', 'idonate'); ?></label>
									<input id="password" name="password" class="form-control" placeholder="<?php echo esc_attr('New Password', 'idonate') ?>" type="text">
								</div>
								<div class="idonate_col_item">
									<label><?php esc_html_e('Re-type New Password', 'idonate'); ?></label>
									<input id="retypepassword" name="retypepassword" class="form-control" placeholder="<?php echo esc_attr('Re-type New Password', 'idonate') ?>" type="text">
								</div>
							</div>
							<div class="idonate_row idonate_col">
								<div class="idonate_col_item">
									<label><?php esc_html_e('Facebook Url', 'idonate'); ?></label>
									<input id="fburl" name="fburl" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_fburl', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Facebook Url', 'idonate') ?>" type="text">
								</div>
								<div class="idonate_col_item">
									<label><?php esc_html_e('Twitter Url', 'idonate'); ?></label>
									<input id="twitterurl" name="twitterurl" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_twitterurl', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Twitter Url', 'idonate') ?>" type="text">
								</div>
							</div>
							<div class="idonate_row idonate_col">
								<div class="idonate_col_item upload-pic-area">
									<label><?php esc_html_e('Upload Profile Picture', 'idonate'); ?></label>
									<input type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />
									<?php echo wp_kses_post(idonatefile_img($userID)); ?>
								</div>
							</div>
					</div>
					<input type="hidden" value="<?php echo esc_html($userID); ?>" name="donor_id" />
					<?php
					// WP Nonce
					wp_nonce_field('request_nonce_action', 'request_submit_nonce_check');
					?>
					<input class="submit btn mt-30 btn-default btn-center" type="submit" name="donor_submit" value="<?php echo esc_attr('Submit', 'idonate') ?>" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
?>