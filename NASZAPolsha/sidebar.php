<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
global $post;
$sidebar_classes = apply_filters('kleo_sidebar_classes', '');
$sidebar_name = apply_filters('kleo_sidebar_name', '0');
if (is_post_type_archive('classifieds') || is_tax('classifiedcategory') || is_tax('classified_tags')) {
    
} else {
    ?>

    <div class="sidebar sidebar-main <?php echo $sidebar_classes; ?>">
        <div class="inner-content widgets-container">
            <?php
            if (bp_current_component()) {
                dynamic_sidebar('sidebar-buddypress');
            } elseif (is_bbpress()) {
                dynamic_sidebar('sidebar-bbpress');
            } elseif ('job_listing' === get_post_type($post->ID)) {
                dynamic_sidebar('sidebar-wp-job-manager');
            } elseif (148 === $post->ID || is_post_type_archive('job') || is_tax('job_category') || is_tax('job_type')) {
                dynamic_sidebar('jobs-page');
            } else {
                if (function_exists('generated_dynamic_sidebar')) {
                    generated_dynamic_sidebar($sidebar_name);
                } else {
                    dynamic_sidebar('sidebar-1');
                }
            }
            ?>
        </div><!--end inner-content-->
    </div><!--end sidebar-->
    <?php
}