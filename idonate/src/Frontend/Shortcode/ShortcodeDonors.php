<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

namespace ThemeAtelier\Idonate\Frontend\Shortcode;

use ThemeAtelier\Idonate\Frontend\Helpers\IdonateLoopHtml;

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

class ShortcodeDonors
{
	/**
	 * Generate and render shortcode.
	 *
	 * @param array $attributes Shortcode's all option.
	 * @since 1.0.0
	 */
	public function render_donor_shortcode($attributes)
	{

		$option = get_option('idonate_settings');
		ob_start();

		IdonateLoopHtml::idonate_html_show($option);
		return ob_get_clean();
	}
}
new ShortcodeDonors();
