<?php

/**
 *  Dynamic CSS
 *
 * @package    idonate
 * @subpackage idonate/src
 */

if (!defined('ABSPATH')) {
	exit;
}

$options = get_option('idonate_settings');

$donor_maincolor = isset($options['idonate_color_settings']['donor_maincolor']) ? $options['idonate_color_settings']['donor_maincolor'] : '';
$donor_bordercolor = isset($options['idonate_color_settings']['donor_bordercolor']) ? $options['idonate_color_settings']['donor_bordercolor'] : '';
$donor_form_color_bg = isset($options['donor_form_color']['background']) ? $options['donor_form_color']['background'] : '';
$donor_form_color_color = isset($options['donor_form_color']['color']) ? $options['donor_form_color']['color'] : '';
$request_form_color_color = isset($options['request_form_color']['color']) ? $options['request_form_color']['color'] : '';
$request_form_color_bg = isset($options['request_form_color']['background']) ? $options['request_form_color']['background'] : '';
$donor_social_share = isset($options['donor_social_share']) ? $options['donor_social_share'] : '';
$social_icon_custom_color = isset($donor_social_share['social_icon_custom_color']) ? $donor_social_share['social_icon_custom_color'] : '';
$idonate_container = isset($options['idonate_container']) ? $options['idonate_container'] : [];
$idonate_container_mobile = isset($options['idonate_container']['mobile']) ? $options['idonate_container']['mobile'] : '576';
$idonate_container_tablet = isset($options['idonate_container']['tablet']) ? $options['idonate_container']['tablet'] : '768';
$idonate_container_laptop = isset($options['idonate_container']['laptop']) ? $options['idonate_container']['laptop'] : '952';
$idonate_container_desktop = isset($options['idonate_container']['desktop']) ? $options['idonate_container']['desktop'] : '1200';
$idonate_container_large_desktop = isset($options['idonate_container']['large_desktop']) ? $options['idonate_container']['large_desktop'] : '1400';
$section_padding_mobile = isset($options['idonate_section_padding']['mobile']) ? $options['idonate_section_padding']['mobile'] : '40';
$section_padding_tablet = isset($options['idonate_section_padding']['tablet']) ? $options['idonate_section_padding']['tablet'] : '50';
$section_padding_laptop = isset($options['idonate_section_padding']['laptop']) ? $options['idonate_section_padding']['laptop'] : '60';
$section_padding_desktop = isset($options['idonate_section_padding']['desktop']) ? $options['idonate_section_padding']['desktop'] : '80';
$section_padding_large_desktop = isset($options['idonate_section_padding']['large_desktop']) ? $options['idonate_section_padding']['large_desktop'] : '80';


if ($donor_maincolor) {
	$custom_css .= ":root {--idonate-primary: $donor_maincolor;}";
}

// Border
if ($donor_bordercolor) {
	$custom_css .= ":root {--idonate-border: $donor_bordercolor;}";
}

// Form Color
if ($donor_form_color_color) {
	$custom_css .= ".donor_register .request-form #donorPanelForm label, .idonate-login label, .donor_register .submit-info h2, .submit-info p {color: $donor_form_color_color}";
}

// Form Background
if ($donor_form_color_bg) {
	$custom_css .= ".donor_register .request-form {background-color: $donor_form_color_bg}";
}
// request Form Color
if ($request_form_color_color) {
	$custom_css .= ".request-form-page .request-form form label, .request-form-page .submit-info h2, .request-form-page .submit-info p {color: $request_form_color_color}";
}

// Form Background
if ($request_form_color_bg) {
	$custom_css .= ".request-form-page .request-form {background-color: $request_form_color_bg}";
}

// Social Share.
$social_margin        = isset($donor_social_share['social_margin']) ? $donor_social_share['social_margin'] : array(
	'top'    => '0',
	'right'  => '0',
	'bottom' => '0',
	'left'   => '0',
);
$social_icon_color    = isset($donor_social_share['social_icon_color']) ? $donor_social_share['social_icon_color'] : array(
	'icon_color'        => '#ffffff',
	'icon_hover_color'  => '#ffffff',
	'icon_bg'           => '#ef1414',
	'icon_bg_hover'     => '#ef1414',
	'icon_border_hover' => '#ef1414',
);
if ($social_icon_custom_color) {
	$social_icon_color        = $donor_social_share['social_icon_color'];
	$social_icon_border       = $donor_social_share['social_icon_border'];
	$social_icon_border_width = (int) $social_icon_border['all'];
	$social_line_height       = 30 - ($social_icon_border_width * 2);
	$custom_css              .= ".request_info_wrapper .donor_social_share a i{ color: {$social_icon_color['icon_color']}; line-height: {$social_line_height}px; background: {$social_icon_color['icon_bg']}; border: {$social_icon_border_width}px {$social_icon_border['style']} {$social_icon_border['color']}; } .request_info_wrapper .donor_social_share a:hover i{ color: {$social_icon_color['icon_hover_color']}; background: {$social_icon_color['icon_bg_hover']}; border-color: {$social_icon_color['icon_border_hover']}; }";
}
$custom_css .= ".request_info_wrapper .donor_social_share{margin: {$social_margin['top']}px {$social_margin['right']}px {$social_margin['bottom']}px {$social_margin['left']}px;}";

// Media Queries
$custom_css .= "@media (min-width: 576px) {.ta-container-sm, .ta-container {max-width: {$idonate_container_mobile}px;}}@media (min-width: 768px) {.ta-container-md, .ta-container-sm, .ta-container {max-width: {$idonate_container_tablet}px;}}@media (min-width: 992px) {.ta-container-lg, .ta-container-md, .ta-container-sm, .ta-container {max-width: {$idonate_container_laptop}px;}}@media (min-width: 1200px) {.ta-container-xl, .ta-container-lg, .ta-container-md, .ta-container-sm, .ta-container {max-width: {$idonate_container_desktop}px;}}@media (min-width: 1400px) {.ta-container-xxl, .ta-container-xl, .ta-container-lg, .ta-container-md, .ta-container-sm, .ta-container {max-width: {$idonate_container_large_desktop}px;}}";
$custom_css .= "@media (min-width: 576px) {.section-padding {padding-top: {$section_padding_mobile}px;padding-bottom: {$section_padding_mobile}px;}}@media (min-width: 768px) {.section-padding {padding-top: {$section_padding_tablet}px;padding-bottom: {$section_padding_tablet}px;}}@media (min-width: 992px) {.section-padding {padding-top: {$section_padding_laptop}px;padding-bottom: {$section_padding_laptop}px;}}@media (min-width: 1200px) {.section-padding {padding-top: {$section_padding_desktop}px;padding-bottom: {$section_padding_desktop}px;}}@media (min-width: 1400px) {.ta-container-xxl, .section-padding {padding-top: {$section_padding_large_desktop}px;padding-bottom: {$section_padding_large_desktop}px;}}";
