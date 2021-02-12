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
<?php the_terms(get_the_ID(), 'addresscategory', 'Categories: '); ?>
<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('content', get_post_format()); ?>
    <?php
    if (sq_option('post_navigation', 1) == 1) :
        // Previous/next post navigation.
        kleo_post_nav();
    endif;
    ?>
    <?php //echo do_shortcode('[kleo_social_share]'); ?>
    <?php get_template_part('page-parts/posts-social-share'); ?> 

    <?php
    global $post;
    /* Query args */
    $args = array(
        'post__not_in' => array($post->ID),
        'post_type' => 'addresses',
        'showposts' => 8,
        'orderby' => 'date',
        'order' => 'DESC'
    );


    $related_text = 'Recent addresses';
    $tax = 'addresscategory';
    $terms = wp_get_object_terms($post->ID, $tax, array('fields' => 'ids'));

    if (!empty($terms)) {            
            $args['tax_query'][] = array(
                'taxonomy' => $tax,
                'field' => 'id',
                'terms' => $terms
            );
    }
    ?>

    <?php
    query_posts($args);
    if (have_posts()) :
        ?>

        <section class="container-wrap">
            <div class="container">
                <div class="related-wrap">

                    <div class="hr-title hr-long"><abbr><?php echo $related_text; ?></abbr></div>

                    <div class="kleo-carousel-container dot-carousel">
                        <div class="kleo-carousel-items kleo-carousel-post" data-min-items="1" data-max-items="6">
                            <ul class="kleo-carousel">

                                <?php
                                while (have_posts()) : the_post();

                                    get_template_part('page-parts/post-content-carousel');

                                endwhile;
                                ?>

                            </ul>
                        </div>
                        <div class="carousel-arrow">
                            <a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
                            <a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
                        </div>
                        <div class="kleo-carousel-post-pager carousel-pager"></div>
                    </div><!--end carousel-container-->
                </div>
            </div>
        </section>

        <?php
    endif;
// Reset Query
    wp_reset_query();
    ?>

    <!-- Begin Comments -->
    <?php
    if (comments_open() || get_comments_number()) {
        comments_template('', true);
    }
    ?>
    <!-- End Comments -->

<?php endwhile; ?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>
