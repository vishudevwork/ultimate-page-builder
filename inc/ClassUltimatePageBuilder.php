<?php

/*
 * UltimatePageBuilder Main class
 * @package ultimate-page-builder/inc
 * @since   1.0.0
 */

class UltimatePageBuilder {

    /**
     * UltimatePageBuilder version.
     *
     * @var string
     */
    public $version = '1.0.8';

    /**
     * The single instance of the class.
     *
     * @var UltimatePageBuilder
     * @since 1.0.0
     */
    protected static $_instance = null;

    /**
     * UltimatePageBuilder core functions
     *
     * @var engine
     * @since 1.0.0
     */
    public $engine;

    /**
     * Main UltimatePageBuilder Instance.
     *
     * Ensures only one instance of IsLayouts is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return UltimatePageBuilder.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * UltimatePageBuilder Constructor.
     *
     * @global Array UltimatePageBuilder
     *
     */
    function __construct() {
        global $UPBSetting;

        $UPBSetting = get_option('upb_options', true);
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
        $this->engine = new UltimatePageBuilderCore();
        if (isset($_GET['action']) && $_GET['action'] == 'upb_download_sample') {
            $file_link = UPB_ABSPATH . '/data/sample_data.csv';
            if (file_exists($file_link)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_link) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_link));
                flush(); // Flush system output buffer
                readfile($file_link);
                die();
            } else {
                http_response_code(404);
                die();
            }
        }
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks() {
        register_activation_hook(UPB_PLUGIN_FILE, array($this, 'UPB_plugin_install'));
        add_action('init', array($this, 'init'), 0);

        /* register front end scripts */
        add_action('wp_enqueue_scripts', array($this, 'UPBScripts'), 0);

        /* register admin scripts */
        add_action('admin_enqueue_scripts', array($this, 'UPBAdminScripts'), 0);

        add_action('admin_footer', [$this, 'AddModal']);

        add_action('wp_head', [$this, "UpbSchemaMarkup"]);

        add_action('widgets_init', [$this, 'hstngr_register_widget']);

        add_filter('the_content', [$this, 'DisplayRelatedCities']);
    }

    /*
     * UltimatePageBuilder instalation hook
     */

    public function UPB_plugin_install() {
        $this->engine->addTables();
    }

    /*
     * UltimatePageBuilder instalation hook
     */

    public function hstngr_register_widget() {
        register_widget('location_widget');
    }

    /**
     * Init plugin when WordPress Initialises.
     */
    public function init() {
        /* add page builder templates post type */
        $this->engine->registerTemplates();
    }

    /**
     * Define UltimatePageBuilder Constants.
     */
    private function define_constants() {
        $this->define('UPB_ABSPATH', dirname(UPB_PLUGIN_FILE) . '/');
        $this->define('UPB_BASENAME', plugin_basename(UPB_PLUGIN_FILE));
        $this->define('UPB_URL', plugins_url(basename(UPB_ABSPATH)));
        $this->define('UPB_VERSION', $this->version);
        $this->define('UPB_ROLE', 'km_user');
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {
        include_once UPB_ABSPATH . '/inc/ClassWidget.php';
        include_once UPB_ABSPATH . '/inc/ClassUltimatePageBuilderCore.php';
        include_once UPB_ABSPATH . '/inc/ClassShortcodes.php';
        include_once UPB_ABSPATH . '/inc/ClassActions.php';
        /* add admin files */
        if (is_admin()) {
            include_once UPB_ABSPATH . '/inc/ClassAdminOptions.php';
        }
    }

    /**
     * register and enque front end styles and scripts.
     *
     * @since 1.0.0
     */
    public function UPBScripts() {
        wp_enqueue_script('UPB_script', UPB_URL . "/assets/js/ultimate-page-builder.js", array('jquery'), UPB_VERSION);
        wp_enqueue_style('UPB_style', UPB_URL . '/assets/css/ultimate-page-builder.css', array(), UPB_VERSION);



        wp_localize_script('UPB_script', 'UPB_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php')
                )
        );
    }

    public function UPBAdminScripts() {
        wp_register_script('select2-js', UPB_URL . '/assets/js/select2.min.js', [], UPB_VERSION);

        wp_enqueue_script('UPB_admin_script', UPB_URL . '/assets/js/ultimate-page-builder-admin.js', array('jquery', 'jquery-ui-core', 'select2-js'), UPB_VERSION);
        wp_enqueue_script('jquery-ui-datepicker');

        wp_register_style('select2-css', UPB_URL . '/assets/css/select2.min.css', [], UPB_VERSION);
        wp_register_style('jquery-ui', UPB_URL . '/assets/css/jquery-ui.css');
        wp_enqueue_style('UPB_admin_style', UPB_URL . '/assets/css/ultimate-page-builder-admin.css', array('select2-css', 'jquery-ui'), UPB_VERSION);
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Ultimate Page builder global modal
     */
    public function AddModal() {
        print $this->engine->getView('modal');
    }

    public function UpbSchemaMarkup() {
        global $post;
        $schemaJson = get_post_meta($post->ID, "upb-schema-markup", true);
        $upbschematype = get_post_meta($post->ID, "upb-schema-type", true);
        if ($schemaJson) {
            $schemaJsonArray = (array) json_decode($schemaJson);
            $schemaJsonArray['@context'] = "https://schema.org";
            $schemaJsonArray['mainEntityOfPage']['@type'] = "WebPage";
            $schemaJsonArray['mainEntityOfPage']['@id'] = get_the_permalink($post->ID);
            if ($upbschematype == 'Job_Posting') {
                $schemaJsonArray['datePosted'] = get_the_date('', $post->ID);
            } else {
                $schemaJsonArray['datePublished'] = get_the_date('', $post->ID);
                $schemaJsonArray['dateModified'] = get_the_modified_date('', $post->ID);
            }
            print wp_sprintf("<script type='application/ld+json' class='upb-schema-graph'>%s</script>", json_encode($schemaJsonArray));
        }
    }

    public function DisplayRelatedCities($content) {
        global $post;
        $city = get_post_meta($post->ID, 'upb-city', true);
        $state = get_post_meta($post->ID, 'upb-state', true);
        $county = get_post_meta($post->ID, 'upb-county', true);
        $abbr = get_post_meta($post->ID, 'upb-state-abbr', true);
        if(!strlen($state)) {
            return $content;
        }
        $args = array(
            'post_type' => 'page',
            'meta_query' => array(
                array(
                    'key' => 'upb-state',
                    'value' => $state,
                ),
            ),
        );
        $related = new WP_Query($args);
        $relatedposts = "<div class='upb_related_articles'>";
        if ($related->have_posts()) {
            while ($related->have_posts()) {
                $related->the_post();
                $relatedposts.= wp_sprintf("<a class='single_related_article' href='%s'>%s</a>", get_permalink(get_the_ID()), get_post_meta(get_the_ID(), 'upb-city', true));
                // etc
            }
        }
        $relatedposts.= "</div>";
        //if( is_single() ) {
        $content .= $relatedposts;
        //}
        return $content;
    }
}
