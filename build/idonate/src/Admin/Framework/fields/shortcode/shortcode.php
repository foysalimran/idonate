<?php if (!defined('ABSPATH')) {
	die;
} // Cannot access directly.
/**
 *
 * Field: Shortcode
 *
 * @since 2.0
 * @version 2.0
 */
if (!class_exists('IDONATE_Field_shortcode')) {
	class IDONATE_Field_shortcode extends IDONATE_Fields
	{

		public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
		{
			parent::__construct($field, $value, $unique, $where, $parent);
		}

		public function render()
		{

			$type = (!empty($this->field['attributes']['type'])) ? $this->field['attributes']['type'] : 'text';
			global $post;
			$postid = $post->ID;
			echo (!empty($postid)) ? '<div class="idonate-shortdcode-wrapper">
			<div class="idonate-col-lg-3">
				<div class="idonate-scode-content">
					<h2 class="idonate-sc-title">Shortcode</h2>
					<div class="idonate-after-copy-text"><i class="icofont-check-circled"></i>  Shortcode  Copied to Clipboard! </div>
					<p>Copy and paste this shortcode into your posts or pages:</p>
					<div class="shortcode-wrap">
					<div class="idonate-shcode-selectable">[idonate id="' . esc_attr($postid) . '"] </div>
					</div>
				</div>
			</div>
			<div class="idonate-col-lg-3">
				<div class="idonate-scode-content">
					<h2 class="idonate-sc-title">Template Include</h2>
					<p>Paste the PHP code into your template file:</p>
					<div class="shortcode-wrap">
					<span class="idonate-shcode-selectable">&lt;?php echo do_shortcode(\'[idonate id="' . esc_attr($postid) . '"]\'); ?&gt;
					</span>
					</div>
				</div>
			</div>
		</div>' : '';
		}
	}
}
