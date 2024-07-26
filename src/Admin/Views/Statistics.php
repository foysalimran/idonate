<?php



class idonate_blood_statistics_widget extends WP_Widget
{
    function __construct()
    {

        parent::__construct(
            // Base ID of your widget
            'idonate_blood_statistics_widget',


            // Widget name will appear in UI
            esc_html__('Statistics Widget [Idonate]', 'idonate'),

            // Widget description
            array('description' => esc_html__('Add Statistics widget.', 'idonate'), )
        );
    }
    // This is where the action happens
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo wp_kses_post($args['before_widget']);
        if (!empty($title))
            echo wp_kses_post($args['before_title'] . $title . $args['after_title']);

        // Total Donor
        $totalUser = count_users();
        $totalDonor = !empty($totalUser['avail_roles']['donor']) ? $totalUser['avail_roles']['donor'] : '';

        // Total Current Blood request
        $totaRequest = wp_count_posts('blood_request');

        // Active User
        // $userargs = array(
        //     'meta_key' => 'idonate_donor_availability',
        //     'meta_value' => 'available',
        // );
        $userargs = array(
            'meta_query' => array(
                array(
                    'key'     => 'idonate_donor_availability',
                    'value'   => 'available',
                    'compare' => '='
                ),
            ),
        );

        $activeDonor = get_users($userargs);
        $totalActiveDonor = !empty($activeDonor) ? count($activeDonor) : '';


        ?>
        <div class="idonate blood-statistics-widget">
        <div class="single-statistics"><span class="icofont-ui-user-group"></span> <span
                    class="right"><?php esc_html_e('Total Donor : ', 'idonate');
                    echo esc_html($totalDonor); ?></span></div>
            <div class="single-statistics"><span class="icofont-unity-hand"></span> <span
                    class="right"><?php esc_html_e('Available Donor : ', 'idonate');
                    echo esc_html($totalActiveDonor) ?></span></div>
            <div class="single-statistics"><span class="icofont-folder"></span> <span
                    class="right"><?php esc_html_e('Current Request : ', 'idonate');
                    echo esc_html($totaRequest->publish); ?></span></div>
        </div>
        <?php

        echo wp_kses_post($args['after_widget']);
    }

    // Widget Backend 
    public function form($instance)
    {

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = esc_html__('Statistics', 'idonate');
        }

        // Widget admin form
        ?>
        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'idonate'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                value="<?php echo esc_attr($title); ?>" />
        </p>

        <?php
    }


    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title']       = (!empty($new_instance['title'])) ? wp_strip_all_tags($new_instance['title']) : '';
        return $instance;
    }
} // Class  ends here

function idonate_statistics_widget()
{
    register_widget('idonate_blood_statistics_widget');
}
add_action('widgets_init', 'idonate_statistics_widget');
