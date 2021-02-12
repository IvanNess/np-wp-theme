<?php
/* Display the number of views      */
/* display - display or return    */
/* prefix - text before the number of views */
/* postfix - text after the number of views*/

function get_views($display = true, $prefix = '', $postfix = '') {
    $post_views = intval(post_custom('views'));
    $output = $prefix . $post_views . $postfix;
    if ($display) {
        echo $output;
    } else {
        return $output;
    }
}

function get_most_viewed_fun($atts, $content = null) {
    $a = shortcode_atts(array(
        'type' => 'gd_classified',
        'id' => '',
            ), $atts);
    if (!empty(esc_attr($a['id']))) {
        $args = array(
            'post_status' => 'publish',
            'post__in' => array(esc_attr($a['id'])),
            'post_type' => esc_attr($a['type']),
            'meta_key' => 'views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );
    } else {
        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => 100,
            'post_type' => esc_attr($a['type']),
            'meta_key' => 'views',
            'orderby' => 'meta_value_num',
            'order' => 'DESC'
        );
    }


    $query = new WP_Query($args);
    $i = 0;
//echo 'views – the number of views for the entire existence of the topic;<br>
//tviews — the number of views for today;<br>
//yviews – the number of views for yesterday;<br>';
    $table = '';
    $table .= '<div class="table-responsive"><table class="table table-hover">';
    $table .= '<thead><tr><th>#</th><th>Name</th><th>За все время</th><th>Последняя дата</th><th>В последний день</th><th>Днем раньше</th></tr></thead><tbody>';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $i++;
            $views = get_post_meta($query->post->ID, 'views', true);
            $tviews = get_post_meta($query->post->ID, 'tviews', true);
            $yviews = get_post_meta($query->post->ID, 'yviews', true);
            $tdate = get_post_meta($query->post->ID, 'tdate', true);
            $table .= '<tr> <th scope="row">' . $i . '</th><td><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></td><td>' . $views . '</td><td>' . $tdate . '</td><td>' . $tviews . '</td><td>' . $yviews . '</td></tr>';
        }
    } else {
        // No posts found
    }
    $table .= '</tbody></table></div>';
    return $table;
    /* return the original data of the post. Reset $ post. */
    wp_reset_postdata();
}

add_shortcode('get_most_viewed', 'get_most_viewed_fun');

// use: [get_most_viewed]
//[fb_follow]
function fb_follow_func($atts) {
    return '<div class="fb-follow" data-href="https://www.facebook.com/NashaPL/" data-layout="button" data-size="large" data-show-faces="true" style="margin:20px auto 0;"></div>';
}

add_shortcode('fb_follow', 'fb_follow_func');

//[childpages]
function my_list_child_pages() {
    global $post;
    $pages = get_pages("child_of=" . $post->ID);
    if ($pages) {
        echo '<ol>';
        $pageids = array();
        foreach ($pages as $page)
            $pageids[] = $page->ID;

        $args = array(
            'title_li' => '', //'Parent page tree: ' . $parent,
            'include' => $parent . ',' . implode(",", $pageids)
        );
        wp_list_pages($args);
        echo '</ol>';
    }
}

add_shortcode('childpages', 'my_list_child_pages');

//[list_archives]
function list_archives_fun() {
    // Archive of records grouped by days (for the last 20 days)
    echo '<div class="widget_archive"><ol>';
    wp_get_archives('type=daily&limit=20&show_post_count=1');
    echo '</ol></div>';
}

add_shortcode('list_archives', 'list_archives_fun');

//[list_informers]
function list_informers_fun() {
//    $cur_user_id = get_current_user_id();
//    if ($cur_user_id != 1) {
//        if (function_exists('list_informereasysend_fun'))
//            list_informereasysend_fun();
//    } else {
//        if (!wp_is_mobile()) {
//            if (function_exists('informercurrency'))
//                informercurrency();
//        }
//    }
    $array_pl = json_decode(get_field('array_pl', 'option'), true);
    $array_ua = json_decode(get_field('array_ua', 'option'), true);
    $array_pl_date = get_field('array_pl_date', 'option');
    $array_ua_date = get_field('array_ua_date', 'option');
    $ul = '<div class="hidden-xs"><ul>';
    $marquee = '<marquee scrollamount="3" direction="left" style="line-height: 40px;float: left;" class="hidden-sm hidden-md hidden-lg hidden-xlg visible-xs">';
    $i_pl = 0;
    $len_pl = count($array_pl);
    foreach ($array_pl as $k => $v) {
        if ($k == 'UAH') {
            $ul .= '<li>1<strong>' . $k . '</strong> = ' . $v . ' PLN</li>';
        } else {
            $ul .= '<li>1 <strong>' . $k . '</strong> = ' . $v . ' PLN</li>';
        }
        $marquee .= '1 <strong>' . $k . '</strong> = ' . $v . ' PLN';
        if ($i_pl == $len_pl - 1) {
            $marquee .= ' | ';
        } else {
            $marquee .= '; ';
        }
        $i_pl++;
    }
    $ul .= '</ul><ul>';
    $i_ua = 0;
    $len_ua = count($array_ua);
    foreach ($array_ua as $k => $v) {
        $ul .= '<li>1 <strong>' . $k . '</strong> = ' . $v . ' UAH</li>';
        $marquee .= '1 <strong>' . $k . '</strong> = ' . $v . ' UAH';
        if ($i_ua == $len_ua - 1) {
            $marquee .= '';
        } else {
            $marquee .= '; ';
        }
        $i_ua++;
    }
    $ul .= '</ul></div>';
    $marquee .= '</marquee>';
    $t = '<div id="easysend-info" class="informerweather" data-current_time_ua="' . $array_ua_date . '" data-current_time_pl="' . $array_pl_date . '">' . $ul . $marquee . '</div>';
    echo $t;
}

add_shortcode('list_informers', 'list_informers_fun');

function max_carousel_fun($atts, $content = null) {
    $html = '';
    $a = shortcode_atts(array(
        'type' => 'classifieds',
//        'type' => 'gd_classified',
        'showposts' => '',
        'max_items' => '',
        'cat' => '',
            ), $atts);
    $showposts = (!empty(esc_attr($a['showposts']))) ? esc_attr($a['showposts']) : 6;
    $max_items = (!empty(esc_attr($a['max_items']))) ? esc_attr($a['max_items']) : 3;
    $cat = (!empty(esc_attr($a['cat']))) ? esc_attr($a['cat']) : '';

    $args = array(
        'post_type' => esc_attr($a['type']),
        'showposts' => $showposts,
        'cat' => $cat,
        'orderby' => 'date',
        'order' => 'DESC' //most recent first
    );
    query_posts($args);
    if (have_posts()) :
        $html .= '<div class="kleo-carousel-container kleo-carousel-style-overlay">
            <div class="kleo-carousel-items kleo-carousel-post" data-min-items="1" data-max-items="' . $max_items . '" data-autoplay="true" data-speed="5000">
                <ul class="kleo-carousel">';
        while (have_posts()) : the_post();
            $id = get_the_ID();
            global $kleo_config;
            ob_start();
            ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(array("post-item col-sm-4")); ?>>
                <article>
                    <?php
                    if (kleo_get_post_thumbnail_url() != '') {
                        echo '<div class="post-image">';
//                        $terms = get_the_terms($id, 'gd_classified_tags');
                        $terms = get_the_terms($id, 'classified_tags');
                        if (!empty($terms) && !is_wp_error($terms)) {
                            $count = count($terms);
                            $i = 0;
                            $term_list = '<span class="classified_tags_media">';
                            foreach ($terms as $term) {
                                $i++;
                                $term_list .= '<a href="' . get_term_link($term) . '" title="' . sprintf(__('View all post filed under %s', 'kleo'), $term->name) . '">' . $term->name . '</a>';
                                if ($count != $i) {
                                    $term_list .= ' &middot; ';
                                } else {
                                    $term_list .= '</span>';
                                }
                            }
                            echo $term_list;
                        }
                        //check for custom image sizes
//                        if (sq_option('blog_custom_img', 0) == 1) {
//                            $image = kleo_get_post_thumbnail(null, 'kleo-post-gallery');
//                            $img_content = $image;
//                        } else {
                        $img_url = kleo_get_post_thumbnail_url();
                        $image = aq_resize($img_url, $kleo_config['post_gallery_img_width'], $kleo_config['post_gallery_img_height'], true, true, true);
                        $img_content = '<img src="' . $image . '" alt="' . get_the_title() . '">';
//                        }

                        if ($image) {
                            echo '<a href="' . get_permalink() . '" class="element-wrap">'
                            . $img_content
                            . kleo_get_img_overlay()
                            . '</a>';
                        }

                        echo '</div><!--end post-image-->';
                    }
                    ?>
                    <div class="entry-content">
                        <h4 class="post-title entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    </div><!--end post-info-->
                </article>
            </li>
            <?php
            $html .= ob_get_clean();
        endwhile;
        $html .= '</ul>
            </div>
            <div class="carousel-arrow">
                <a class="carousel-prev" href="#"><i class="icon-angle-left"></i></a>
                <a class="carousel-next" href="#"><i class="icon-angle-right"></i></a>
            </div>
            <div class="kleo-carousel-post-pager carousel-pager"></div>
        </div><!--end carousel-container-->';
    endif;
    wp_reset_query();
    return $html;
}

add_shortcode('max_carousel', 'max_carousel_fun');

function max_focus_fun($atts, $content = null) {
    $html = '';
    $a = shortcode_atts(array(
        'type' => 'post',
        'showposts' => '',
        'featured' => '',
        'cat' => '',
        'new_tab' => '',
            ), $atts);
    $showposts = (!empty(esc_attr($a['showposts']))) ? esc_attr($a['showposts']) : 5;
    $featured = (!empty(esc_attr($a['featured']))) ? esc_attr($a['featured']) : 1;
    $cat = (!empty(esc_attr($a['cat']))) ? esc_attr($a['cat']) : '';
    $new_tab = (!empty(esc_attr($a['new_tab']))) ? esc_attr($a['new_tab']) : '';

    $args = array(
        'post_type' => esc_attr($a['type']),
        'showposts' => $showposts,
        'cat' => $cat,
        'orderby' => 'date',
        'order' => 'DESC' //most recent first
    );
    query_posts($args);
    if (have_posts()) {
        $count = 0;
        $html .= '<div class="news-focus">';
        $html .= '<div class="row">';
        $html .= '<div class="col-sm-6">';
        $html .= '<div class="posts-listing standard-listing with-meta inline-meta">';
        while (have_posts()) : the_post();
            $count++;
            $kleo_post_format = get_post_format();
            //Left side thumb
            if ($count <= $featured) {
                ob_start();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-content animated animate-when-almost-visible el-appear">
                        <div class="article-media clearfix">
                            <?php echo kleo_get_post_media($kleo_post_format); ?>
                        </div>
                        <h3 class="post-title entry-title">
                            <a href="<?php the_permalink(); ?>" <?php echo ($new_tab == 1) ? 'target="_blank"' : ''; ?>>
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <div class="article-meta">
                            <span class="post-meta">
                                <?php kleo_entry_meta(); ?>
                            </span>
                        </div>
                        <div class="entry-summary">
                            <?php
                            if (!in_array($kleo_post_format, array('status', 'quote', 'link'))) {
                                echo kleo_excerpt();
                            } else {
                                the_content();
                            }
                            ?>
                        </div><!-- .entry-summary -->
                    </div>
                </article>
                <?php
                $html .= ob_get_clean();
                if ($count == $featured) {
                    $html .= '</div> <!-- .posts-listing -->';
                    $html .= '</div> <!-- .col-sm-6 -->';
                    $html .= '<div class="col-sm-6">';
                    $html .= '<div class="posts-listing left-thumb-listing">';
                }
            } else {
                ob_start();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-content animated animate-when-almost-visible el-appear">
                        <div class="article-media">
                            <?php echo kleo_get_post_media($kleo_post_format, array('media_width' => 220, 'media_height' => 192)); ?>
                        </div>
                        <div class="post-date"><?php the_date(); ?></div>
                        <h3 class="post-title entry-title"><a href="<?php the_permalink(); ?>" <?php echo ($new_tab == 1) ? 'target="_blank"' : ''; ?>><?php the_title(); ?></a></h3>
                    </div>
                </article>
                <?php
                $html .= ob_get_clean();
            }
        endwhile;
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }
    wp_reset_query();
    return $html;
}

add_shortcode('max_focus', 'max_focus_fun');

function max_flexslider_fun($atts, $content = null) {
    $html = '';
    $a = shortcode_atts(array(
        'type' => 'gd_classified',
        'showposts' => '',
        'max_items' => '',
        'cat' => '',
            ), $atts);
//    $showposts = (!empty(esc_attr($a['showposts']))) ? esc_attr($a['showposts']) : 6;
    $showposts = (!empty(esc_attr($a['showposts']))) ? esc_attr($a['showposts']) : 4;
    $max_items = (!empty(esc_attr($a['max_items']))) ? esc_attr($a['max_items']) : 3;
    $cat = (!empty(esc_attr($a['cat']))) ? esc_attr($a['cat']) : '';

    $args = array(
        'post_type' => esc_attr($a['type']),
        'showposts' => $showposts,
        'cat' => $cat,
        'orderby' => 'date',
        'order' => 'DESC' //most recent first
    );
    query_posts($args);
    if (have_posts()) :
        $html .= '<div class="max_flexslider loading"><ul class="slides">';
        while (have_posts()) : the_post();
            $id = get_the_ID();
            $html .= '<li data-thumb="' . get_the_post_thumbnail_url($id, 'thumbnail') . '">';
            $html .= '<img src="' . get_the_post_thumbnail_url($id, 'full') . '" />';
            $html .= '<h3 class="post-title entry-title flex-caption"><a href="' . get_the_permalink($id) . '">' . get_the_title($id) . '</a></h3>';
            $html .= '</li>';
        endwhile;
        $html .= '</ul></div>';
    endif;
    wp_reset_query();
    return $html;
}

add_shortcode('max_flexslider', 'max_flexslider_fun');

//[disk_free_space_gb]
//function disk_free_space_fun() {
//    $bytes = disk_free_space(".");
////    $bytes = disk_total_space(".");
//    $si_prefix = array('B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB');
//    $base = 1024;
//    $class = min((int) log($bytes, $base), count($si_prefix) - 1);
//    $str = '<p>Осталось: ' . sprintf('%1.2f', $bytes / pow($base, $class)) . ' ' . $si_prefix[$class] . '</p>';
//    return $str;
//}
//
//add_shortcode('disk_free_space_gb', 'disk_free_space_fun');

function max_jobs_fun($atts, $content = null) {
    $html = '';
    $a = shortcode_atts(array(
        'max_items' => '',
        'cat' => '',
            ), $atts);
    $max_items = (!empty(esc_attr($a['max_items']))) ? esc_attr($a['max_items']) : 4;
    $cat = (!empty(esc_attr($a['cat']))) ? esc_attr($a['cat']) : '';

    $args = array(
        'post_type' => 'job',
        'showposts' => $max_items,
        'cat' => $cat,
        'orderby' => 'date',
        'order' => 'DESC' //most recent first
    );
    query_posts($args);
    if (have_posts()) :
        $html .= '<div class="job_listings"><ul class="job_listings">';
        while (have_posts()) : the_post();
            ob_start();
            get_template_part('page-parts/content-job');
            $html .= ob_get_clean();
        endwhile;
        $html .= '</ul></div>';
    endif;
    wp_reset_query();
//    return $html;
    echo $html;
}

add_shortcode('max_jobs', 'max_jobs_fun'); //[jobs per_page="4" show_filters="false"]

function max_jobs_loadMore_fun($atts, $content = null) {
    $html = '';
    $a = shortcode_atts(array(
        'max_items' => '',
        'cat' => '',
            ), $atts);
    $max_items = (!empty(esc_attr($a['max_items']))) ? esc_attr($a['max_items']) : 20;
    $cat = (!empty(esc_attr($a['cat']))) ? esc_attr($a['cat']) : '';

    $args = array(
        'post_type' => 'job',
        'showposts' => $max_items,
        'cat' => $cat,
        'orderby' => 'date',
        'order' => 'DESC' //most recent first
    );
    query_posts($args);
    if (have_posts()) :
        $html .= '<div class="job_listings"><ul class="job_listings load_jobs">';
        while (have_posts()) : the_post();
            ob_start();
            $new_view = new_job_view();
            if ($new_view) {
                get_template_part('page-parts/content-job_new');
            } else {
                get_template_part('page-parts/content-job');
            }
            $html .= ob_get_clean();
        endwhile;
        $html .= '</ul><a href="#" id="loadMore">Дивитись більше</a></div>';
    endif;
    wp_reset_query();
//    return $html;
    echo $html;
}

add_shortcode('max_jobs_loadMore', 'max_jobs_loadMore_fun'); //[jobs per_page="4" show_filters="false"]

function easysend_statistics_fun($atts, $content = null) {
    get_template_part('page-parts/general-easysend-wrap');
}

add_shortcode('easysend_statistics', 'easysend_statistics_fun');

function preview_job_btn_fun($atts, $content = null) {
    return '<a href="#" class="job_application_button">Відгукнутися</a>';
}

add_shortcode('preview_job_btn', 'preview_job_btn_fun');

function news_highlight_ua_fun() {
    $output = $args = $output_inside = $featured = '';
    $args = array('cat' => 712, 'posts_per_page' => 5);
	//$new_tab = (!empty(esc_attr($a['new_tab']))) ? esc_attr($a['new_tab']) : '';
	$new_tab = 1;
    $el_class = 'news-highlight';
    $featured = 1;

    $category = '<span class="label">' . get_cat_name(712) . '</span>';
    query_posts($args);
    if (have_posts()) {
        $count = 0;

        global $wp_query;
        if (isset($wp_query->post_count) && $wp_query->post_count > 0 && $featured > $wp_query->post_count) {
            $featured = $wp_query->post_count;
        }

        $output_inside .= '<div class="posts-listing standard-listing with-meta inline-meta">';

        while (have_posts()) : the_post();

            $count++;

            $kleo_post_format = get_post_format();

            //Featured post
            if ($count <= $featured) {

                ob_start();
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-content animated animate-when-almost-visible el-appear">

                        <div class="article-media clearfix">
                            <?php
                            if (( $kleo_post_format == 'image' || $kleo_post_format == 'gallery' || ( $kleo_post_format === false && has_post_thumbnail() ) ) && $count == 1) {
                                echo $category;
                            }
                            ?>
                            <?php echo kleo_get_post_media($kleo_post_format); ?>
                        </div>

                        <h3 class="post-title entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                        <div class="article-meta">
                            <span class="post-meta">
                                <?php kleo_entry_meta(); ?>
                            </span>
                        </div>

                        <div class="entry-summary">
                            <?php
                            if (!in_array($kleo_post_format, array('status', 'quote', 'link'))) {
                                echo kleo_excerpt();
                            } else {
                                the_content();
                            }
                            ?>
                        </div><!-- .entry-summary -->

                    </div>
                </article>

                <?php
                if ($count == $featured) {
                    echo '</div> <!-- .posts-listing -->
                    <div class="posts-listing left-thumb-listing">';
                }
                ?>

                <?php
                $output_inside .= ob_get_clean();
            } else {
                ob_start();
                ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-content animated animate-when-almost-visible el-appear">

                        <div class="article-media">
                            <?php echo kleo_get_post_media($kleo_post_format, array('media_width' => 220, 'media_height' => 192)); ?>
                        </div>

                        <div class="post-date"><?php the_date(); ?></div>

                        <h3 class="post-title entry-title"><a href="<?php the_permalink(); ?>" <?php
                                                              if ($new_tab == 1) {
                                                                  echo 'target="_blank"';
                                                              }
                                                              ?>><?php the_title(); ?></a></h3>

                    </div>
                </article>

                <?php
                $output_inside .= ob_get_clean();
            }

        endwhile;

        $output_inside .= '</div><!-- .posts-listing -->';
    }

    // Reset Query
    wp_reset_query();

    $output .= "\n\t" . "<div class=\"{$el_class}\">{$output_inside}</div>";
    return $output;
}

add_shortcode('news_highlight_ua', 'news_highlight_ua_fun');
