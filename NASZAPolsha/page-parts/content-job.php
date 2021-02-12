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
    $job_class = 'job_listing status-expired';
} else {
    $job_class = 'job_listing';
}
?>
<li <?php post_class($job_class); ?> data-longitude="<?php echo esc_attr($post->geolocation_lat); ?>" data-latitude="<?php echo esc_attr($post->geolocation_long); ?>">
    <a href="<?php the_permalink(); ?>">    
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
            <div class="date"><?php
                $display_date = sprintf('%s temu', human_time_diff(get_post_time('U'), current_time('timestamp')));
                echo $display_date;
                ?>
            </div>
            <h3><?php the_title(); ?></h3>
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
                    <?php
                    $job_employment = get_the_terms($post_id, 'job_employment');
                    if (!empty($job_employment)) : foreach ($job_employment as $employment) :
                            echo '<i>' . $employment->name . '</i><br>';
                        endforeach;
                    endif;
                    ?>
                    <strong><?php echo esc_attr($post->_company_name); ?></strong>
                    <?php //the_company_tagline('<span class="tagline">', '</span>');  ?>           
                </div>
                <strong class="location">
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
                </strong>
                <ul class="meta">
                    <?php //kleo_entry_meta($echo = 'echo', $att = array(), $post_id); ?>

                    <?php
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
                    ?>
                </ul>
            </div>
        </div>
        <div class="job_info_box">
            <?php
            $salary_type = get_post_meta($post_id, '_job_salary_type', true);
            $salary_type_view = (!empty($salary_type)) ? '<strong>' . $salary_type . '</strong>' : '';
            ?>
            <div class="title_job_info">Salary: <?php echo $salary_type_view; ?></div>
            <div class="lineb">
                <strong class="box_job_salary">
                    <?php
                    $values = get_post_meta($post_id, '_job_salary', true);

                    $price_tag = get_post_meta($post_id, '_job_price_tag', true);
                    $price_tag_view = (!empty($price_tag)) ? $price_tag : 'зл/год';
                    $values = get_post_meta($post_id, '_job_salary', true);
                    if (!empty($values)) {
                        echo ' <span>' . $values . '</span> ' . $price_tag_view;
                    } else {
                        echo 'Договірна';
                    }
                    ?>
                </strong>
                <div class="more_about_job">Read More</div>
            </div>
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
