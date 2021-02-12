<?php
/**
 * Template Name: Page TEST
 */
get_header();
?>

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php get_template_part('page-parts/general-title-section'); ?>
<div class="page_test_top">

    <?php
    $sub_title = get_field('sub_title');
    if (!empty($sub_title)) {
        ?>
        <h2><?php echo $sub_title; ?></h2>
    <?php } else { ?>
        <h2> </h2>  
    <?php } ?>
    <div class="page_test_sub_title">
        <div class="page_test_sub_title_box">
            <h4>Today about:</h4>
            <h3><?php echo the_title(); ?></h3>
        </div>
    </div>
</div>
<style>
    .article-media img {
        visibility: hidden;
        height: 1px;
    }
</style>
<div class="page_test_content">
    <?php get_template_part('page-parts/general-before-wrap'); ?>

    <?php
    if (have_posts()) :
        // Start the Loop.
        while (have_posts()) : the_post();

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part('content', 'page');
            ?>

            <?php if (sq_option('page_comments', 0) == 1): ?>

                <!-- Begin Comments -->
                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template('', true);
                }
                ?>
                <!-- End Comments -->

            <?php endif; ?>

            <?php
        endwhile;

    endif;
    ?>
</div>
<?php echo do_shortcode('[kleo_social_share]'); ?>
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>