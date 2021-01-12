<?php
/**
 * Template Name: Page Add Job
 */
get_header();
?>

<?php get_template_part('page-parts/general-title-section'); ?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php if (have_posts()) : ?>
    <?php
    // Start the Loop.
    while (have_posts()) : the_post();
        ?>

        <?php
        $extra_classes = 'clearfix';
        if (get_cfield('centered_text') == 1) {
            $extra_classes .= ' text-center';
        }
        ?>

        <!-- Begin Article -->
        <article id="post-<?php the_ID(); ?>" <?php post_class($extra_classes); ?>>

            <?php
            if (kleo_postmedia_enabled('page_media', 0, true)) {

                $slides = get_cfield('slider');
                $audio = get_cfield('audio');

                //oEmbed video
                $video = get_cfield('embed');
                // video bg self hosted
                $bg_video_args = array();
                $k_video = '';

                if (get_cfield('video_mp4')) {
                    $bg_video_args['mp4'] = get_cfield('video_mp4');
                }
                if (get_cfield('video_ogv')) {
                    $bg_video_args['ogv'] = get_cfield('video_ogv');
                }
                if (get_cfield('video_webm')) {
                    $bg_video_args['wemb'] = get_cfield('video_webm');
                }

                if (!empty($bg_video_args)) {
                    $attr_strings = array(
                        'preload="none"'
                    );

                    if (get_cfield('video_poster')) {
                        $attr_strings[] = 'poster="' . get_cfield('video_poster') . '"';
                    }

                    $k_video .= '<div class="kleo-video-wrap"><video ' . join(' ', $attr_strings) . ' controls="controls" class="kleo-video" style="height: 100%; width: 100%;">';

                    $source = '<source type="%s" src="%s" />';
                    foreach ($bg_video_args as $video_type => $video_src) {
                        $video_type = wp_check_filetype($video_src, wp_get_mime_types());
                        $k_video .= sprintf($source, $video_type['type'], esc_url($video_src));
                    }

                    $k_video .= '</video></div>';
                    echo '<div class="article-media clearfix">';
                    echo $k_video;
                    echo '</div>';
                } // oEmbed
                elseif (!empty($video)) {
                    echo '<div class="article-media clearfix">';
                    echo wp_oembed_get($video);
                    echo '</div>';
                } elseif (!empty($slides)) {

                    echo '<div class="article-media kleo-banner-slider">'
                    . '<div class="kleo-banner-items" >';

                    foreach ($slides as $slide) {
                        echo '<article>'
                        . '<a href="' . $slide . '" data-rel="modalPhoto[inner-gallery]">'
                        . '<img src="' . $slide . '" alt="">'
                        . kleo_get_img_overlay()
                        . '</a>'
                        . '</article>';
                    }

                    echo '</div>'
                    . '<a href="#" class="kleo-banner-prev"><i class="icon-angle-left"></i></a>'
                    . '<a href="#" class="kleo-banner-next"><i class="icon-angle-right"></i></a>'
                    . '<div class="kleo-banner-features-pager carousel-pager"></div>'
                    . '</div>';
                } elseif (!empty($audio)) {
                    ?>

                    <div class="article-media clearfix">
                        <audio id="audio_<?php the_id(); ?>" class="kleo-audio" src="<?php echo $audio; ?>"></audio>
                    </div><!--end article-media-->


                <?php } elseif (get_post_thumbnail_id()) { ?>

                    <div class="article-media clearfix">
                        <?php the_post_thumbnail('kleo-full-width'); ?>
                    </div><!--end article-media-->

                <?php } ?>

            <?php } /* end if is_single */ ?>

            <div class="article-content">

                <?php
                if (is_user_logged_in()) {
                    the_content();
                } else {
                    dynamic_sidebar('sidebar-buddypress');
                }
                ?>

            </div><!--end article-content-->

            <?php //edit_post_link( __( 'Edit', 'kleo_framework' ), '<span class="edit-link clearfix">', '</span>' );  ?>
        </article>
        <!-- End  Article -->

    <?php endwhile; ?>

<?php endif; ?>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>