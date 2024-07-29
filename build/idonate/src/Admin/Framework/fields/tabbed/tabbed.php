<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: tabbed
 *
 * @since 1.0.0
 * @version 1.0.0
 */
use ThemeAtelier\Idonate\Admin\Framework\Classes\IDONATE;

if ( ! class_exists( 'IDONATE_Field_tabbed' ) ) {
	class IDONATE_Field_tabbed extends IDONATE_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$unallows = array( 'tabbed' );

			echo wp_kses_post( $this->field_before() );

			echo '<div class="idonate-tabbed-nav">';
			foreach ( $this->field['tabs'] as $key => $tab ) {

				$tabbed_icon   = ( ! empty( $tab['icon'] ) ) ? '<i class="idonate--icon ' . esc_attr( $tab['icon'] ) . '"></i>' : '';
				$tabbed_active = ( empty( $key ) ) ? 'idonate-tabbed-active' : '';

				echo '<a href="#" class="' . esc_attr( $tabbed_active ) . '"">' . wp_kses_post($tabbed_icon) . esc_attr( $tab['title'] ) . '</a>';

			}
			echo '</div>';

			echo '<div class="idonate-tabbed-contents">';
			foreach ( $this->field['tabs'] as $key => $tab ) {

				$tabbed_hidden = ( ! empty( $key ) ) ? ' hidden' : '';

				echo '<div class="idonate-tabbed-content' . esc_attr( $tabbed_hidden ) . '">';

				foreach ( $tab['fields'] as $field ) {

					if ( in_array( $field['type'], $unallows ) ) {
						$field['_notice'] = true; }

					$field_id      = ( isset( $field['id'] ) ) ? $field['id'] : '';
					$field_default = ( isset( $field['default'] ) ) ? $field['default'] : '';
					$field_value   = ( isset( $this->value[ $field_id ] ) ) ? $this->value[ $field_id ] : $field_default;
					$unique_id     = ( ! empty( $this->unique ) ) ? $this->unique : '';

					IDONATE::field( $field, $field_value, $unique_id, 'field/tabbed' );

				}

				echo '</div>';

			}
			echo '</div>';

			echo wp_kses_post( $this->field_after() );
		}
	}
}
