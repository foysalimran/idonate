<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

use ThemeAtelier\Idonate\Helpers\TaT_Donor;
use ThemeAtelier\Idonate\Helpers\DonorFunctions;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;

$obj = new TaT_Donor();
?>

<div class="donor-panel">
	<?php
	// Response
	if (isset($_POST['donor_submit'])) {
		$res = DonorFunctions::idonate_donor_add();
		echo wp_kses_post(DonorFunctions::idonate_response_msg($res, 'add'));
	}
	if (isset($_POST['donorupdate_submit'])) {
		$res = DonorFunctions::idonate_donor_edit();
		echo wp_kses_post(DonorFunctions::idonate_response_msg($res, 'update'));
	}

	if (isset($_GET['action'])) {
		echo wp_kses_post(DonorFunctions::idonate_response_msg(intval($_GET['action']), 'delete'));
	}

	$options = get_option('idonate_settings');
	?>
	<div class="admin-donor-add">
		<div id="donor_form_popup">
			<div id="donorPanelForm">
				<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
					<div class="close" onclick="div_hide()">X</div>
					<h3><?php esc_html_e('Blood Donors Register ', 'idonate'); ?></h3>
					<hr>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="full_name"><?php esc_html_e('Full Name', 'idonate'); ?></label>
							<input id="full_name" title="<?php esc_html_e('Full Name field can\'t be empty.', 'idonate') ?>" name="full_name" placeholder="<?php esc_attr_e('Name', 'idonate') ?>" type="text" required>
						</div>
						<div class="idonate_col_item">
							<label for="user_name"><?php esc_html_e('User Name', 'idonate'); ?></label>
							<input id="user_name" title="<?php esc_html_e('User Name field can\'t be empty.', 'idonate') ?>" name="user_name" placeholder="<?php esc_attr_e('User Name', 'idonate'); ?>" type="text" required>
						</div>
					</div>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="email"><?php esc_html_e('E-Mail ID', 'idonate'); ?></label>
							<input id="email" title="<?php esc_html_e('Enter a valid email address.', 'idonate') ?>" name="email" placeholder="<?php esc_attr_e('E-Mail', 'idonate'); ?>" type="email" required>
						</div>
						<div class="idonate_col_item">
							<label for="bloodgroup"><?php esc_html_e('Blood Group', 'idonate'); ?></label>
							<select id="bloodgroup" name="bloodgroup">
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
							<label for="gender"><?php esc_html_e('Gender', 'idonate'); ?></label>
							<select id="gender" class="form-control gender" name="gender">
								<option value="Male"><?php esc_html_e('Male', 'idonate'); ?></option>
								<option value="Female"><?php esc_html_e('Female', 'idonate'); ?></option>
								<option value="Other"><?php esc_html_e('Other', 'idonate'); ?></option>
							</select>
						</div>
					</div>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="datebirth"><?php esc_html_e('Date Of Birth', 'idonate'); ?></label>
							<input id="datebirth" title="<?php esc_html_e('Date of birth field can\'t be empty.', 'idonate') ?>" name="date_birth" class="form-control" placeholder="<?php esc_html_e('Date Of Birth', 'idonate'); ?>" type="date" required>
						</div>
						<div class="idonate_col_item">
							<label for="mobile"><?php esc_html_e('Mobile Number', 'idonate'); ?></label>
							<input id="mobile" title="<?php esc_html_e('Mobile Number field can\'t be empty.', 'idonate') ?>" name="mobile" placeholder="<?php esc_attr_e('Mobile Number', 'idonate'); ?>" type="text" required>
						</div>
					</div>
					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="landline"><?php esc_html_e('Land Line Number', 'idonate'); ?></label>
							<input id="landline" name="landline" placeholder="<?php esc_attr_e('Land Line Number', 'idonate'); ?>" type="text">
						</div>
						<div class="idonate_col_item">
							<label for="city"><?php esc_html_e('City', 'idonate'); ?></label>
							<input id="city" title="<?php esc_html_e('City field can\'t be empty.', 'idonate') ?>" name="city" placeholder="<?php esc_attr_e('City', 'idonate'); ?>" type="text" required>
						</div>
					</div>

					<div class="idonate_row idonate_col">
						<?php if (!$options['enable_single_country'] || empty($options['idonate_country'])) : ?>
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
							<label for="address"><?php esc_html_e('Address', 'idonate'); ?></label>
							<textarea id="address" rows="4" title="<?php esc_html_e('Please select your address.', 'idonate') ?>" name="address" class="form-control" required></textarea>
						</div>
					</div>

					<div class="idonate_row idonate_col">
						<div class="idonate_col_item">
							<label for="password"><?php esc_html_e('Password', 'idonate'); ?></label>
							<input id="password" title="<?php esc_html_e('Password field can\'t be empty.', 'idonate') ?>" name="password" placeholder="<?php esc_attr_e('Password', 'idonate'); ?>" type="password" required>
						</div>
						<div class="idonate_col_item">
							<label for="retypepassword"><?php esc_html_e('Re-type Password', 'idonate'); ?></label>
							<input id="retypepassword" title="<?php esc_html_e('Retype password field can\'t be empty.', 'idonate') ?>" name="retypepassword" placeholder="<?php esc_attr_e('Re-type Password', 'idonate'); ?>" type="password" required>
						</div>
					</div>
					<div class="idonate_row idonate_col">

						<div class="idonate_col_item">
							<label for="profilepic"><?php esc_html_e('Upload Profile Picture', 'idonate'); ?></label>
							<input id="profilepic" type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />
							<img class="upload-preview" src="<?php echo esc_url(IDONATE_DIR_URL) ?>src/assets/images/idonate-preview-image.jpg" alt="<?php esc_html_e('your image', 'idonate') ?>" />
						</div>
					</div>
					<?php
					// WP Nonce
					wp_nonce_field('request_nonce_action', 'request_submit_nonce_check');
					?>
					<input class="submit" type="submit" name="donor_submit" value="<?php echo esc_attr('Submit', 'idonate') ?>" />
				</form>
			</div>
		</div>
		<button id="popup" onclick="div_show()"><?php esc_html_e('Add New', 'idonate'); ?></button>

	</div>
	<table id="table_id" class="display">
		<thead>
			<tr>
				<th><?php esc_html_e('ID', 'idonate'); ?></th>
				<th><?php esc_html_e('Name', 'idonate'); ?></th>
				<th><?php esc_html_e('Blood Group', 'idonate'); ?></th>
				<th><?php esc_html_e('Availability', 'idonate'); ?></th>
				<th><?php esc_html_e('Mobile No', 'idonate'); ?></th>
				<th><?php esc_html_e('State', 'idonate'); ?></th>
				<th><?php esc_html_e('Action', 'idonate'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$args = array(
				'role'    => 'donor',
				'orderby' => 'registered',
				'order'   => 'DESC' // Use 'ASC' for ascending order
			);
			$users = get_users($args);

			$i = 0;
			foreach ($users as $user) :
				$countrycode = get_user_meta($user->ID, 'idonate_donor_country', true);
				$stateCode = get_user_meta($user->ID, 'idonate_donor_state', true);

				$statename = Countries::idonate_states_name_by_code($countrycode, $stateCode);

			?>
				<tr>
					<td><?php echo esc_html($i); ?></td>
					<td><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_full_name', true)); ?></td>
					<td><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_bloodgroup', true)); ?></td>
					<td><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_availability', true)); ?></td>
					<td><?php echo esc_html(get_user_meta($user->ID, 'idonate_donor_mobile', true)); ?></td>
					<td><?php echo esc_html($statename); ?></td>
					<td>
						<a class="idonate_button dedit" onclick="div_donor_show()" data-donor-view="1" data-donor-id="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html('View', 'idonate') ?></a>
						<a class="idonate_button dedit" onclick="div_donor_show()" data-donor-edit="1" data-donor-id="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html('Edit', 'idonate') ?></a>
						<a class="idonate_button dedit" onclick="div_donor_show()" data-donor-delete="1" data-donor-id="<?php echo esc_attr($user->ID); ?>"><?php echo esc_html('Delete', 'idonate') ?></a>
					</td>
				</tr>
			<?php
				$i++;
			endforeach;
			?>
		</tbody>
	</table>
</div>