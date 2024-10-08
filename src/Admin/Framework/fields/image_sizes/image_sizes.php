<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: Image sizes.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'IDONATE_Field_image_sizes' ) ) {
	class IDONATE_Field_image_sizes extends IDONATE_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$args = wp_parse_args(
				$this->field,
				array(
					'chosen'      => false,
					'multiple'    => false,
					'placeholder' => '',
				)
			);

			$this->value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

			echo wp_kses_post( $this->field_before() );

			// Get the image sizes.
            global $_wp_additional_image_sizes;
            $sizes = array();

			foreach ( get_intermediate_image_sizes() as $_size ) {
				if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {

					$width  = get_option( "{$_size}_size_w" );
					$height = get_option( "{$_size}_size_h" );
					$crop   = (bool) get_option( "{$_size}_crop" ) ? 'hard' : 'soft';

					$sizes[ $_size ] = ucfirst( "{$_size} - $crop:{$width}x{$height}" );

				} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

					$width  = $_wp_additional_image_sizes[ $_size ]['width'];
					$height = $_wp_additional_image_sizes[ $_size ]['height'];
					$crop   = $_wp_additional_image_sizes[ $_size ]['crop'] ? 'hard' : 'soft';

					$sizes[ $_size ] = ucfirst( "{$_size} - $crop:{$width}X{$height}" );
				}
			}
			$sizes = array_merge(
				$sizes,
				array(
					'full'   => esc_html__( 'Original uploaded image', 'idonate' ),
					'custom' => esc_html__( 'Set custom size', 'idonate' ),
				)
			);

			//if ( ! empty( $this->field['options'] ) ) {
			if ( ! empty( $sizes ) ) {

				//$options          = ( is_array( $this->field['options'] ) ) ? $this->field['options'] : $this->field_data( $this->field['options'] );
				$multiple_name    = ( $args['multiple'] ) ? '[]' : '';
				$multiple_attr    = ( $args['multiple'] ) ? ' multiple="multiple"' : '';
				$chosen_rtl       = ( is_rtl() ) ? ' chosen-rtl' : '';
				$chosen_attr      = ( $args['chosen'] ) ? ' class="spf-chosen' . $chosen_rtl . '"' : '';
				$placeholder_attr = ( $args['chosen'] && $args['placeholder'] ) ? ' data-placeholder="' . esc_attr($args['placeholder']) . '"' : '';

				if ( ! empty( $sizes ) ) {

					echo '<select name="' . esc_attr($this->field_name( $multiple_name )) . '"' . esc_attr( $multiple_attr . $chosen_attr ) . wp_kses_post( $placeholder_attr ) . wp_kses_post($this->field_attributes()) . '>';

					if ( $args['placeholder'] && empty( $args['multiple'] ) ) {
						if ( ! empty( $args['chosen'] ) ) {
							echo '<option value=""></option>';
						} else {
							echo '<option value="">' . esc_html( $args['placeholder'] ) . '</option>';
						}
					}

					foreach ( $sizes as $option_key => $option ) {

						if ( is_array( $option ) && ! empty( $option ) ) {

							echo '<optgroup label="' . esc_attr( $option_key ) . '">';

							foreach ( $option as $sub_key => $sub_value ) {
								$selected = ( in_array( $sub_key, $this->value ) ) ? ' selected' : '';
								echo '<option value="' . esc_attr( $sub_key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $sub_value ) . '</option>';
							}

							echo '</optgroup>';

						} else {
							$selected = ( in_array( $option_key, $this->value ) ) ? ' selected' : '';
							echo '<option value="' . esc_attr($option_key) . '" ' . esc_attr($selected) . '>' . esc_html($option) . '</option>';
						}
					}

					echo '</select>';

				} else {

					echo ( ! empty( $this->field['empty_message'] ) ) ? esc_html( $this->field['empty_message'] ) : esc_html__( 'No image sizes found.', 'idonate' );

				}
			}

			echo wp_kses_post( $this->field_after() );

		}

	}
}
