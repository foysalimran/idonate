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

// Create blood request type 
add_action( 'plugins_loaded', 'idonate_blood_request_type' );
function idonate_blood_request_type(){
	
	$args = array(
		'publicly_queryable' => true,
		'menu_icon' 		 => 'dashicons-editor-insertmore',
		'show_ui'       	 => true,
		'show_in_menu'       => false,
		'supports' 			 => array( 'title' )
	);
	
	$args = array(
		'post_type'		 => 'blood_request',
		'plural_name'    => 'Blood Request',
		'singular_name'  => 'Blood Request',
		'args'       	 => $args,
		'textdomain' 	 => 'idonate',
	);
	
	$object = new TaT_Posttype( $args );
	
}

// Idonate custom meta id callback
function idonate_meta_id( $id = '' ){
    
    $value = get_post_meta( get_the_ID(), $id, true );
    
    return $value;
}

// Idonate blood request single page table helper
function idonate_blood_request_table( $class ='' ,$label, $val  ){
	
	$html = '';
	
	$html .= '<tr>';
	$html .= '<td class="tbllabel '.esc_attr( $class ).'">'.esc_html( $label ).'</td>';
	$html .= '<td class="'.esc_attr( $class ).'">'.esc_html( $val ).'</td>';
	$html .= '</tr>';
	
	
	return $html;
}
	
// Inline Css callback 
function idonate_inline_css( $css ){
	
	$inlinestyle = '';
	if( $css ){
		$inlinestyle .= '<script typotica type="text/javascript">';
			$inlinestyle .= '( function($){
				$("head").append( "<style>'.$css.'</style>" );
			})(jQuery);';
		$inlinestyle .= '</script>';
	}
	echo $inlinestyle;
	
}

// Single page template
add_filter( 'single_template', 'idonate_custom_post_type_single_template' );
function idonate_custom_post_type_single_template($single_template) {
     global $post;

     if ($post->post_type == 'blood_request') {
          $single_template = IDONATE_DIR_NAME . '/templates/single-blood_request.php';
     }
     return $single_template;
}


// Template Include
add_filter( 'template_include', 'idonate_custom_post_type_template' );
function idonate_custom_post_type_template( $template ) {
		global $post;
		
		$requestOption = get_option( 'idonate_request_option_name' );
		
		// Request page
		if( !empty( $requestOption['rp_request_page'] ) ){
			$requestPage = $requestOption['rp_request_page'];
		}else{
			$requestPage = 'request';
		}
		
		// Request post form page
		if( !empty( $requestOption['rf_form_page'] ) ){
			$requestPostPage = $requestOption['rf_form_page'];
		}else{
			$requestPostPage = 'post-request';
		}
		
		
		if( is_page( $requestPage ) ){
			$template = IDONATE_DIR_NAME . '/templates/blood-request.php';
		}
		//
		if( is_page( $requestPostPage ) ){
			$template = IDONATE_DIR_NAME . '/templates/post-blood-request.php';
		}
   
          
  
		return $template;
}


// plugin settings link
add_filter( "plugin_action_links_".IDONATE_BASENAME."", 'idonate_add_settings_link' );
function idonate_add_settings_link( $links ) {
    $settings_link = '<a href="'.esc_url( admin_url('?page=idonate-setting-admin') ).'">' . esc_html__( 'Settings', 'idonate' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}

// Pro version link
add_filter("plugin_action_links_".IDONATE_BASENAME."", 'idonate_pro_link');
function idonate_pro_link(array $links)
{
    $url = "https://1.envato.market/a1Mjvq";
    $settings_link = '<a style="color: #35b747; font-weight: 700;" href="' .esc_url( $url ). '">' . esc_html__('Go Pro!', 'idonate') . '</a>';
    $links[] = $settings_link;
    return $links;
}

// Create page when plugin activated
function idonate_create_page_plugin_activated(){
	
	// Post Request page create
	$args = array(
		'post_type'	  => 'page',
		'post_title'  => wp_strip_all_tags('Post Request'),
		'post_status' => 'publish',
	);

    wp_insert_post( $args );
	
	// Request page create
	$Requestargs = array(
		'post_type'	  => 'page',
		'post_title'  => wp_strip_all_tags('Request'),
		'post_status' => 'publish',
	);

    wp_insert_post( $Requestargs );
}
// Delete page when plugin deactivated
function idonate_delete_page_plugin_deactivated(){
	
	$postRequestPage	= get_page_by_path( 'post-request' );
	$requestPage		= get_page_by_path( 'request' );
  
	wp_delete_post( $postRequestPage->ID );
	wp_delete_post( $requestPage->ID );
}

/**
 * Auto request Delete after pass data
 *
 */
 function idonate_auto_request_delete(){
	 
	$args = array(
		'post_type' => 'blood_request',
		'posts_per_page' => '-1'
	);
	
	
	$requests = get_posts( $args );
	
	$currentDate =  strtotime( date( 'M d, Y', current_time( 'timestamp', 1 ) ) );
	
	foreach( $requests as $request){
		
		$neededdate = get_post_meta( $request->ID, 'idonatepatient_bloodneed', true );
		
		
		
		if( $currentDate > strtotime( $neededdate ) ){
			wp_delete_post( $request->ID ); 
		}

	}

	
 }
 add_action( 'init', 'idonate_auto_request_delete' );

 /**
 * Custom Post pagination
 *
 */
function idonate_pagination( $custom_query ) {

	if( is_front_page() ){
		$paged = 'page';
	}else{
		$paged = 'paged';
	}

	$total_pages = $custom_query->max_num_pages;
	$big = 999999999; // need an unlikely integer

	if ($total_pages > 1){
		$current_page = max(1, get_query_var($paged));
		
		echo '<div class="row"><div class="col-sm-12"><div class="idonate-pagination">';
		echo paginate_links(array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?'.$paged.'=%#%',
			'current' => $current_page,
			'total' => $total_pages,
		));
		echo '</div></div></div>';
	}
}


?>