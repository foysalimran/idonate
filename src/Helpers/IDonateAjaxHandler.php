<?php
/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

namespace ThemeAtelier\Idonate\Helpers;

use ThemeAtelier\Idonate\Frontend\Manager;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}
if (!class_exists('IDonateAjaxHandler')) {
	class IDonateAjaxHandler
	{
		public function __construct()
		{

			$this->idonate_ajax_action();
		}


		private function idonate_ajax_action()
		{
			add_action('wp_ajax_idonate_donor_popup', array($this, 'idonate_donor_popup'));
			add_action('wp_ajax_nopriv_idonate_donor_popup', array($this, 'idonate_donor_popup'));
			add_action('wp_ajax_idonate_blood_request_popup', array($this, 'idonate_blood_request_popup'));
			add_action('wp_ajax_nopriv_idonate_blood_request_popup', array($this, 'idonate_blood_request_popup'));

			add_action('wp_ajax_panding_donor_action', array($this, 'panding_donor_action'));
			add_action('wp_ajax_nopriv_panding_donor_action', array($this, 'panding_donor_action'));

			add_action('wp_ajax_panding_blood_request_action', array($this, 'panding_blood_request_action'));
			add_action('wp_ajax_nopriv_panding_blood_request_action', array($this, 'panding_blood_request_action'));

			add_action('wp_ajax_idonate_request_popup_modal', array($this, 'idonate_request_popup_modal'));
			add_action('wp_ajax_nopriv_idonate_request_popup_modal', array($this, 'idonate_request_popup_modal'));
			add_action('wp_ajax_idonate_request_popup_next_prev', array($this, 'idonate_request_popup_next_prev'));
			add_action('wp_ajax_nopriv_idonate_request_popup_next_prev', array($this, 'idonate_request_popup_next_prev'));
		}
		public function admin_donor_profile_view()
		{
			$meta_key_name = array(
				'full_name',
				'bloodgroup',
				'gender',
				'date_birth',
				'mobile',
				'landline',
				'country',
				'state',
				'city',
				'address',
				'availability',
				'profilepic',
				'fburl',
				'twitterurl',
			);

			$id = '';
			if (isset($_REQUEST['id']) && absint($_REQUEST['id'])) {
				$id = $_REQUEST['id'];
			}

			$data = array();
			if ($id) {

				$userData = get_userdata($id);

				$data['id'] = $userData->id;
				$data['user_name'] = $userData->user_login;
				$data['email'] 	   = $userData->user_email;

				foreach ($meta_key_name as $key_name) {

					if ('idonate_donor_' . esc_html($key_name) == 'idonate_donor_country') {
						$country = get_user_meta(esc_html($id), 'idonate_donor_' . esc_html($key_name), true);
						$data[$key_name] = Countries::idonate_country_name_by_code($country);
						$data['contycode'] = $country;
					} elseif ('idonate_donor_' . esc_html($key_name) == 'idonate_donor_state') {

						$statecode  = get_user_meta(esc_html($id), 'idonate_donor_' . esc_html($key_name), true);
						$countrycode = get_user_meta(esc_html($id), 'idonate_donor_country', true);
						$data[$key_name] = Countries::idonate_states_name_by_code($countrycode, $statecode);
						$data['statecode'] = $statecode;
					} elseif ('idonate_donor_' . esc_html($key_name) == 'idonate_donor_profilepic') {

						$attachmentID = get_user_meta(esc_html($id), 'idonate_donor_' . esc_html($key_name), true);

						$data[$key_name] = wp_get_attachment_url($attachmentID);
					} else {
						$data[$key_name] = get_user_meta(esc_html($id), 'idonate_donor_' . esc_html($key_name), true);
					}
				}
			}

			$data = wp_json_encode($data);
			echo wp_kses_post($data);
			die();
		}
		public function idonate_country_to_states_ajax()
		{
			$options = get_option('idonate_settings');
			$enable_single_country = isset($options['enable_single_country']) ? $options['enable_single_country'] : false;
			$idonate_country = isset($options['idonate_country']) ? $options['idonate_country'] : '';
			$selected_country = $_POST['country'];
			if ($enable_single_country && !empty($idonate_country)) {
				$selected_country = $idonate_country;
			}
			$path = IDONATE_COUNTRIES . 'states/' . $selected_country . '.php';
			if (isset($selected_country) && file_exists($path)) {
				include($path);
				global $states;
				echo  wp_json_encode($states[$selected_country]);
				die();
			}
		}



		/**
		 * Post modal.
		 */
		public static function idonate_donor_popup()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}

			$user_id = stripslashes($_POST['user_id']);

			$countryCode = get_user_meta($user_id, 'idonate_donor_country', true);
			$statecode   = get_user_meta($user_id, 'idonate_donor_state', true);
			$country = Countries::idonate_country_name_by_code($countryCode);
			$state      = Countries::idonate_states_name_by_code($countryCode, $statecode);
			// availability
			$availability = get_user_meta($user_id, 'idonate_donor_availability', true);
			if ('available' == $availability) {
				$abclass = 'available';
				$signal  = '<i class="icofont-check-circled"></i>';
			} else {
				$abclass = 'unavailable';
				$signal = '<i class="icofont-close-circled"></i>';
			}
			$user_info = get_userdata($user_id);
			$user_email = $user_info->user_email; // Get user email
?>
			<div id="idonate_single_user" class="idonate-donor-modal idonate-donor-modal white-popup idonate_donor_modal">
				<div class="idonate_popup_ajax_content">
					<div class="idonate-donor-modal_wrapper" id="idonate_popup_ajax_content">
						<div class="donor_info">
							<div class="donor_info_image">
								<?php if (idonate_profile_img($user_id)) : ?>
									<?php
									echo wp_kses_post(idonate_profile_img($user_id));
									?>
								<?php else :
									echo '<img src="' . esc_url(IDONATE_DIR_URL) . 'src/assets/images/donorplaceholder.jpeg"  alt="' . esc_attr(get_user_meta($user_id, 'idonate_donor_full_name', true)) . '"/>';
								endif; ?>
							</div>
							<div class="donor_content">

								<p><strong><?php esc_html_e('Name : ', 'idonate'); ?></strong><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_full_name', true)); ?></p>
								<p><strong><?php esc_html_e('Gender : ', 'idonate'); ?></strong><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_gender', true)); ?></p>
								<p><strong><?php esc_html_e('Date Of Birth : ', 'idonate'); ?></strong><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_date_birth', true)); ?></p>
								<p><strong><?php esc_html_e('Email : ', 'idonate'); ?></strong><?php echo esc_html($user_email); ?></p>
								<p><strong><?php esc_html_e('Mobile : ', 'idonate'); ?></strong><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_mobile', true)); ?></p>
								<?php if ($availability) : ?>
									<p><strong><?php esc_html_e('Availability  : ', 'idonate'); ?></strong><span class="<?php echo esc_attr($abclass); ?>"><?php echo esc_html($availability) . wp_kses_post($signal); ?></span></p>
								<?php endif; ?>
								<p><strong><?php esc_html_e('Blood Group : ', 'idonate'); ?></strong><?php echo esc_html(get_user_meta($user_id, 'idonate_donor_bloodgroup', true)); ?></p>

								<?php
								$landline = get_user_meta($user_id, 'idonate_donor_landline', true);
								if ($landline) :
								?>
									<p><strong><?php esc_html_e('Land Line Number :', 'idonate'); ?></strong> <?php echo esc_html($landline); ?></p>
								<?php
								endif;
								if ($country) :
								?>
									<p><strong><?php esc_html_e('Country :', 'idonate'); ?></strong> <?php echo esc_html($country); ?></p>
								<?php
								endif;
								if ($state) :
								?>
									<p><strong><?php esc_html_e('State :', 'idonate'); ?></strong> <?php echo esc_html($state); ?></p>
								<?php
								endif;
								?>
								<p><strong><?php esc_html_e('City :', 'idonate'); ?></strong> <?php echo esc_html(get_user_meta($user_id, 'idonate_donor_city', true)); ?></p>
								<p><strong><?php esc_html_e('Address :', 'idonate'); ?></strong> <?php echo esc_html(get_user_meta($user_id, 'idonate_donor_address', true)); ?></p>
								<p><strong><?php esc_html_e('User Name:', 'idonate'); ?></strong> <?php echo esc_html($user_info->user_login); ?></p>

							</div>
						</div>
						<?php
						// if ($popup_close_button) {
						?>
						<button title="<?php esc_html_e('Close (Esc)', 'idonate') ?>" type="button" class="mfp-close idonate-popup-close">&#215;</button>
						<?php
						// }
						?>

						<div id="preloader" style="display: none;">
							<div class="spinner"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn delete btn-default" data-uid="<?php echo esc_attr($user_id); ?>" data-donoraction="delete"><?php esc_html_e('Delete', 'idonate'); ?></button>
					<button type="button" class="btn btn-default" data-uid="<?php echo esc_attr($user_id); ?>" data-donoraction="approve"><?php esc_html_e('Approve', 'idonate'); ?></button>
				</div>
			</div>
		<?php
			die();
		}

		public static function idonate_blood_request_popup()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}

			$post_id = stripslashes($_POST['user_id']);

			$post_title = get_the_title($post_id);

			$name = get_post_meta($post_id, 'idonatepatient_name', true);
			$age = get_post_meta($post_id, 'idonatepatient_age', true);
			$group = get_post_meta($post_id, 'idonatepatient_bloodgroup', true);
			$bloodNeeded = get_post_meta($post_id, 'idonatepatient_bloodneed', true);
			$bloodunit = get_post_meta($post_id, 'idonatepatient_bloodunit', true);
			$idonatepurpose = get_post_meta($post_id, 'idonatepurpose', true);
			$email = get_post_meta($post_id, 'email', true);
			$mobnumber = get_post_meta($post_id, 'idonatepatient_mobnumber', true);
			$hospital_name = get_post_meta($post_id, 'idonatehospital_name', true);
			$idonatecountry = get_post_meta($post_id, 'idonatecountry', true);
			$idonatestate = get_post_meta($post_id, 'idonatestate', true);
			$idonatecity = get_post_meta($post_id, 'idonatecity', true);
			$idonateaddress = get_post_meta($post_id, 'idonateaddress', true);
		?>
			<div id="idonate_single_user" class="idonate-donor-modal idonate-donor-modal white-popup idonate_modal_pos_request">
				<div class="idonate_popup_ajax_content">
					<div class="idonate-donor-modal_wrapper" id="idonate_popup_ajax_content">
						<div class="donor_info">
							<div class="top-info">
								<h4 class="modal_title" id="myModalLabel"><?php echo esc_html($post_title); ?></h4>
								<img width="60" src="<?php echo esc_url(IDONATE_DIR_URL); ?>src/assets/images/heart-01.png" />
							</div>
							<div class="donor_content">
								<?php if ($name) : ?>
									<p><?php echo esc_html__('Patient Name: ', 'idonate') . '<span>' . esc_html($name) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($age) : ?>
									<p><?php echo esc_html__('Patient Age:', 'idonate') . '<span> ' . esc_html($age) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($group) : ?>
									<p><?php echo esc_html__('Blood Group:', 'idonate') . '<span> ' . esc_html($group) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($bloodNeeded) : ?>
									<p><?php echo esc_html__('When Need Blood?:', 'idonate') . '<span> ' . esc_html($bloodNeeded) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($bloodunit) : ?>
									<p><?php echo esc_html__('Blood Unit / Bag (S):', 'idonate') . '<span> ' . esc_html($bloodunit) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($idonatepurpose) : ?>
									<p><?php echo esc_html__('Purpose: ', 'idonate') . '<span> ' . esc_html($idonatepurpose) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($email) : ?>
									<p><?php echo esc_html__('Email: ', 'idonate') . '<span> ' . esc_html($email) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($mobnumber) : ?>
									<p><?php echo esc_html__('Mobile Number: ', 'idonate') . '<span> ' . esc_html($mobnumber) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($hospital_name) : ?>
									<p><?php echo esc_html__('Hospital Name: ', 'idonate') . '<span> ' . esc_html($hospital_name) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($idonatecountry) : ?>
									<p><?php echo esc_html__('Country: ', 'idonate') . '<span> ' . esc_html($idonatecountry) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($idonatestate) : ?>
									<p><?php echo esc_html__('State: ', 'idonate') . '<span> ' . esc_html($idonatestate) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($idonatecity) : ?>
									<p><?php echo esc_html__('City: ', 'idonate') . '<span> ' . esc_html($idonatecity) . '</span>'; ?></p>
								<?php endif; ?>

								<?php if ($idonateaddress) : ?>
									<p><?php echo esc_html__('Address:', 'idonate') . '<span> ' . esc_html($idonateaddress) . '</span>'; ?></p>
								<?php endif; ?>


							</div>
						</div>
						<?php
						// if ($popup_close_button) {
						?>
						<button title="<?php esc_html_e('Close (Esc)', 'idonate') ?>" type="button" class="mfp-close idonate-popup-close">&#215;</button>
						<?php
						// }
						?>

						<div id="preloader" style="display: none;">
							<div class="spinner"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn delete btn-default" data-uid="<?php echo esc_attr($post_id); ?>" data-reqaction="delete"><?php esc_html_e('Delete', 'idonate'); ?></button>
					<button type="button" class="btn btn-default" data-uid="<?php echo esc_attr($post_id); ?>" data-reqaction="approve"><?php esc_html_e('Approve', 'idonate'); ?></button>
				</div>
			</div>
		<?php
			die();
		}

		// Panding donor action ajax
		public function panding_donor_action()
		{
			$result = '';
			// user status
			if (isset($_POST['target']) && $_POST['target'] == 'delete') {
				if (isset($_POST['userid'])) {
					$id = wp_delete_user($_POST['userid']);

					if (!is_wp_error($id)) {
						$result = array(
							'action' => 'deleted',
							'msg'	 => 'Successfully deleted'
						);
					}
				}
			} elseif (isset($_POST['target']) && $_POST['target'] == 'approve') {
				if (isset($_POST['userid'])) {
					$id = update_user_meta($_POST['userid'], 'idonate_donor_status', esc_attr('1'));

					if (!is_wp_error($id)) {
						$result = array(
							'action' => 'approved',
							'msg'	 => 'Successfully approved'
						);
					}
				}
			}

			if (is_array($result)) {
				$result = wp_json_encode($result);
			}

			echo wp_kses_post($result);
			die();
		}
		// Panding blood request action ajax
		public function panding_blood_request_action()
		{

			$result = '';
			// Blood request action
			if (isset($_POST['target']) && $_POST['target'] == 'delete') {
				if (isset($_POST['userid'])) {
					$id = wp_delete_post($_POST['userid']);
					if (!is_wp_error($id)) {
						$result = array(
							'action' => 'delete',
							'msg'	 => 'Successfully delete'
						);
					}
				}
			} elseif (isset($_POST['target']) && $_POST['target'] == 'approve') {
				if (isset($_POST['userid'])) {

					$id =	update_post_meta($_POST['userid'], 'idonate_status', '1');

					if (!is_wp_error($id)) {
						$result = array(
							'action' => 'approved',
							'msg'	 => 'Successfully approved'
						);
					}
				}
			}

			if (is_array($result)) {
				$result = wp_json_encode($result);
			}

			echo wp_kses_post($result);

			die();
		}

		/**
		 * Post modal.
		 */
		public static function idonate_post_popup()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}

			$option = get_option('idonate_settings');
			$next_prev = isset($option['next_prev']) ? $option['next_prev'] : '';
		?>
			<div id="idonate_single_user" class="idonate-donor-modal idonate-donor-modal white-popup">
				<div class="idonate_popup_ajax_content">
					<?php Manager::donor_popup_views_html(); ?>
				</div>
				<?php
				if ($next_prev) {
				?>
					<div class="idonate-popup-button-prev"><i class="icofont-rounded-left"></i></div>
					<div class="idonate-popup-button-next"><i class="icofont-rounded-right"></i></div>
				<?php
				}
				?>

			</div>
		<?php
			die();
		}

		/**
		 * Post next prev modal.
		 */
		public static function idonate_post_admin_popup_next_prev()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}
			Manager::donor_popup_views_html();
			die();
		}
		/**
		 * Post modal.
		 */
		public static function idonate_request_popup_modal()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}

			$option = get_option('idonate_settings');
			$request_next_prev = isset($option['request_next_prev']) ? $option['request_next_prev'] : '';
		?>
			<div id="idonate_single_user" class="idonate-donor-modal idonate-donor-modal white-popup">
				<div class="idonate_popup_ajax_content">
					<?php Manager::donor_request_popup_views_html(); ?>
				</div>
				<?php
				if ($request_next_prev) {
				?>
					<div class="idonate-popup-button-prev"><i class="icofont-rounded-left"></i></div>
					<div class="idonate-popup-button-next"><i class="icofont-rounded-right"></i></div>
				<?php
				}
				?>

			</div>
<?php
			die();
		}

		/**
		 * Post next prev modal.
		 */
		public static function idonate_request_popup_next_prev()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}
			Manager::donor_request_popup_views_html();
			die();
		}

		// Handle the AJAX request
		public function idonate_search_donors()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}
			$bloodgroup 	= isset($_POST['bloodgroup']) ? sanitize_text_field($_POST['bloodgroup']) : '';
			$availability 	= isset($_POST['availability']) ? sanitize_text_field($_POST['availability']) : '';
			$country 		= isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
			$state 			= isset($_POST['state']) ? sanitize_text_field($_POST['state']) : '';
			$city 			= isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
			$name 			= isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
			$paged 			= isset($_POST['paged']) ? intval($_POST['paged']) : 1;
			$pagenumLink 	= isset($_POST['pagenumLink']) ? sanitize_text_field($_POST['pagenumLink']) : '';
			$options 		= get_option('idonate_settings');
			$number 		= isset($options['donor_per_page']) ? $options['donor_per_page'] : 10;
			$pagenum_link 	= $pagenumLink;

			$totaldonor_args = array(
				'role' => 'donor',
				'meta_key' => 'idonate_donor_status',
				'meta_value' => '1'
			);
			$get_donor = get_users($totaldonor_args);
			$total_donor = count($get_donor);

			$args = array(
				'role' => 'donor',
				'meta_key' => 'idonate_donor_status',
				'meta_value' => '1',
				'order' => 'ASC',
				'offset' => ($paged - 1) * $number,
				'number' => $number,
			);

			$meta_query = array('relation' => 'AND');

			if (!empty($bloodgroup)) {
				$meta_query[] = array(
					'key' => 'idonate_donor_bloodgroup',
					'value' => $bloodgroup,
					'compare' => '='
				);
			}

			if (!empty($availability)) {
				$meta_query[] = array(
					'key' => 'idonate_donor_availability',
					'value' => $availability,
					'compare' => '='
				);
			}

			if (!empty($country)) {
				$meta_query[] = array(
					'key' => 'idonate_donor_country',
					'value' => $country,
					'compare' => '='
				);
			}

			if (!empty($state)) {
				$meta_query[] = array(
					'key' => 'idonate_donor_state',
					'value' => $state,
					'compare' => '='
				);
			}

			if (!empty($city)) {
				$meta_query[] = array(
					'key' => 'idonate_donor_city',
					'value' => $city,
					'compare' => 'LIKE'
				);
			}

			if (!empty($name)) {
				$meta_query[] = array(
					'key' => 'idonate_donor_full_name',
					'value' => $name,
					'compare' => 'LIKE'
				);
			}

			if (!empty($meta_query)) {
				$args['meta_query'] = $meta_query;
			}

			$users = get_users($args);

			ob_start();
			if (count($users) > 0) {
				Manager::views_html($users, $total_donor, $number, $paged, $pagenum_link);
			} else {
				echo '<h3 class="notmatch">' . esc_html__('Sorry. No donors match your criteria.', 'idonate') . '</h3>';
			}
			$html = ob_get_clean();

			wp_send_json_success(array('html' => $html));
		}

		public function idonate_search_request()
		{
			if (isset($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'idonate_nonce')) {
				wp_send_json_error(array('message' => esc_html__('Nonce verification failed', 'idonate')), 403);
				return false;
			}
			
			$option = get_option('idonate_settings');
			$rp_request_per_page = isset($option['rp_request_per_page']) ? $option['rp_request_per_page'] : '';

			// request per page
			if ($rp_request_per_page) {
				$rperpage =  $rp_request_per_page;
			} else {
				$rperpage = 10;
			}

			$bloodgroup = isset($_POST['bloodgroup']) ? sanitize_text_field($_POST['bloodgroup']) : '';
			$country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';
			$state = isset($_POST['state']) ? sanitize_text_field($_POST['state']) : '';
			$city = isset($_POST['city']) ? sanitize_text_field($_POST['city']) : '';
			$name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
			$start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
			$end_date = isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : '';
			$pagenumLink = isset($_POST['pagenumLink']) ? sanitize_text_field($_POST['pagenumLink']) : '';
			$pagenum_link = $pagenumLink;

			if (is_front_page()) {
				$paged = (get_query_var('page')) ? get_query_var('page') : 1;
			} else {
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			}

			$args = array(
				'post_type'         => 'blood_request',
				'paged'             => $paged,
				'posts_per_page'    => $rperpage,
			);

			$meta_query = array();
			if (!empty($bloodgroup)) {
				$meta_query[] = array(
					'key' => 'idonatepatient_bloodgroup',
					'value' => $bloodgroup,
					'compare' => '='
				);
			}
			if (!empty($country)) {
				$meta_query[] = array(
					'key' => 'idonatecountry',
					'value' => $country,
					'compare' => '='
				);
			}
			if (!empty($state)) {
				$meta_query[] = array(
					'key' => 'idonatestate',
					'value' => $state,
					'compare' => '='
				);
			}
			if (!empty($city)) {
				$meta_query[] = array(
					'key' => 'idonatecity',
					'value' => $city,
					'compare' => 'LIKE'
				);
			}

			// Add date query
			if (!empty($start_date) && !empty($end_date)) {
				$meta_query[] = array(
					'key' => 'idonatepatient_bloodneed',
					'value' => array($start_date, $end_date),
					'compare' => 'BETWEEN',
					'type' => 'DATE'
				);
			}

			if (!empty($meta_query)) {
				$args['meta_query'] = $meta_query;
			}
			if (!empty($name)) {
				$args['s'] = $name;
			}

			$loops = new \WP_Query($args);
			$total_posts = $loops->found_posts;

			ob_start();
			if ($total_posts > 0) {
				Manager::request_views_html($loops, $pagenum_link);
			} else {
				echo '<h3 class="notmatch">' . esc_html__('Sorry. No requests matched your criteria.', 'idonate') . '</h3>';
			}
			$html = ob_get_clean();
			wp_send_json_success(array('html' => $html));
		}
	}
}