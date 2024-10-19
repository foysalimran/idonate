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
class IDonateRequestSettings
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
	}
}
