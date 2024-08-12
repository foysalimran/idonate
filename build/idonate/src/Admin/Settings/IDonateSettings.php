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
use ThemeAtelier\Idonate\Helpers\Countries\Countries;
// Cannot access directly.
if (!defined('ABSPATH')) {
	die;
}

/**
 * This class is responsible for Custom CSS settings tab in settings page.
 *
 * @since      1.0.0
 */
class IDonateSettings
{

	/**
	 * Custom CSS settings.
	 *
	 * @since 1.0.0
	 * @param string $prefix idonate_organizers_settings.
	 */
	public static function section($prefix)
	{

		$countryOption = Countries::idonate_all_countries();

		IDONATE::createSection(
			$prefix,
			array(
				'title'  => esc_html__('GENERAL', 'idonate'),
				'icon'	=> 'icofont-gear',
				'fields' => array(
					array(
						'id'       => 'idonate_container',
						'type'     => 'column',
						'title'    => esc_html__('Container Width', 'idonate'),
						'desc' => esc_html__('Set plugin pages container maximum width in different devices.', 'idonate'),
						'default'  => array(
							'large_desktop'    	=> '1120',
							'desktop'          	=> '1140',
							'laptop'          	=> '960',
							'tablet'           	=> '720',
							'mobile'           	=> '540',
						),
					),
					array(
						'id'       => 'idonate_section_padding',
						'type'     => 'column',
						'class' => 'pro_only_field',
						'title'    => esc_html__('Section Padding', 'idonate'),
						'desc' => esc_html__('Set plugin pages section padding in different devices.', 'idonate'),
						'default'  => array(
							'large_desktop'    	=> '80',
							'desktop'          	=> '80',
							'laptop'          	=> '60',
							'tablet'           	=> '50',
							'mobile'           	=> '40',
						),
					),
					array(
						'id'        => 'idonate_color_settings',
						'type'      => 'color_group',
						'title'     => esc_html__('Color Settings', 'idonat-pro'),
						'class'		=> 'pro_only_field',
						'desc'		=> esc_html__('Basic color palette for elements', 'idoante-pro'),
						'options'   => array(
							'donor_maincolor' => esc_html__('Main Color', 'idonate'),
							'donor_bordercolor' => esc_html__('Main Border Color', 'idonate'),
						)
					),

					array(
						'id'       	=> 'idonate_recaptcha_active',
						'type'     	=> 'switcher',
						'title'    	=> esc_html__('Activate reCAPTCHA for Forms', 'idonate'),
						'desc'		=> __('When enabled, reCAPTCHA will be activated on all forms to enhance security and prevent spam submissions.', 'idonate'),
						'text_on'	=> esc_html__('Enable', 'idonate'),
						'text_off'	=> esc_html__('Disable', 'idonate'),
						'text_width'	=> '100',
					),
					array(
						'id' 			=>	'idonate_recapthca_label',
						'type' 			=>	'text',
						'title'			=> esc_html__('reCAPTCHA Label', 'idoante-pro'),
						'desc'			=> esc_html__('Label to display before the reCAPTCHA checkbox.', 'idoante-pro'),
						'default'		=> esc_html__('Please verify that you are human:', 'idoante-pro'),
						'dependency' 	=> array('idonate_recaptcha_active', '==', 'true'),
					),
					array(
						'id'       		=> 'idonate_recaptcha_secretkey',
						'type'     		=> 'text',
						'title'    		=> esc_html__('reCAPTCHA Secret Key', 'idonate'),
						'desc'	=> __('Create google recaptcha <a href="https://www.google.com/recaptcha/admin#list">sitekey and secretkey</a>', 'idonate'),
						'subtitle'			=> esc_html__('Set your generated recaptcha secret key.', 'idonate'),
						'dependency' 	=> array('idonate_recaptcha_active', '==', 'true')
					),
					array(
						'id'       => 'idonate_recaptcha_sitekey',
						'type'     => 'text',
						'title'    => esc_html__('Recaptcha Site Key', 'idonate'),
						'desc'	=> __('Create google recaptcha <a href="https://www.google.com/recaptcha/admin#list">sitekey and secretkey</a>', 'idonate'),
						'subtitle'		=> esc_html__('Set your generated recaptcha site key.', 'idonate'),
						'dependency' => array('idonate_recaptcha_active', '==', 'true')
					),
					array(
						'id'       => 'enable_single_country',
						'type'     => 'switcher',
						'title'    => esc_html__('Single Country Mode', 'idonate'),
						'desc'	=> esc_html__('When enabled, the forms will display only the selected country in the country field', 'idonate'),
						'text_on'	=> esc_html__('Enable', 'idonate'),
						'text_off'	=> esc_html__('Disable', 'idonate'),
						'text_width'	=> '100',
					),
					array(
						'id'       => 'idonate_country',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Select Country', 'idonate'),
						'options' => $countryOption,
						'dependency' => array('enable_single_country', '==', 'true')
					),

					array(
						'id'     => 'donor_social_share',
						'type'   => 'fieldset',
						'title'  => esc_html__('Social Share', 'idonate'),
						'fields' => array(
							array(
								'id'       => 'social_sharing_media',
								'type'     => 'select',
								'title'    => esc_html__('Sharing Media', 'idonate'),
								'chosen'   => true,
								'sortable' => true,
								'multiple' => true,
								'placeholder' => esc_html__('Choose an option', 'idonate'),
								'options'  => array(
									'facebook' => esc_html__('Facebook', 'idonate'),
									'twitter' => esc_html__('Twitter', 'idonate'),
									'linkedIn' => esc_html__('LinkedIn', 'idonate'),
									'pinterest' => esc_html__('Pinterest', 'idonate'),
									'email' => esc_html__('Email', 'idonate'),
									'instagram' => esc_html__('Instagram', 'idonate'),
									'vk'   => esc_html__('VK', 'idonate'),
									'digg' => esc_html__('digg', 'idonate'),
									'tumblr' => esc_html__('Tumblr', 'idonate'),
									'reddit' => esc_html__('Reddit', 'idonate'),
									'whatsapp' => esc_html__('WhatsApp', 'idonate'),
									'xing' => esc_html__('Xing', 'idonate'),
								),
							),
							array(
								'id'       => 'social_margin',
								'type'     => 'spacing',
								'title'    => esc_html__('Margin', 'idonate'),
								'sanitize' => 'idonate_sanitize_number_array_field',
								'min'      => -100,
								'units'    => array('px'),
								'default'  => array(
									'top'  => '0',
									'right' => '0',
									'bottom' => '0',
									'left' => '0',
								),
							),
							array(
								'id'      => 'social_icon_shape',
								'class'   => 'social_icon_shape',
								'type'    => 'layout_preset',
								'title'   => esc_html__('Icon Shape', 'idonate'),
								'options' => array(
									'idonate_circle'    => array(
										'image'       => IDONATE_ASSETS . 'images/circle-icon.png',
										'text' => esc_html__('Circle', 'idonate'),
									),
									'idonate_rounded'   => array(
										'image'       => IDONATE_ASSETS . 'images/round-icon.png',
										'text' => esc_html__('Rounded', 'idonate'),
									),
									'idonate_square'    => array(
										'image'       => IDONATE_ASSETS . 'images/square-icon.png',
										'text' => esc_html__('Square', 'idonate'),
									),
									'icon_only' => array(
										'image'       => IDONATE_ASSETS . 'images/only-icon.png',
										'text' => esc_html__('Icon only', 'idonate'),
									),
								),
								'default' => 'idonate_circle',
							),
							array(
								'id'      => 'social_icon_custom_color',
								'type'    => 'checkbox',
								'title'   => esc_html__('Custom Color', 'idonate'),
								'default' => false,
							),
							array(
								'id'      => 'social_icon_color',
								'type'    => 'color_group',
								'title'   => esc_html__('Icon Color', 'idonate'),
								'options' => array(
									'icon_color'       => esc_html__('Icon', 'idonate'),
									'icon_hover_color' => esc_html__('Icon Hover', 'idonate'),
									'icon_bg'       => esc_html__('Background', 'idonate'),
									'icon_bg_hover' => esc_html__('Background Hover', 'idonate'),
									'icon_border_hover' => esc_html__('Border Hover', 'idonate'),
								),
								'default' => array(
									'icon_color'       => '#ffffff',
									'icon_hover_color' => '#ffffff',
									'icon_bg'       => '#ef1414',
									'icon_bg_hover' => '#ef1414',
									'icon_border_hover' => '#ef1414',
								),
								'dependency' => array('social_icon_custom_color', '==', 'true'),
							),
							array(
								'id'      => 'social_icon_border',
								'type'    => 'border',
								'title'   => esc_html__('Icon Border', 'idonate'),
								'default' => array(
									'all' => '1',
									'style' => 'solid',
									'color' => '#af111c',
								),
								'all'     => true,
								'dependency' => array('social_icon_custom_color', '==', 'true'),
							),
						),
					),

				),
			)
		);
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
										'id'       => 'hide_email',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide Email From Donor Listing', 'idonate'),
										'desc'	=> esc_html__('Show/Hide email address from donor listing.', 'idonate'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> true,
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
									),
									array(
										'id'       => 'hide_donor_social_share',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
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
		IDONATE::createSection(
			$prefix,
			array(
				'title'  => esc_html__('REQUEST SETTINGS', 'idonate'),
				'icon'	=> 'icofont-blood',
				'fields' => array(
					array(
						'type' => 'tabbed',
						'tabs' => array(
							array(
								'title'  => __('Blood Request Listings Settings', 'idaonte-pro'),
								'fields' => array(
									array(
										'id'       => 'donor_request_status',
										'type'     => 'switcher',
										'title'    => esc_html__('Require Admin Approval for Blood Requests', 'idonate'),
										'desc'		=> esc_html__('When enabled, all blood request posts will require your approval before being published to ensure accuracy and appropriateness.', 'idonate'),
										'text_on'	=> esc_html__('Enable', 'idonate'),
										'text_off'	=> esc_html__('Disable', 'idonate'),
										'text_width'	=> '100'
									),
									array(
										'id'       => 'post_request_number_of_columns',
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
										'id'       	=> 'rp_request_per_page',
										'type'     	=> 'number',
										'title'    	=> esc_html__('Blood Request Per Page', 'idonate'),
										'desc'	=> esc_html__('Set the number of blood requests displayed per page in the blood requests listings.', 'idonate'),
										'default' 	=> 9,
									),

									array(
										'id'       => 'request_view_button',
										'type'     => 'button_set',
										'class'      => 'pro_only_field',
										'title'    => esc_html__('Open Request View Details', 'idonate'),
										'desc'	=> esc_html__('Choose how the request details should displayed on', 'idonate'),
										'options' => array(
											'single_page_link' => esc_html__('On Single Page', 'idonate'),
											'popup' => esc_html__('On Pop Up', 'idonate'),
										),
										'default'	=> 'single_page_link',
									),
									array(
										'id'       => 'request_next_prev',
										'type'     => 'checkbox',
										'title'    => esc_html__('Enable Next/Prev', 'idonate'),
										'desc'	=> esc_html__('Allow navigation between requests using next and previous buttons in the popup view.', 'idonate'),
										'dependency' => array('request_view_button', '==', 'popup')
									),
									array(
										'id'       => 'auto_delete_expired_requests',
										'type'     => 'select',
										'title'    => esc_html__('Auto-Delete Expired Blood Requests', 'idonate'),
										'desc'	=> esc_html__('Automatically remove blood requests that are no longer needed. ', 'idonate'),
										'options' => array(
											'never_delete' => esc_html__('Never Delete', 'idonate'),
											'current_date' => esc_html__('Delete on Blood Needed Date', 'idonate'),
											'one_week' => esc_html__('Delete One Week After Blood Needed Date', 'idonate'),
											'two_week' => esc_html__('Delete Two Weeks After Blood Needed Date (Pro)', 'idonate'),
											'one_month' => esc_html__('Delete One Month After Blood Needed Date (Pro)', 'idonate'),
										),
										'default' => 'one_week',
									),
								),
							),
							array(
								'title'  => __('Text Settings (Pro)', 'idaonte-pro'),
								'fields' => array(
									array(
										'id'       => 'rf_form_title',
										'type'     => 'text',
										'class'      => 'pro_only_field',
										'title'    => esc_html__('Blood Request Form Title', 'idonate'),
										'desc'		=> esc_html__('The title displayed on the request form.', 'idonate'),
										'default'	=> esc_html__('Submit Your Request', 'idonate'),
									),
									array(
										'id'       => 'rf_sub_title',
										'type'     => 'text',
										'class'      => 'pro_only_field',
										'title'    => esc_html__('Blood Request Form Sub Title', 'idonate'),
										'desc'		=> esc_html__('The subtitle displayed on the request form.', 'idonate'),
										'default'	=> esc_html__('Please fill the following information to post your blood request.', 'idonate'),
									),
									array(
										'id'       => 'rf_btn_label',
										'type'     => 'text',
										'class'      => 'pro_only_field',
										'title'    => esc_html__('Submit Button Label for Request Form', 'idonate'),
										'desc'	=> esc_html__('The label text displayed on the submit button of the request form.', 'idonate'),
										'default'	=> esc_html__('Blood Request', 'idonate'),
									),
								),
							),
							array(
								'title'  => __('Form Settings', 'idaonte-pro'),
								'fields' => array(
									array(
										'id'       => 'idonate_bloodrequestcountryhide',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide Country and State Fields On the Request Form', 'idonate'),
										'desc'	=> esc_html__('Toggle the visibility of country and state fields', 'idoante-pro'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> true,
									),
									array(
										'id'       => 'rf_form_img_upload',
										'type'     => 'switcher',
										'class'      => 'switcher_pro_only',
										'title'    => esc_html__('Show/Hide Image Upload Field On the Request Form', 'idonate'),
										'desc'	=> esc_html__('Toggle the visibility of image upload field', 'idoante-pro'),
										'text_on'	=> esc_html__('Show', 'idonate'),
										'text_off'	=> esc_html__('Hide', 'idonate'),
										'text_width'	=> '80',
										'default' 	=> false,
									),
									array(
										'id'       => 'request_form_color',
										'type'     => 'color_group',
										'class'      => 'pro_only_field',
										'title'    => esc_html__('Request Form Color', 'idonate'),
										'desc'	=> esc_html__('Set request form text and background color.', 'idonate'),
										'options'   => array(
											'background' => esc_html__('Background Color', 'idonate'),
											'color' => esc_html__('Text Color', 'idonate'),
										),
									),
								),
							),
						),
					),
				),
			)
		);

		IDONATE::createSection(
			$prefix,
			array(
				'title'  => esc_html__('PAGE SETTINGS', 'idonate'),
				'icon' => 'icofont-file-alt',
				'fields' => array(
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
						'id'       => 'donor_edit_page',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Donor Profile Edit Page', 'idonate'),
						'options'    => 'pages',
						'desc'    => esc_html__('Select your page to display donor edit form.  Default page name: Donor Edit', 'idonate'),
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
					array(
						'id'       => 'donor_profile_page',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Donor Profile Page', 'idonate'),
						'options'    => 'pages',
						'desc'    => esc_html__('Select your page to display donor profile. Default page name: Donor Profile', 'idonate'),
						'placeholder' => esc_html__('Select a page', 'idonate'),
					),
					array(
						'id'       => 'login_page',
						'type'     => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'    => esc_html__('Login Page', 'idonate'),
						'options'    => 'pages',
						'desc'    => esc_html__('Select your page to display donor login form. Default page name: Donor Login', 'idonate'),
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
		IDONATE::createSection(
			$prefix,
			array(
				'title'  => esc_html__('ADVANCE SETTINGS', 'idonate'),
				'icon'	=> 'icofont-tools-alt-2',
				'fields' => array(
					array(
						'type' => 'tabbed',
						'tabs' => array(
							array(
								'title'  => __('Advance Control', 'idaonte-pro'),
								'fields' => array(
									array(
										'id' 	  => 'idonate_data_remove',
										'type'    => 'checkbox',
										'title' => esc_html__('Delete Default Pages On Plugin Deactivation', 'idonate'),
										'help' => esc_html__('Check this box if you would like Idonate plugin to completely remove all pages created by default.', 'idonate'),
									),
									array(
										'type'    => 'subheading',
										'content' => esc_html__('Enqueue or Dequeue CSS', 'idonate'),
									),
									array(
										'id'       => 'load_icofont',
										'type'     => 'switcher',
										'title'    => esc_html__('IcoFont', 'idonate'),
										'text_on'	=> esc_html__('Enqueued', 'idonate'),
										'text_off'	=> esc_html__('Dequeued', 'idonate'),
										'text_width'	=> '100',
										'default' => true,
									),
									array(
										'id'       => 'load_magnific_popup_css',
										'type'     => 'switcher',
										'title'    => esc_html__('Magnific Popup', 'idonate'),
										'text_on'	=> esc_html__('Enqueued', 'idonate'),
										'text_off'	=> esc_html__('Dequeued', 'idonate'),
										'text_width'	=> '100',
										'default' => true,
									),
									array(
										'id'       => 'datatables_css',
										'type'     => 'switcher',
										'title'    => esc_html__('Data Tables', 'idonate'),
										'text_on'	=> esc_html__('Enqueued', 'idonate'),
										'text_off'	=> esc_html__('Dequeued', 'idonate'),
										'text_width'	=> '100',
										'default' => true,
									),
									array(
										'type'    => 'subheading',
										'content' => esc_html__('Enqueue or Dequeue JS', 'idonate'),
									),
									array(
										'id'       => 'load_magnific_popup_js',
										'type'     => 'switcher',
										'title'    => esc_html__('Magnific Popup', 'idonate'),
										'text_on'	=> esc_html__('Enqueued', 'idonate'),
										'text_off'	=> esc_html__('Dequeued', 'idonate'),
										'text_width'	=> '100',
										'default' => true,
									),
									array(
										'id'       => 'datatables_js',
										'type'     => 'switcher',
										'title'    => esc_html__('Data Tables', 'idonate'),
										'text_on'	=> esc_html__('Enqueued', 'idonate'),
										'text_off'	=> esc_html__('Dequeued', 'idonate'),
										'text_width'	=> '100',
										'default' => true,
									),
									array(
										'id'       => 'validate_js',
										'type'     => 'switcher',
										'title'    => esc_html__('Form Validate', 'idonate'),
										'text_on'	=> esc_html__('Enqueued', 'idonate'),
										'text_off'	=> esc_html__('Dequeued', 'idonate'),
										'text_width'	=> '100',
										'default' => true,
									),
								),
							),
							array(
								'title'  => __('Custom Codes', 'idaonte-pro'),
								'fields' => array(
									array(
										'id'       => 'idoante_custom_css',
										'type'     => 'code_editor',
										'title'    => esc_html__('CUSTOM CSS', 'idonate'),
										'sanitize' => false,
										'settings' => array(
											'theme'  => 'mbo',
											'mode'   => 'css',
										),
									),
									array(
										'id'       => 'idoante_custom_js',
										'type'     => 'code_editor',
										'title'    => esc_html__('CUSTOM JS', 'idonate'),
										'sanitize' => false,
										'settings' => array(
											'theme'  => 'monokai',
											'mode'   => 'javascript',
										),
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
