<div class="upb_confirmation_text">
    <?php print wp_sprintf("<span>This selection will create <strong>%s</strong> pages in your wordpress. Are you sure to create these pages?</span>", $totalCities);
    ?>
</div>
<div class="upb_process_status">
    <p><processed>0</processed> out of <strong><?php echo $totalCities; ?></strong> processed</p>
    <div class="upb_progress_bar_wrap">
        <span class="upb_progress_bar"></span>
    </div>
</div>
<div class="upb_detailed_status"></div>