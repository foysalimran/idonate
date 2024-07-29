<?php

namespace ThemeAtelier\Idonate\Admin\Settings;

use ThemeAtelier\Idonate\Admin\Framework\Classes\IDONATE;
use ThemeAtelier\Idonate\Admin\Settings\IDonateSettings;

/**
 * Settings class to create all settings options for Woo Idonate.
 */
class Settings
{

	/**
	 * Create Option fields for the setting options.
	 *
	 * @param string $prefix Option setting key prefix.
	 * @return void
	 */
	public static function options($prefix)
	{
		IDONATE::createOptions(
			$prefix,
			array(
				'menu_title'              => esc_html__('IDonate Settings', 'idonate'),
				'menu_slug'               => 'idonate-settings',
				'menu_type'               => 'submenu',
				'show_bar_menu'           => false,
				'show_sub_menu'           => false,
				'framework_title'         => esc_html__('Idonate Settings', 'idonate'),
				'admin_bar_menu_priority' => 5,
				'show_search'             => false,
				'show_all_options'        => false,
				'show_reset_all'          => false,
				'show_reset_section'      => true,
				'show_footer'             => false,
				'theme'                   => 'light',
				'nav'          			  => 'inline',
				'framework_class'         => 'idonate-setting-admin',
			)
		);

		// Serialized Ahead!
		IDonateSettings::section($prefix);
	}
}
