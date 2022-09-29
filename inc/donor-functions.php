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

// Recaptcha response
function idonate_recaptcha_response(){
	
	$option = get_option( 'idonate_general_option_name' );
	
	$result = array();
	
	if( !empty( $option['idonate_recaptcha_active'] ) ){
	
		if( isset( $_POST['g-recaptcha-response'] ) && !empty( $_POST['g-recaptcha-response'] ) ){
			//your site secret key
			$secret = !empty( $option['idonate_recaptcha_secretkey'] ) ? $option['idonate_recaptcha_secretkey'] : '' ;
			//get verify response data
			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
			$responseData = json_decode($verifyResponse);
			
			if( $responseData->success ){
				$result['status'] = $responseData->success;
			}else{
				$result['status'] = false;
				$result['msg'] = __( 'Robot verification failed, please try again.', 'idonate' );
			}
			
		}else{
			$result['status'] = false;
			$result['msg'] = __( 'Please click on the reCAPTCHA box.', 'idonate' );
		}
	
	}else{
		$result['status'] = true;
	}

	return $result;
}

// idonate Old version request status update
function idonate_oldver_request_status_update(){
	
	$args = array(
		'post_type' => 'blood_request',
		'posts_per_page' => '-1'
	);
	
	$posts = get_posts( $args );
	
	foreach( $posts as $id ){
				
		update_post_meta( $id->ID, 'idonate_status', '1' );
			
	}
	
}
// idonate Old version donor status update
function idonate_oldver_donor_status_update(){
	
	$args = array(
		'post_type' => 'blood_request',
		'posts_per_page' => '-1'
	);
	
	$posts = get_posts( $args );
	
	foreach( $posts as $id ){
				
		update_post_meta( $id->ID, 'idonate_status', '1' );
			
	}
	
}


?>