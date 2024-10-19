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
class IDonateAdvanceSettings
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
