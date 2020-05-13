<div id="upb_builder_form">
    <h3><?php _e("Create Bulk Pages", "") ?></h3>
    <form class="upb_form" id="upb_form" method="post" onsubmit="return UPB_Admin.ProcessPageData(event, this);">  
        <p class="upb_information notice notice-info"><?php _e("you can use shortcodes ".implode(' ', $this->Shortcodes), "ultimate-page-builder"); ?></p>   
        <div class="upb_row">
            <div class="upb_page_fields">
                <div class="upb_field_wrap">
                    <label><?php _e("How would you like to build posts?", "ultimate-page-builder"); ?></label>
                    <select class="gpb_input gpb_pages_for select2" data-required="true" name="gpb_pages_for">
                        <option value="">-Select-</option>
                        <option value="all"><?php _e("For all cities/states", 'ultimate-page-builder');  ?></option>
                        <option value="states"><?php _e("For specific states", 'ultimate-page-builder');  ?></option>
                        <option value="counties"><?php _e("For specific counties", 'ultimate-page-builder');  ?></option>
                        <option value="csv"><?php _e("From CSV file", 'ultimate-page-builder');  ?></option>
                    </select>
                </div>
                <div id="upb_csv_uploader" class="upb_field_wrap upb_hidden upb_csv_uploader">
                    <label><?php _e("CSV file", 'ultimate-page-builder') ?> &nbsp; &nbsp; <a href="<?php echo site_url('?action=upb_download_sample'); ?>" target="_blank"><?php _e("Download Sample Data", 'ultimate-page-builder'); ?></a></label>
                    <input type="file" name="upb_csv_file" class="upb_csv_file"/>
                </div>
                <div class="upb_field_wrap upb_hidden upb_states_wrap">
                    <label><?php _e("Select states to target", 'ultimate-page-builder') ?></label>
                    <select id="upb_states" class="gpb_input upb_states select2" name="upb_states">
                        <option value="">-Select-</option>
                    </select>
                </div>
                <div class="upb_field_wrap upb_hidden upb_counties_wrap">
                    <label><?php _e("Select counties to target", "ultimate-page-builder"); ?></label>
                    <select id="upb_counties" multiple="true" class="gpb_input upb_counties select2" name="upb_counties[]">
                        <option value="">-Select-</option>
                    </select>
                </div>
                <div class="upb_field_wrap">
                    <label><?php _e("Template", "ultimate-page-builder"); ?></label>
                    <select class="gpb_input gpb_page_template select2" name="post_template">
                        <?php foreach($this->getPageTemplates() as $key => $template): ?>
                        <option value="<?php print $template->ID; ?>"><?php print $template->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="upb_field_wrap">
                    <label><?php _e("Page Title", "ultimate-page-builder"); ?></label>
                    <input type="text" name="page_name" class="gpb_input page_name" value="<?php echo implode(' ', $this->Shortcodes); ?>" placeholder="Enter page name here">
                </div>
                <div class="upb_field_wrap">
                    <label><?php _e("Meta Title", "ultimate-page-builder"); ?></label>
                    <input type="text" name="meta_title" class="gpb_input meta_title" value="<?php echo implode(' ', $this->Shortcodes); ?>" placeholder="Enter meta title here">
                </div>
                <div class="upb_field_wrap">
                    <label><?php _e("Keyword", "ultimate-page-builder"); ?></label>
                    <input type="text" name="meta_keyword" class="gpb_input meta_title" value="" placeholder="Enter meta keyword here">
                </div>
                <div class="upb_field_wrap">
                    <label><?php _e("Meta Description", "ultimate-page-builder"); ?></label>
                    <textarea class="gpb_input meta_desction" name="meta_description" placeholder="Enter description here"><?php echo implode(' ', $this->Shortcodes); ?></textarea>
                </div>
            </div>
            
            <div class="upb_markup_fields">
                <div class="upb_field_wrap">
                    <label><?php _e("Schema.org markup", "ultimate-page-builder"); ?></label>
                    <select onchange="UPB_Admin.displayShemaMarkup(event, this);" name="upb_schema_type" class="gpb_input select2">
                        <?php foreach($this->getSchemaMarkupTypes() as $key => $type): ?>
                        <option value="<?php print $key; ?>"><?php print $type; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="upb_schemamarkup_fields">
                    <?php print $this->displayMarkupFields(); ?>
                </div>
            </div>
        </div>
        
        <div class="upb_btn_wrap">
            <input type="submit" class="button button-primary button-large" name="add_pages" value="<?php _e("Create Pages"); ?>">
        </div>
    </form>
</div>