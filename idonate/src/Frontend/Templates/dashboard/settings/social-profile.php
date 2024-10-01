<?php

/**
 * Social Profile Template
 *
 * @package Idonate
 * @subpackage Dashboard\Settings
 * @author ThemeAtelier<themeatelierbd@gmail.com>
 * @link https://themeum.com
 * @since 2.0.0
 */

 use ThemeAtelier\Idonate\Helpers\DonorFunctions;
 
 $userID         = get_current_user_id();
 $userData       = get_userdata($userID);
 $options        = get_option('idonate_settings');
 $donor_peft     = isset($options['donor_peft']) ? $options['donor_peft'] : '';
 
 $user = wp_get_current_user();
 $msg = '';
 if (isset($_POST['donor_submit'])) {
	 $res = DonorFunctions::idonate_donor_social_share();
	 $msg =  DonorFunctions::idonate_response_msg($res, 'update');
 }
?>

<div class="idonate">
	<div class="idonate__wrapper">
		<h3 class="dashboard_content_title"><?php echo esc_html__('Social Profile', 'idonate'); ?></h3>
		<?php
		idonate_load_template('dashboard.settings.nav-bar', array('active_setting_nav' => 'social-profile'));
		?>
		<div class="request-form">
	<div id="donorPanelForm">
		<?php
		echo wp_kses_post($msg);
		?>
		<form action="#" id="form" method="post" name="form" enctype="multipart/form-data">
			<div id="social_profile" class="tabcontent">
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
					<div class="idonate_col_item">
						<label><?php esc_html_e('Linkedin', 'idonate'); ?></label>
						<input id="linkedin" name="linkedin" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_linkedin', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Linkedin', 'idonate') ?>" type="text">
					</div>
					<div class="idonate_col_item">
						<label><?php esc_html_e('Website', 'idonate'); ?></label>
						<input id="website" name="website" value="<?php echo esc_attr(get_user_meta($userID, 'idonate_donor_website', true)); ?>" class="form-control" placeholder="<?php echo esc_attr('Website', 'idonate') ?>" type="text">
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