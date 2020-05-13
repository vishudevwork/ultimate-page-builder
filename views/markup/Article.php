<div class="upb_field_wrap">
    <label><?php _e("Article @type", "ultimate-page-builder"); ?></label>
    <select class="gpb_input select2" data-required="true" name="schemamarkup[@type]">
        <option value="">-Select-</option>
        <option value="Article"><?php _e("Article", 'ultimate-page-builder');  ?></option>
        <option value="NewsArticle"><?php _e("NewsArticle", 'ultimate-page-builder');  ?></option>
        <option value="BlogPosting"><?php _e("BlogPosting", 'ultimate-page-builder');  ?></option>
    </select>
</div>
<div class="upb_field_wrap">
    <label><?php _e("Headline", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[headline]" class="gpb_input headline" value="" placeholder="Enter Headline">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Image Url", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[image]" class="gpb_input image" value="" placeholder="img full src">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Short Description", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[description]" class="gpb_input description" value="" placeholder="Enter few lines about article">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Auther @type", "ultimate-page-builder"); ?></label>
    <select class="gpb_input select2" data-required="true" name="schemamarkup[author][@type]">
        <option value="">-Select-</option>
        <option value="Person"><?php _e("Personal", 'ultimate-page-builder');  ?></option>
        <option value="Organization"><?php _e("Organization", 'ultimate-page-builder');  ?></option>
    </select>
</div>
<div class="upb_field_wrap">
    <label><?php _e("Auther Name", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[author][name]" class="gpb_input type" value="" placeholder="Enter Auther name">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Publisher Name", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[publisher][@type]" class="gpb_input publisher_type" value="Organization">
    <input type="text" name="schemamarkup[publisher][name]" class="gpb_input publisher_name" value="">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Publisher's Logo", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[publisher][logo][@type]" class="gpb_input logo_type" value="ImageObject">
    <input type="hidden" name="schemamarkup[publisher][logo][width]" class="gpb_input logo_width" value="600">
    <input type="hidden" name="schemamarkup[publisher][logo][height]" class="gpb_input logo_height" value="60">
    <input type="text" name="schemamarkup[publisher][logo][url]" class="gpb_input logo_url" value="">
</div>