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
class IDonateDonorSettings
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
				'title'  => esc_html__('DONOR SETTINGS', 'idonate'),
				'icon'	=> 'icofont-blood-drop',
				'fields' => array(
					array(
						'type' => 'tabbed',
						'tabs' => array(

							array(
								'title'  => __('Donor Listings Settings', 'idaonte-pro'),
								'fields' => array(
									array(
										'id'       => 'donor_register_status',
										'type'     => 'switcher',
										'title'    => esc_html__('Require Admin Approval for Donor Registration', 'idonate'),
										'desc'		=> esc_html__('When enabled, all donor registrations will require admin approval before being accepted to ensure the validity and reliability of the information.', 'idonate'),
										'text_on'	=> esc_html__('Enable', 'idonate'),
										'text_off'	=> esc_html__('Disable', 'idonate'),
										'text_width'	=> '100'
									),

									array(
										'id'       => 'idonate_donorshowlogin',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Require User Login to View Donors', 'idonate'),
										'desc'	=> esc_html__('When enabled, users must log in to view the list of donors, ensuring the privacy and security of donor information.', 'idonate'),
										'text_on'	=> esc_html__('Enable', 'idonate'),
										'text_off'	=> esc_html__('Disable', 'idonate'),
										'text_width'	=> '100'
									),

									array(
										'id'       => 'donors_number_of_columns',
										'type'     => 'column',
										'class' => 'pro_only_field',
										'title'    => esc_html__('Column(s)', 'idonate'),
										'desc' => esc_html__('Set number of column(s) in different devices for responsive view.', 'idonate'),
										'default'  => array(
											'large_desktop'    => '3',
											'desktop'          => '3',
											'tablet'           => '2',
											'mobile'           => '1',
										),
										'min'      => '1',
										'help'       => __('<i class="icofont-monitor"></i> <b> Large Desktop </b> - is larger than 1200px,<br><i class="icofont-laptop"></i> <b>Desktop</b> - size is larger than 992px,<br> <i class="icofont-surface-tablet"></i> <b>Tablet</b> - Size is larger than 768,<br> <i class="icofont-android-tablet"></i> <b> Mobile Landscape </b> - size is larger than 576px.,<br> <i class="icofont-android-tablet"></i> <b> Mobile </b> - size is smaller than 576px.', 'idonate'),
									),

									array(
										'id'       => 'donor_per_page',
										'type'     => 'number',
										'title'    => esc_html__('Donor Per Page', 'idonate'),
										'desc'		=> esc_html__('Set the number of donors displayed per page in the donor listings.', 'idonate'),
										'default'	=> 9,
									),
									array(
										'id'       => 'donor_view_button',
										'type'     => 'button_set',
										'class'     => 'pro_only_field',
										'title'    => esc_html__('Open Donor View Details Button', 'idonate'),
										'desc'	=> esc_html__('Choose how the donor details should displayed on', 'idonate'),
										'options' => array(
											'single_page_link' => esc_html__('On Single Page', 'idonate'),
											'popup' => esc_html__('On Pop Up', 'idonate'),
										),
										'default'	=> 'single_page_link',
									),
									array(
										'id'       	=> 'donor_view_slug',
										'type'     	=> 'text',
										'title'    	=> esc_html__('Donor Single Page Slug', 'idonate'),
										'default'	=> 'donor',
										'dependency' => array('donor_view_button', '==', 'single_page_link'),
									),
									array(
										'id'       => 'next_prev',
										'type'     => 'checkbox',
										'title'    => esc_html__('Enable Next/Prev', 'idonate'),
										'desc'		=> esc_html__('Allow navigation between donors using next and previous buttons in the popup view.', 'idonate'),
										'dependency' => array('donor_view_button', '==', 'popup')
									),

									array(
										'id'       => 'show_donor_search',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide Donor Search Options', 'idonate'),
										'desc'		=> esc_html__('Toggle the visibility of donor search options in the donor listings.', 'idonate'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> true,
									),
									array(
										'id'       => 'restrict_contact_info',
										'type'     => 'select',
										'class'      => 'select_pro_only',
										'title'    => esc_html__('Restrict Contact Info Visibility', 'idonate'),
										'options'  => array(
											'hide' => esc_html__('Hide', 'idonate'),
											'show_for_everyone' => esc_html__('Show for everyone', 'idonate'),
											'only_login_user' => esc_html__('Only logged in user', 'idonate'),
										),
										'default' => 'show_for_everyone',
									),
									array(
										'id'       => 'hide_email',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide Email From Donor Listing', 'idonate'),
										'desc'	=> esc_html__('Show/Hide email address from donor listing.', 'idonate'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> true,
										'dependency' 	=> array('restrict_contact_info', '!=', 'hide'),
									),
									array(
										'id'       => 'hide_mobile_number',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide Mobile Number', 'idonate'),
										'desc'	=> esc_html__('Show/Hide donors mobile number from donor listing.', 'idonate'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> true,
										'dependency' 	=> array('restrict_contact_info', '!=', 'hide'),
									),
									array(
										'id'       => 'hide_donor_social_share',
										'type'     => 'switcher',
										'class'    => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide Social Share', 'idonate'),
										'desc'	=> esc_html__('Show/Hide donors mobile number from donor listing.', 'idonate'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> true,
									),
								),
							),
							array(
								'title'  => __('Text Settings (Pro)', 'idaonte-pro'),
								'fields' => array(
									array(
										'id'       	=> 'donor_register_form_title',
										'type'     	=> 'text',
										'class'      => 'pro_only_field',
										'title'    	=> esc_html__('Title for Donor Registration Form', 'idonate'),
										'desc'	=> esc_html__('The title displayed on the donor registration form.', 'idonate'),
										'default'	=> esc_html__('Blood Donors Register', 'idonate'),
									),
									array(
										'id'       	=> 'donor_register_form_subtitle',
										'type'     	=> 'text',
										'class'      => 'pro_only_field',
										'title'    	=> esc_html__('Subtitle for Donor Registration Form', 'idonate'),
										'desc'		=> esc_html__('The subtitle displayed on the donor registration form', 'idonate'),
										'default'	=> esc_html__('Please fill the following information to register donor.', 'idonate'),
									),

									array(
										'id'       => 'donor_lft',
										'type'     => 'text',
										'class'      => 'pro_only_field',
										'title'    => esc_html__('Donor Login Form Title', 'idonate'),
										'desc'	=> esc_html__('The title displayed on the donor login form.', 'idonate'),
										'default' => 'Donor Login',
									),
									array(
										'id'       => 'donor_peft',
										'type'     => 'text',
										'class'      => 'pro_only_field',
										'title'    => esc_html__('Donor Profile Edit Form Title', 'idonate'),
										'desc'	=> esc_html__('The title displayed on the donor profile edit form.', 'idonate'),
										'default'	=> 'Edit Donors Information',
									),

								),
							),
							array(
								'title'  => __('Form Settings', 'idaonte-pro'),
								'fields' => array(
									array(
										'id'       => 'idonate_countryhide',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide country and state fields', 'idonate'),
										'desc'	=> esc_html__('Toggle the visibility of country and state fields', 'idonate'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> true,
									),
									array(
										'id'        => 'donor_form_color',
										'type'      => 'color_group',
										'class'      => 'pro_only_field',
										'title'     => esc_html__('Donor Form Color', 'idonat-pro'),
										'desc'	=> esc_html__('Set request form text and background color.', 'idonate'),
										'options'   => array(
											'background' => esc_html__('Background Color', 'idonate'),
											'color' => esc_html__('Text Color', 'idonate'),
										)
									),
								),
							),
						),
					),
				),
			)
		);
	}
}
