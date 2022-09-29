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
if( ! defined( 'ABSPATH' ) ) {
    die ( IDONATE_ALERT_MSG );
}


// Post blood request form data
function idonate_blood_request_form_handel(){
	
	
	$request_error = new WP_Error;
	
	if( isset( $_POST['request_submit_nonce_check'] ) && wp_verify_nonce( $_POST['request_submit_nonce_check']  , 'request_nonce_action' ) ){  // nonce check
		
		$response = idonate_recaptcha_response();
		
		if( !empty( $response['status'] ) ){
		
		//  Empty title check
		if( !empty( $_POST['title'] ) ){
			$title = $_POST['title'];
		}else{
			$request_error->add( 'field', __( 'Title field can\'t be empty.', 'idonate' ) );
		}
		//  Empty patient name check
		if( !empty( $_POST['patientname'] ) ){
			$patientname = $_POST['patientname'];
		}else{
			$request_error->add( 'field', __( 'Patient name field can\'t be empty.', 'idonate' ) );
		}
		//  Empty patient age check
		if( !empty( $_POST['patientage'] ) && (int) $_POST['patientage']  ){
			$patientage = $_POST['patientage'];
		}else{
			$request_error->add( 'field', __( 'Patient age should be number and field can\'t be empty.', 'idonate' ) );
		}
		//  Empty blood group check
		if( !empty( $_POST['bloodgroup'] ) ){
			$bloodgroup = $_POST['bloodgroup'];
		}else{
			$request_error->add( 'field', __( 'Blood group field can\'t be empty.', 'idonate' ) );
		}
		//  Empty when need blood check
		if( !empty( $_POST['needblood'] ) ){
			$needblood = $_POST['needblood'];
		}else{
			$request_error->add( 'field', __( 'When need blood field can\'t be empty.', 'idonate' ) );
		}
		//  Empty blood units check
		if( !empty( $_POST['bloodunits'] ) && (int) $_POST['bloodunits'] ){
			$bloodunits = $_POST['bloodunits'];
		}else{
			$request_error->add( 'field', __( 'Blood units field can\'t be empty and should be number.', 'idonate' ) );
		}
		//  Empty purpose check
		if( !empty( $_POST['purpose'] ) ){
			$purpose = $_POST['purpose'];
		}else{
			$request_error->add( 'field', __( 'Purpose field can\'t be empty.', 'idonate' ) );
		}
		//  Empty mobile number check
		if( !empty( $_POST['mobilenumber'] ) ){
			$mobilenumber = $_POST['mobilenumber'];
		}else{
			$request_error->add( 'field', __( 'Mobile number field can\'t be empty.', 'idonate' ) );
		}
		//  Empty hospital name check
		if( !empty( $_POST['hospitalname'] ) ){
			$hospitalname = $_POST['hospitalname'];
		}else{
			$request_error->add( 'field', __( 'Hospital name field can\'t be empty.', 'idonate' ) );
		}
		
		//  Empty Country check
		if( !empty( $_POST['country'] ) ){
			$country = $_POST['country'];
		}else{
			$request_error->add( 'field', __( 'Country field can\'t be empty.', 'idonate' ) );
		}
		//  Empty State check
		if( !empty( $_POST['state'] ) ){
			$state = $_POST['state'];
		}else{
			$request_error->add( 'field', __( 'State field can\'t be empty.', 'idonate' ) );
		}
		//  Empty city check
		if( !empty( $_POST['city'] ) ){
			$city = $_POST['city'];
		}else{
			$request_error->add( 'field', __( 'City field can\'t be empty.', 'idonate' ) );
		}
		
		//  Empty location check
		if( !empty( $_POST['location'] ) ){
			$location = $_POST['location'];
		}else{
			$request_error->add( 'field', __( 'Location field can\'t be empty.', 'idonate' ) );
		}
		//  Empty Details check
		if( !empty( $_POST['details'] ) ){
			$details = $_POST['details'];
		}else{
			$request_error->add( 'field', __( 'Details field can\'t be empty.', 'idonate' ) );
		}
		

		
		// Insert Post
		if( 1 > count( $request_error->get_error_messages() ) ){
			
			$args = array(
				'post_type' 	=> 'blood_request',
				'post_title' 	=> sanitize_text_field( $title ),
				'post_status' 	=> 'publish',
			);
			
			$insert_ID = wp_insert_post( $args );
			
			if( $insert_ID ){
				
				// Post status 
				$option = get_option( 'idonate_general_option_name' );
				$status = '1';
				if( !empty( $option['donor_request_status'] ) ){
					$status = '0';
				}
								
				update_post_meta( $insert_ID, 'idonatepatient_name', sanitize_text_field( $patientname ) );
				update_post_meta( $insert_ID, 'idonatepatient_bloodgroup', sanitize_text_field( $bloodgroup ) );
				update_post_meta( $insert_ID, 'idonatepatient_age', sanitize_text_field( $patientage ) );
				update_post_meta( $insert_ID, 'idonatepatient_bloodneed', sanitize_text_field( $needblood ) );
				update_post_meta( $insert_ID, 'idonatepatient_bloodunit', sanitize_text_field( $bloodunits ) );
				update_post_meta( $insert_ID, 'idonatepurpose', sanitize_text_field( $purpose ) );
				update_post_meta( $insert_ID, 'idonatepatient_mobnumber', sanitize_text_field( $mobilenumber ) );
				update_post_meta( $insert_ID, 'idonatehospital_name', sanitize_text_field( $hospitalname ) );
				update_post_meta( $insert_ID, 'idonatecountry', sanitize_text_field( $country ) );
				update_post_meta( $insert_ID, 'idonatestate', sanitize_text_field( $state ) );
				update_post_meta( $insert_ID, 'idonatecity', sanitize_text_field( $city ) );
				update_post_meta( $insert_ID, 'idonatelocation', sanitize_text_field( $location ) );
				update_post_meta( $insert_ID, 'idonatedetails', sanitize_text_field( $details ) );
				update_post_meta( $insert_ID, 'idonate_status', sanitize_text_field( $status ) );
				
				
				return esc_html__( 'Thank you! Your request has been submitted.', 'idonate' );
			}else{
				return esc_html__( 'Sorry, an error occurred while processing your request.', 'idonate' );
			}
			
			
			
		}else{
			
			$error =  $request_error->get_error_messages();
			$error = implode( '<br>', $error );
			
			return $error;
		}
		
		}else{
			return !empty( $response['msg'] ) ? $response['msg'] : '';
		}
		
	}else{
		return esc_html__( 'Sorry, an error occurred while processing your request. Please try again.', 'idonate' );
	}// End check nonce
	
	
}


?>