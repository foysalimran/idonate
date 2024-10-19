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
class IDonateGeneralSettings
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
	}
}
