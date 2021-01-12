<?php
if (is_post_type_archive('addresses')) {
    $post_types = 'addresses';
} else {
    $post_types = 'classifieds';
}
if (false) {
    ?>
    <div class="widget widget_search" style="margin-bottom: 20px;">
        <form role="search" method="get" class="searchform" action="https://dev.nashapolsha.pl/">
            <div class="input-group">
                <input name="s" autocomplete="off" type="text" class="ajax_s form-control input-sm" value="" style="opacity: 1;" placeholder="Шукати">
                <input type="hidden" name="post_type" value="<?php echo $post_types; ?>" />
                <span class="input-group-btn">
                    <input type="submit" value="Пошук" class="searchsubmit button">
                </span>
            </div>
        </form>
    </div>
    <?php
} else {
    echo '<div class="search_form_archive">' . do_shortcode('[kleo_search_form context="' . $post_types . '" placeholder="Шукати"]') . '</div>';
}
?>