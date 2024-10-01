<?php
/**
 * Framework border field file.
 *
 * @link       https://themeatelier.net
 * @since      1.0.0
 *
 * @package    idonate
 * @author     ThemeAtelier <themeatelierbd@gmail.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
} // Cannot access directly.

if ( ! class_exists( 'IDONATE_Field_border' ) ) {
	/**
	 *
	 * Field: border
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	class IDONATE_Field_border extends IDONATE_Fields {
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
					'top_icon'           => '<i class="icofont-long-arrow-up"></i>',
					'left_icon'          => '<i class="icofont-long-arrow-left"></i>',
					'bottom_icon'        => '<i class="icofont-long-arrow-down"></i>',
					'right_icon'         => '<i class="icofont-long-arrow-right"></i>',
					'all_icon'           => '<i class="icofont-drag"></i>',
					'top_placeholder'    => esc_html__( 'top', 'idonate' ),
					'right_placeholder'  => esc_html__( 'right', 'idonate' ),
					'bottom_placeholder' => esc_html__( 'bottom', 'idonate' ),
					'left_placeholder'   => esc_html__( 'left', 'idonate' ),
					'all_placeholder'    => esc_html__( 'all', 'idonate' ),
					'top'                => true,
					'left'               => true,
					'bottom'             => true,
					'right'              => true,
					'all'                => false,
					'color'              => true,
					'hover_color'        => true,
					'style'              => true,
					'unit'               => 'px',
				)
			);

			$default_value = array(
				'top'         => '',
				'right'       => '',
				'bottom'      => '',
				'left'        => '',
				'color'       => '',
				'hover_color' => '',
				'style'       => 'solid',
				'all'         => '',
			);

			$border_props = array(
				'solid'  => esc_html__( 'Solid', 'idonate' ),
				'dashed' => esc_html__( 'Dashed', 'idonate' ),
				'dotted' => esc_html__( 'Dotted', 'idonate' ),
				'double' => esc_html__( 'Double', 'idonate' ),
				'inset'  => esc_html__( 'Inset', 'idonate' ),
				'outset' => esc_html__( 'Outset', 'idonate' ),
				'groove' => esc_html__( 'Groove', 'idonate' ),
				'ridge'  => esc_html__( 'Ridge', 'idonate' ),
				'none'   => esc_html__( 'None', 'idonate' ),
			);

			$default_value = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_value ) : $default_value;

			$value = wp_parse_args( $this->value, $default_value );

			echo wp_kses_post( $this->field_before() );

			echo '<div class="idonate--inputs" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';

			if ( ! empty( $args['all'] ) ) {

				$placeholder = ( ! empty( $args['all_placeholder'] ) ) ? ' placeholder="' . esc_attr( $args['all_placeholder'] ) . '"' : '';

				echo '<div class="idonate--idonate-border">';
				echo '<div class="idonate--title">' . esc_html__( 'Width', 'idonate' ) . '</div>';
				echo '<div class="idonate--input">';
				echo ( ! empty( $args['all_icon'] ) ) ? '<span class="idonate--label idonate--icon">' . wp_kses_post( $args['all_icon'] ) . '</span>' : '';
				echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '"' . $placeholder . ' class="idonate-input-number idonate--is-unit" step="any" />';//phpcs:ignore
				echo ( ! empty( $args['unit'] ) ) ? '<span class="idonate--label idonate--unit">' . esc_attr( $args['unit'] ) . '</span>' : '';
				echo '</div>';
				echo '</div>';

			} else {

				$properties = array();

				foreach ( array( 'top', 'right', 'bottom', 'left' ) as $prop ) {
					if ( ! empty( $args[ $prop ] ) ) {
						$properties[] = $prop;
					}
				}

				$properties = ( array( 'right', 'left' ) === $properties ) ? array_reverse( $properties ) : $properties;

				foreach ( $properties as $property ) {

					$placeholder = ( ! empty( $args[ $property . '_placeholder' ] ) ) ? ' placeholder="' . esc_attr( $args[ $property . '_placeholder' ] ) . '"' : '';

					echo '<div class="idonate--idonate-border">';
					echo '<div class="idonate--title">' . esc_html__( 'Width', 'idonate' ) . '</div>';
					echo '<div class="idonate--input">';
					echo ( ! empty( $args['all_icon'] ) ) ? '<span class="idonate--label idonate--icon">' . wp_kses_post( $args['all_icon'] ) . '</span>' : '';
					echo '<input type="number" name="' . esc_attr( $this->field_name( '[all]' ) ) . '" value="' . esc_attr( $value['all'] ) . '"' . $placeholder . ' class="idonate-input-number idonate--is-unit" step="any" />';//phpcs:ignore
					echo ( ! empty( $args['unit'] ) ) ? '<span class="idonate--label idonate--unit">' . esc_attr( $args['unit'] ) . '</span>' : '';
					echo '</div>';
					echo '</div>';

				}
			}

			if ( ! empty( $args['style'] ) ) {
				echo '<div class="idonate--idonate-border">';
				echo '<div class="idonate--title">' . esc_html__( 'Style', 'idonate' ) . '</div>';
				echo '<div class="idonate--input">';
				echo '<select name="' . esc_attr( $this->field_name( '[style]' ) ) . '">';
				foreach ( $border_props as $border_prop_key => $border_prop_value ) {
					$selected = ( $value['style'] === $border_prop_key ) ? ' selected' : '';
					echo '<option value="' . esc_attr( $border_prop_key ) . '"' . esc_attr( $selected ) . '>' . esc_attr( $border_prop_value ) . '</option>';
				}
				echo '</select>';
				echo '</div>';
				echo '</div>';
			}

			echo '</div>';

			if ( ! empty( $args['color'] ) ) {
				$default_color_attr = ( ! empty( $default_value['color'] ) ) ? ' data-default-color="' . esc_attr( $default_value['color'] ) . '"' : '';
				echo '<div class="idonate--color">';
				echo '<div class="idonate-field-color">';
				echo '<div class="idonate--title">' . esc_html__( 'Color', 'idonate' ) . '</div>';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[color]' ) ) . '" value="' . esc_attr( $value['color'] ) . '" class="idonate-color"' . $default_color_attr . ' />';//phpcs:ignore
				echo '</div>';
				echo '</div>';
			}

			if ( ! empty( $args['hover_color'] ) ) {
				$default_color_attr = ( ! empty( $default_value['hover_color'] ) ) ? ' data-default-color="' . esc_attr( $default_value['hover_color'] ) . '"' : '';
				echo '<div class="idonate--color">';
				echo '<div class="idonate-field-color">';
				echo '<div class="idonate--title">' . esc_html__( 'Hover Color', 'idonate' ) . '</div>';
				echo '<input type="text" name="' . esc_attr( $this->field_name( '[hover_color]' ) ) . '" value="' . esc_attr( $value['hover_color'] ) . '" class="idonate-color"' . $default_color_attr . ' />'; //phpcs:ignore
				echo '</div>';
				echo '</div>';
			}

			echo wp_kses_post( $this->field_after() );
		}

	}
}
