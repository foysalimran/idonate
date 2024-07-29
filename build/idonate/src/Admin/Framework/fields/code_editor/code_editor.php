<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.
/**
 *
 * Field: code_editor
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('IDONATE_Field_code_editor')) {
	class IDONATE_Field_code_editor extends IDONATE_Fields
	{

		public $version = '6.65.7';
		public $cdn_url = IDONATE_DIR_URL . 'src/Admin/Framework/assets';

		public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
		{
			parent::__construct($field, $value, $unique, $where, $parent);
		}

		public function render()
		{

			$default_settings = array(
				'tabSize'       => 2,
				'lineNumbers'   => true,
				'theme'         => 'default',
				'mode'          => 'htmlmixed',
				'cdnURL'        => $this->cdn_url,
			);

			$settings = (!empty($this->field['settings'])) ? $this->field['settings'] : array();
			$settings = wp_parse_args($settings, $default_settings);

			echo wp_kses_post( $this->field_before() );
			echo '<textarea name="' . esc_attr($this->field_name()) . '"' . wp_kses_post($this->field_attributes()) . ' data-editor="' . esc_attr(wp_json_encode($settings)) . '">' . wp_kses_post($this->value) . '</textarea>';
			echo wp_kses_post( $this->field_after() );
		}

		public function enqueue()
		{

			$page = (!empty($_GET['page'])) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';

			// Do not loads CodeMirror in ridonatelider page.
			if (in_array($page, array('ridonatelider'))) {
				return;
			}

			if (!wp_script_is('idonate-codemirror')) {
				wp_enqueue_script('idonate-codemirror', IDONATE_DIR_URL . 'src/Admin/Framework/assets/js/codemirror.min.js', array('idonate'),  $this->version, true);
				wp_enqueue_script('idonate-codemirror-loadmode', IDONATE_DIR_URL . 'src/Admin/Framework/assets/js/loadmode.min.js', array('idonate-codemirror'), $this->version, true);
			}

			if (!wp_style_is('idonate-codemirror')) {
				wp_enqueue_style('idonate-codemirror', IDONATE_DIR_URL . 'src/Admin/Framework/assets/css/codemirror.min.css', array(), $this->version);
			}
		}
	}
}
