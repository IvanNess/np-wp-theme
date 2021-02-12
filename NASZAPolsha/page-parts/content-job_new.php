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
$post_id = get_the_ID();
//print_a($post);
$actual_by = get_post_meta($post_id, '_job_expires', true);
$today_date = current_time('Y-m-d');
if (!empty($actual_by) && $today_date > $actual_by) {
    $job_class = 'job_listing_new job_listing status-expired';
} else {
    $job_class = 'job_listing_new job_listing';
}
?>
<li <?php post_class($job_class); ?> data-longitude="<?php echo esc_attr($post->geolocation_lat); ?>" data-latitude="<?php echo esc_attr($post->geolocation_long); ?>">
    <a href="<?php the_permalink(); ?>">    
        <?php
        $great_logo_of_the_company = get_post_meta($post_id, 'great_logo_of_the_company', true);
        if (!empty($great_logo_of_the_company)) {
            $image = wp_get_attachment_image($great_logo_of_the_company, 'full', array('class' => 'company_logo kleo-full-width'));
            $image_url = wp_get_attachment_image_url($post_id, 'full');
        } else {
            $image = kleo_get_post_thumbnail(null, 'kleo-full-width');
            $image_url = get_the_post_thumbnail_url($post_id, 'kleo-full-width');
        }
        if (!empty($image_url)) {
            $class_img = 'col-sm-5 yes_img';
            echo '<div class="company_logo_bg col-sm-3" style="background-image:url(' . $image_url . ')">' . $image . '</div>';
        } else {
            $class_img = 'col-sm-8 no_img';
        }
        ?>
        <div class="content_job_box <?php echo $class_img; ?>">
            <h6><strong><?php the_title(); ?></strong></h6>
            <div class="company">
                <?php
                $job_employment = get_the_terms($post_id, 'job_employment');
                $job_employment_i = 0;
                if (!empty($job_employment)) : foreach ($job_employment as $employment) : $job_employment_i++;
                        if ($job_employment_i == count($job_employment)) {
                            $separator = ': ';
                        } else {
                            $separator = ', ';
                        }
                        echo $employment->name . $separator;
                    endforeach;
                endif;
                $company_name = get_post_meta($post_id, '_company_name', true);
                if (!empty($company_name)) {
                    echo $company_name;
                }
                ?>       
            </div>
            <div class="bottom_meta row">
                <span class="location col-sm-6"><i class="icon icon-location"></i>
                    <?php
                    $tags = get_the_terms($post_id, 'classified_tags');
					if (!empty($tags) && !is_wp_error($tags)) {
						$count = count($tags);
						$i = 0;
						$tags_list = '';
							
						foreach ($tags as $term) {
							$i++;
							$tags_list .= $term->name;
							if ($count != $i) {
								$tags_list .= ', ';
							}
						}

						echo $tags_list;
					} else {
						echo 'Всюди';
					}
                    ?>
                </span>
                <span class="date col-sm-6" style="padding:0;"><i class="icon icon-clock"></i>
                    <?php
                    $display_date = sprintf('%s temu', human_time_diff(get_post_time('U'), current_time('timestamp')));
                    echo $display_date;
                    ?>
                </span>
            </div>
        </div>
        <div class="info_job_box col-sm-4">

            <strong class="box_job_salary">
                <?php
                $values = get_post_meta($post_id, '_job_salary', true);

                $price_tag = get_post_meta($post_id, '_job_price_tag', true);
                $price_tag_view = (!empty($price_tag)) ? $price_tag : 'zł/godzinę';
                $values = get_post_meta($post_id, '_job_salary', true);
                if (!empty($values)) {
                    echo ' <span>' . $values . '</span> ' . $price_tag_view;
                } else {
                    echo 'Umowne';
                }
                ?>
            </strong>
            <ul class="meta_li">
                <?php
                $salary_type = get_post_meta($post_id, '_job_salary_type', true);
                if (!empty($salary_type)) {
                    echo '<li><strong>Wynagrodzenie:</strong> ' . $salary_type . '</li>';
                }
                $types = get_the_terms($post_id, 'job_type');
                $types_i = 0;
                $type_name = '';
                if (!empty($types)) : foreach ($types as $type) : $types_i++;
                        if ($types_i == count($types)) {
                            $separator = '';
                        } else {
                            $separator = ', ';
                        }
                        $type_name .= esc_html($type->name) . $separator;
                    endforeach;
                    echo '<li><strong>Wymiar godzin:</strong> ' . $type_name . '</li>';
                endif;
                $job_type_contract = get_the_terms($post_id, 'job_type_contract');
                $job_type_contract_i = 0;
                $contract_name = '';
                if (!empty($job_type_contract)) : foreach ($job_type_contract as $contract) : $job_type_contract_i++;
                        if ($job_type_contract_i == count($job_type_contract)) {
                            $separator = '';
                        } else {
                            $separator = ', ';
                        }
                        $contract_name .= esc_html($contract->name) . $separator;

                    endforeach;
                    echo '<li><strong>Rodzaj umowy:</strong> ' . $contract_name . '</li>';
                endif;
                ?>
            </ul>
            <strong class="more_about_job">Zobacz więcej</strong>
        </div>
        <?php
        if (!empty($actual_by) && $today_date > $actual_by) {
            $is_position_featured_top = get_post_meta($post_id, 'is_position_featured_top', true);
            if (!empty($is_position_featured_top)) {
                delete_post_meta($post_id, 'is_position_featured_top');
            }
            echo '<span class="job_expires">closed</span>';
        }
        ?>
    </a>
</li>
