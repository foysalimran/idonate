<?php
/**
 * Framework column field file.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package idonate
 * @author     ThemeAtelier<themeatelierbd@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'IDONATE_Field_column' ) ) {
	/**
	 *
	 * Field: column
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class IDONATE_Field_column extends IDONATE_Fields {
		/**
		 * Field constructor.
		 *
		 * @param array  $field The field type.
		 * @param string $value The values of the field.
		 * @param string $unique The unique ID for the field.
		 * @param string $where To where show the output CSS.
		 * @param string $parent The parent args.
		 */
		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		/**
		 * Render field
		 *
		 * @return void
		 */
		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'large_desktop_icon'        => '<i class="icofont-monitor"></i>',
					'desktop_icon'              => '<i class="icofont-laptop-alt"></i>',
					'laptop_icon'               => '<i class="icofont-laptop"></i>',
					'tablet_icon'               => '<i class="icofont-surface-tablet"></i>',
					'mobile_icon'               => '<i class="icofont-android-tablet"></i>',
					'all_text'                  => '<i class="icofont-drag"></i>',
					'large_desktop_placeholder' => esc_html__( 'Large Desktop', 'idonate' ),
					'desktop_placeholder'       => esc_html__( 'Desktop', 'idonate' ),
					'laptop_placeholder'        => esc_html__( 'Small Desktop', 'idonate' ),
					'tablet_placeholder'        => esc_html__( 'Tablet', 'idonate' ),
					'mobile_placeholder'        => esc_html__( 'Mobile', 'idonate' ),
					'all_placeholder'           => esc_html__( 'all', 'idonate' ),
					'large_desktop'             => true,
					'desktop'                   => true,
					'laptop'                    => true,
					'tablet'                    => true,
					'mobile'                    => true,
					'unit'                      => false,
					'min'                       => '0',
					'all'                       => false,
					'units'                     => array( 'px', '%', 'em' ),
				)
			);

			$default_values = array(
				'large_desktop' => '4',
				'desktop'       => '4',
				'laptop'        => '3',
				'tablet'        => '2',
				'mobile'        => '1',
				'min'           => '',
				'all'           => '',
				'unit'          => 'px',
			);

			$value = wp_parse_args( $this->value, $default_values );

			echo wp_kses_post( $this->field_before() );

			echo '<div class="idonate--inputs">';

			$min = ( isset( $args['min'] ) ) ? ' min="' . $args['min'] . '"' : '';
			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="' . $args['all_placeholder'] . '"' : '';

				echo '<div class="idonate--input">';
				echo ( ! empty( $args['all_text'] ) ) ? '<span class="idonate--label idonate--icon">' . wp_kses_post( $args['all_text'] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '"' . $placeholder . $min . ' class="idonate-number" />';//phpcs:ignore
				echo ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? '<span class="idonate--label idonate--label-unit">' . esc_html( $args['units'][0] ) . '</span>' : '';
				echo '</div>';

			} else {

				$properties = array();

				foreach ( array( 'large_desktop', 'desktop', 'laptop', 'tablet', 'mobile' ) as $prop ) {
					if ( ! empty( $args[ $prop ] ) ) {
						$properties[] = $prop;
					}
				}

				$properties = ( array( 'laptop', 'mobile' ) === $properties ) ? array_reverse( $properties ) : $properties;

				foreach ( $properties as $property ) {

					$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? ' placeholder="' . esc_attr( $args[ $property . '_placeholder' ] ) . '"' : '';

					echo '<div class="idonate--input">';
					echo ( ! empty( $args[ $property . '_icon' ] ) ) ? '<span class="idonate--label idonate--icon">' . wp_kses_post( $args[ $property . '_icon' ] ) . '</span>' : '';
					echo '<input type="number" name="' . esc_attr( $this->field_name( '[' . $property . ']' ) ) . '" value="' . esc_attr( $value[ $property ] ) . '"' . $placeholder . $min . ' class="idonate-number" />';// phpcs:ignore
					echo ( count( $args['units'] ) === 1 && ! empty( $args['unit'] ) ) ? '<span class="idonate--label idonate--label-unit">' . esc_html( $args['units'][0] ) . '</span>' : '';
					echo '</div>';

				}
			}

			if ( ! empty( $args['unit'] ) && count( $args['units'] ) > 1 ) {
				echo '<select name="' . esc_attr( $this->field_name( '[unit]' ) ) . '">';
				foreach ( $args['units'] as $unit ) {
					$selected = ( $value['unit'] === $unit ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $unit ) . '"' . esc_attr( $selected ) . '>' . esc_html( $unit ) . '</option>';
				}
				echo '</select>';
			}

			echo '</div>';
			echo wp_kses_post( $this->field_after() );

		}
	}
}
