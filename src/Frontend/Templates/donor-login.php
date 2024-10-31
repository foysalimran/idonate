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
$donor_lft = isset($options['donor_lft']) ? $options['donor_lft'] : 'Donor Login';


use ThemeAtelier\Idonate\Helpers\Helpers;

Helpers::idonate_custom_header();

?>
<div class="idonate login section-padding">
	<div class="ta-container">
		<div class="ta-row">
			<div class="ta-col-xl-2 mx-auto">
				<div class="request-form">
					<div id="donorPanelForm" class="idonate-login">
						<h3><?php echo esc_html($donor_lft); ?></h3>
						<hr>
						<?php
						// Display error message if login failed
						if (isset($_GET['login']) && $_GET['login'] === 'failed') {
							echo '<div class="idonate-alert idonate-alert-error">' . esc_html__('Login failed. Please check your username and password.', 'idonate') . '</div>';
						}

						$args = array(
							'id_username' => 'user',
							'id_password' => 'pass',
						);
						wp_login_form($args);
						?>
						<br>
						<p><?php echo esc_html__('Don\'t have an account?', 'idonate'); ?> <a href="<?php echo esc_url(site_url('/donor-register')); ?>"><?php echo esc_html__('Register Now'); ?></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
Helpers::idonate_custom_footer();
