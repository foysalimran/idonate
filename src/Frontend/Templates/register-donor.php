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

use ThemeAtelier\Idonate\Helpers\Helpers;

Helpers::idonate_custom_header();
?>
<div class="section-padding">
  <div class="ta-container">
    <?php
    if (!is_user_logged_in()) {
      echo do_shortcode('[register-donor]');
    } else {
      echo '
      <div class="register_success_donor">
        <h3>' . esc_html('Thank you for registering as an donor!', 'idonate') . '</h3>
        
        <a href="' . esc_url(home_url() . '/dashboard') . '">' . esc_html('Go to Dashboard', 'idonate') . '</a>
      </div>
      ';
    }

    ?>
  </div>
</div>
<?php

Helpers::idonate_custom_footer();
