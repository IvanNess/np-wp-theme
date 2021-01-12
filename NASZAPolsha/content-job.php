<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

<?php
/* Helper variables for this template */
$is_single = is_single();
$post_meta_enabled = kleo_postmeta_enabled();

$slides = get_cfield('slider');
$post_media_enabled = ( kleo_postmedia_enabled() && !empty($slides) );

/* Check if we need an extra container for meta and media */
$show_extra_container = $is_single && sq_kleo()->get_option('has_vc_shortcode') && $post_media_enabled;

$post_class = 'clearfix';
if ($is_single && get_cfield('centered_text') == 1) {
    $post_class .= ' text-center';
}
$post_id = get_the_ID();
$actual_by = get_post_meta($post_id, '_job_expires', true);
$today_date = current_time('Y-m-d');
if (!empty($actual_by) && $today_date > $actual_by) {
    $post_class .= ' status-expired';
}
?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class(array($post_class)); ?>>

    <?php if (!$is_single) : ?>
        <h2 class="article-title entry-title">
            <a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
    <?php endif; ?>

    <?php if ($show_extra_container) : /* Small fix for full width layout to center media and meta */ ?>
        <div class="container">
        <?php endif; ?>

        <?php if ($post_meta_enabled) : ?>
            <div class="article-meta">
                <span class="post-meta">
                    <?php kleo_entry_meta(); ?>
                </span>
                <?php edit_post_link(__('Edit', 'kleo_framework'), '<span class="edit-link">', '</span>'); ?>
            </div><!--end article-meta-->
        <?php endif; ?>

        <?php if ($show_extra_container) : /* Small fix for full width layout to center media and meta */ ?>
        </div>
    <?php endif; ?>

    <div class="article-content single_job_listing <?php echo (!empty($actual_by) && $today_date > $actual_by) ? 'job-expired' : ''; ?>">

        <?php do_action('kleo_before_inner_article_loop'); ?>

        <?php if (!$is_single) : // Only display Excerpts for Search ?>

            <?php echo kleo_excerpt(50); ?>
            <p class="kleo-continue">
                <a class="btn btn-default"
                   href="<?php the_permalink() ?>"><?php esc_html_e(sq_option('continue_reading_blog_text', 'Continue reading'), 'kleo_framework'); ?></a>
            </p>

        <?php else : ?>

            <?php the_content(esc_html__('Continue reading <span class="meta-nav">&rarr;</span>', 'kleo_framework')); ?>
            <ul class="job-listing-meta meta">
                <?php	
				$tags = get_the_terms($post_id, 'classified_tags');
				if (!empty($tags) && !is_wp_error($tags)) {
					$count = count($tags);
					$i = 0;
					$tags_list = '<li class="location">';
						
					foreach ($tags as $term) {
						$i++;
						$tags_list .= '<a class="google_map_link" href="http://maps.google.com/maps?q=' . $term->name . '&amp;zoom=14&amp;size=512x512&amp;maptype=roadmap&amp;sensor=false" target="_blank" rel="noopener">' . $term->name . '</a>';
						if ($count != $i) {
							$tags_list .= ', ';
						} else {
							$tags_list .= '</li>';
						}
					}

					echo $tags_list;
				}
			
                $display_date = sprintf('%s temu', human_time_diff(get_post_time('U'), current_time('timestamp')));
                if (!empty($display_date)) {
                    echo '<li class="date-posted"><time datetime="' . get_the_date('Y-m-d') . '">' . $display_date . '</time></li>';
                }
                if (!empty($actual_by) && $today_date > $actual_by) {
                    $is_position_featured_top = get_post_meta($post_id, 'is_position_featured_top', true);
                    if (!empty($is_position_featured_top)) {
                        delete_post_meta($post_id, 'is_position_featured_top');
                    }
                    echo '<li class="listing-expired">Вакансія закрита</li>';
                }
                $types = get_the_terms($post_id, 'job_type');
                if (!empty($types)) : foreach ($types as $type) :
                        ?>
                        <li class="job-type <?php echo esc_attr(sanitize_title($type->slug)); ?>"><?php echo esc_html($type->name); ?></li>
                        <?php
                    endforeach;
                endif;
                $job_type_contract = get_the_terms($post_id, 'job_type_contract');
                if (!empty($job_type_contract)) : foreach ($job_type_contract as $contract) :
                        ?>
                        <li class="job-type <?php echo esc_attr(sanitize_title($contract->slug)); ?>"><?php echo esc_html($contract->name); ?></li>
                        <?php
                    endforeach;
                endif;
                $salary = get_post_meta($post_id, '_job_salary', true);
                $salary_type = get_post_meta($post_id, '_job_salary_type', true);
                $salary_type_view = (!empty($salary_type)) ? $salary_type : '';
                $price_tag = get_post_meta($post_id, '_job_price_tag', true);
                $price_tag_view = (!empty($price_tag)) ? $price_tag : 'зл/год';
                if (!empty($salary)) {
                    echo '<li><i class="icon-money"></i> Зарплата: ' . $salary_type_view . ' <strong>' . $salary . '</strong> ' . $price_tag_view . '</li>';
                } else {
                    echo '<li><i class="icon-money"></i> Зарплата: <strong>Договірна</strong></li>';
                }
                $phone = get_post_meta($post_id, 'phone', true);
                if (!empty($phone)) {
                    echo '<li><div class="more_info_phone"><i class="icon-volume-control-phone"></i> Телефон: <a href="tel:' . $phone . '" style="color:#fd3300;">' . $phone . '</a><span class="mask_phone">зателефонувати</span></div></li>';
                }
                ?>
            </ul>

            <?php
            $company_name = get_post_meta($post_id, '_company_name', true);
            if (!empty($company_name)) {
                echo '<div class="company">';
                $company_logo = get_the_post_thumbnail_url($post_id);
                if (!empty($company_logo)) {
                    echo '<img class="company_logo" src="' . $company_logo . '" alt="' . $company_name . '">';
                }
                $job_employment = get_the_terms($post_id, 'job_employment');
                if (!empty($job_employment)) : foreach ($job_employment as $employment) :
                        echo '<p class="tagline">'.$employment->name.'</p>';
                    endforeach;
                endif;
                echo '<p class="name">';
                $company_website = get_post_meta($post_id, '_company_website', true);
                if (!empty($company_website)) {
                    echo '<a class="website" href="' . $company_website . '" rel="nofollow noopener" target="_blank">Сайт</a>';
                }
                echo '<strong>' . $company_name . '</strong></p>';
                $company_tagline = get_post_meta($post_id, '_company_tagline', true);
                if (!empty($company_tagline)) {
                    echo '<p class="tagline">' . $company_tagline . '</p>';
                }
                echo '</div>';
            }
            if (!empty($actual_by) && $today_date > $actual_by) {
                echo '<div class="job-expired-content">вакансія закрита</div>';
            } else {
                ?>
              <!--  <a href="#" class="job_application_button">Відгукнутися</a>

                <div class="job_application_details" style="display: none;"><?php echo do_shortcode('[contact-form-7 id="4" title="Контактна форма"]'); ?></div>-->
            <?php } ?>

        <?php endif; ?>

        <?php do_action('kleo_after_inner_article_loop'); ?>

    </div><!--end article-content-->

</article>
<!-- End  Article -->
