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
if( !class_exists( 'IDonate_ajax_handler' ) ){
	class IDonate_ajax_handler{
		
		function __construct(){
		
			add_action( 'wp_ajax_country_to_states_ajax', array( $this, 'idonate_country_to_states_ajax' ) );
			add_action( 'wp_ajax_nopriv_country_to_states_ajax', array( $this, 'idonate_country_to_states_ajax' ) );
			
		}
		

		// Country and states ajax
		public function idonate_country_to_states_ajax(){
			
			if( isset( $_POST['country'] ) ){
				
				include( IDONATE_COUNTRIES.'states/'.$_POST['country'].'.php' );
			}
			
			global $states;
			echo  json_encode( $states[$_POST['country']] );
			die();
			
		}
		
		
	}
	
	
	$ob = new IDonate_ajax_handler();
	
}
?>