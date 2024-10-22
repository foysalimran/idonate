<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

namespace ThemeAtelier\Idonate\Frontend\Shortcode;

use ThemeAtelier\Idonate\Helpers\DonorFunctions;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}
class ShortcodeRegisterDonor
{
	public function shortcode_register_donor()
	{
		$options = get_option('idonate_settings');
		$form_title = isset($options['donor_register_form_title']) ? $options['donor_register_form_title'] : '';
		$form_subtitle = isset($options['donor_register_form_subtitle']) ? $options['donor_register_form_subtitle'] : '';
		$idonate_recaptcha_active = isset($options['idonate_recaptcha_active']) ? $options['idonate_recaptcha_active'] : '';
		$sitekey = $options['idonate_recaptcha_sitekey'] ? $options['idonate_recaptcha_sitekey'] : '';
		$idonate_countryhide = isset($options['idonate_countryhide']) ? $options['idonate_countryhide'] : '';

		ob_start();
?>
		<div class="idonate donor_register">

			<div class="request-form">
				<div class="submit-info">
					<?php
					echo '<h2>' . esc_html__('Blood Donors Register', 'idonate') . '</h2>';
					echo '<p>' . esc_html__('Please fill the following information to register donor.', 'idonate') . '</p>';
					?>
					<hr>
				</div>

				<div id="donorPanelForm">
					<!-- Contact Us Form -->
					<?php
					if (isset($_POST['donor_submit'])) {
						$res = DonorFunctions::idonate_donor_add();
						echo wp_kses_post(DonorFunctions::idonate_response_msg($res, 'add'));
					}
					?>
					<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<label for="full_name"><?php esc_html_e('Full Name', 'idonate'); ?></label>
								<input id="full_name" title="<?php esc_html_e('Full Name field can\'t be empty.', 'idonate') ?>" name="full_name" class="form-control" placeholder="<?php esc_html_e('Name', 'idonate'); ?>" type="text" required>
							</div>
							<div class="idonate_col_item">
								<label for="user_name"><?php esc_html_e('User Name', 'idonate'); ?></label>
								<input id="user_name" title="<?php esc_html_e('User Name field can\'t be empty.', 'idonate') ?>" name="user_name" class="form-control" placeholder="<?php esc_html_e('User Name', 'idonate'); ?>" type="text" required>
							</div>
						</div>
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<label for="email"><?php esc_html_e('E-Mail ID', 'idonate'); ?></label>
								<input id="email" title="<?php esc_html_e('Enter a valid email address.', 'idonate') ?>" name="email" class="form-control" placeholder="<?php esc_html_e('E-Mail', 'idonate'); ?>" type="email" required>
							</div>
							<div class="idonate_col_item">
								<label for=""><?php esc_html_e('Blood Group', 'idonate'); ?></label>
								<select id="bloodgroup" class="form-control" name="bloodgroup">
									<option value=""><?php esc_html_e('-----Select-----', 'idonate'); ?></option>
									<?php
									$GetBloodGroup = idonate_blood_group();
									$selectOptions = '';
									foreach ($GetBloodGroup as $bloodgroup) {
										$selectOptions .= '<option value="' . esc_attr($bloodgroup) . '">' . esc_html($bloodgroup) . '</option>';
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
								<label for="availability"><?php esc_html_e('Availability to donate blood', 'idonate'); ?></label>
								<select id="availability" class="form-control" name="availability">
									<option value=""><?php esc_html_e('-----Select-----', 'idonate'); ?></option>
									<option value="available"><?php esc_html_e('Available', 'idonate'); ?></option>
									<option value="unavailable"><?php esc_html_e('Unavailable', 'idonate'); ?></option>
								</select>
							</div>
							<div class="idonate_col_item">
								<label for="datebirth"><?php esc_html_e('Date Of Birth', 'idonate'); ?></label>
								<input id="datebirth" title="<?php esc_html_e('Date of birth field can\'t be empty.', 'idonate') ?>" name="date_birth" class="form-control" placeholder="<?php esc_html_e('Date Of Birth', 'idonate'); ?>" type="date" required>
							</div>
						</div>
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<label for="mobile"><?php esc_html_e('Mobile Number', 'idonate'); ?></label>
								<input id="mobile" title="<?php esc_html_e('Mobile Number field can\'t be empty.', 'idonate') ?>" name="mobile" placeholder="<?php esc_attr_e('Mobile Number', 'idonate'); ?>" type="text" required>
							</div>
							<div class="idonate_col_item">
								<label for="landline"><?php esc_html_e('Land Line Number', 'idonate'); ?></label>
								<input id="landline" name="landline" placeholder="<?php esc_attr_e('Land Line Number', 'idonate'); ?>" type="text">
							</div>
						</div>
						<?php
						if ($idonate_countryhide) :
							$enable_single_country = isset($options['enable_single_country']) ? $options['enable_single_country'] : false;
							$idonate_country = isset($options['idonate_country']) ? $options['idonate_country'] : '';

						?>
							<div class="idonate_row idonate_col">
								<?php if (!$enable_single_country || ($idonate_country == '')) : ?>
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
											echo wp_kses(Countries::IDONATE_COUNTRIES_options(), $allowed_html);
											?>
										</select>
									</div>
								<?php endif; ?>
								<div class="idonate_col_item">
									<label for="state"><?php esc_html_e('Select State', 'idonate'); ?></label>
									<select class="form-control state" name="state">
										<?php if (!$enable_single_country || ($idonate_country == '')) : ?>
											<option><?php esc_html_e('Select Country First', 'idonate'); ?></option>
										<?php else : ?>
											<option><?php esc_html_e('Select State', 'idonate'); ?></option>
										<?php
											$path = IDONATE_COUNTRIES . 'states/' . $options['idonate_country'] . '.php';
											include($path);
											global $states;
											foreach ($states as $key => $state) {
												foreach ($state as $key => $value) {
													echo '<option value="' . $key . '">' . $value . '</option>';
												}
											}
										endif;
										?>

									</select>
								</div>
							</div>
						<?php
						endif;
						?>
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<div class="dp-col-12">
									<label for="city"><?php esc_html_e('City', 'idonate'); ?></label>
									<input id="city" title="<?php esc_html_e('City field can\'t be empty.', 'idonate') ?>" name="city" class="form-control" placeholder="<?php esc_html_e('City', 'idonate'); ?>" type="text" required>
								</div>
							</div>
						</div>
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<div class="dp-col-12">
									<label for="address"><?php esc_html_e('Address', 'idonate'); ?></label>
									<textarea id="address" rows="4" title="<?php esc_html_e('Please select your address.', 'idonate') ?>" name="address" class="form-control" required></textarea>
								</div>
							</div>
						</div>
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<label for="password"><?php esc_html_e('Password', 'idonate'); ?></label>
								<input id="password" title="<?php esc_html_e('Password field can\'t be empty.', 'idonate') ?>" name="password" class="form-control" placeholder="<?php esc_html_e('Password', 'idonate'); ?>" type="password" required>
							</div>
							<div class="idonate_col_item">
								<label for="retypepassword"><?php esc_html_e('Re-type Password', 'idonate'); ?></label>
								<input id="retypepassword" title="<?php esc_html_e('Retype password field can\'t be empty.', 'idonate') ?>" name="retypepassword" class="form-control" placeholder="<?php esc_html_e('Re-type Password', 'idonate'); ?>" type="password" required>
							</div>
						</div>
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<label for="profilepic"><?php esc_html_e('Upload Profile Picture', 'idonate'); ?></label>
								<input id="profilepic" type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />
								<img class="upload-preview" src="<?php echo esc_url(IDONATE_DIR_URL) ?>src/assets/images/idonate-preview-image.jpg" alt="<?php esc_html_e('your image', 'idonate') ?>" />
							</div>
						</div>
						<div class="idonate_row idonate_col">

							<div class="idonate_col_item">
								<?php
								if ($idonate_recaptcha_active) {
									$recaptchaLabel = $options['idonate_recapthca_label'] ? $options['idonate_recapthca_label'] : '';
									if ($recaptchaLabel) {
								?>
										<label for="recaptcha"><?php echo esc_html($recaptchaLabel); ?></label>
								<?php
									}
									echo '<div class="g-recaptcha" data-sitekey="' . esc_attr($sitekey) . '"></div></div>';
								}
								?>
							</div>
							<?php
							// WP Nonce
							wp_nonce_field('request_nonce_action', 'request_submit_nonce_check');
							?>
							<div class="idonate_row idonate_col justify-end">
								<div class="submit_button">
									<input class="submit register_donor" type="submit" name="donor_submit" value="<?php echo esc_attr('Submit', 'idonate'); ?>" />
								</div>
							</div>
					</form>
				</div>
			</div>
		</div>
		</div>

<?php

		return ob_get_clean();
	}
}
