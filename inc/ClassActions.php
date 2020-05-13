<?php

/*
 * UltimatePageBuilder Actions
 * @package ultimate-page-builder/inc
 * @since   1.0.0
 */

class UPBActions {

    /**
     * UltimatePageBuilder Constructor.
     */
    function __construct() {
        foreach ($this->AjaxActions() as $key => $action) {
            add_action("wp_ajax_{$action['name']}", [$this, $action['callback']]);
            add_action("wp_ajax_nopriv_{$action['name']}", [$this, $action['callback']]);
        }
        add_action('init', [$this, 'UPBActionsInit']);
    }

    /*
     * UltimatePageBuilder ajax handlers 
     * 
     * @return Array
     */

    private function AjaxActions() {
        return [
            ['name' => 'getstates', 'callback' => 'getStates'],
            ['name' => 'getcounties', 'callback' => 'getCounties'],
            ['name' => 'process_pages', 'callback' => 'processPages'],
            ['name' => 'create_pages', 'callback' => 'createPages'], 
            ['name' => 'markup_fields', 'callback' => 'markupFields']
        ];
    }
    
    /**
     * get states data
     * @global type $wpdb
     * @return JSON
     */
    public function getStates() {
        global $wpdb;
        $states = $wpdb->get_results("select * from {$wpdb->prefix}upb_states");
        wp_send_json(['status' => 'success', 'data' => $states]);
        return;
    }
    
    /**
     * get counties
     * @global type $wpdb
     * @return JSON
     */
    public function getCounties() {
        global $wpdb;
        $stateName = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
        $counties = $wpdb->get_results("select * from {$wpdb->prefix}upb_counties where state like '{$stateName}'");
        wp_send_json(['status' => 'success', 'data' => $counties]);
        return;
    }
    
    /**
     * 
     * @global type $wpdb
     * @return JSON
     */
    public function processPages() {
        global $wpdb;
        $postdata = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = $this->validateData($postdata);

        $errors = $data['errors'];
        $where = $data['where'];
        $response = [];
        if (empty($errors)) {
            if ($postdata['gpb_pages_for'] == 'csv') {
                // upload csv file
                $pathToUpload = UPB_ABSPATH . '/tmp/';
                if (!is_dir($pathToUpload)) {
                    mkdir($pathToUpload);
                }
                $filename = time() . '.csv';
                $filePath = $pathToUpload . $filename;
                move_uploaded_file($_FILES['upb_csv_file']['tmp_name'], $filePath);

                $csvData = $this->processCsvFile($filePath);
                $totalCities = count($csvData);
                $response['csv_file'] = $filename;
            } else {
                $sql = "SELECT count(*) FROM `{$wpdb->prefix}upb_cities`";
                if (!empty($where)) {
                    $sql .= " where " . implode(' and ', $where);
                }
                $totalCities = $wpdb->get_var($sql);
            }
            $response['status'] = 'success';
            $response['header'] = __("Please confirm to create these pages", "ultimate-page-builder");
            $response['footer'] = "<input onclick='return UPB_Admin.createWordpressPages(event, this)' type='submit' value='Yes, Create Now' class='button button-primary button-large'/>";
            $response['content'] = UltimatePageBuilder()->engine->getView('page_confirmation', ['totalCities' => $totalCities]);
            $response['total_results'] = $totalCities;
            wp_send_json($response);
        } else {
            wp_send_json(['status' => 'failed', 'errors' => $errors]);
        }

        return;
    }
    
    /**
     * normalize CSV file
     * @param type $filePath
     * @return JSON
     */
    private function processCsvFile($filePath) {
        $row = 1; $records = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $records[] = $data;
            }
            fclose($handle);
            
            if(count($records)) {
                if((bool)array_intersect(['state', 'county', 'city', 'abbr'], $records[0])) {
                    $keys = $records[0];
                    unset($records[0]);
                    $cities = [];
                    foreach ($records as $key => $record) {
                        $inner = [];
                        foreach ($record as $key => $detail) {
                            $inner[$keys[$key]] = $detail;
                        }
                        $cities[] = (object) $inner;
                    }
                    
                    return $cities;
                }else {
                    wp_send_json(['status' => 'failed', 'errors' => ['upb_csv_file' => 'Csv data is not valid. make sure it has state, county, city and abbr headers on first row']]);
                }
            }else {
                wp_send_json(['status' => 'failed', 'errors' => ['upb_csv_file' => 'CSV file is empty']]);
            }
        }
    }
    
    /**
     * create pages in wordpress
     * @global type $wpdb
     * @return JSON
     */
    public function createPages() {
        global $wpdb;
        $postdata = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $page_name_input = UltimatePageBuilder()->engine->getValue('page_name', $postdata, false);
        $page_template = UltimatePageBuilder()->engine->getValue('post_template', $postdata, false);
        $gpb_pages_for = UltimatePageBuilder()->engine->getValue('gpb_pages_for', $postdata, false);
        $upb_csv_file = UltimatePageBuilder()->engine->getValue('upb_csv_file', $postdata, false); 
        /* meta content */
        $meta_title_input = UltimatePageBuilder()->engine->getValue('meta_title', $postdata, false); 
        $meta_description_input = UltimatePageBuilder()->engine->getValue('meta_description', $postdata, false); 
        $meta_keyword_input = UltimatePageBuilder()->engine->getValue('meta_keyword', $postdata, false); 
        
        $content_post = get_post($page_template);
        $meta_data= get_post_meta($content_post->ID);
        $post_meta_data = array();
        foreach($meta_data as $key=>$val){
              if(strpos($key,'elementor')!== false || strpos($key,'_wp_page_template')!== false ){
               $post_meta_data[$key] =$val[0];
              }
            }

        $limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_STRING);
        $offset = filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_STRING);
        $processed = filter_input(INPUT_GET, 'processed', FILTER_SANITIZE_STRING);

        if (!$content_post) {
            wp_send_json(['status' => 'failed', 'message' => "invalid page template"]);
        }
        $data = $this->validateData($postdata);
        $errors = $data['errors'];
        $where = $data['where'];

        if (empty($errors)) {
            if($gpb_pages_for == 'csv') {
                $filePath = UPB_ABSPATH . '/tmp/'.$upb_csv_file;
                if(file_exists($filePath)) {
                    $Cities = $this->processCsvFile($filePath);
                    $cityparam = "city";
                    unlink($filePath);
                }else {
                    wp_send_json(['status' => 'failed', 'message' => "file doesn't exist. Please reupload the file."]);
                }
                
            }else {
                $sql = "SELECT * FROM `{$wpdb->prefix}upb_cities`";
                if (!empty($where)) {
                    $sql .= " where " . implode(' and ', $where);
                }

                $sql .= " limit $limit OFFSET $offset";
                $Cities = $wpdb->get_results($sql);
                $cityparam = "name";
            }
            $logs = "";
            foreach ($Cities as $key => $City) {
                
                $page_name = $this->replaceShortcodes($page_name_input, $City, $cityparam); 
                $metaTitle = $this->replaceShortcodes($meta_title_input, $City, $cityparam); 
                $metaDescription = $this->replaceShortcodes($meta_description_input, $City, $cityparam); 
                $keyWord = $this->replaceShortcodes($meta_keyword_input, $City, $cityparam); 
                
                $page = get_page_by_title($page_name);
                if (!$page) {
                    // Create post object
                    $postmeta = array_merge($post_meta_data, [
                            'upb-city' => $City->$cityparam, 
                            'upb-state' => $City->state, 
                            'upb-county' => $City->county, 
                            'upb-state-abbr' => $City->abbr,
                            'upb_city_description' => UltimatePageBuilder()->engine->getValue('city_description', $City, false),
                            'upb_business_name' => UltimatePageBuilder()->engine->getValue('business_name', $City, false),
                            'upb_phone_number' => UltimatePageBuilder()->engine->getValue('phone_number', $City, false),
                            'upb_street_address' => UltimatePageBuilder()->engine->getValue('street_address', $City, false),
                            'upb_zip_code' => UltimatePageBuilder()->engine->getValue('zip_code', $City, false),
                            'upb_lat' => UltimatePageBuilder()->engine->getValue('lat', $City, false),
                            'upb_long' => UltimatePageBuilder()->engine->getValue('long', $City, false),
                            '_yoast_wpseo_title' => $metaTitle,
                            '_yoast_wpseo_metadesc' => $metaDescription,
                            '_yoast_wpseo_focuskw' => $keyWord,
                            'upb-schema-type' => $postdata['upb_schema_type'],
                            'upb-schema-markup' => $this->createSchemaMarkup($postdata, $City, $cityparam)
                        ]);
                    $post_data = array(
                        'post_type' => 'page',
                        'post_title' => $page_name,
                        'post_content' => $this->spintexprocess($content_post->post_content),
                        'post_status' => 'publish',
                        'meta_input' => $postmeta
                    );
                    // Insert the post into the database
                    $postId = wp_insert_post($post_data);
                    $postlink = get_permalink($postId);
                    $logs .= wp_sprintf("<span>Page <a target='_blank' href='%s'>%s</a> Created successfully</span>", $postlink, $page_name);
                } else {
                    $logs .= wp_sprintf("<span>Failed to create <b>%s</b>. Already exists.</span>", $page_name);
                }
                $processed++;
            }

            $newoffset = $offset + $limit;
            
            wp_send_json(['status' => 'success', 'processed' => $processed, 'newoffset' => $newoffset, 'logs' => $logs]);
        } else {
            wp_send_json(['status' => 'failed', 'errors' => $errors]);
        }

        return;
    }
    
    /**
     * 
     * @param string $text
     * @return String
     */
    public function spintexprocess($text)
    {
        return preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*?)\}/x',
            array($this, 'replace'),
            $text
        );
    }
    
    /**
     * 
     * @param Array $text
     * @return Array
     */
    public function replace($text)
    {
        $text = $this->spintexprocess($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }
    /**
     * replace string with the shortcodes
     * @param type $string
     * @param type $City
     * @param type $cityparam
     * @return String
     */
    private function replaceShortcodes($string, $City, $cityparam) {
        $shortcodeMaping = [$City->state, $City->$cityparam, $City->county, $City->abbr];
        return str_replace(UltimatePageBuilder()->engine->Shortcodes, $shortcodeMaping, $string);
    }
    
    /**
     * create markup json object
     * @param array $postData
     * @param String $City
     * @param String $cityParam
     * @return Json
     */
    private function createSchemaMarkup($postData, $City, $cityParam) {
        $schemamarkup = UltimatePageBuilder()->engine->getValue('schemamarkup', $postData, false);
        foreach ($schemamarkup as $key => $markup) {
            if(!is_array($markup)) {
                $schemamarkup[$key] = $this->replaceShortcodes($markup, $City, $cityParam);
            }else {
                foreach ($markup as $key2 => $markup2) {
                    if(!is_array($markup2)) {
                        $schemamarkup[$key][$key2] = $this->replaceShortcodes($markup2, $City, $cityParam);
                    }else {
                        foreach ($markup2 as $key3 => $markup3) {
                            if(!is_array($markup3)) {
                                $schemamarkup[$key][$key2][$key3]= $this->replaceShortcodes($markup3, $City, $cityParam);
                            }
                        }
                    }
                }
            }
        }
        
        return json_encode($schemamarkup);
    }
    /**
     * validate data
     * @param array $postdata
     * @return array
     */
    private function validateData($postdata) {
        $return = ['errors' => null, 'where' => null];
        $page_name = UltimatePageBuilder()->engine->getValue('page_name', $postdata, false);
        $pages_for = UltimatePageBuilder()->engine->getValue('gpb_pages_for', $postdata, false);
        $state = UltimatePageBuilder()->engine->getValue('upb_states', $postdata, false);
        $counties = UltimatePageBuilder()->engine->getValue('upb_counties', $postdata, false);
        if (!$page_name) {
            $return['errors']['page_name'] = __("Please enter page name");
        }
        if (!$pages_for) {
            $return['errors']['gpb_pages_for'] = __("Please select any value");
        }
        if (($pages_for == 'states' || $pages_for == 'counties')) {
            if (!$state)
                $return['errors']['upb_states'] = __("Please select states");
            else
                $return['where'][] = "`state` like '{$state}'";
        }

        if ($pages_for == 'counties') {
            if (!$counties) {
                $return['errors']['upb_counties'] = __("Please select counties");
            } else {
                $counties_query = [];
                foreach ($counties as $county) {
                    $counties_query[] = "county like '$county'";
                }
                $return['where'][] = "(" . implode(' or ', $counties_query) . ")";
            }
        }

        if ($pages_for == 'csv') {
            if ($_FILES['upb_csv_file']['size'] == 0) {
                $return['errors']['upb_csv_file'] = __("Please select a csv file");
            }
            $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
            if (!in_array($_FILES['upb_csv_file']['type'], $mimes)) {
                $return['errors']['upb_csv_file'] = __("Please select a valid csv file");
            }
        }
        return $return;
    }

    /**
     * actions init method
     */
    public function UPBActionsInit() {
        
    }
    
    public function markupFields() {
        $template = filter_input(INPUT_POST, 'markupType', FILTER_SANITIZE_STRING);
        if($template) {
            $content = UltimatePageBuilder()->engine->displayMarkupFields($template);
            wp_send_json(['status' => 'success', 'content' => $content]);
        }else {
            wp_send_json(['status' => 'fail', 'message' => __("invalid template", "ultimate-page-builder")]);
        }
    }
}

return new UPBActions();
