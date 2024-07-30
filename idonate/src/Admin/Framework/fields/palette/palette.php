<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: palette
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'IDONATE_Field_palette' ) ) {
	class IDONATE_Field_palette extends IDONATE_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$palette = ( ! empty( $this->field['options'] ) ) ? $this->field['options'] : array();

			echo wp_kses_post( $this->field_before() );

			if ( ! empty( $palette ) ) {

				echo '<div class="idonate-siblings idonate--palettes">';

				foreach ( $palette as $key => $colors ) {

					$active  = ( $key === $this->value ) ? ' idonate--active' : '';
					$checked = ( $key === $this->value ) ? ' checked' : '';

					echo '<div class="idonate--sibling idonate--palette' . esc_attr( $active ) . '">';

					if ( ! empty( $colors ) ) {

						foreach ( $colors as $color ) {

								echo '<span style="background-color: ' . esc_attr( $color ) . ';"></span>';

						}
					}

					echo '<input type="radio" name="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $key ) . '"' . wp_kses_post( $this->field_attributes() ) . esc_attr( $checked ) . '/>';
					echo '</div>';

				}

				echo '</div>';

			}

			echo wp_kses_post( $this->field_after() );
		}
	}
}
