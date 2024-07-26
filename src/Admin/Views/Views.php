<?php

/**
 * Views class for Shortcode generator options.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package idonate
 * @subpackage idonate/Admin/Views
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\Idonate\Admin\Views;

use ThemeAtelier\Idonate\Admin\Framework\Classes\IDONATE;
use ThemeAtelier\Idonate\Admin\Views\General;

/**
 * Views class to create all metabox options for Idonate Shortcode generator.
 */
class Views
{
	/**
	 * Create metabox for the Generator options.
	 *
	 * @param string $prefix Metabox key prefix.
	 * @return void
	 */
	public static function metaboxes($prefix)
	{
		IDONATE::createMetabox(
			$prefix,
			array(
				'title'        => esc_html__('Views Generator Settings', 'idonate'),
				'post_type'    => 'blood_request',
				'theme'        => 'light',
				'class'        => 'idonate-metabox-tabs',
				'nav'          => 'inline',
				'show_restore' => false,
				'data_type'    => 'unserialize',
			)
		);

		// Serialized Ahead!
		General::section($prefix);
	}
}
