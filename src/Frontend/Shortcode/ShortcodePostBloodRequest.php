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

use ThemeAtelier\Idonate\Helpers\Countries\Countries;
use ThemeAtelier\Idonate\Frontend\Helpers\FormDataHandle;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

class ShortcodePostBloodRequest
{
	public function shortcode_post_blood_request()
	{
		if (isset($_POST['request_submit'])) {
			$message = FormDataHandle::idonate_blood_request_form_handel();
		} else {
			$message = '';
		}
		$options = get_option('idonate_settings');

		ob_start();
?>
		<section class="idonate request-form-page">

			<div class="request-form">
				<?php

				$html = '<div class="submit-info">';
				// Title
				$html .= '<h2>' . esc_html__('Submit Your Request', 'idonate') . '</h2>';
				// Sub title
				$html .= '<p>' . esc_html__('Please fill the following information to post your blood request.', 'idonate') . '</p>';
				$html .= '<hr />';
				$html .= '</div>';
				echo wp_kses_post($html);

				// Form Submit confirmation message
				if ($message) {
					echo '<div id="idonate-response-msg">';
					echo '<span class="text-center idonate-alert idonate-alert-success">';
					echo wp_kses_post($message);
					echo '</span>';
					echo '</div>';
				}
				?>

				<form action="" id="blood-request" method="post" enctype="multipart/form-data">
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="requesttitle"><?php esc_html_e('Title', 'idonate'); ?></label>
							<input type="text" title="<?php esc_html_e('Title field can\'t be empty.', 'idonate') ?>" class="form-control" name="title" id="requesttitle" placeholder="<?php esc_html_e('Title', 'idonate'); ?>" required>
						</div>
						<div class="idonate_col_item">
							<label for="purpose"><?php esc_html_e('Purpose', 'idonate'); ?></label>
							<input type="text" class="form-control" id="purpose" name="purpose" placeholder="<?php esc_html_e('Purpose', 'idonate'); ?>">
						</div>
					</div>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="bloodunits"><?php esc_html_e('Blood Unit / Bag (S)', 'idonate'); ?></label>
							<input type="number" title="<?php esc_html_e('Please enter blood unite / bag (s).', 'idonate') ?>" class="form-control" id="bloodunits" name="bloodunits" placeholder="<?php esc_html_e('Blood Units', 'idonate'); ?>" required>
						</div>
						<div class="idonate_col_item">
							<label for="bloodgroup"><?php esc_html_e('Blood Group', 'idonate'); ?></label>
							<select title="<?php esc_html_e('Select correct blood group.', 'idonate') ?>" class="form-control" name="bloodgroup" required>
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
							<label for="needblood"><?php esc_html_e('When Need Blood?', 'idonate'); ?></label>
							<input type="date" title="<?php esc_html_e('Please enter date.', 'idonate') ?>" class="form-control date-picker" id="needblood" name="needblood" placeholder="<?php esc_html_e('When Need Blood ?', 'idonate'); ?>" required>
						</div>
						<div class="idonate_col_item">
							<label for="hospitalname"><?php esc_html_e('Hospital Name', 'idonate'); ?></label>
							<input type="text" class="form-control" id="hospitalname" name="hospitalname" placeholder="<?php esc_html_e('Hospital Name', 'idonate'); ?>">
						</div>

					</div>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="patientname"><?php esc_html_e('Patient Name', 'idonate'); ?></label>
							<input type="text" class="form-control" id="patientname" name="patientname" placeholder="<?php esc_html_e('Patient Name', 'idonate'); ?>">
						</div>
						<div class="idonate_col_item">
							<label for="patientage"><?php esc_html_e('Patient Age', 'idonate'); ?></label>
							<input type="number" class="form-control" id="patientage" name="patientage" placeholder="<?php esc_html_e('Patient age', 'idonate'); ?>">
						</div>
					</div>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="mobilenumber"><?php esc_html_e('Mobile Number', 'idonate'); ?></label>
							<input type="text" title="<?php esc_html_e('Please enter mobile number.', 'idonate') ?>" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="<?php esc_html_e('Mobile Number', 'idonate'); ?>" required>
						</div>
						<div class="idonate_col_item">
							<label for="email"><?php esc_html_e('Email', 'idonate'); ?></label>
							<input type="text" class="form-control" id="email" name="email" placeholder="<?php esc_html_e('Email', 'idonate'); ?>">
						</div>
					</div>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="location"><?php esc_html_e('City', 'idonate'); ?></label>
							<input type="text" title="<?php esc_html_e('City field can\'t be empty.', 'idonate') ?>" class="form-control" id="city" name="city" placeholder="<?php esc_html_e('City', 'idonate'); ?>" required>
						</div>
						<div class="idonate_col_item">
							<label for="location"><?php esc_html_e('Address', 'idonate'); ?></label>
							<input type="text" class="form-control" id="location" name="location" placeholder="<?php esc_html_e('Location', 'idonate'); ?>">
						</div>
					</div>
					<div class="idonate_row idonate_col">
						<?php if (!$options['enable_single_country'] || empty($options['idonate_country'])) : ?>
							<div class="idonate_col_item">
								<label for="bloodgroup"><?php esc_html_e('Country', 'idonate'); ?></label>
								<select class="form-control country" name="country">
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
							<label for="bloodgroup"><?php esc_html_e('State', 'idonate'); ?></label>
							<select class="form-control state" name="state">
								<?php if (!$options['enable_single_country'] || empty($options['idonate_country'])) : ?>
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
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="details"><?php esc_html_e('Details', 'idonate'); ?></label>
							<textarea class="form-control" name="details" rows="3" placeholder="<?php esc_html_e('Details', 'idonate'); ?>"></textarea>
						</div>
					</div>
					<?php
					// recaptcha
					if ($options['idonate_recaptcha_active']) {
						$sitekey = $options['idonate_recaptcha_sitekey'] ? $options['idonate_recaptcha_sitekey'] : '';

					?>
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<?php
								$recaptchaLabel = $options['idonate_recapthca_label'] ? $options['idonate_recapthca_label'] : '';
								if ($recaptchaLabel) {
								?>
									<label for="recaptcha"><?php echo esc_html($recaptchaLabel); ?></label>
							<?php
								}
								echo '<div class="g-recaptcha" data-sitekey="' . esc_attr($sitekey) . '"></div></div></div>';
							}
							wp_nonce_field('request_nonce_action', 'request_submit_nonce_check');
							?>
							<div class="idonate_row idonate_col">
								<button type="submit" name="request_submit" class="request_submit_button"><?php echo esc_html__('Blood Request', 'idonate'); ?></button>
							</div>
				</form>
			</div>

		</section>
<?php
		return ob_get_clean();
	}
}
