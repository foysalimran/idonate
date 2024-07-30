<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.
/**
 *
 * Field: heading
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if (!class_exists('IDONATE_Field_heading')) {
	class IDONATE_Field_heading extends IDONATE_Fields
	{

		public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
		{
			parent::__construct($field, $value, $unique, $where, $parent);
		}

		public function render()
		{

			echo (!empty($this->field['icon'])) ? wp_kses_post($this->field['icon']) : '';
			echo (!empty($this->field['content'])) ? esc_html($this->field['content']) : '';
			echo (!empty($this->field['image'])) ? '<img src="' . esc_url($this->field['image']) . '"/>' : '';
			echo (!empty($this->field['after']) && !empty($this->field['link'])) ? '<span class="spacer"></span><span class="support"><a href="' . esc_url($this->field['link']) . '" target="_blank">' . wp_kses_post($this->field['after']) . '</a></span>' : '';
		}
	}
}
