<?php

/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
get_header();
?>

<?php

//Specific class for post listing */
if (kleo_postmeta_enabled()) {
    $meta_status = ' with-meta';
    if (sq_option('blog_single_meta', 'left') == 'inline') {
        $meta_status .= ' inline-meta';
    }
    add_filter('kleo_main_template_classes', function( $cls ) use ( $meta_status ) {
        $cls .= $meta_status;
        return $cls;
    });
}

/* Related posts logic */
$related = sq_option('related_posts', 1);
if (!is_singular('post')) {
    $related = sq_option('related_custom_posts', 0);
}
//post setting
if (get_cfield('related_posts') != '') {
    $related = get_cfield('related_posts');
}
?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php /* Start the Loop */ ?>
<?php

$id = get_the_ID();
$kleo_slider = get_post_meta($id, '_kleo_slider', true);
$k = 'empty';
if(empty($kleo_slider)){
                $upload = get_post_meta($id, 'upload', true);
                if(!empty($upload)){
                    $k = bf_save_classifieds_meta($id, $upload);
                }
            }
//if_me($k);
if ('post' == get_post_type()) {
    $sub_title = get_field('sub_title');
    if (!empty($sub_title)) {
        echo $sub_title;
    }
}
?>
<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('content', 'classifieds'); ?>

    <?php //echo do_shortcode('[mistape]');  ?>
    <?php //echo do_shortcode('[kleo_social_share]'); ?>
    <?php get_template_part('page-parts/posts-social-share'); ?>

    <?php

    if ($related == 1) {
        get_template_part('page-parts/posts-related');
    }
    ?>

    <?php

    if (sq_option('post_navigation', 1) == 1) :
        // Previous/next post navigation.
        kleo_post_nav();
    endif;
    ?>



<?php endwhile; ?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>