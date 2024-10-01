<?php

/**
 * 
 * @package    iDonate - blood donor management system WordPress Plugin
 * @version    1.0
 * @author     ThemeAtelier
 * @Websites: https://themeatelier.net/
 *
 */

namespace ThemeAtelier\Idonate\Frontend\Shortcode;

// Blocking direct access
if (!defined('ABSPATH')) {
    die(esc_html(IDONATE_ALERT_MSG));
}

class IdonateStatistics
{
    public function idonate_statistics()
    {
        // Total Donor
        $totalDonor = idonate_get_total_donor();
        // Total Current Blood request
        $totaRequest = idonate_get_current_request();
        // Active User
        $totalActiveDonor =  idonate_get_available_donor();

        ob_start();
?>
        <div class="idonate blood-statistics-widget">
            <div class="single-statistics">
                <span class="icofont-ui-user-group"></span>
                <span class="right"><?php esc_html_e('Total Donor : ', 'idonate');
                                    echo esc_html($totalDonor); ?>
                </span>
            </div>
            <div class="single-statistics">
                <span class="icofont-unity-hand"></span>
                <span class="right"><?php esc_html_e('Available Donor : ', 'idonate'); echo esc_html($totalActiveDonor) ?>
                </span>
            </div>
            <div class="single-statistics">
                <span class="icofont-folder"></span>
                <span class="right"><?php esc_html_e('Current Request : ', 'idonate');
                                    echo esc_html($totaRequest); ?>
                </span>
            </div>
        </div>
<?php

        return ob_get_clean();
    }
}
