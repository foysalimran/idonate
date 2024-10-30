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

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

class DonorFunctions
{
	// Add DonorFunctions
	public static function idonate_donor_add()
	{
		$options = get_option('idonate_settings');

		// These files need to be included as dependencies when on the front end.
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		if (isset($_POST['request_submit_nonce_check']) && wp_verify_nonce(wp_unslash($_POST['request_submit_nonce_check']), 'request_nonce_action')) {

			$validation_error = new \WP_Error;
			$donarData = array();
			// Check Full Name
			if (!empty($_POST['full_name'])) {
				$donarData['full_name'] = sanitize_text_field(wp_unslash( $_POST['full_name'] ));
			}
			// Check Gender
			if (!empty($_POST['gender'])) {
				$donarData['gender'] = sanitize_text_field(wp_unslash( $_POST['gender'] ));
			}
			// Check Date Of Birth
			if (!empty($_POST['date_birth'])) {
				$donarData['date_birth'] = sanitize_text_field(wp_unslash( $_POST['date_birth'] ));
			}
			// Check Blood Group
			if (!empty($_POST['bloodgroup'])) {
				$donarData['bloodgroup'] = sanitize_text_field(wp_unslash( $_POST['bloodgroup'] ));
			}
			// Check Mobile Number
			if (!empty($_POST['mobile'])) {
				$donarData['mobile'] = sanitize_text_field(wp_unslash( $_POST['mobile'] ));
			}
			// Check Land Line Number
			if (!empty($_POST['landline'])) {
				$donarData['landline'] = sanitize_text_field(wp_unslash( $_POST['landline'] ));
			} else {
				$donarData['landline'] = '';
			}

			// Check City
			if (!empty($_POST['city'])) {
				$donarData['city'] = sanitize_text_field(wp_unslash( $_POST['city'] ));
			}
			// Check Address
			if (!empty($_POST['address'])) {
				$donarData['address'] = sanitize_text_field(wp_unslash( $_POST['address'] ));
			}
			// Check E-Mail
			if (!empty($_POST['email'])) {

				$email = '';
				$userEmail = sanitize_text_field(wp_unslash( $_POST['email'] ));
				if (is_email($userEmail)) {
					if (!email_exists($userEmail)) {
						$email = $userEmail;
					}
				}
			}
			// Check User Name
			if (!empty($_POST['user_name'])) {
				$userName = sanitize_text_field(wp_unslash( $_POST['user_name'] ));
			}
			// Check Password
			if (!empty($_POST['password'])) {
				$password = sanitize_text_field(wp_unslash( $_POST['password'] ));
			}
			// Check Password
			if (!empty($_POST['retypepassword'])) {
				$retypepassword = sanitize_text_field(wp_unslash( $_POST['retypepassword'] ));
			}
			// Check Availability
			if (!empty($_POST['availability'])) {
				$donarData['availability'] = sanitize_text_field(wp_unslash( $_POST['availability'] ));
			}

			if (wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')) {
				$recapresponse = self::idonate_recaptcha_response();
				if (!empty($recapresponse['status'])) {
					if (1 > count($validation_error->get_error_messages())) {
						if ($password === $retypepassword) {

							$args = array(
								'user_login'  =>  sanitize_user($userName),
								'user_email'  =>  sanitize_email($email),
								'user_pass'   =>  $password,  // When creating an user, `user_pass` is expected.
								'role'   	  =>  'donor'
							);
							$user_id = wp_insert_user($args);

							if (!is_wp_error($user_id)) {
								// Media upload handle
								$attachment_id = media_handle_upload('profileimg', $user_id);

								//media upload update
								update_user_meta($user_id, 'idonate_donor_profilepic', $attachment_id);
								// Donor approval check
								$option = get_option('idonate_settings');
								$donor_register_status = isset($option['donor_register_status']) ? $option['donor_register_status'] : '';
								$status = '1';
								if ($donor_register_status) {
									$status = '0';
								}
								update_user_meta($user_id, 'idonate_donor_status', esc_html($status));
								foreach ($donarData as $key => $info) {

									update_user_meta($user_id, 'idonate_donor_' . $key, $info);
								}
								$response = 'success';
							} else {
								$response = 'insert_failed';
							}
						} else {
							$response = 'password_not_match';
						}
					} else {
						$response = array('error' => 1, 'error_msg' => $validation_error->get_error_messages());
					}
				} else {
					$msg =  !empty($recapresponse['msg']) ? $recapresponse['msg'] : '';
					$response = array('error' => 1, 'error_msg' => array($msg));
				}
			} else {
				$response = 'illegal';
			}
			return $response;
		}
	}

	// Donor information update
	public static function idonate_donor_edit()
	{
		// These files need to be included as dependencies when on the front end.
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		if (isset($_POST['request_submit_nonce_check']) && wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')) {

			$validation_error = new \WP_Error;
			$donarData = array();

			// Check Full Name
			if (!empty($_POST['full_name'])) {
				$donarData['full_name'] = sanitize_text_field(wp_unslash( $_POST['full_name'] ));
			} else {
				$validation_error->add('field', esc_html__('Full Name field can\'t be empty.', 'idonate'));
			}
			// Check Gender
			if (!empty($_POST['gender'])) {
				$donarData['gender'] = sanitize_text_field(wp_unslash( $_POST['gender'] ));
			} else {
				$validation_error->add('field', esc_html__('Gender field can\'t be empty.', 'idonate'));
			}
			// Check Date Of Birth
			if (!empty($_POST['date_birth'])) {
				$donarData['date_birth'] = sanitize_text_field(wp_unslash( $_POST['date_birth'] ));
			} else {
				$validation_error->add('field', esc_html__('Date of birth field can\'t be empty.', 'idonate'));
			}

			// Check Blood Group
			if (!empty($_POST['bloodgroup'])) {
				$donarData['bloodgroup'] = sanitize_text_field(wp_unslash( $_POST['bloodgroup'] ));
			} else {
				$validation_error->add('field', esc_html__('Blood group field can\'t be empty.', 'idonate'));
			}
			// Check Mobile Number
			if (!empty($_POST['mobile'])) {
				$donarData['mobile'] = sanitize_text_field(wp_unslash( $_POST['mobile'] ));
			} else {
				$validation_error->add('field', esc_html__('Mobile Number field can\'t be empty.', 'idonate'));
			}
			// Check Land Line Number
			if (!empty($_POST['landline'])) {
				$donarData['landline'] = sanitize_text_field(wp_unslash( $_POST['landline'] ));
			} else {
				$donarData['landline'] = '';
			}
			// Check City
			if (!empty($_POST['city'])) {
				$donarData['city'] = sanitize_text_field(wp_unslash( $_POST['city'] ));
			} else {
				$validation_error->add('field', esc_html__('City field can\'t be empty.', 'idonate'));
			}
			// Check District
			if (!empty($_POST['address'])) {
				$donarData['address'] = sanitize_text_field(wp_unslash( $_POST['address'] ));
			} else {
				$validation_error->add('field', esc_html__('Please write your address.', 'idonate'));
			}
			// Check Availability
			if (!empty($_POST['availability'])) {
				$donarData['availability'] = sanitize_text_field(wp_unslash( $_POST['availability'] ));
			} else {
				$validation_error->add('field', esc_html__('Please select your availability to donate blood field', 'idonate'));
			}
			// Check Availability
			if (!empty($_POST['lastdonate'])) {
				$donarData['lastdonate'] = sanitize_text_field(wp_unslash( $_POST['lastdonate'] ));
			} else {
				$donarData['lastdonate'] = __('Not yet', 'idonate');
			}
			// Check Availability
			if (!empty($_POST['fburl'])) {
				$donarData['fburl'] = sanitize_text_field(wp_unslash( $_POST['fburl'] ));
			}
			// Check Availability
			if (!empty($_POST['twitterurl'])) {
				$donarData['twitterurl'] = sanitize_text_field(wp_unslash( $_POST['twitterurl'] ));
			}
			// Check E-Mail
			if (!empty($_POST['email'])) {
				$userEmail = sanitize_text_field(wp_unslash( $_POST['email'] ));
				if (is_email($userEmail)) {
					$email = $userEmail;
				} else {
					$validation_error->add('email_invalid', esc_html__('Invalid email.', 'idonate'));
				}
			} else {
				$validation_error->add('field', esc_html__('Email field can\'t be empty.', 'idonate'));
			}

			// New Password
			if (!empty($_POST['newpassword']) && !empty($_POST['retypenewpassword'])) {

				$getnewpass 			= sanitize_text_field(wp_unslash( $_POST['newpassword'] ));
				$getretypenewpassword   = sanitize_text_field(wp_unslash( $_POST['retypenewpassword'] ));

				if ($getnewpass == $getretypenewpassword) {
					$newpass = $getnewpass;
				} else {
					$validation_error->add('field', esc_html__('Your password are not match.', 'idonate'));
				}
			} else {
				$newpass = '';
			}


			if (
				isset($_POST['donor_id']) && !empty($_POST['donor_id']) && absint($_POST['donor_id']) &&
				wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')
			) {
				if (1 > count($validation_error->get_error_messages())) {
					$userdata = array(
						'ID'         => $_POST['donor_id'],
						'user_email' => $email,
						'user_pass'  => $newpass,
					);

					$user_id = wp_update_user($userdata);

					if (!is_wp_error($user_id)) {
						//media upload
						$attachment_id = media_handle_upload('profileimg', $user_id);

						if (!is_wp_error($attachment_id)) {
							update_user_meta($user_id, 'idonate_donor_profilepic', $attachment_id);
						}

						foreach ($donarData as $key => $info) {
							update_user_meta($user_id, 'idonate_donor_' . $key, $info);
						}

						$response = 'update_success';
					} else {
						$response = 'update_failed';
					}
				} else {
					$response = array('error' => 1, 'error_msg' => $validation_error->get_error_messages());
				}
			} else {
				$response = 'illegal';
			}

			return $response;
		}
	}

	public static function idonate_donor_profile()
	{
		// These files need to be included as dependencies when on the front end.
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		if (isset($_POST['request_submit_nonce_check']) && wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')) {

			$validation_error = new \WP_Error;
			$donarData = array();

			// Check Full Name
			if (!empty($_POST['full_name'])) {
				$donarData['full_name'] = sanitize_text_field(wp_unslash( $_POST['full_name'] ));
			} else {
				$validation_error->add('field', esc_html__('Full Name field can\'t be empty.', 'idonate'));
			}
			// Check E-Mail
			if (!empty($_POST['email'])) {
				$userEmail = sanitize_text_field(wp_unslash( $_POST['email'] ));
				if (is_email($userEmail)) {
					$email = $userEmail;
				} else {
					$validation_error->add('email_invalid', esc_html__('Invalid email.', 'idonate'));
				}
			} else {
				$validation_error->add('field', esc_html__('Email field can\'t be empty.', 'idonate'));
			}
			// Check Blood Group
			if (!empty($_POST['bloodgroup'])) {
				$donarData['bloodgroup'] = sanitize_text_field(wp_unslash( $_POST['bloodgroup'] ));
			} else {
				$validation_error->add('field', esc_html__('Blood group field can\'t be empty.', 'idonate'));
			}
			// Check Availability
			if (!empty($_POST['availability'])) {
				$donarData['availability'] = sanitize_text_field(wp_unslash( $_POST['availability'] ));
			} else {
				$validation_error->add('field', esc_html__('Please select your availability to donate blood field', 'idonate'));
			}
			// Check Gender
			if (!empty($_POST['gender'])) {
				$donarData['gender'] = sanitize_text_field(wp_unslash( $_POST['gender'] ));
			} else {
				$validation_error->add('field', esc_html__('Gender field can\'t be empty.', 'idonate'));
			}
			// Check Date Of Birth
			if (!empty($_POST['date_birth'])) {
				$donarData['date_birth'] = sanitize_text_field(wp_unslash( $_POST['date_birth'] ));
			} else {
				$validation_error->add('field', esc_html__('Date of birth field can\'t be empty.', 'idonate'));
			}
			// Check Mobile Number
			$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
			$donarData['mobile'] = $mobile;
			// Check Land Line Number
			$landline = isset($_POST['landline']) ? $_POST['landline'] : '';
			$donarData['landline'] = $landline;
			// Last Donate
			if (!empty($_POST['lastdonate'])) {
				$donarData['lastdonate'] = sanitize_text_field(wp_unslash( $_POST['lastdonate'] ));
			} else {
				$donarData['lastdonate'] = __('Not yet', 'idonate');
			}

			if (
				isset($_POST['donor_id']) && !empty($_POST['donor_id']) && absint($_POST['donor_id']) &&
				wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')
			) {
				if (1 > count($validation_error->get_error_messages())) {
					$userdata = array(
						'ID'         => $_POST['donor_id'],
						'user_email' => $email,
					);
					$user_id = wp_update_user($userdata);
					if (!is_wp_error($user_id)) {
						//media upload
						$attachment_id = media_handle_upload('profileimg', $user_id);

						if (!is_wp_error($attachment_id)) {
							update_user_meta($user_id, 'idonate_donor_profilepic', $attachment_id);
						}
						foreach ($donarData as $key => $info) {
							update_user_meta($user_id, 'idonate_donor_' . $key, $info);
						}
						$response = 'update_success';
					} else {
						$response = 'update_failed';
					}
				} else {
					$response = array('error' => 1, 'error_msg' => $validation_error->get_error_messages());
				}
			} else {
				$response = 'illegal';
			}

			return $response;
		}
	}
	public static function idonate_donor_password()
	{

		if (isset($_POST['request_submit_nonce_check']) && wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')) {

			$validation_error = new \WP_Error;

			// New Password
			if (!empty($_POST['password']) && !empty($_POST['retypepassword'])) {
				$get_new_password = sanitize_text_field(wp_unslash( $_POST['password'] ));
				$getretypepassword = sanitize_text_field(wp_unslash( $_POST['retypepassword'] ));

				if ($get_new_password === $getretypepassword) {
					$new_pass = $get_new_password;
				} else {
					$validation_error->add('field', esc_html__('Your passwords do not match.', 'idonate'));
				}
			} else {
				$new_pass = '';
			}

			$response = '';
			wp_set_password($new_pass, $_POST['donor_id']);
			$response = 'update_success';
			echo '<script>window.location.replace("', esc_url(home_url()), '");</script>';

			return $response;
		}
	}

	public static function idonate_donor_address()
	{
		$options = get_option('idonate_settings');
		if (isset($_POST['request_submit_nonce_check']) && wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')) {

			$validation_error = new \WP_Error;
			$donarData = array();
			$idonate_countryhide = isset($options['idonate_countryhide']) ? $options['idonate_countryhide'] : '';
			if ($idonate_countryhide) {
				$donarData['country'] = sanitize_text_field(wp_unslash( $_POST['country'] ));
				if (!empty($_POST['country'])) {
				} else {
					$validation_error->add('field', esc_html__('Please select your country.', 'idonate'));
				}
				if (!empty($_POST['state'])) {
					$donarData['state'] = sanitize_text_field(wp_unslash( $_POST['state'] ));
				}
			}

			if (!empty($_POST['city'])) {
				$donarData['city'] = sanitize_text_field(wp_unslash( $_POST['city'] ));
			} else {
				$validation_error->add('field', esc_html__('City field can\'t be empty.', 'idonate'));
			}
			if (!empty($_POST['address'])) {
				$donarData['address'] = sanitize_text_field(wp_unslash( $_POST['address'] ));
			} else {
				$validation_error->add('field', esc_html__('Please write your address.', 'idonate'));
			}

			if (
				isset($_POST['donor_id']) && !empty($_POST['donor_id']) && absint($_POST['donor_id']) &&
				wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')
			) {
				if (1 > count($validation_error->get_error_messages())) {
					$userdata = array(
						'ID'         => sanitize_text_field(wp_unslash( $_POST['donor_id'] )),
					);

					$user_id = wp_update_user($userdata);
					if (!is_wp_error($user_id)) {

						foreach ($donarData as $key => $info) {
							update_user_meta($user_id, 'idonate_donor_' . $key, $info);
						}
						$response = 'update_success';
					} else {
						$response = 'update_failed';
					}
				} else {
					$response = array('error' => 1, 'error_msg' => $validation_error->get_error_messages());
				}
			} else {
				$response = 'illegal';
			}

			return $response;
		}
	}
	public static function idonate_donor_social_share()
	{
		if (isset($_POST['request_submit_nonce_check']) && wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')) {

			$validation_error = new \WP_Error;
			$donarData = array();

			// Facebook account
			$facebook = isset($_POST['fburl']) ? sanitize_text_field(wp_unslash($_POST['fburl'])) : '';
			$donarData['fburl'] = $facebook;
			// Twitter account
			$twitter = isset($_POST['twitterurl']) ? sanitize_text_field(wp_unslash( $_POST['twitterurl'] )) : '';
			$donarData['twitterurl'] = $twitter;
			// Linkedin account
			$linkedin = isset($_POST['linkedin']) ? sanitize_text_field(wp_unslash( $_POST['linkedin'] )) : '';
			$donarData['linkedin'] = $linkedin;
			// Website
			$website = isset($_POST['website']) ? sanitize_text_field(wp_unslash( $_POST['website'] )) : '';
			$donarData['website'] = $website;

			if (
				isset($_POST['donor_id']) && !empty($_POST['donor_id']) && absint($_POST['donor_id']) &&
				wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')
			) {
				if (1 > count($validation_error->get_error_messages())) {
					$userdata = array(
						'ID'         => $_POST['donor_id'],
					);

					$user_id = wp_update_user($userdata);
					if (!is_wp_error($user_id)) {

						foreach ($donarData as $key => $info) {
							update_user_meta($user_id, 'idonate_donor_' . $key, $info);
						}

						$response = 'update_success';
					} else {
						$response = 'update_failed';
					}
				} else {
					$response = array('error' => 1, 'error_msg' => $validation_error->get_error_messages());
				}
			} else {
				$response = 'illegal';
			}

			return $response;
		}
	}

	// response message
	public static function idonate_response_msg($res, $action)
	{
		$resMsg = __('This donor is already added', 'idontate');

		$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('This donor is already added', 'idonate') . '</span>';
		switch ($action) {
			case 'add':
				if ($res == 'success') {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-success">' . esc_html__('Your registration successfully complete.', 'idonate') . '</span>';
				} else if ($res == 'insert_faield') {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('Sorry your registration failed.', 'idonate') . '</span>';
				} else if ($res == 'illegal') {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('Please don\'t try illegal method.', 'idonate') . '</span>';
				} else if ($res == 'password_not_match') {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('Your password are not match.', 'idonate') . '</span>';
				} else {
					if (is_array($res)) {

						if (!empty($res['error_msg'])) {
							$resMsg = '';
							foreach ($res['error_msg'] as $msg) {
								$resMsg .= '<span class="text-center idonate-alert idonate-alert-error">' . esc_html($msg) . '</span>';
							}
						}
					}
				}
				break;
			case 'update':
				if ($res == 'update_success') {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-success">' . esc_html__('Your information successfully update.', 'idonate') . '</span>';
				} else if ($res == 'update_failed') {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('Sorry your update request failed.', 'idonate') . '</span>';
				} else if ($res == 'illegal') {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('Please don\'t try illegal method.', 'idonate') . '</span>';
				} else {
					if (is_array($res)) {

						if (!empty($res['error_msg'])) {
							$resMsg = '';
							foreach ($res['error_msg'] as $msg) {
								$resMsg .= '<span class="text-center idonate-alert idonate-alert-error">' . esc_html($msg) . '</span>';
							}
						}
					}
				}
				break;
			case 'delete':
				if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'])) {
					if ($res == '1') {
						$resMsg = '<span class="text-center idonate-alert idonate-alert-success">' . esc_html__('Your information successfully Delete.', 'idonate') . '</span>';
					} else {
						$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('Sorry your delete request failed.', 'idonate') . '</span>';
					}
				} else {
					$resMsg = '<span class="text-center idonate-alert idonate-alert-error">' . esc_html__('Don\'t try illegal method.', 'idonate') . '</span>';
				}
				break;
		}
		return '<div id="idonate-response-msg">' . wp_kses_post($resMsg) . '</div>';
	}

	// Add donar user role
	public static function idonate_user_role()
	{
		add_role('donor', 'Donor', array('read' => true, 'level_0' => true));
	}

	// Page set option
	public static function displayset_option()
	{
		return get_option('idonate_settings');
	}

	// Recaptcha response
	public static function idonate_recaptcha_response()
	{

		$option = get_option('idonate_settings');

		$result = array();

		if ($option['idonate_recaptcha_active']) {

			if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
				//your site secret key
				$secret = $option['idonate_recaptcha_secretkey'] ? $option['idonate_recaptcha_secretkey'] : '';
				//get verify response data
				$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
				$responseData = json_decode($verifyResponse);

				if ($responseData->success) {
					$result['status'] = $responseData->success;
				} else {
					$result['status'] = false;
					$result['msg'] = __('Robot verification failed, please try again.', 'idonate');
				}
			} else {
				$result['status'] = false;
				$result['msg'] = __('Please click on the reCAPTCHA box.', 'idonate');
			}
		} else {
			$result['status'] = true;
		}

		return $result;
	}

	public static function idonate_donor_delete()
	{
		$response = '0';
		if (wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action') && isset($_POST['donor_delete'])) {

			if (!empty($_POST['user_id']) && absint($_POST['user_id'])) {
				$res = wp_delete_user($_POST['user_id']);

				if ($res) {
					$response = $res;
				} else {
					$response = '0';
				}
			}
		}
		wp_safe_redirect(wp_nonce_url(admin_url('admin.php?page=idonate-donor&action=' . $response)));
	}
}
