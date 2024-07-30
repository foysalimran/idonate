<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: repeater
 *
 * @since 1.0.0
 * @version 1.0.0
 */
use ThemeAtelier\Idonate\Admin\Framework\Classes\IDONATE;

if ( ! class_exists( 'IDONATE_Field_repeater' ) ) {
	class IDONATE_Field_repeater extends IDONATE_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'max'          => 0,
					'min'          => 0,
					'button_title' => '<i class="icofont-plus-circle"></i>',
				)
			);

			if ( preg_match( '/' . preg_quote( '[' . $this->field['id'] . ']' ) . '/', $this->unique ) ) {

				echo '<div class="idonate-notice idonate-notice-danger">' . esc_html__( 'Error: Field ID conflict.', 'idonate' ) . '</div>';

			} else {

				echo wp_kses_post( $this->field_before() );

				echo '<div class="idonate-repeater-item idonate-repeater-hidden" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';
				echo '<div class="idonate-repeater-content">';
				foreach ( $this->field['fields'] as $field ) {

					$field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';
					$field_unique  = ( ! empty( $this->unique ) ) ? $this->unique . '[' . $this->field['id'] . '][0]' : $this->field['id'] . '[0]';

					IDONATE::field( $field, $field_default, '___' . $field_unique, 'field/repeater' );

				}
				echo '</div>';
				echo '<div class="idonate-repeater-helper">';
				echo '<div class="idonate-repeater-helper-inner">';
				echo '<i class="idonate-repeater-sort icofont-drag"></i>';
				echo '<i class="idonate-repeater-clone icofont-copy-invert"></i>';
				echo '<i class="idonate-repeater-remove idonate-confirm icofont-close" data-confirm="' . esc_html__( 'Are you sure to delete this item?', 'idonate' ) . '"></i>';
				echo '</div>';
				echo '</div>';
				echo '</div>';

				echo '<div class="idonate-repeater-wrapper idonate-data-wrapper" data-field-id="[' . esc_attr( $this->field['id'] ) . ']" data-max="' . esc_attr( $args['max'] ) . '" data-min="' . esc_attr( $args['min'] ) . '">';

				if ( ! empty( $this->value ) && is_array( $this->value ) ) {

					$num = 0;

					foreach ( $this->value as $key => $value ) {

						echo '<div class="idonate-repeater-item">';
						echo '<div class="idonate-repeater-content">';
						foreach ( $this->field['fields'] as $field ) {

								$field_unique = ( ! empty( $this->unique ) ) ? $this->unique . '[' . $this->field['id'] . '][' . $num . ']' : $this->field['id'] . '[' . $num . ']';
								$field_value  = ( isset( $field['id'] ) && isset( $this->value[ $key ][ $field['id'] ] ) ) ? $this->value[ $key ][ $field['id'] ] : '';

								IDONATE::field( $field, $field_value, $field_unique, 'field/repeater' );

						}
						echo '</div>';
						echo '<div class="idonate-repeater-helper">';
						echo '<div class="idonate-repeater-helper-inner">';
						echo '<i class="idonate-repeater-sort icofont-drag"></i>';
						echo '<i class="idonate-repeater-clone icofont-copy-invert"></i>';
						echo '<i class="idonate-repeater-remove idonate-confirm icofont-close" data-confirm="' . esc_html__( 'Are you sure to delete this item?', 'idonate' ) . '"></i>';
						echo '</div>';
						echo '</div>';
						echo '</div>';

						++$num;

					}
				}

				echo '</div>';

				echo '<div class="idonate-repeater-alert idonate-repeater-max">' . esc_html__( 'You cannot add more.', 'idonate' ) . '</div>';
				echo '<div class="idonate-repeater-alert idonate-repeater-min">' . esc_html__( 'You cannot remove more.', 'idonate' ) . '</div>';
				echo '<a href="#" class="button button-primary idonate-repeater-add">' . wp_kses_post( $args['button_title'] ) . '</a>';

				echo wp_kses_post( $this->field_after() );

			}
		}

		public function enqueue() {

			if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}
		}
	}
}
