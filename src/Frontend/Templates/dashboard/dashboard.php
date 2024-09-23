<?php

/**
 * Frontend Dashboard Template
 *
 * @package Idonate\Templates
 * @subpackage Dashboard
 * @author ThemeAtelier<themeatelierbd@gmail.com>
 * @link https://themeum.com
 * @since 1.4.3
 */

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

$userID = get_current_user_id();
$bloodgroup = get_user_meta($userID, 'idonate_donor_bloodgroup', true);
$availability = get_user_meta($userID, 'idonate_donor_availability', true);
$lastdonate = get_user_meta($userID, 'idonate_donor_lastdonate', true);

?>

<div class="donor_dashboard">
	<h3><?php esc_html_e('Dashboard', 'idonate'); ?></h3>


	<div class="ta-row">
		<div class=" ta-col-sm-1 ta-col-md-2 ta-col-lg-2 ta-col-xl-3">
			<div class="idonate_card">
				<div class="idonate_card_icon">
					<i class="icofont-blood-drop"></i>
				</div>
				<div class="idonate_card_title">
					<div class="blood_group"><?php echo esc_html($bloodgroup) ?></div>
					<h4><?php echo esc_html__('Blood Group', 'idonate') ?></h4>
				</div>
			</div>
		</div>
		<div class=" ta-col-sm-1 ta-col-md-2 ta-col-lg-2 ta-col-xl-3">
			<div class="idonate_card">
				<div class="idonate_card_icon">
					<?php if ($availability == 'unavailable') {
						echo '<i class="icofont-close-circled"></i>';
					} else {
						echo '<i class="icofont-check-circled"></i>';
					}
					?>

				</div>
				<div class="idonate_card_title">
					<div class="blood_group"><?php echo esc_html($availability) ?></div>
					<h4><?php echo esc_html__('Donate Availability', 'idonate') ?></h4>
				</div>
			</div>
		</div>
		<div class=" ta-col-sm-1 ta-col-md-2 ta-col-lg-2 ta-col-xl-3">
			<div class="idonate_card">
				<div class="idonate_card_icon">
					<i class="icofont-calendar"></i>
				</div>
				<div class="idonate_card_title">
					<div class="blood_group"><?php echo esc_html($lastdonate) ?></div>
					<h4><?php echo esc_html__('Last Donate', 'idonate') ?></h4>
				</div>
			</div>
		</div>
	</div>
</div>