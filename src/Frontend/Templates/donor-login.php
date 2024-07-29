<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

idonate_is_user_logged_in();
$options = get_option('idonate_settings');

get_header();

?>
<div class="idonate login section-padding">
	<div class="ta-container">
		<div class="ta-row">
			<div class="ta-col-xl-3 mx-auto">
				<div class="request-form">
					<div id="donorPanelForm" class="idonate-login">
						<h3><?php echo esc_html__('Donor Login', 'idonate'); ?></h3>
						<hr>
						<?php
						$args = array(
							'id_username' => 'user',
							'id_password' => 'pass',
						);
						wp_login_form($args);
						?>
						<br>
						<p><?php echo esc_html__('Don\'t have an account?', 'idonate');?> <a href="<?php echo esc_url(site_url('/donor-register'));?>"><?php echo esc_html__('Register Now'); ?></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
