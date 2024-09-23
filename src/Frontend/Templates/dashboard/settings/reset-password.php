<?php

/**
 * Reset password
 *
 * @package Idonate
 * @subpackage Dashboard\Settings
 * @author ThemeAtelier<themeatelierbd@gmail.com>
 * @link https://themeum.com
 * @version 1.4.3
 */

use ThemeAtelier\Idonate\Helpers\DonorFunctions;

$userID         = get_current_user_id();
$userData       = get_userdata($userID);
$options        = get_option('idonate_settings');
$donor_peft     = isset($options['donor_peft']) ? $options['donor_peft'] : '';

$msg = '';
if (isset($_POST['donor_submit'])) {
	$res = DonorFunctions::idonate_donor_password();
	$msg =  DonorFunctions::idonate_response_msg($res, 'update');
}
?>

<div class="idonate">
	<div class="idonate__wrapper">
		<h3 class="dashboard_content_title"><?php echo esc_html__('Password', 'idonate'); ?></h3>
		<?php
		idonate_load_template('dashboard.settings.nav-bar', array('active_setting_nav' => 'reset_password'));
		?>
		<div class="request-form">
			<div id="donorPanelForm">
				<?php
				echo wp_kses_post($msg);
				?>
				<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
					<div id="password" class="tabcontent">
						<div class="idonate_row idonate_col">
							<div class="idonate_col_item">
								<label><?php esc_html_e('New Password', 'idonate'); ?></label>
								<input id="password" name="password" class="form-control" placeholder="<?php echo esc_attr('New Password', 'idonate') ?>" type="password">
							</div>
							<div class="idonate_col_item">
								<label><?php esc_html_e('Re-type New Password', 'idonate'); ?></label>
								<input id="retypepassword" name="retypepassword" class="form-control" placeholder="<?php echo esc_attr('Re-type New Password', 'idonate') ?>" type="password">
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