<?php
/**
 * Template Class
 *
 * @package Idonate
 * @author ThemeAtelier<themeatelierbd@gmail.com>
 * @link https://themeatelier.net
 * @since 1.0.0
 */

 namespace ThemeAtelier\Idonate\Frontend\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle template before include
 *
 * @since 1.0.0
 */
class Template {

	/**
	 * Register Hooks
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_filter( 'template_include', array( $this, 'donor_public_profile' ), 99 );
	}


	public function donor_public_profile( $template ) {
		global $wp_query;
		$query_var = $wp_query->query_vars;
		if ( ! empty( $wp_query->query['idonate_profile_username'] ) ) {
			$template = IDONATE_DIR_NAME . '/src/Frontend/Templates/single-donor.php';
		}

		return $template;
	}
}
