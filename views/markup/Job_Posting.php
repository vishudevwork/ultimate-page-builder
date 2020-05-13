<div class="upb_field_wrap">
    <label><?php _e("Job's title", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[@type]" class="gpb_input" value="JobPosting">
    <input type="text" name="schemamarkup[title]" class="gpb_input title" value="" placeholder="Enter title">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Identifier", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[identifier][@type]" value="PropertyValue">
    <input type="hidden" name="schemamarkup[identifier][name]" class="upb_identifier_name">
    <input type="text" name="schemamarkup[identifier][value]" class="gpb_input" value="" placeholder="Enter Headline">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Job's description (in HTML)", "ultimate-page-builder"); ?></label>
    <textarea type="text" name="schemamarkup[description]" class="gpb_input headline" value="" placeholder="Enter few lines about job"></textarea>
</div>

<div class="upb_field_wrap">
    <label><?php _e("Company", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[hiringOrganization][@type]" value="Organization">
    <input type="text" onkeyup="return jQuery('.upb_identifier_name').val(jQuery(this).val())" name="schemamarkup[hiringOrganization][name]" class="gpb_input headline" value="" placeholder="Enter Headline">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Company URL", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[hiringOrganization][sameAs]" class="gpb_input headline" value="">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Employment type", "ultimate-page-builder"); ?></label>
    <select class="gpb_input select2" data-required="true" name="schemamarkup[employmentType]">
        <option value="FULL_TIME"><?php _e("Full time", 'ultimate-page-builder');  ?></option>
        <option value="PART_TIME"><?php _e("Part time", 'ultimate-page-builder');  ?></option>
        <option value="CONTRACTOR"><?php _e("Contractor", 'ultimate-page-builder');  ?></option>
        <option value="TEMPORARY"><?php _e("Temporary", 'ultimate-page-builder');  ?></option>
        <option value="INTERN"><?php _e("Intern", 'ultimate-page-builder');  ?></option>
        <option value="VOLUNTEER"><?php _e("Volunteer", 'ultimate-page-builder');  ?></option>
        <option value="PER_DIEM"><?php _e("Per diem", 'ultimate-page-builder');  ?></option>
        <option value="OTHER"><?php _e("Other", 'ultimate-page-builder');  ?></option>
    </select>
</div>

<div class="upb_field_wrap">
    <label><?php _e("Work hours (e.g. 8am-5pm, shift)", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[workHours]" class="gpb_input workHours" value="" placeholder="Enter workHours">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Expire Date", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[validThrough]" class="gpb_input validThrough upb_datepicker" value="">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Country", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[jobLocation][@type]" value="Place">
    <select name="schemamarkup[jobLocation][address][addressCountry]" class="gpb_input Country select2">
        <option value="US">USA</option>
    </select>
</div>
<div class="upb_field_wrap">
    <label><?php _e("State/Province/Region", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[jobLocation][address][addressRegion]" class="gpb_input addressLocality" value="[state_abbr]">
</div>
<div class="upb_field_wrap">
    <label><?php _e("City", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[jobLocation][address][addressLocality]" class="gpb_input addressLocality" value="[city]">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Street", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[jobLocation][address][@type]" value="PostalAddress">
    <input type="text" name="schemamarkup[jobLocation][address][streetAddress]" class="gpb_input streetAddress" value="">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Zip code", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[jobLocation][address][postalCode]" class="gpb_input postalCode" value="">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Min. salary", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[baseSalary][value][minValue]" class="gpb_input maxValue" value="">
</div>
<div class="upb_field_wrap">
    <label><?php _e("Max. salary", "ultimate-page-builder"); ?></label>
    <input type="hidden" name="schemamarkup[baseSalary][@type]" value="MonetaryAmount">
    <input type="hidden" name="schemamarkup[baseSalary][value][@type]" value="QuantitativeValue">
    <input type="text" name="schemamarkup[baseSalary][value][maxValue]" class="gpb_input maxValue" value="" >
</div>

<div class="upb_field_wrap">
    <label><?php _e("Currency", "ultimate-page-builder"); ?></label>
    <select class="gpb_input select2" data-required="true" name="schemamarkup[baseSalary][currency]">
        <?php foreach($this->getCurrencies() as $currencyKey => $label): ?>
        <option value="<?php echo $currencyKey; ?>"><?php echo $label; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div class="upb_field_wrap">
    <label><?php _e("Per...", "ultimate-page-builder"); ?></label>
    <select class="gpb_input select2" data-required="true" name="schemamarkup[baseSalary][value][unitText]">
        <option value="HOUR"><?php _e("Hour", 'ultimate-page-builder');  ?></option>
        <option value="WEEK"><?php _e("Week", 'ultimate-page-builder');  ?></option>
        <option value="MONTH"><?php _e("Month", 'ultimate-page-builder');  ?></option>
        <option value="YEAR"><?php _e("Year", 'ultimate-page-builder');  ?></option>
    </select>
</div>

<div class="upb_field_wrap">
    <label><?php _e("Responsabilities", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[responsibilities]" class="gpb_input responsibilities" value="" placeholder="Enter responsibilities">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Skills", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[skills]" class="gpb_input skills" value="" placeholder="Enter skills">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Qualifications", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[qualifications]" class="gpb_input skills" value="" placeholder="Enter qualifications">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Education requirements", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[educationRequirements]" class="gpb_input educationRequirements" value="" placeholder="Enter education Requirements">
</div>

<div class="upb_field_wrap">
    <label><?php _e("Experience requirements", "ultimate-page-builder"); ?></label>
    <input type="text" name="schemamarkup[experienceRequirements]" class="gpb_input skills" value="" placeholder="Experience requirements">
</div>
