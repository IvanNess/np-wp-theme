<?php

/* Query args */
$argss=array(
    'post__not_in' => array($post->ID),
    'showposts'=> 8,
    'orderby' => 'rand', //random posts
    'order'   => 'ASC' //most recent first
);
$args=array(
    'post__not_in' => array($post->ID),
    'showposts'=> 8,
//    'orderby' => 'rand', //random posts
    'orderby' => 'date', 
    'order'   => 'DESC' //most recent first
);

//logic for blog posts
if (is_singular('post')) {

    //related text
//    $related_text = esc_html__("Related Articles", "kleo_framework");
    $related_text = 'Останні записи';

    $categories = get_the_category($post->ID);

//    if (!empty($categories)) {
    if (FALSE) {
        $category_ids = array();
        foreach ($categories as $rcat) {
            $category_ids[] = $rcat->term_id;
        }

        $args['category__in'] = $category_ids;
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
}
// logic for custom post types
else {

    //related text
    $related_text = esc_html__("Related", "kleo_framework");

    global $post;
    $categories = get_object_taxonomies($post);

    if (!empty($categories)) {
        foreach( $categories as $tax ) {
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
}

/* Remove this line to show related posts even no categories are found */
if (!$categories) { return; }

?>

<?php query_posts($args); if ( have_posts() ) : ?>


<section class="container-wrap">
	<div class="container">
		<div class="related-wrap">
        
            <div class="hr-title hr-long"><abbr><?php echo $related_text; ?></abbr></div>
        
            <div class="kleo-carousel-container dot-carousel">
                <div class="kleo-carousel-items kleo-carousel-post" data-min-items="1" data-max-items="6">
                    <ul class="kleo-carousel">

                        <?php
                        while ( have_posts() ) : the_post();

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
<!-- dodana reklama w artykulach -->
<div><h3>Новини партнерів</h3><div>
<div class="r38781"></div>
<script type="text/javascript">
    (function() {
        var tag = (function() {
                var informers = document.getElementsByClassName('r38781'),
                    len = informers.length;
                return len ? informers[len - 1] : null;
            })(),
            idn = (function() {
                var i, num, idn = '', chars = "abcdefghiklmnopqrstuvwxyz",
                    len = Math.floor((Math.random() * 2) + 4);
                for (i = 0; i < len; i++) {
                    num = Math.floor(Math.random() * chars.length);
                    idn += chars.substring(num, num + 1);
                }
                return idn;
            })(),
            domains = JSON.parse(atob('WyJuZXdzY29kZS5vbmxpbmUiLCJpbmZvY29kZS50ZWNoIiwiaW5mb3JtZXIubGluayJd')),
            loadScript = function() {
                if (! domains.length) return;
                var script = document.createElement('script');
                script.onerror = function() { loadScript(); };
                script.className = 's38781';
                script.src = '//' + domains.shift() + '/ua/38781/';
                script.dataset.idn = idn;
                tag.parentNode.insertBefore(script, tag);
            };
        var container = document.createElement('div');
            container.id = idn;
            container.innerHTML = 'загрузка...';
        tag.appendChild(container);
        loadScript();
    })();
</script>
<!-- koniec reklamy -->
</section>


<?php
endif;

// Reset Query
wp_reset_query();
?>

