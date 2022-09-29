<?php 
if( !class_exists('Idonate_DashboardWidgets') ){
class Idonate_DashboardWidgets{
	
	function __construct(){
		
		add_action( 'wp_dashboard_setup', array( $this, 'add_blood_request_panding_widget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'dashboard_scripts' ) );
		add_action( 'wp_ajax_panding_blood_request_action', array( $this, 'panding_blood_request_action' ) );
		add_action( 'wp_ajax_nopriv_panding_blood_request_action', array( $this, 'panding_blood_request_action' ) );
	}
	
	// 
	public static function add_dashboard_widgets( $widget_slug, $widget_title, $widget_callback ){
		wp_add_dashboard_widget(
                $widget_slug,     // Widget slug.
                $widget_title,    // Title.
                $widget_callback // Display function.
        );	
	}

	// Panding Blood Request Widget
	public function add_blood_request_panding_widget(){
		self::add_dashboard_widgets( 'idonate-pbrw', 'Panding Blood Request List ', array( $this, 'blood_request_panding_callback' ) );
	}
	// Panding Blood Request callback
	public function  blood_request_panding_callback(){
		echo '<h2 class="panding-list-heading">Blood Request Panding List</h2>';
		
		$args = array(
			'post_type' 	=> 'blood_request',
			'meta_key'		=> 'idonate_status',
			'meta_value'	=> '0'
		);
		
		$loop = new WP_Query( $args );
		
		if( $loop->have_posts() ){
			echo '<ul class="panding-list">';
		while( $loop->have_posts() ){
			$loop->the_post();
				$listid = 'list'.esc_attr( get_the_ID() );
				echo '<li id="'.esc_attr( $listid ).'" data-listid="#'.esc_attr($listid).'" class="list-item"><span>'.esc_html( get_the_title() ).'</span><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal'.esc_attr( get_the_ID() ).'">'.esc_html__( 'Preview', 'idonate' ).'</button>'.$this->blood_request_modal().'</li>';
			}
			echo '</ul>';
		}
	}
		
	// Blood Request modal
	public function blood_request_modal(){
		$bgroup = idonate_meta_id( 'idonatepatient_bloodgroup' );
		$need = idonate_meta_id( 'idonatepatient_bloodneed' );
		$units = idonate_meta_id( 'idonatepatient_bloodunit' );
		$mobnumber = idonate_meta_id( 'idonatepatient_mobnumber' );

		ob_start();
		?>
		<!-- Modal -->
		<div class="idonate-dpdw-modal fade" id="modal<?php echo esc_attr( get_the_ID() ); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="#modal<?php echo esc_attr( get_the_ID() ); ?>" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="top-info">
					<h4 class="modal-title" id="myModalLabel"><?php the_title(); ?></h4>
					<img width="60" src="<?php echo esc_url( IDONATE_DIR_URL ); ?>img/heart-01.png" />
				</div>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<?php
						// Name
						$name = idonate_meta_id( 'idonatepatient_name' );
						if( $name ){
							echo idonate_blood_request_table( 'info', esc_html__('Patient Name:', 'idonate' ) ,$name );
						}
						// Age
						$age = idonate_meta_id( 'idonatepatient_age' );
						if( $age ){
							echo idonate_blood_request_table( 'info', esc_html__('Patient Age:', 'idonate' ) ,$age );
						}
						// Blood Group
						$bgroup = idonate_meta_id( 'idonatepatient_bloodgroup' );
						if( $bgroup ){
							echo idonate_blood_request_table( 'danger', esc_html__('Blood Group:', 'idonate' ) ,$bgroup );
						}
						// When Need Blood ?
						$need = idonate_meta_id( 'idonatepatient_bloodneed' );
						if( $need ){
							echo idonate_blood_request_table( 'danger', esc_html__('When Need Blood ?:', 'idonate' ) ,$need );
						}
						// Blood Units
						$units = idonate_meta_id( 'idonatepatient_bloodunit' );
						if( $units ){
							echo idonate_blood_request_table( 'danger', esc_html__('Blood Unit / Bag (S):', 'idonate' ) ,$units );
						}
						// Purpose
						$purpose = idonate_meta_id( 'idonatepurpose' );
						if( $purpose ){
							echo idonate_blood_request_table( 'info', esc_html__('Purpose: ', 'idonate' ) ,$purpose );
						}
						// Mobile Number
						$mobnumber = idonate_meta_id( 'idonatepatient_mobnumber' );
						if( $mobnumber ){
							echo idonate_blood_request_table( 'danger', esc_html__('Mobile Number: ', 'idonate' ) ,$mobnumber );
						}
						// Email
						$email = idonate_meta_id( 'idonatepatient_email' );
						if( $email ){
							echo idonate_blood_request_table( 'info', esc_html__('Email: ', 'idonate' ) ,$email );
						}
						// Hospital Name
						$hospital = idonate_meta_id( 'idonatehospital_name' );
						if( $hospital ){
							echo idonate_blood_request_table( 'info', esc_html__('Hospital Name: ', 'idonate' ) ,$hospital );
						}
						// Country
						$countrycode = idonate_meta_id( 'idonatecountry' );
						$country = idonate_country_name_by_code( $countrycode );
						
						if( $country ){
							echo idonate_blood_request_table( 'info', esc_html__('Country: ', 'idonate' ) ,$country );
						}
						// State
						$statecode = idonate_meta_id( 'idonatestate' );
						$state = idonate_states_name_by_code( $countrycode, $statecode );
						if( $state ){
							echo idonate_blood_request_table( 'info', esc_html__('State: ', 'idonate' ) ,$state );
						}
						// City
						$city = idonate_meta_id( 'idonatecity' );
						if( $city ){
							echo idonate_blood_request_table( 'info', esc_html__('City: ', 'idonate' ) ,$city );
						}
						// Location/Address
						$location = idonate_meta_id( 'idonatelocation' );
						if( $location ){
							echo idonate_blood_request_table( 'info', esc_html__('Address:', 'idonate' ) ,$location );
						}
						
						?>
					  </table>
					
				</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default delete" data-uid="<?php echo esc_attr( get_the_ID() ); ?>" data-reqaction="delete"><?php esc_html_e( 'Delete', 'idonate' ); ?></button>
				<button type="button" class="btn btn-default" data-uid="<?php echo esc_attr( get_the_ID() ); ?>" data-reqaction="approve"><?php esc_html_e( 'Approve', 'idonate' ); ?></button>
			  </div>
			</div>
		  </div>
		</div>
		<?php
		return ob_get_clean();
	}
	// enqueue script
	public function dashboard_scripts(){
		wp_enqueue_style( 'dashboard-widget', IDONATE_DIR_URL.'css/idonate-dashboard-widget.css' );
		wp_enqueue_script( 'dashboard-widget', IDONATE_DIR_URL.'js/idonate-dashboard-widget.js', array('jquery'), '1.0', true );
		
		wp_localize_script( 'dashboard-widget', 'idonate_dashboardwidget', array(
			'ajax_url' => admin_url( 'admin-ajax.php' )
		));
	}

	// Panding blood request action ajax
	public function panding_blood_request_action(){
		
		$result = '';
		// Blood request action
		if( isset( $_POST['target'] ) && $_POST['target'] == 'delete' ){
			if( isset( $_POST['userid'] ) ){
				$id = wp_delete_post( $_POST['userid']);
				if( !is_wp_error( $id ) ){
					$result = array(
						'action' => 'delete',
						'msg'	 => 'Successfully delete'
					);
				}
			}
		}elseif( isset( $_POST['target'] ) && $_POST['target'] == 'approve' ){
			if( isset( $_POST['userid'] ) ){
								
				$id =	update_post_meta( $_POST['userid'], 'idonate_status', '1' );
				
				if( !is_wp_error( $id ) ){
					$result = array(
						'action' => 'approved',
						'msg'	 => 'Successfully approved'
					);
				}
				
			}
		}
		
		if( is_array( $result ) ){
			$result = wp_json_encode( $result );
		}
		
		echo $result;
		
		die();
	}
}
$obj = new Idonate_DashboardWidgets();
}
?>