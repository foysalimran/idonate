<?php

/**
 * Template for displaying Assignments
 *
 * @package Idonate
 * @subpackage Dashboard\Settings
 * @author ThemeAtelier<themeatelierbd@gmail.com>
 * @link https://themeum.com
 * @since 1.6.2
 */

use ThemeAtelier\Idonate\Helpers\Helpers;

$settings_url   = Helpers::idonate_dashboard_page_permalink('settings');
$withdraw       = Helpers::idonate_dashboard_page_permalink('settings/withdraw-settings');
$reset_password = Helpers::idonate_dashboard_page_permalink('settings/reset-password');
$address 		= Helpers::idonate_dashboard_page_permalink('settings/address');
$social         = Helpers::idonate_dashboard_page_permalink('settings/social-profile');

$setting_menus = array(
	'profile'        => array(
		'url'   => esc_url($settings_url),
		'title' => __('Profile', 'idonate'),
		'role'  => false,
	),
	'reset_password' => array(
		'url'   => esc_url($reset_password),
		'title' => __('Password', 'idonate'),
		'role'  => false,
	),
	'address' => array(
		'url'   => esc_url($address),
		'title' => __('Address', 'idonate'),
		'role'  => false,
	),
	'social-profile' => array(
		'url'   => esc_url($social),
		'title' => __('Social Profile', 'idonate'),
		'role'  => false,
	),
);

$setting_menus                = apply_filters('idonate_dashboard/nav_items/settings/nav_items', $setting_menus);
$GLOBALS['idonate_setting_nav'] = $setting_menus;

?>

<ul class="settings_nav" idonate-priority-nav>
	<?php foreach ($setting_menus as $menu_key => $menu) : ?>


		<?php $valid = 'profile' == $menu_key || ! $menu['role'] ?>
		<?php if ($valid) : ?>
			<li class="tab_button">
				<a class="idonate-nav-link<?php echo $active_setting_nav == $menu_key ? ' active' : ''; ?>" href="<?php echo esc_url($menu['url']); ?>"><?php echo esc_html($menu['title']); ?></a>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>