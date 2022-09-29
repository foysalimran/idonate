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
    die( IDONATE_ALERT_MSG );
}

if( !class_exists( 'TaT_Enqueue' ) ){
	
	class TaT_Enqueue{
		
		public function __construct( $args = array() ){
		
			add_action( 'wp_enqueue_scripts', array( $this, 'tal_frontend_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'tal_admin_enqueue_scripts' ) );

		}
		// Front-End enqueue scripts
		public function tal_frontend_enqueue_scripts(){
			
			$option = get_option( 'idonate_general_option_name' );
					
			// style
			if(  !empty( $option['load_bootstrap'] )  ){
				
				wp_enqueue_style( 'bootstrap', IDONATE_DIR_URL.'/css/bootstrap.min.css', array(), '3.7.7', false );
			}
			
			if( !empty( $option['load_fontawesome'] ) ){
				wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css', array(), '1.0', false );
			}
			
			wp_enqueue_style( 'idonate', IDONATE_DIR_URL.'/css/idonate.css', array(), '1.0', false );
			
			// Jquery ui css
			wp_enqueue_style('jquery-ui', IDONATE_DIR_URL.'/css/jquery-ui.min.css', array(), '1.12.1', false );   
			
			/**
			 * Scripts 
			 *
			 */
			 
			if( !empty( $option['idonate_recaptcha_active'] ) ){
				wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js', array('jquery' ), '1.0', true );
			}
			
			if(  !empty( $option['load_bootstrap'] )  ){
				wp_enqueue_script( 'bootstrap', IDONATE_DIR_URL.'/js/bootstrap.min.js', array('jquery'), '3.7.7', true );
			}
			
			wp_enqueue_script( 'idonate-min', IDONATE_DIR_URL.'/js/idonate-min.js', array('jquery','jquery-ui-datepicker'), '3.7.7', true );
			
			$data = array(
				'statesurl' => admin_url('admin-ajax.php')
			);
			
			wp_localize_script(
				'idonate-min',
				'localData',
				$data
			
			);

			
		}
		// Admin enqueue scripts
		public function tal_admin_enqueue_scripts(){
			
			// style			
			wp_enqueue_style( 'idonate-admin', IDONATE_DIR_URL.'/css/idonate-admin.css', array(), '1.0', false );
			
			wp_enqueue_style( 'wp-color-picker' );
			
			// Scripts
			
			wp_enqueue_script( 'idonate-admin', IDONATE_DIR_URL.'/js/idonate-admin.js', array('jquery', 'wp-color-picker' ), '1.0', true );
			

			
		}
		
		
	}
	$obj = new TaT_Enqueue();
}
?>