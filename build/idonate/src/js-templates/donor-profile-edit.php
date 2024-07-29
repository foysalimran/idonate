<?php

use ThemeAtelier\Idonate\Helpers\Countries\Countries;

$generalOpt = get_option('idonate_settings');
?>
<!-- Contact Us Form -->
<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
	<h3><?php esc_html_e('Donor Edit', 'idonate'); ?></h3>
	<hr>

	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<label for="full_name"><?php esc_html_e('Full Name', 'idonate'); ?></label>
			<input id="full_name" name="full_name" value="{{data.full_name}}" placeholder="<?php esc_attr_e('Name', 'idonate') ?>" type="text">
		</div>
		<div class="idonate_col_item">
			<label for="user_name"><?php esc_html_e('User Name', 'idonate'); ?></label>
			<input id="user_name" name="user_name" value="{{data.user_name}}" placeholder="<?php esc_attr_e('User Name', 'idonate') ?>" type="text" readonly>
		</div>

	</div>
	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<label for="email"><?php esc_html_e('E-Mail ID', 'idonate'); ?></label>
			<input id="email" name="email" value="{{data.email}}" placeholder="<?php esc_attr_e('E-Mail', 'idonate') ?>" type="text">
		</div>
		<div class="idonate_col_item" data-select="{{data.bloodgroup}}">
			<label for="bloodgroup"><?php esc_html_e('Blood Group', 'idonate'); ?></label>
			<select id="bloodgroup" class="form-control" name="bloodgroup">
				<option value=""><?php esc_html_e('-----Select-----', 'idonate'); ?></option>
				<?php
				$GetBloodGroup = idonate_blood_group();
				$options = '';
				foreach ($GetBloodGroup as $bloodgroup) {

					$options .= '<option value="' . esc_attr($bloodgroup) . '">' . esc_html($bloodgroup) . '</option>';
				}
				$allowed_html = array(
					'option' => array(
						'value' => array(),
						'selected' => array(),  // Allow the selected attribute
					),
				);
				echo wp_kses($options, $allowed_html);
				?>
			</select>
		</div>
	</div>
	<div class="idonate_row idonate_col">
		<div class="idonate_col_item" data-select="{{data.availability}}">
			<label for="availability"><?php esc_html_e('Availability to donate blood', 'idonate'); ?></label>
			<select id="availability" class="form-control" name="availability">
				<option value=""><?php esc_html_e('-----Select-----', 'idonate'); ?></option>
				<option value="available"><?php esc_html_e('Available', 'idonate'); ?></option>
				<option value="unavailable"><?php esc_html_e('Unavailable', 'idonate'); ?></option>
			</select>
		</div>
		<div class="idonate_col_item">
			<label for="gender"><?php esc_html_e('Gender', 'idonate'); ?></label>
			<select id="gender" class="form-control gender" name="gender" data-select="{{data.gender}}">
				<option value="Male" <?php echo "{{data.gender == 'Male' ? 'selected' : '' }}" ?>><?php esc_html_e('Male', 'idonate'); ?></option>
				<option value="Female" <?php echo "{{data.gender == 'Female' ? 'selected' : '' }}" ?>><?php esc_html_e('Female', 'idonate'); ?></option>
				<option value="Other" <?php echo "{{data.gender == 'Other' ? 'selected' : '' }}" ?>><?php esc_html_e('Other', 'idonate'); ?></option>
			</select>
		</div>
	</div>
	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<label for="datebirthedit"><?php esc_html_e('Date Of Birth', 'idonate'); ?></label>

			<input id="datebirthedit" name="date_birth" value="{{data.date_birth}}" class="form-control" placeholder="<?php esc_attr_e('Date Of Birth', 'idonate'); ?>" type="text">
		</div>
		<div class="idonate_col_item">
			<label for="mobile"><?php esc_html_e('Mobile Number', 'idonate'); ?></label>
			<input id="mobile" name="mobile" placeholder="<?php esc_attr_e('Mobile Number', 'idonate'); ?>" value="{{data.mobile}}" type="text">
		</div>
	</div>
	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<label for=landline><?php esc_html_e('Land Line Number', 'idonate'); ?></label>
			<input id="landline" name="landline" placeholder="<?php esc_attr_e('Land Line Number', 'idonate'); ?>" value="{{data.landline}}" type="text">
		</div>
		<div class="idonate_col_item">
			<label for="city"><?php esc_html_e('City', 'idonate'); ?></label>
			<input id="city" name="city" value="{{data.city}}" placeholder="<?php esc_attr_e('City', 'idonate') ?>" type="text">
		</div>
	</div>

	<div class="idonate_row idonate_col">
		<div class="idonate_col_item" data-select="{{data.contycode}}">
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
		<div class="idonate_col_item" data-select="{{data.statecode}}">
			<label for="state"><?php esc_html_e('Select State', 'idonate'); ?></label>
			<select class="form-control state" name="state">
				<option><?php esc_html_e('Select Country First', 'idonate'); ?></option>
			</select>
		</div>
	</div>


	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<label for="address"><?php esc_html_e('Address', 'idonate'); ?></label>
			<textarea id="address" rows="4" name="address" class="form-control">{{data.address}}</textarea>
		</div>
	</div>

	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<label for="password"><?php esc_html_e('New Password', 'idonate'); ?></label>
			<input id="password" name="newpassword" placeholder="<?php esc_attr_e('New Password', 'idonate') ?>" type="text">
		</div>
		<div class="idonate_col_item">
			<label for="retypepassword"><?php esc_html_e('Re-type New Password', 'idonate'); ?></label>
			<input id="retypepassword" name="retypenewpassword" placeholder="<?php esc_attr_e('Re-type New Password', 'idonate') ?>" type="text">
		</div>
	</div>
	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<label for="fburl"><?php esc_html_e('Facebook Url', 'idonate'); ?></label>
			<input id="fburl" value="{{data.fburl}}" name="fburl" placeholder="<?php esc_attr_e('Facebook Url', 'idonate') ?>" type="text">
		</div>
		<div class="idonate_col_item">
			<label for="twitterurl"><?php esc_html_e('Twitter Url', 'idonate'); ?></label>
			<input id="twitterurl" value="{{data.twitterurl}}" name="twitterurl" placeholder="<?php esc_attr_e('Twitter Url', 'idonate') ?>" type="text">
		</div>
	</div>
	<div class="idonate_row idonate_col">
		<div class="idonate_col_item">
			<# var img='<?php echo esc_url(IDONATE_DIR_URL) . 'src' ?>/assets/images/idonate-preview-image.jpg' ; if( data.profilepic ){ img=data.profilepic } #>

				<label for="availability"><?php esc_html_e('Upload Profile Picture', 'idonate'); ?></label>
				<input id="availability" type='file' class="profilepic" name="profileimg" data-target=".upload-preview" />

				<img class="upload-preview" src="{{img}}" alt="<?php esc_attr_e('Profile pic', 'idonate') ?>" />
		</div>
	</div>
	<?php
	// WP Nonce
	wp_nonce_field('request_nonce_action', 'request_submit_nonce_check');
	?>
	<input type="hidden" name="donor_id" value="{{data.id}}" />
	<input class="submit" type="submit" name="donorupdate_submit" value="<?php esc_attr_e('Submit', 'idonate') ?>" />
</form>