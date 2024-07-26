<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! class_exists( 'IDONATE_Field_backup' ) ) {
	class IDONATE_Field_backup extends IDONATE_Fields {

		public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
			parent::__construct( $field, $value, $unique, $where, $parent );
		}

		public function render() {

			$unique = $this->unique;
			$nonce  = wp_create_nonce( 'idonate_backup_nonce' );
			$export = add_query_arg(
				array(
					'action' => 'idonate-export',
					'unique' => $unique,
					'nonce'  => $nonce,
				),
				admin_url( 'admin-ajax.php' )
			);

			echo wp_kses_post( $this->field_before() );

			echo '<textarea name="idonate_import_data" class="idonate-import-data"></textarea>';
			echo '<button type="submit" class="button button-primary idonate-confirm idonate-import" data-unique="' . esc_attr( $unique ) . '" data-nonce="' . esc_attr( $nonce ) . '">' . esc_html__( 'Import', 'idonate' ) . '</button>';
			echo '<hr />';
			echo '<textarea readonly="readonly" class="idonate-export-data">' . esc_attr( wp_json_encode( get_option( $unique ) ) ) . '</textarea>';
			echo '<a href="' . esc_url( $export ) . '" class="button button-primary idonate-export" target="_blank">' . esc_html__( 'Export & Download', 'idonate' ) . '</a>';
			echo '<hr />';
			echo '<button type="submit" name="idonate_transient[reset]" value="reset" class="button idonate-warning-primary idonate-confirm idonate-reset" data-unique="' . esc_attr( $unique ) . '" data-nonce="' . esc_attr( $nonce ) . '">' . esc_html__( 'Reset', 'idonate' ) . '</button>';

			echo wp_kses_post( $this->field_after() );
		}
	}
}
