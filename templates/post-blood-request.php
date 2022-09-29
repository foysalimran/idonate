<?php 
 /**
  * 
  * @package    iDonate - blood donor management system WordPress Plugin
  * @version    1.0
  * @author     ThemeAtelier
  * @Websites: https://themeatelier.net/
  *
  *
  */
  
// Blocking direct access
if( ! defined( 'ABSPATH' ) ) {
    die ( IDONATE_ALERT_MSG );
}

get_header();

if( isset( $_POST['request_submit'] ) ){
	$message = idonate_blood_request_form_handel();
}else{
	$message = '';
}

//
$option = get_option( 'idonate_request_option_name' );

// Title
if( !empty( $option['rf_form_title'] ) ){
	$Formtitle =  $option['rf_form_title'];
}else{
	$Formtitle = esc_html__( 'Submit Your Request', 'idonate' );;
}
// Sub title
if( !empty( $option['rf_sub_title'] ) ){
	$Formsubtitle =  $option['rf_sub_title'];
}else{
	$Formsubtitle = esc_html__( 'Please fill the following information to post your blood request.', 'idonate' );
}

// Button Label
if( !empty( $option['rf_btn_label'] ) ){
	$Formbtnlabel =  $option['rf_btn_label'];
}else{
	$Formbtnlabel = esc_html__( 'Post Request', 'idonate' );
}

// Wrapper page
if( !empty( $option['rf_form_wrp_class'] ) ){
	$wrpClass =  $option['rf_form_wrp_class'];
}else{
	$wrpClass = '';
}
// Form Background Color
if( !empty( $option['rf_form_bgcolor'] ) ){
	$bgColor =  $option['rf_form_bgcolor'];
}else{
	$bgColor = '';
}
// Form Background Color
if( !empty( $option['rf_form_color'] ) ){
	$Color =  $option['rf_form_color'];
}else{
	$Color = '';
}


$Css = '.request-form,.request-form .form-control,.request-form .submit-info h2,.request-form .form-control::-moz-placeholder{color:'.esc_attr( $Color ).';}.request-form{background-color:'.esc_attr($bgColor).';};';

idonate_inline_css( $Css );


?>
<section class="request-form-page <?php echo esc_attr( $wrpClass ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 offset-sm-2">
				<div class="request-form">
					<?php 
					if( $Formtitle || $Formsubtitle ){
						
						$html = '<div class="submit-info">';
						// Title
						if( $Formtitle ){
							$html .= '<h2>'.esc_html( $Formtitle ).'</h2>';
						}
						// Sub title
						if( $Formsubtitle ){
							$html .= '<p>'.esc_html( $Formsubtitle ).'</p>';
						}
						
						$html .= '</div>';
						
						echo wp_kses_post( $html );
						
					}
					// Form Submit confirmation message
					if( $message ){
						echo '<div class="confirmation">';
							echo wp_kses_post( $message );
						echo '</div>';
					}
					
					?>
					
					<form action="" method="post">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="requesttitle"><?php esc_html_e( 'Title', 'idonate' ); ?></label>
									<input type="text" class="form-control" name="title" id="requesttitle" placeholder="<?php esc_html_e( 'Title', 'idonate' ); ?>" required>
								</div>
								<div class="form-group">
									<label for="patientname"><?php esc_html_e( 'Patient Name', 'idonate' ); ?></label>
									<input type="text" class="form-control" id="patientname" name="patientname" placeholder="<?php esc_html_e( 'Patient Name', 'idonate' ); ?>">
								</div>
								<div class="form-group">
									<label for="bloodgroup"><?php esc_html_e( 'Blood Group', 'idonate' ); ?></label>
									<select class="form-control" name="bloodgroup">
										<option value="Select"><?php esc_html_e( '-----Select-----', 'idonate' ); ?></option>
										<option value="A+"><?php esc_html_e( 'A+', 'idonate' ); ?></option>
										<option value="A-"><?php esc_html_e( 'A-', 'idonate' ); ?></option>
										<option value="A1+"><?php esc_html_e( 'A1+', 'idonate' ); ?></option>
										<option value="A1-"><?php esc_html_e( 'A1-', 'idonate' ); ?></option>
										<option value="A1B+"><?php esc_html_e( 'A1B+', 'idonate' ); ?></option>
										<option value="A1B-"><?php esc_html_e( 'A1B-', 'idonate' ); ?></option>
										<option value="A2+"><?php esc_html_e( 'A2+', 'idonate' ); ?></option>
										<option value="A2-"><?php esc_html_e( 'A2-', 'idonate' ); ?></option>
										<option value="A2B+"><?php esc_html_e( 'A2B+', 'idonate' ); ?></option>
										<option value="A2B-"><?php esc_html_e( 'A2B-', 'idonate' ); ?></option>
										<option value="AB+"><?php esc_html_e( 'AB+', 'idonate' ); ?></option>
										<option value="AB-"><?php esc_html_e( 'AB-', 'idonate' ); ?></option>
										<option value="B+"><?php esc_html_e( 'B+', 'idonate' ); ?></option>
										<option value="B-"><?php esc_html_e( 'B-', 'idonate' ); ?></option>
										<option value="O+"><?php esc_html_e( 'O+', 'idonate' ); ?></option>
										<option value="O-"><?php esc_html_e( 'O-', 'idonate' ); ?></option>
									</select>
								</div>
								<div class="form-group">
									<label for="patientage"><?php esc_html_e( 'Patient Age', 'idonate' ); ?></label>
									<input type="number" class="form-control" id="patientage" name="patientage" placeholder="<?php esc_html_e( 'Patient Age', 'idonate' ); ?>">
								</div>
								<div class="form-group">
									<label for="needblood"><?php esc_html_e( 'When Need Blood ?', 'idonate' ); ?></label>
									<input type="text" class="form-control date-picker" id="needblood" name="needblood" placeholder="<?php esc_html_e( 'When Need Blood ?', 'idonate' ); ?>">
								</div>
								<div class="form-group">
									<label for="bloodgroup"><?php esc_html_e( 'State', 'idonate' ); ?></label>
									<select class="form-control state" name="state">
										<option><?php esc_html_e( 'Select Country First', 'idonate' ); ?></option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="bloodunits"><?php esc_html_e( 'Blood Unit / Bag (S)', 'idonate' ); ?></label>
									<input type="number" class="form-control" id="bloodunits" name="bloodunits" placeholder="<?php esc_html_e( 'Blood Units', 'idonate' ); ?>" required>
								</div>
								<div class="form-group">
									<label for="purpose"><?php esc_html_e( 'Purpose', 'idonate' ); ?></label>
									<input type="text" class="form-control" id="purpose" name="purpose" placeholder="<?php esc_html_e( 'Purpose', 'idonate' ); ?>" required>
								</div>
								<div class="form-group">
									<label for="mobilenumber"><?php esc_html_e( 'Mobile Number', 'idonate' ); ?></label>
									<input type="text" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="<?php esc_html_e( 'Mobile Number', 'idonate' ); ?>">
								</div>
								<div class="form-group">
									<label for="hospitalname"><?php esc_html_e( 'Hospital Name', 'idonate' ); ?></label>
									<input type="text" class="form-control" id="hospitalname" name="hospitalname" placeholder="<?php esc_html_e( 'Hospital Name', 'idonate' ); ?>" required>
								</div>
								<div class="form-group">
									<label for="bloodgroup"><?php esc_html_e( 'Country', 'idonate' ); ?></label>
									<select class="form-control country" name="country">
										<?php 
										echo idonate_countries_options();
										?>
									</select>
								</div>
								<div class="form-group">
									<label for="location"><?php esc_html_e( 'City', 'idonate' ); ?></label>
									<input type="text" class="form-control" id="city" name="city" placeholder="<?php esc_html_e( 'City', 'idonate' ); ?>">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="location"><?php esc_html_e( 'Address', 'idonate' ); ?></label>
									<input type="text" class="form-control" id="location" name="location" placeholder="<?php esc_html_e( 'Address', 'idonate' ); ?>">
								</div>
								<div class="form-group">
									<label for="details"><?php esc_html_e( 'Details', 'idonate' ); ?></label>
									<textarea class="form-control" name="details" rows="3" placeholder="<?php esc_html_e( 'Details', 'idonate' ); ?>"></textarea>
								</div>
								<?php
								$option = get_option( 'idonate_general_option_name' );
								if( !empty( $option['idonate_recaptcha_active'] ) ){
									$sitekey = !empty( $option['idonate_recaptcha_sitekey'] ) ? $option['idonate_recaptcha_sitekey'] : '';
									echo '<div class="g-recaptcha" data-sitekey="'.esc_attr( $sitekey ).'"></div>';
								}								
								//
								wp_nonce_field( 'request_nonce_action', 'request_submit_nonce_check' );
								?>
								<button type="submit" name="request_submit" class="btn mt-30 btn-default btn-center"><?php echo esc_html( $Formbtnlabel ); ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
get_footer();
?>