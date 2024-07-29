<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 *
 */

// Blocking direct access
if (!defined('ABSPATH')) {
	die(esc_html(IDONATE_ALERT_MSG));
}

get_header();
?>
<div class="section-padding">
	<div class="ta-container">
		<?php
		echo do_shortcode('[donors]');
		?>
	</div>
</div>
<?php
get_footer();
