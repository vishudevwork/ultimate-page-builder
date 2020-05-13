<?php

/**
 * Plugin Name: Ultimate Page Builder
 * Plugin URI: https://example.com/
 * Description: A wordpress plugin to create pages in bulk
 * Version: 1.0.8
 * Author: Glocify
 * Author URI: https://example.com
 * Text Domain: ultimate-page-builder
 * Domain Path: /i18n/languages/
 *
 * @package ultimate-page-builder
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Define UPB_PLUGIN_FILE.
if (!defined('UPB_PLUGIN_FILE')) {
    define('UPB_PLUGIN_FILE', __FILE__);
}

// Include the main UltimatePageBuilder class.
if (!class_exists('UltimatePageBuilder')) {
    include_once dirname(__FILE__) . '/inc/ClassUltimatePageBuilder.php';
}

/**
 * Main instance of UltimatePageBuilder.
 *
 * Returns the main instance of UltimatePageBuilder.
 *
 * @since  1.0.0
 * @return UltimatePageBuilder
 */
function UltimatePageBuilder() {
    return UltimatePageBuilder::instance();
}

// Global for backwards compatibility.
$GLOBALS['ultimate_page_builder'] = UltimatePageBuilder();
