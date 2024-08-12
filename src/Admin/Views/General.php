<?php

/**
 * General tab.
 *
 * @since      1.0.0
 *
 * @package idonate
 * @subpackage idonate/Admin/Views
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

namespace ThemeAtelier\Idonate\Admin\Views;

use ThemeAtelier\Idonate\Admin\Framework\Classes\IDONATE;
use ThemeAtelier\Idonate\Helpers\Countries\Countries;

// Cannot access directly.
if (!defined('ABSPATH')) {
	die;
}

/**
 * This class is responsible for General tab in Idonate Views page.
 *
 * @since      1.0.0
 */
class General
{

	/**
	 * General settings.
	 *
	 * @since 1.0.0
	 * @param string $prefix idonate_idonate_metaboxes.
	 */
	public static function section($prefix)
	{

		$countryOption = Countries::idonate_all_countries();

		IDONATE::createSection(
			$prefix,
			array(
				'title'  => esc_html__('Request Info', 'idonate'),
				'icon'   => 'icofont-ui-settings',
				'fields' => array(
					array(
						'id'         => 'idonatepurpose',
						'type'       => 'text',
						'title'      => esc_html__('Purpose', 'idonate'),
					),
					array(
						'id'         => 'idonatepatient_bloodunit',
						'type'       => 'number',
						'title'      => esc_html__('Blood Unit / Bag (S)', 'idonate'),
					),
					array(
						'id'         => 'idonatepatient_bloodgroup',
						'type'       => 'select',
						'title'      => esc_html__('Patient Blood Group', 'idonate'),
						'options' => idonate_blood_group_assosiative(),
						'placeholder' => esc_html__('Select Blood Group', 'idonate'),
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
					),
					array(
						'id'         => 'idonatepatient_bloodneed',
						'type'       => 'date',
						'title'      => esc_html__('When Need Blood?', 'idonate'),
					),
					array(
						'id'         => 'idonatehospital_name',
						'type'       => 'text',
						'title'      => esc_html__('Hospital Name', 'idonate'),
					),
					array(
						'id'         => 'idonatepatient_name',
						'type'       => 'text',
						'title'      => esc_html__('Patient Name', 'idonate'),
					),
					array(
						'id'         => 'idonatepatient_age',
						'type'       => 'number',
						'title'      => esc_html__('Patient Age', 'idonate'),
					),
					array(
						'id'         => 'idonatepatient_mobnumber',
						'type'       => 'text',
						'title'      => esc_html__('Mobile Number', 'idonate'),
					),
					array(
						'id'         => 'email',
						'type'       => 'text',
						'title'      => esc_html__('Email', 'idonate'),
					),
					array(
						'id'         => 'idonatecity',
						'type'       => 'text',
						'title'      => esc_html__('City', 'idonate'),
					),
					array(
						'id'         => 'idonateaddress',
						'type'       => 'text',
						'title'      => esc_html__('Address', 'idonate'),
					),

					array(
						'id'         => 'idonatecountry',
						'type'       => 'select',
						'chosen'      => true,
						'settings'	=> array(
							'width'		=> '227px',
						),
						'title'      => esc_html__('Country', 'idonate'),
						'options'	 => $countryOption,
						'class'	=> 'br_country_meta',
					),

					array(
						'id'         => 'idonatestate',
						'type'       => 'select',
						'title'      => esc_html__('State', 'idonate'),
						'state'	=> true,
						'options' => [
							'' => 'Select state',
						],
						'class'	=> 'br_state_meta',
						
					),
					array(
						'id'         => 'idonatedetails',
						'type'       => 'textarea',
						'title'      => esc_html__('Details', 'idonate'),
					),
				),
			)
		);
	}
}
