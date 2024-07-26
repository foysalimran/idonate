<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: accordion
 *
 * @since 1.0.0
 * @version 1.0.0
 */
use ThemeAtelier\Idonate\Admin\Framework\Classes\IDONATE;

if ( ! class_exists( 'IDONATE_Field_accordion' ) ) {
	class IDONATE_Field_accordion extends IDONATE_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$unallows = array( 'accordion' );

			echo wp_kses_post( $this->field_before() );

			echo '<div class="idonate-accordion-items" data-depend-id="' . esc_attr( $this->field['id'] ) . '">';

			foreach ( $this->field['accordions'] as $key => $accordion ) {

				echo '<div class="idonate-accordion-item">';

				$icon = ( ! empty( $accordion['icon'] ) ) ? 'idonate--icon ' . $accordion['icon'] : 'idonate-accordion-icon icofont-rounded-right';

				echo '<h4 class="idonate-accordion-title">';
				echo '<i class="' . esc_attr( $icon ) . '"></i>';
				echo esc_html( $accordion['title'] );
				echo '</h4>';

				echo '<div class="idonate-accordion-content">';

				foreach ( $accordion['fields'] as $field ) {

					if ( in_array( $field['type'], $unallows ) ) {
						$field['_notice'] = true; }

					$field_id      = ( isset( $field['id'] ) ) ? $field['id'] : '';
					$field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';
					$field_value   = ( isset( $this->value[ $field_id ] ) ) ? $this->value[ $field_id ] : $field_default;
					$unique_id     = ( ! empty( $this->unique ) ) ? $this->unique . '[' . $this->field['id'] . ']' : $this->field['id'];

					IDONATE::field( $field, $field_value, $unique_id, 'field/accordion' );

				}

				echo '</div>';

				echo '</div>';

			}

			echo '</div>';

			echo wp_kses_post( $this->field_after() );
		}
	}
}
