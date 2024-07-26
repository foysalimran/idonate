<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 * Template Name: Blood Request Page
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
		echo do_shortcode('[blood-request]');
		?>
	</div>
</div>
<?php

get_footer();
