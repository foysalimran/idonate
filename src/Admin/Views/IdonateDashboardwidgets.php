<?php

namespace ThemeAtelier\Idonate\Admin\Views;

if (!class_exists('IdonateDashboardwidgets')) {
	class IdonateDashboardwidgets
	{

		public static function dashboard_widget_function()
		{
			// Fetch your data from the database or other source here.
			$data = [
				'total_donor' => [
					'label' => esc_html__('Total Donor(s):', 'idonate'),
					'value' => idonate_get_total_donor(),
					'color' => 'primary',
					'icon' => 'dashicons dashicons-groups',
				],
				'available_donor' => [
					'label' => esc_html__('Available Donor(s):', 'idonate'),
					'value' => idonate_get_available_donor(),
					'color' => 'primary',
					'icon' => 'dashicons dashicons-universal-access',
				],
				'current_request' => [
					'label' => esc_html__('Current Request(s):', 'idonate'),
					'value' => idonate_get_current_request(),
					'color' => 'primary',
					'icon' => 'dashicons dashicons-image-filter',
				],
			];

?>
			<div class="idonate_dashboard_cards">
				<?php foreach ($data as $key => $item) : ?>
					<div class="idonate_dashboard_cards_card">
						<span class="<?php echo esc_attr($item['icon']) ?>"></span>
						<div class="<?php echo esc_html($item['color']) ?>">
							<h3>
								<strong><?php echo esc_html($item['label']); ?></strong>
							</h3>
							<h2>
								<?php echo esc_html($item['value']) ?>
							</h2>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
<?php
		}

		public static function panding_donor_callback()
		{

			echo '<div class="donor_pending_lists">';
			echo '<h2 class="panding-list-heading">Panding Donor(s)</h2>';
			// $args = array(
			// 	'role'         => 'donor',
			// 	'meta_key'	   => 'idonate_donor_status',
			// 	'meta_value'   => '0',
			// 	'order'        => 'ASC',
			// );

			$args = array(
				'role'         => 'donor',
				'meta_query'   => array(
					array(
						'key'     => 'idonate_donor_status',
						'value'   => '0',
						'compare' => '='
					),
				),
				'orderby'      => 'user_login',
				'order'        => 'ASC',
			);

			// Get donor
			$users = get_users($args);

			if (!count($users) > 0) {
				echo esc_html__('No pending donor(s)', 'idonate');
			}

			if (is_array($users) && count($users) > 0) {
				echo '<ul class="panding-list">';
				foreach ($users as $user) {
					$name = get_user_meta($user->ID, 'idonate_donor_full_name', true);
					$listid = 'list' . esc_attr($user->ID);
					echo '<li data-id="' . esc_attr($user->ID) . '" id="' . esc_attr($listid) . '" class="donor_info list-item" data-listid="#' . esc_attr($listid) . '"><span>' . esc_html($name) . '</span><a href="' . esc_url(site_url("donor-info?donor_id=" . $user->ID)) . '" class="idonate_button idonate_popup_modal">' . esc_html__("Preview", "idonate") . '</a></li>';
				}
				echo '</ul>';
			}
			echo '</div>';
		}


		// Panding Blood Request callback
		public static function  blood_request_panding_callback()
		{

			echo '<div class="request_pending_lists">';
			echo '<h2 class="panding-list-heading">Panding Blood Request(s)</h2>';

			$args = array(
				'post_type'  => 'blood_request',
				'meta_query' => array(
					array(
						'key'     => 'idonate_status',
						'value'   => '0',
						'compare' => '='
					),
					'orderby'      => 'user_login',
					'order'        => 'ASC',
				),
			);

			$loop = new \WP_Query($args);

			if (!$loop->have_posts()) {
				echo esc_html__('No pending blood requests', 'idonate');
			}

			if ($loop->have_posts()) {
				echo '<ul class="panding-list">';
				while ($loop->have_posts()) {
					$loop->the_post();
					$listid = 'list' . esc_attr(get_the_ID());
					echo '<li id="' . esc_attr($listid) . '" data-id="' . esc_attr(get_the_ID()) . '" data-listid="#' . esc_attr($listid) . '" class="blood_request_info list-item"><span>' . esc_html(get_the_title()) . '</span><a href="' . esc_url(get_the_permalink(get_the_ID())) . '" class="idonate_button idonate_popup_modal">' . esc_html__("Preview", "idonate") . '</a></li>';
				}
				echo '</ul>';
			}

			echo '</div>';
		}
	}
}
