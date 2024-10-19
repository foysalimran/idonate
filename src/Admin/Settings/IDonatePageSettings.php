<?php

/**
 * Custom CSS settings tab.
 *
 * @since      1.0.0
 *
 * @package idonate
 * @subpackage idonate/Admin/Settings
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\Idonate\Admin\Settings;

use ThemeAtelier\Idonate\Admin\Framework\Classes\IDONATE;
// Cannot access directly.
if (!defined('ABSPATH')) {
	die;
}

/**
 * This class is responsible for Custom CSS settings tab in settings page.
 *
 * @since      1.0.0
 */
class IDonatePageSettings
{
	/**
	 * Custom CSS settings.
	 *
	 * @since 1.0.0
	 * @param string $prefix idonate_organizers_settings.
	 */
	public static function section($prefix)
	{
		IDONATE::createSection(
			$prefix,
			array(
				'title'  => esc_html__('PAGE SETTINGS', 'idonate'),
				'icon' => 'icofont-file-alt',
				'fields' => array(
					array(
						'id'       	=> 'dashboard_page',
						'type'     	=> 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    	=> esc_html__('Dashboard Page', 'idonate'),
						'options' 	=> 'pages',
						'desc'    	=> esc_html__('Select your dashboard page', 'idonate'),
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
					array(
						'id'       	=> 'rp_request_page',
						'type'     	=> 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    	=> esc_html__('Blood Request Listing Page', 'idonate'),
						'options' 	=> 'pages',
						'desc'    	=> esc_html__('Select your page to display blood requests. Default page name: Request', 'idonate'),
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
					array(
						'id'       => 'rf_form_page',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Blood Request Form Page', 'idonate'),
						'options' => 'pages',
						'desc'		=> esc_html('Select your page to display blood request form. Default page name: Blood request', 'idonate'),
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
					array(
						'id'       => 'donor_page',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Donor Listing Page', 'idonate'),
						'options'    => 'pages',
						'desc'    => esc_html__('Select your page to display donors. Default page name: Donors', 'idonate'),
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
					array(
						'id'       => 'donor_table_page',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Donor Table Page', 'idonate'),
						'options'    => 'pages',
						'desc'    => esc_html__('Select your page to display donor table. Default page name: Donor Table', 'idonate'),
						'placeholder' => 'Select an option',
					),
					array(
						'id'       => 'donor_register_page',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Donor Register Page', 'idonate'),
						'options'    => 'pages',
						'desc'    => esc_html__('Select your page to display donor registraion form. Default page name: Donor Register', 'idonate'),
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
					array(
						'id'       => 'login_redirect',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('After Login Redirect Page', 'idonate'),
						'desc'    => esc_html__('Select your page to redirect after successful login. Default page name: Home page', 'idonate'),
						'options'    => 'pages',
						'placeholder' => esc_html__('Select a page', 'idonate'),
						'query_args'  => array(
							'posts_per_page' => -1
						),
					),
					array(
						'id'       => 'logout_redirectpage',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('After Logout Redirect Page', 'idonate'),
						'desc'    => esc_html__('Select your page to redirect after successful logout. Default page name: Login page', 'idonate'),
						'options'    => 'pages',
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
				),
			)
		);
	}
}
