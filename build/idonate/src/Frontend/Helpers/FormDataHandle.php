<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

namespace ThemeAtelier\Idonate\Frontend\Helpers;

use ThemeAtelier\Idonate\Helpers\DonorFunctions;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

class FormDataHandle
{
	// Post blood request form data
	public static function idonate_blood_request_form_handel()
	{
		// These files need to be included as dependencies when on the front end.
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		if (isset($_POST['request_submit_nonce_check']) && wp_verify_nonce($_POST['request_submit_nonce_check'], 'request_nonce_action')) {  // nonce check
			$response = DonorFunctions::idonate_recaptcha_response();
			if (!empty($response['status'])) {
				// ADD THE FORM INPUT TO $testimonial_form ARRAY.
				$title = isset($_POST['title']) ? $_POST['title'] : '';
				$patientname = isset($_POST['patientname']) ? $_POST['patientname'] : '';
				$purpose = isset($_POST['purpose']) ? $_POST['purpose'] : '';
				$bloodgroup = isset($_POST['bloodgroup']) ? $_POST['bloodgroup'] : '';
				$patientage = isset($_POST['patientage']) ? $_POST['patientage'] : '';
				$needblood = isset($_POST['needblood']) ? $_POST['needblood'] : '';
				$email = isset($_POST['email']) ? $_POST['email'] : '';
				$bloodunits = isset($_POST['bloodunits']) ? $_POST['bloodunits'] : '';
				$mobilenumber = isset($_POST['mobilenumber']) ? $_POST['mobilenumber'] : '';
				$hospitalname = isset($_POST['hospitalname']) ? $_POST['hospitalname'] : '';
				$country = isset($_POST['country']) ? $_POST['country'] : '';
				$state = isset($_POST['state']) ? $_POST['state'] : '';
				$city = isset($_POST['city']) ? $_POST['city'] : '';
				$location = isset($_POST['location']) ? $_POST['location'] : '';
				$details = isset($_POST['details']) ? $_POST['details'] : '';

				$args = array(
					'post_title'   =>  sanitize_text_field($title),
					'post_status'  => 'publish',
					'post_type'    => 'blood_request',
					'meta_input'   => array(
						'idonatepatient_name'           => $patientname,
						'idonatepurpose'				=> $purpose,
						'idonatepatient_bloodgroup'     => $bloodgroup,
						'idonatepatient_age'     		=> $patientage,
						'idonatepatient_bloodneed'    	=> $needblood,
						'email'    						=> $email,
						'idonatepatient_bloodunit'      => $bloodunits,
						'idonatepatient_mobnumber'      => $mobilenumber,
						'idonatehospital_name'         	=> $hospitalname,
						'idonatecountry'       		   	=> $country,
						'idonatestate'          		=> $state,
						'idonatecity' 					=> $city,
						'idonateaddress' 				=> $location,
						'idonatedetails' 				=> $details,
					),
				);

				$insert_ID = wp_insert_post($args);

				if ($insert_ID) {
					// Post status 
					$option = get_option( 'idonate_settings' );
					$status = '1';
					if( !empty( $option['donor_request_status'] ) ){
						$status = '0';
					}
					update_post_meta( $insert_ID, 'idonate_status', sanitize_text_field( $status ) );

					if ($_FILES) {
						foreach ($_FILES as $file => $array) {
							if (UPLOAD_ERR_OK !== $_FILES[$file]['error']) {
							} else {
								$attachment_id = media_handle_upload($file, $insert_ID);
								if (!is_wp_error($attachment_id) && $attachment_id > 0) {
									update_post_meta($insert_ID, '_thumbnail_id', $attachment_id);
								}
							}
						}
					}
					return esc_html__('Thank you! Your request has been submitted.', 'idonate');
				} else {
					return esc_html__('Sorry, an error occurred while processing your request.', 'idonate');
				}
			} else {
				return !empty($response['msg']) ? $response['msg'] : '';
			}
		} else {
			return esc_html__('Sorry, an error occurred while processing your request.', 'idonate');
		} // End check nonce
	}
}
