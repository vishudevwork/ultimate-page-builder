<?php

class location_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
        'location_widget',
        __('Page Location', 'ultimate-page-builder'),
        array ( 'description' => __( 'Widget to display page location details like city, state , address etc', 'ultimate-page-builder' ), )
        );
    }

    public function widget($args, $instance) {
        $queried_object = get_queried_object();
        if ( !$queried_object ) {
            return;
        }
        $post_id = $queried_object->ID;
        $city = get_post_meta($post_id, 'upb-city', true);
        if(!strlen($city)) {
            return;
        }
        $title = "<i class='upb_icon upb_plus_icon upb_acordion' data-target='#upb_location_info'></i>".apply_filters('widget_title ', $instance['title']);
        //echo $args['before_widget'];
        UltimatePageBuilder()->engine->getValue('before_widget', $args);
        If (!empty($title)) {
            echo UltimatePageBuilder()->engine->getValue('before_title', $args) . $title . $args['after_title'];
        }
        /* get post meta */
        $data = [
            'city' => $city,
            'city_description' => get_post_meta($post_id, 'upb_city_description', true),
            'state' => get_post_meta($post_id, 'upb-state', true),
            'county' => get_post_meta($post_id, 'upb-county', true),
            'abbr' => get_post_meta($post_id, 'upb-state-abbr', true),
            'business_name' => get_post_meta($post_id, 'upb_business_name', true),
            'phone_number' => get_post_meta($post_id, 'upb_phone_number', true),
            'street_addr' => get_post_meta($post_id, 'upb_street_address', true),
            'zip' => get_post_meta($post_id, 'upb_zip_code', true),
            'latitude' => get_post_meta($post_id, 'upb_lat', true),
            'longitude' => get_post_meta($post_id, 'upb_long', true)
        ];

        echo UltimatePageBuilder()->engine->getView('widget_output', $data);
        //echo __( 'Greetings from Hostinger.com!', 'ultimate-page-builder' );
        echo $args['after_widget'];
    }

    public function form($instance) {

        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        else {
            $title = __('', 'ultimate-page-builder');
        }
        ?>

        <p>

            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>

            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {

        $instance = array();

        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }

}
