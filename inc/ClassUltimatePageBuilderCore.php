<?php

/*
 * UltimatePageBuilder Core funtions
 * @package ultimate-page-builder/inc
 * @since   1.0.0
 */

class UltimatePageBuilderCore {

    private $post_type = 'ubp-template';
    
    public $Shortcodes = ['[state]', '[city]', '[county]', '[state_abbr]', '[lat]', '[long]'];
    /**
     * class constructor 
     */
    function __construct() {
        add_action('admin_menu', array($this, 'addSubmenuPages'));
        // Add meta box goes into our admin_init function
        
        add_action( 'add_meta_boxes', [$this, 'wpdocs_register_meta_boxes'] );
        /* save meta boxes */
        
        add_action('save_post', [$this, 'upbSaveMetaBoxes']);
    }

    /**
     * get the content from view file
     * @param String $viewname view file name
     * @param Array $data Data to send into view file
     * @throws ApiException on a non 2xx response
     * @return HTML
     */
    public function getView($viewname, array $data = []) {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }
        /* default variables in view */
        global $UPBSetting;

        ob_start();
        $viewpath = get_stylesheet_directory() . "/ultimate-page-builder/{$viewname}.php";
        if (!file_exists($viewpath)) {
            $viewpath = UPB_ABSPATH . "views/{$viewname}.php";
        }
        require($viewpath);
        $html = ob_get_clean();
        return $html;
    }
    
    /**
     * get value from array/object if set
     * 
     * @param String $key
     * @param Mixed $Data
     * 
     * return Mixed
     */
    public function getValue($key, $Data, $print = true) {
        if (is_array($Data)) {
            if (array_key_exists($key, $Data)) {
                if ($print) {
                    echo $Data[$key];
                } else {
                    return $Data[$key];
                }
            }
        }

        if (isset($Data->$key)) {
            if ($print) {
                echo $Data->$key;
            } else {
                return $Data->$key;
            }
        }

        return false;
    }
    
    /**
     * register post type upb_templates
     */
    public function registerTemplates() {
        $labels = array(
            'name' => _x( 'Templates', 'post type general name', 'ultimate-page-builder' ),
            'singular_name' => _x( 'Template', 'post type singular name', 'ultimate-page-builder' ),
            'menu_name' => _x( 'Templates', 'admin menu', 'ultimate-page-builder' ),
            'name_admin_bar' => _x( 'Template', 'add new on admin bar', 'ultimate-page-builder' ),
            'add_new' => _x( 'Add New Template', 'book', 'ultimate-page-builder' ),
            'add_new_item' => __( 'Add New Template', 'ultimate-page-builder' ),
            'new_item' => __( 'New Template', 'ultimate-page-builder' ),
            'edit_item' => __( 'Edit Template', 'ultimate-page-builder' ),
            'view_item' => __( 'View Template', 'ultimate-page-builder' ),
            'all_items' => __( 'All Templates', 'ultimate-page-builder' ),
            'search_items' => __( 'Search Templates', 'ultimate-page-builder' ),
            'parent_item_colon' => __( 'Parent Template:', 'ultimate-page-builder' ),
            'not_found' => __( 'No Template found.', 'ultimate-page-builder' ),
            'not_found_in_trash' => __( 'No Templates found in Trash.', 'ultimate-page-builder' )
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => 'template' ),
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array( 'title', 'editor', 'author' ) // 
            );

        register_post_type( $this->post_type, $args );
        
        
    }
    
    /**
     * register meta box
     */
    public function wpdocs_register_meta_boxes() {
        add_meta_box(   'upb_shortcode_info', __('Ultimate Page Builder Shortcodes'),  [$this, 'upb_shortcode_info'], $this->post_type, 'side', 'high');
        add_meta_box(   'location_info_in_pages', __('Location Fields'),  [$this, 'upb_location_fields'], 'page');
    }
    
    /**
     * display shortcodes infor in the templates
     * @param mixed $post
     */
    public function upb_shortcode_info($post) {
        echo wp_sprintf("<p>%s</p>", __("you can use following shortcodes in templates", 'ultimate-page-builder'));
        foreach ($this->Shortcodes as $key => $shortcode) {
            echo wp_sprintf('<strong class="upb_shortcode">%s</strong>', $shortcode);
        }
    }
    
    public function upb_location_fields($post) {
        ?>
        <div class="upb_row">
            <div class="upb_field_wrap upb_location_fields">
                <label><?php _e("Business Name"); ?></label>
                <input type="text" name="upb_location_fields[upb_business_name]" value="<?php echo get_post_meta($post->ID, 'upb_business_name', true); ?>" class="gpb_input"/>
            </div>
            <div class="upb_field_wrap upb_location_fields">
                <label><?php _e("Phone Number"); ?></label>
                <input type="text" name="upb_location_fields[upb_phone_number]" value="<?php echo get_post_meta($post->ID, 'upb_phone_number', true); ?>" class="gpb_input"/>
            </div>
            <div class="upb_field_wrap upb_location_fields">
                <label><?php _e("Street Address"); ?></label>
                <input type="text" name="upb_location_fields[upb_street_address]" value="<?php echo get_post_meta($post->ID, 'upb_street_address', true); ?>" class="gpb_input"/>
            </div>
        </div>
        <div class="upb_row">        
            <div class="upb_field_wrap upb_location_fields">
                <label><?php _e("City"); ?></label>
                <input type="text" name="upb_location_fields[upb_city]" value="<?php echo get_post_meta($post->ID, 'upb-city', true); ?>" class="gpb_input"/>
            </div>
            <div class="upb_field_wrap upb_location_fields">
                <label><?php _e("State"); ?></label>
                <input type="text" name="upb_location_fields[upb_state]" value="<?php echo get_post_meta($post->ID, 'upb-state', true); ?>" class="gpb_input"/>
            </div>
            <div class="upb_field_wrap upb_location_fields">
                <label><?php _e("Zip Code"); ?></label>
                <input type="text" name="upb_location_fields[upb_zip_code]" value="<?php echo get_post_meta($post->ID, 'upb_zip_code', true); ?>" class="gpb_input"/>
            </div>
        </div>
        <div class="upb_row">
            <div class="upb_field_wrap upb_location_fields">
                <label><?php _e("About City"); ?></label>
                <textarea name="upb_location_fields[upb_city_description]" rows="4" class="gpb_input">
                    <?php echo get_post_meta($post->ID, 'upb_city_description', true); ?>
                </textarea>
            </div>
        </div>
        <?php
    }
    
    /**
     * add submenu pages in admin menu
     */
    public function addSubmenuPages() {
        add_submenu_page(
            'edit.php?post_type=ubp-template',
            __( 'Add Bulk Pages', 'menu-test' ),
            __( 'Add Pages', 'menu-test' ),
            'manage_options',
            'upb-add-pages',
            [$this, 'AddBulkPages'],
            500   
        );
    }
    /**
     * add bulk pages
     */
    public function AddBulkPages() {
        print $this->getView('add_pages');
    }
    
    public function addTables() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $this->addStates();
        $this->addCounties();
        $this->addCities();
    }
    
    private function addStates() {
        global $wpdb;
        $sql="CREATE TABLE `{$wpdb->prefix}upb_states` (
            `id` int(45) NOT NULL AUTO_INCREMENT,
            `name` varchar(55)  NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

        $response=dbDelta( $sql );
        
        return $response;
    }
    
    private function addCounties() {
        global $wpdb;
        $sql="CREATE TABLE `{$wpdb->prefix}upb_counties` (
            `id` int(45) NOT NULL AUTO_INCREMENT,
            `name` varchar(55)  NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

        $response=dbDelta( $sql );
        
        return $response;
    }
    
    private function addCities() {
        global $wpdb;
        $sql="CREATE TABLE `{$wpdb->prefix}upb_cities` (
            `id` int(45) NOT NULL AUTO_INCREMENT,
            `name` varchar(255)  NULL,
            `state` varchar(55)  NULL,
            `code` int(55)  NULL,
            `county` varchar(55)  NULL,
            `lat` varchar(55)  NULL,
            `long` varchar(55)  NULL,
            `abbr` varchar(25)  NULL,
            `created` datetime NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

        $response=dbDelta( $sql );
        
        return $response;
    }
    
    public function getPageTemplates() {
        $args = array(
            'numberposts' => -1,
            'post_type'   => $this->post_type
        );

        return get_posts( $args );
    }
    
    public function upbSaveMetaBoxes($post_id) {
        if(array_key_exists('upb_location_fields', $_POST)) {
            $postmeta = $_POST['upb_location_fields'];
            if(count($postmeta)) {
                foreach ($postmeta as $metaKey => $metaValue) {
                    update_post_meta($post_id, $metaKey, $metaValue);
                }
            }
        }
    }
    
    public function getSchemaMarkupTypes() {
        return [
            "Article" => __("Article", "ultimate-page-builder"),
            //"Event" => __("Event", "ultimate-page-builder"),
            //"How_to" => __("How-to", "ultimate-page-builder"),
            "Job_Posting" => __("Job Posting", "ultimate-page-builder")
        ];
    }
    
    public function displayMarkupFields($FieldKey = "Article") {
        return $this->getView("markup/{$FieldKey}");
    }
    
    private function getCurrencies() {
        return [
            "USD" => __("United States Dollar", "ultimate-page-builder"),
            "GBP" => __("British Pound Sterling", "ultimate-page-builder"),
            "CAD" => __("Canadian Dollar", "ultimate-page-builder"),
            "EUR" => __("Euro", "ultimate-page-builder")
        ];
    }
}
