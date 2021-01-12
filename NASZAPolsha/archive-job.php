<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
get_header();
if (is_active_sidebar('archive-top-sidebar')) {
    dynamic_sidebar('archive-top-sidebar');
}
?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php if (category_description()) { ?>
    <div class="archive-description"><?php echo category_description(); ?></div>

<?php } else { ?>
    <div class="archive-description"><p>Безкоштовна дошка вакансій. Знайди достойну роботу для себе у Польщі...</p></div>
<?php }; ?>
<div class="job_filters">
    <?php get_template_part('page-parts/archive-search-job'); ?>
    <?php get_template_part('page-parts/archive-job-top'); ?>
</div>
<?php if (have_posts()) : ?>
    <div class="job_listings">
        <ul class="job_listings">

            <?php do_action('kleo_before_archive_content'); ?>


            <?php
            // Start the Loop.
            while (have_posts()) : the_post();
                $new_view = new_job_view();
                if ($new_view) {
                    get_template_part('page-parts/content-job_new');
                } else {
                    get_template_part('page-parts/content-job');
                }
            endwhile;
            ?>

        </ul>
    </div>

    <?php
    // page navigation.
    kleo_pagination();

else :
    // If no content, include the "No posts found" template.
    get_template_part('content', 'none');

endif;
?>

<?php do_action('kleo_after_archive_content'); ?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>
