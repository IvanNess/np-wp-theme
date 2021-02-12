<?php
/**
 * Job listing in the loop.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.0.0
 * @version     1.27.0
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $post;
?>
<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr($post->geolocation_lat); ?>" data-latitude="<?php echo esc_attr($post->geolocation_long); ?>">
    <a href="<?php the_job_permalink(); ?>">
        <div class="company_logo_box">
            <?php
            if (false) {
                $great_logo_of_the_company = get_post_meta(get_the_ID(), 'great_logo_of_the_company', true);
                if (!empty($great_logo_of_the_company)) {
                    echo wp_get_attachment_image($great_logo_of_the_company, 'full', array('class' => 'company_logo'));
                } else {
                    the_company_logo($size = 'full');
                }
            }
            ?>
        </div>
        <div class="position position_job_box">
            <div class="date"><?php the_job_publish_date(); ?></div>
            <h3><?php wpjm_the_job_title(); ?></h3>
            <?php
            $content = get_the_content();
            $trimmed_content = wp_trim_words($content, 10, '...');
            echo '<p>' . $trimmed_content . '</p>';
            ?>
        </div>
        <div class="job_info_box">
            <div class="title_job_info">Offer:</div>
            <div class="lineb">
                <div class="company">
                    <?php the_company_name('<strong>', '</strong> '); ?>
                    <?php the_company_tagline('<span class="tagline">', '</span>'); ?>           
                </div>
                <strong class="location">
                    <?php the_job_location(false); ?>
                </strong>
                <ul class="meta">
                    <?php do_action('job_listing_meta_start'); ?>

                    <?php if (get_option('job_manager_enable_types')) { ?>
                        <?php $types = wpjm_get_the_job_types(); ?>
                        <?php if (!empty($types)) : foreach ($types as $type) : ?>
                                <li class="job-type <?php echo esc_attr(sanitize_title($type->slug)); ?>"><?php echo esc_html($type->name); ?></li>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    <?php } ?>

                    <?php do_action('job_listing_meta_end'); ?>
                </ul>
            </div>
        </div>
        <div class="job_info_box">
            <?php
            $salary_type = get_post_meta($post_id, '_job_salary_type', true);
            $salary_type_view = (!empty($salary_type)) ? $salary_type : '';
            ?>
            <div class="title_job_info">Salary: <?php echo $salary_type_view; ?></div>
            <div class="lineb">
                <strong class="box_job_salary"><?php
                    $post_id = $post->ID;
                    $values = get_post_meta($post_id, '_job_salary', true);

                    $price_tag = get_post_meta($post_id, '_job_price_tag', true);
                    $price_tag_view = (!empty($price_tag)) ? $price_tag : 'зл/год';
                    $values = get_post_meta($post_id, '_job_salary', true);
                    if (!empty($values)) {
                        echo '<span>' . $values . '</span> ' . $price_tag_view;
                    } else {
                        echo 'Agreed';
                    }
                    ?></strong>
                <div class="more_about_job">Read more</div>
            </div>
        </div>
    </a>
</li>
