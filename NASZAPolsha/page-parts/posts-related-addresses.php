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

$categories = get_object_taxonomies('addresses');

if (!empty($categories)) {
    foreach ($categories as $tax) {
        $terms = wp_get_object_terms($post->ID, $tax, array('fields' => 'ids'));
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        $args['tax_query'][] = array(
            'taxonomy' => $tax,
            'field' => 'id',
            'terms' => $terms
        );
    }
}

/* Remove this line to show related posts even no categories are found */
if (!$categories) {
    return;
}
?>

<?php
query_posts($args);
if (have_posts()) :
    ?>

    <section class="container-wrap">
        <div class="container">
            <div class="related-wrap">

                <div class="hr-title hr-long"><abbr><?php echo $related_text . get_the_ID(); ?></abbr></div>

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