<?php
class Idonate_Settings_Page
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $general_options;
    private $request_options;
	
    /**
     * Start up
     */
    public function __construct()
    {
		
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
		add_menu_page(
			esc_html__( 'IDonate Settings Page', 'idonate' ),
			esc_html__( 'IDonate Settings', 'idonate' ),
			'manage_options',
			'idonate-setting-admin',
			array( $this, 'create_admin_page' ),
			'dashicons-universal-access',
			6
		);
		// Add blood request post type into the sub menu of Idonate Settings menu.
		add_submenu_page(
			'idonate-setting-admin',
			esc_html__( 'Blood Request', 'idonate' ),
			esc_html__( 'Blood Request', 'idonate' ),
			'manage_options',
			'edit.php?post_type=blood_request',
			NULL
		);
		
		
    }

	
    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property general option
        $this->general_options = get_option( 'idonate_general_option_name' );
		
		// Set class property  request option
        $this->request_options = get_option( 'idonate_request_option_name' );
        ?>
        <div class="wrap">

            <ul class="settings-menu">
				<li><a href="<?php echo esc_url( admin_url('admin.php?page=idonate-setting-admin&tab=general') ); ?>"><?php esc_html_e( 'General', 'idonate' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url('admin.php?page=idonate-setting-admin&tab=request') ); ?>"><?php esc_html_e( 'Blood Request', 'idonate' ); ?></a></li>
			</ul>   

			<?php 
			// add error/update messages
	        
			// check if the user have submitted the settings
			if ( isset( $_GET['settings-updated'] ) ) {
			// add settings saved message with the class of "updated"
			add_settings_error( 'idonate_messages', 'idonate_message', __( 'Settings Saved', 'idonate' ), 'updated' );
			}
			
			// show error/update messages
			settings_errors( 'idonate_messages' );
			?>
            <form method="post" action="options.php">
			
            <?php
                // This prints out all hidden setting fields
               
				if( isset( $_GET['tab'] ) && $_GET['tab'] == 'request' ){
					
					settings_fields( 'idonate_option_group_request' );
					do_settings_sections( 'idonate-request-setting-admin' );
					
					
				}else{
					// general page
					settings_fields( 'idonate-general-option-group' );
					do_settings_sections( 'idonate-general-setting-admin' );
					
				}
                                
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
	
		// general register setting
        register_setting(
            'idonate-general-option-group', // Option group
            'idonate_general_option_name', // Option name
            array( $this, 'sanitize_general' ) // Sanitize
        );
		
        register_setting(
            'idonate_option_group_request', // Option group
            'idonate_request_option_name', // Option name
            array( $this, 'sanitize_request' ) // Sanitize
        );   
		
		
		/**
		 *  Settings Section
		 *
		 **/
		 
		// Idonate General Settings Section
        add_settings_section(
            'setting_section_general', // ID
            'General Settings', // Title
            array( $this, 'idonate_section_info' ), // Callback
            'idonate-general-setting-admin' // Page
        );
		
		// Blood Request Settings Section
        add_settings_section(
            'setting_section_request', // ID
            'Blood Request Form Settings', // Title
            array( $this, 'idonate_section_info' ), // Callback
            'idonate-request-setting-admin' // Page
        );  
		
		/**
		 *  General Settings field
		 *
		 **/
		add_settings_field(
			'load_bootstrap',
			'Load Bootstrap',
			array($this, 'load_bootstrap_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'load_fontawesome',
			'Load Fontawesome',
			array($this, 'load_fontawesome_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'donor_request_status',
			'Blood request post need approve',
			array($this, 'donor_request_status_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'idonate_recaptcha_active',
			'Form recaptcha Active',
			array($this, 'idonate_recaptcha_active_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'idonate_recaptcha_secretkey',
			'Recaptcha secret key',
			array($this, 'idonate_recaptcha_secretkey_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'idonate_recaptcha_sitekey',
			'Recaptcha Site key',
			array($this, 'idonate_recaptcha_sitekey_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		add_settings_field(
			'idonate_country',
			'Use single country',
			array($this, 'idonate_country_callback'),
			'idonate-general-setting-admin',
			'setting_section_general'
		);
		/**
		 *  Blood request Settings field
		 *
		 **/
        add_settings_field(
            'rf_divider', // ID
            '', // Title 
            array( $this, 'idonate_admin_divider_rf_callback' ), // Callback
            'idonate-request-setting-admin', // Page
            'setting_section_request' // Section           
        );
        add_settings_field(
            'rf_form_title', // ID
            'Request Form Title', // Title 
            array( $this, 'rf_form_title_callback' ), // Callback
            'idonate-request-setting-admin', // Page
            'setting_section_request' // Section           
        );
        add_settings_field(
            'rf_sub_title', 
            'Request Form Sub Title', 
            array( $this, 'rf_sub_title_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
        add_settings_field(
            'rf_btn_label', 
            'Request Form Submit Button Label', 
            array( $this, 'rf_btn_label_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rf_form_page', 
            'Request Form Page', 
            array( $this, 'rf_form_page_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
        add_settings_field(
            'rf_form_wrp_class', 
            'Request Form Wrapper Class', 
            array( $this, 'rf_form_wrp_class_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rf_form_bgcolor', 
            'Request Form Background Color', 
            array( $this, 'rf_form_bgcolor_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rf_form_color', 
            'Request Form Text Color', 
            array( $this, 'rf_form_color_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
		// request Page
		add_settings_field(
            'rp_admin_divider', 
            '', 
            array( $this, 'idonate_admin_divider_rp_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
		add_settings_field(
            'rp_request_page', 
            'Blood Request Page', 
            array( $this, 'rp_request_page_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
		add_settings_field(
            'rp_request_per_page', 
            'Blood Request Per Page', 
            array( $this, 'rp_request_perpage_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
        add_settings_field(
            'rp_request_page_wrp_class', 
            'Request Page Wrapper Class', 
            array( $this, 'rp_request_page_wrp_class_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        );
        add_settings_field(
            'rp_page_bgcolor', 
            'Request Page Background Color', 
            array( $this, 'rp_page_bgcolor_callback' ), 
            'idonate-request-setting-admin', 
            'setting_section_request'
        ); 
		
    }

    /**
	 * General Tab
	 *
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_general( $input  )
    {
        $new_input = array();
		
		
        if( isset( $input['load_bootstrap'] ) )
            $new_input['load_bootstrap'] = absint( $input['load_bootstrap'] );
		
		if( isset( $input['load_fontawesome'] ) )
            $new_input['load_fontawesome'] = absint( $input['load_fontawesome'] );
		
		if( isset( $input['donor_request_status'] ) )
            $new_input['donor_request_status'] = absint( $input['donor_request_status'] );
		
        if( isset( $input['idonate_recaptcha_active'] ) )
            $new_input['idonate_recaptcha_active'] = absint( $input['idonate_recaptcha_active'] );
		
        if( isset( $input['idonate_recaptcha_secretkey'] ) )
            $new_input['idonate_recaptcha_secretkey'] =  $input['idonate_recaptcha_secretkey'];
		
        if( isset( $input['idonate_recaptcha_sitekey'] ) )
            $new_input['idonate_recaptcha_sitekey'] =  $input['idonate_recaptcha_sitekey'];
				
        if( isset( $input['idonate_country'] ) )
            $new_input['idonate_country'] =  $input['idonate_country'];
		
        return $new_input;
    }

    /**
	 * Request Tab
	 * 
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_request( $input  )
    {
        $new_input = array();
		
		// Blood Request settings data
		if( isset( $input['rf_form_title'] ) )
			$new_input['rf_form_title'] = sanitize_text_field( $input['rf_form_title'] );
		
		if( isset( $input['rf_sub_title'] ) )
			$new_input['rf_sub_title'] = sanitize_text_field( $input['rf_sub_title'] );
		
		if( isset( $input['rf_btn_label'] ) )
			$new_input['rf_btn_label'] = sanitize_text_field( $input['rf_btn_label'] );
		
		if( isset( $input['rf_form_page'] ) )
			$new_input['rf_form_page'] = sanitize_text_field( $input['rf_form_page'] );
		
		if( isset( $input['rf_form_wrp_class'] ) )
			$new_input['rf_form_wrp_class'] = sanitize_text_field( $input['rf_form_wrp_class'] );
		
		if( isset( $input['rf_form_bgcolor'] ) )
			$new_input['rf_form_bgcolor'] = sanitize_text_field( $input['rf_form_bgcolor'] );
		
		if( isset( $input['rf_form_color'] ) )
			$new_input['rf_form_color'] = sanitize_text_field( $input['rf_form_color'] );
		
		if( isset( $input['rp_request_page'] ) )
			$new_input['rp_request_page'] = sanitize_text_field( $input['rp_request_page'] );
		
		if( isset( $input['rp_request_per_page'] ) )
			$new_input['rp_request_per_page'] = sanitize_text_field( $input['rp_request_per_page'] );
		
		if( isset( $input['rp_request_page_wrp_class'] ) )
			$new_input['rp_request_page_wrp_class'] = sanitize_text_field( $input['rp_request_page_wrp_class'] );
		
		if( isset( $input['rp_page_bgcolor'] ) )
			$new_input['rp_page_bgcolor'] = sanitize_text_field( $input['rp_page_bgcolor'] );
			
		
        return $new_input;
    }



	/*****************************************
		General Settings fields
	*****************************************/
	
	/** 
     * Get the settings option array and print one of its values
     */
    public function load_bootstrap_callback()
    {
		if( isset( $this->general_options['load_bootstrap'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="load_bootstrap" value="1" name="idonate_general_option_name[load_bootstrap]" %s />',
            $checked
        );
    }
	public function load_fontawesome_callback()
    {
		if( isset( $this->general_options['load_fontawesome'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="load_fontawesome" value="1" name="idonate_general_option_name[load_fontawesome]" %s />',
            $checked
        );
    }
	public function donor_request_status_callback()
    {
		if( isset( $this->general_options['donor_request_status'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="donor_request_status" value="1" name="idonate_general_option_name[donor_request_status]" %s />',
            $checked
        );
    }
				
    public function idonate_recaptcha_active_callback()
    {
		$url = 'https://www.google.com/recaptcha/admin#list';
		
		if( isset( $this->general_options['idonate_recaptcha_active'] ) ){
			$checked = ' checked';
		}else{
			$checked = '';
		}
		
		//
        printf(
            '<input type="checkbox" id="idonate_recaptcha_active" value="1" name="idonate_general_option_name[idonate_recaptcha_active]" %s />',
            $checked
        );
		echo '<p>Create google recaptcha <a target="_blank" href="'.esc_url( $url ).'"> sitekey and secretkey</a> </p>';
    }
	
    public function idonate_recaptcha_secretkey_callback()
    {
				
		if( isset( $this->general_options['idonate_recaptcha_secretkey'] ) ){
			$secretkey = $this->general_options['idonate_recaptcha_secretkey'];
		}else{
			$secretkey = '';
		}
		
		//
        printf(
            '<input type="text" id="idonate_recaptcha_secretkey" value="%s" name="idonate_general_option_name[idonate_recaptcha_secretkey]"  />',
            $secretkey
        );
		
    }
	
    public function idonate_recaptcha_sitekey_callback()
    {
		if( isset( $this->general_options['idonate_recaptcha_sitekey'] ) ){
			$sitekey = $this->general_options['idonate_recaptcha_sitekey'];
		}else{
			$sitekey = '';
		}
		
		//
        printf(
            '<input type="text" id="idonate_recaptcha_sitekey" value="%s" name="idonate_general_option_name[idonate_recaptcha_sitekey]"  />',
            $sitekey
        );
    }
	
    public function donotr_per_page_callback()
    {
		if( isset( $this->general_options['donor_per_page'] ) ){
			$number = $this->general_options['donor_per_page'];
		}else{
			$number = '10';
		}
		
		//
        printf(
            '<input type="text" id="donor_per_page" value="%s" name="idonate_general_option_name[donor_per_page]"  />',
            $number
        );
    }
	
    public function idonate_country_callback()
    {

	?>
	<select id="idonate_country" name="idonate_general_option_name[idonate_country]">
		<option value="all"><?php esc_html_e( 'All Countries', 'idonate' ); ?></option>
		<?php 
		$countries = idonate_all_countries();
        
		foreach( $countries as $key => $value ){
			
			$selected = ( isset ($this->general_options['idonate_country'] ) && $this->general_options['idonate_country'] == $key )? 'selected': '';
			
		echo '<option value="'.esc_html( $key ).'" '.esc_attr( $selected ).'>'.esc_html( $value ).'</option>';
			
		}
		
		?>
	
	</select>
	<?php
    }
    /** 
     * Admin Section Information
     */
    public function idonate_section_info()
    {
		
		$idpUrl  = 'https://codecanyon.net/item/idonatepro-blood-request-and-blood-donor-management-system-wordpress-plugin/21525871?ref=ThemeAtelier';
		$tfUrl  = 'https://themeforest.net/user/themeatelier/portfolio';
		$cUrl   = 'https://codecanyon.net/user/themeatelier/portfolio';
		$idonatepro  = IDONATE_DIR_URL . 'img/idonatepro.jpg';
		$tfImg  	 = IDONATE_DIR_URL . 'img/checkout.jpg';
		$cUImg  	 = IDONATE_DIR_URL . 'img/checkout-plugin.jpg';
		
		$html = '';
		$html .= '<div class="plug-info">';
		$html .= '<p>IDonate - Blood Request Management Wordpress Plugins.</p>';
		$html .= '<div class="ad-img">';
		$html .= '<a href="'.esc_url( $idpUrl ).'" target="_blank"><img width="130" src="'.esc_url( $idonatepro ).'" /></a>';
		$html .= '<a href="'.esc_url( $tfUrl ).'" target="_blank"><img width="130" src="'.esc_url( $tfImg ).'" /></a>';
		$html .= '<a href="'.esc_url( $cUrl ).'" target="_blank"><img width="130" src="'.esc_url( $cUImg ).'" /></a>';
		$html .= '</div>';
		$html .= '</div>';
		
		echo wp_kses_post( $html );
		
		
    }

	
	/*****************************************
		Blood Request Settings fields
	*****************************************/
	
	// Divider
    public function idonate_admin_divider_rf_callback()
    {
		$info = __( 'Blood Request Form Page Settings', 'idonate' );
		
        echo '<div class="id-admin-divider">'.esc_html( $info ).'</div>';
		
    }
	
    /** 
     * blood request form title callback
     */
    public function rf_form_title_callback()
    {
        printf(
            '<input type="text" id="rf_form_title" name="idonate_request_option_name[rf_form_title]" value="%s" />',
            isset( $this->request_options['rf_form_title'] ) ? esc_attr( $this->request_options['rf_form_title']) : ''
        );
    }

    /** 
     * blood request form sub title callback
     */
    public function rf_sub_title_callback()
    {
        printf(
            '<input type="text" id="rf_sub_title" name="idonate_request_option_name[rf_sub_title]" value="%s" />',
            isset( $this->request_options['rf_sub_title'] ) ? esc_attr( $this->request_options['rf_sub_title']) : ''
        );
		
    }
    /** 
     * blood request form button label callback
     */
    public function rf_btn_label_callback()
    {
        printf(
            '<input type="text" id="rf_btn_label" name="idonate_request_option_name[rf_btn_label]" value="%s" />',
            isset( $this->request_options['rf_btn_label'] ) ? esc_attr( $this->request_options['rf_btn_label']) : ''
        );
		
    }
    /** 
     * blood request form page callback
     */
    public function rf_form_page_callback()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>	 
	<select id="rf_form_page" name="idonate_request_option_name[rf_form_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->request_options['rf_form_page']) && $this->request_options['rf_form_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name post request', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 echo $html ;		
		
	
    }
	
	/** 
     * blood request form wrapper class callback
     */
    public function rf_form_wrp_class_callback()
    {
        printf(
            '<input type="text" id="rf_form_wrp_class" name="idonate_request_option_name[rf_form_wrp_class]" value="%s" />',
            isset( $this->request_options['rf_form_wrp_class'] ) ? esc_attr( $this->request_options['rf_form_wrp_class']) : ''
        );
		
    }
	
	/** 
     * blood request form background color callback
     */
    public function rf_form_bgcolor_callback()
    {
        printf(
            '<input type="text" id="rf_form_bgcolor" class="color-picker" name="idonate_request_option_name[rf_form_bgcolor]" value="%s" />',
            isset( $this->request_options['rf_form_bgcolor'] ) ? esc_attr( $this->request_options['rf_form_bgcolor']) : ''
        );
		
    }
	/** 
     * blood request form color callback
     */
    public function rf_form_color_callback()
    {
        printf(
            '<input type="text" id="rf_form_color" class="color-picker" name="idonate_request_option_name[rf_form_color]" value="%s" />',
            isset( $this->request_options['rf_form_color'] ) ? esc_attr( $this->request_options['rf_form_color']) : ''
        );
		
    }
  
  
   /******************************
    *Blood Request Page Fields
	*****************************/
  
	// Divider
    public function idonate_admin_divider_rp_callback()
    {
		$info = 'Blood Request Page Settings';
		
        echo '<div class="id-admin-divider">'.esc_html( $info ).'</div>';
		
    }
    /** 
     * blood request page callback
     */
    public function rp_request_page_callback()
    {
		
		$pages = get_pages();
					
		
		ob_start();
     ?>
	 
	<select id="rp_request_page" name="idonate_request_option_name[rp_request_page]">
		<option value=""><?php esc_html_e( 'Select Page', 'idonate' ); ?></option>
		<?php 
		if( $pages ){
			foreach( $pages as $page ){
				
				$selected = ( isset ($this->request_options['rp_request_page']) && $this->request_options['rp_request_page'] == $page->post_name )? 'selected':'';
				
			echo '<option value="'.esc_html( $page->post_name ).'" '.esc_attr( $selected ).'>'.esc_html( $page->post_title ).'</option>';
				
			}
		}
		
		?>
	
	</select>
    <p><?php esc_html_e( 'Default page name request', 'idonate' ); ?></p>
	<?php

	 $html = ob_get_clean();
	 echo  $html;		
		
	
    }
	/** 
     * blood request per page callback
     */
    public function rp_request_perpage_callback()
    {
        printf(
            '<input type="text" id="rp_request_per_page" name="idonate_request_option_name[rp_request_per_page]" value="%s" />',
            isset( $this->request_options['rp_request_per_page'] ) ? esc_attr( $this->request_options['rp_request_per_page']) : ''
        );
		
    }
	/** 
     * blood request wrapper class callback
     */
    public function rp_request_page_wrp_class_callback()
    {
        printf(
            '<input type="text" id="rp_request_page_wrp_class" name="idonate_request_option_name[rp_request_page_wrp_class]" value="%s" />',
            isset( $this->request_options['rp_request_page_wrp_class'] ) ? esc_attr( $this->request_options['rp_request_page_wrp_class']) : ''
        );
		
    }
	
	/** 
     * blood request page background color callback
     */
    public function rp_page_bgcolor_callback()
    {
        printf(
            '<input type="text" id="rp_page_bgcolor" class="color-picker" name="idonate_request_option_name[rp_page_bgcolor]" value="%s" />',
            isset( $this->request_options['rp_page_bgcolor'] ) ? esc_attr( $this->request_options['rp_page_bgcolor']) : ''
        );
		
    }


	
	
}

if( is_admin() )
    $idonate_settings_page = new Idonate_Settings_Page();
