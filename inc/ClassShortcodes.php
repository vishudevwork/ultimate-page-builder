<?php

/*
 * UltimatePageBuilder Shortcodes
 * @package ultimate-page-builder/inc
 * @since   1.0.0
 */

class UPBShortcodes {
    
    /**
     * class constructor
     */
    function __construct() {
        /**
         * shortcode to replace cities on post content
         */
        add_shortcode('city', [$this, 'UPBCity']);
        
        /**
         * shortcode to replace cities on post content
         */
        add_shortcode('state', [$this, 'UPBState']);
        
        /**
         * shortcode to replace cities on post content
         */
        add_shortcode('county', [$this, 'UPBCounty']);
        
        /**
         * shortcode to replace cities on post content
         */
        add_shortcode('state_abbr', [$this, 'UPBstateAbbr']);
         /**
         * shortcode to replace lat on post content
         */
        add_shortcode('lat', [$this, 'UPBlatAbbr']);
         /**
         * shortcode to replace cities on long content
         */
        add_shortcode('long', [$this, 'UPBlongAbbr']);
    }
    
    /**
     * display Post City
     * @global type $post
     * @return String
     */
    public function UPBCity() {
        global $post;
        return get_post_meta($post->ID, 'upb-city', true);
    }
    
    /**
     * Display Post state
     * @global type $post
     * @return String
     */
    public function UPBState() {
        global $post;
        return get_post_meta($post->ID, 'upb-state', true);
    }
    
    /**
     * display Post County
     * @global type $post
     * @return String
     */
    public function UPBCounty() {
        global $post;
        return get_post_meta($post->ID, 'upb-county', true);
    }
    
    /**
     * Display Post state abbr
     * @global type $post
     * @return String
     */
    public function UPBstateAbbr() {
        global $post;
        return get_post_meta($post->ID, 'upb-state-abbr', true);
    }
    /**
     * Display Post lat abbr
     * @global type $post
     * @return String
     */
    public function UPBlatAbbr() {
        global $post;
        return get_post_meta($post->ID, 'upb_lat', true);
    }
    /**
     * Display Post long abbr
     * @global type $post
     * @return String
     */
    public function UPBlongAbbr() {
        global $post;
        return get_post_meta($post->ID, 'upb_long', true);
    }
}

return new UPBShortcodes();
