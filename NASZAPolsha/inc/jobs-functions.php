<?php
/**
 * Adding Theme Support Wp Job Manager
 */
add_theme_support('job-manager-templates');

/**
 * Remove the preview step. Code goes in theme functions.php or custom plugin.
 * @param  array $steps
 * @return array
 */
//function custom_submit_job_steps( $steps ) {
//	unset( $steps['preview'] );
//	return $steps;
//}
//add_filter( 'submit_job_steps', 'custom_submit_job_steps' );
/**
 * Change button text (won't work until v1.16.2)
 */
//function change_preview_text() {
//    return __('Додати вакансію');
//}
//
//add_filter('submit_job_form_submit_button_text', 'change_preview_text');
/**
 * Since we removed the preview step and it's handler, we need to manually publish jobs
 * @param  int $job_id
 */
//function done_publish_job( $job_id ) {
//	$job = get_post( $job_id );
//	if ( in_array( $job->post_status, array( 'preview', 'expired' ) ) ) {
//		// Reset expirey
//		delete_post_meta( $job->ID, '_job_expires' );
//		// Update job listing
//		$update_job                  = array();
//		$update_job['ID']            = $job->ID;
//		$update_job['post_status']   = get_option( 'job_manager_submission_requires_approval' ) ? 'pending' : 'publish';
//		$update_job['post_date']     = current_time( 'mysql' );
//		$update_job['post_date_gmt'] = current_time( 'mysql', 1 );
//		wp_update_post( $update_job );
//	}
//}
//add_action( 'job_manager_job_submitted', 'done_publish_job' );
// https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
//function xyz_custom_orderby( $query_args ) {
//	// Use meta_value_num for numeric sorting (if issues with meta_value)
//	$query_args[ 'orderby' ] = 'meta_value';
//	$query_args[ 'order' ] = 'ASC';
//	return $query_args;
//}
//add_filter( 'job_manager_get_listings_args', 'xyz_custom_orderby', 99 );
//function xyz_custom_orderby_query_args( $query_args ) {
//	$query_args[ 'cache-bust' ] = time();
//	$query_args[ 'meta_key' ] = '_job_salary';
//	return $query_args;
//}
//add_filter( 'get_job_listings_query_args', 'xyz_custom_orderby_query_args', 99 );
//Tutorial: Adding a salary field for jobs
//Add the field to the frontend
add_filter('submit_job_form_fields', 'frontend_add_salary_field');
add_filter('submit_job_form_fields', 'frontend_company_field');

function frontend_company_field($fields) {
    unset($fields['company']['company_twitter']);
    unset($fields['company']['company_video']);
    unset($fields['company']['company_tagline']);
    return $fields;
}

function frontend_add_salary_field($fields) {
    $fields['job']['job_salary'] = array(
        'label' => __('Salary, PLN/hour', 'job_manager'),
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Example, 10',
        'priority' => 7
    );
    return $fields;
}

//Add the field to admin
add_filter('job_manager_job_listing_data_fields', 'admin_add_salary_field');

function admin_add_salary_field($fields) {
    
if ( is_admin() ) {
    global $post;
//    $post = get_post($post);
    if ('job_listing' == $post->post_type) {
        $job_location = get_post_meta($post->ID, '_job_location', true);
        $job_salary = get_post_meta($post->ID, '_job_salary', true);
        $company_name = get_post_meta($post->ID, '_company_name', true);
        $company_tagline = get_post_meta($post->ID, '_company_tagline', true);
        $company_website = get_post_meta($post->ID, '_company_website', true);
        $application = get_post_meta($post->ID, '_application', true);
        if (empty($company_name)) {
            $fields['_company_name']['value'] = 'HRex';
        }
        if (empty($company_tagline)) {
            $fields['_company_tagline']['value'] = 'Pracownik z Ukrainy w Twojej firmie';
        }
        if (empty($company_website)) {
            $fields['_company_website']['value'] = 'http://hrex.pl';
        }
        if (empty($application)) {
            $fields['_application']['value'] = 'hr.hrex@hrex.eu';
        }
        if (empty($job_location)) {
            $fields['_job_location']['value'] = 'ul. ZAWODZIE 20, 80-726 GDAŃSK';
        }
        $fields['_job_salary'] = array(
            'label' => __('Salary, PLN/hour', 'job_manager'),
            'type' => 'text',
            'placeholder' => 'Example, 10',
            'description' => ''
        );
        if (empty($job_salary)) {
            $fields['_job_salary']['value'] = '10';
        }
        return $fields;
    }
}
}

//Display "Salary" on the single job page
add_action('single_job_listing_meta_end', 'display_job_salary_data');

function display_job_salary_data() {
    global $post;

    $salary = get_post_meta($post->ID, '_job_salary', true);

    if ($salary) {
        echo '<li>' . __('Salary: ') . '<strong>' . esc_html($salary) . '</strong>' . __(' зл/год') . '</li>';
    }
}

//Adding a Salary Filter to the Job Search Form (advanced)
/**
 * This can either be done with a filter (below) or the field can be added directly to the job-filters.php template file!
 *
 * job-manager-filter class handling was added in v1.23.6
 */
add_action('job_manager_job_filters_search_jobs_end', 'filter_by_salary_field');

function filter_by_salary_field() {
    ?>
    <div class="search_categories" id="search_salary">
        <label for="search_categories"><?php _e('Salary', 'wp-job-manager'); ?></label>
        <select name="filter_by_salary" class="job-manager-filter" id="filter_by_salary">
            <option value=""><?php _e('Any salary', 'wp-job-manager'); ?></option>
            <option value="upto10"><?php _e('Up to PLN 10/hour', 'wp-job-manager'); ?></option>
            <option value="10-12"><?php _e('From 10 to 12 PLN/hour', 'wp-job-manager'); ?></option>
            <option value="12-15"><?php _e('From 12 to 15 PLN/hour', 'wp-job-manager'); ?></option>
            <option value="over15"><?php _e('15+ PLN/hour', 'wp-job-manager'); ?></option>
        </select>
    </div>
    <?php
}

/**
 * This code gets your posted field and modifies the job search query
 */
add_filter('job_manager_get_listings', 'filter_by_salary_field_query_args', 10, 2);

function filter_by_salary_field_query_args($query_args, $args) {
    if (isset($_POST['form_data'])) {
        parse_str($_POST['form_data'], $form_data);
        // If this is set, we are filtering by salary
        if (!empty($form_data['filter_by_salary'])) {
            $selected_range = sanitize_text_field($form_data['filter_by_salary']);
            switch ($selected_range) {
                case 'upto10' :
                    $query_args['meta_query'][] = array(
                        'key' => '_job_salary',
                        'value' => '10',
                        'compare' => '<',
                        'type' => 'NUMERIC'
                    );
                    break;
                case 'over15' :
                    $query_args['meta_query'][] = array(
                        'key' => '_job_salary',
                        'value' => '15',
                        'compare' => '>=',
                        'type' => 'NUMERIC'
                    );
                    break;
                default :
                    $query_args['meta_query'][] = array(
                        'key' => '_job_salary',
                        'value' => array_map('absint', explode('-', $selected_range)),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC'
                    );
                    break;
            }
            // This will show the 'reset' link
            add_filter('job_manager_get_listings_custom_filter', '__return_true');
        }
    }
    return $query_args;
}

//is_position_featured_top in post_class
function is_position_featured_top($classes) {
    global $post;
    $post = get_post($post);
    if ('job_listing' == $post->post_type) {
        if (get_field('is_position_featured_top', $post->ID)) {
            if ($post->_featured) {
                $classes[] = 'is_position_featured_top';
            } else {
                $classes[] = 'is_position_featured_bottom';
            }
        }
    }
    return $classes;
}

add_filter('post_class', 'is_position_featured_top');

//
//add_filter( 'job_manager_default_company_logo', 'smyles_custom_job_manager_logo' );
//function smyles_custom_job_manager_logo( $logo_url ){
//	// Change the value below to match the filename of the custom logo you want to use
//	// Place the file in a /images/ directory in your child theme's root directory.
//	// The example provided assumes "/images/custom_logo.png" exists in your child theme
////	$filename = 'custom_logo.png';
////	$logo_url = get_stylesheet_directory_uri() . '/images/' . $filename;
//	$logo_url = 'http://dev.nashapolsha.pl/wp-content/uploads/2016/09/logo.png';
//	
//	return $logo_url;
//	
//}

add_action('save_post', 'hrex_job_manager_logo');

function hrex_job_manager_logo($post_id) {

    // Get Thumbnail
    $post_thumbnail = get_post_meta($post_id, $key = '_thumbnail_id', $single = true);
    $company_name = get_post_meta($post_id, $key = '_company_name', $single = true);

    if (get_post_type() == 'quizs') {
        if (!wp_is_post_revision($post_id)) {
            // Check if Thumbnail exists
            if (empty($post_thumbnail)) {
                // Add thumbnail to post
                update_post_meta($post_id, $meta_key = '_thumbnail_id', $meta_value = '3570');
                update_post_meta($post_id, $meta_key = 'sub_title', $meta_value = 'Weekend test. How well are you familiar with Polish laws?');
            }
        }
    }
    // Verify that post is not a revision
    if (get_post_type() == 'job_listing' && get_post_field('post_author', $post_id) == 741 && $company_name == 'HRex') {
        if (!wp_is_post_revision($post_id)) {
            // Check if Thumbnail exists
            if (empty($post_thumbnail)) {
                // Add thumbnail to post
                update_post_meta($post_id, $meta_key = '_thumbnail_id', $meta_value = '3940');
                update_post_meta($post_id, $meta_key = 'great_logo_of_the_company', $meta_value = '341');
            }
        }
    }
}

//function quizs_function_excerpt(){
//    if (get_post_type() == 'quizs') {
//	if ( ! wp_is_post_revision( $post_id ) ){
//		// remove this hook so that it does not create an infinite loop
//		remove_action('save_post', 'quizs_function_excerpt');
//                $args['post_excerpt'] = 'Weekend test. How well are you aware of Polish laws about'.$args['post_title'];
//		// update the post when the save_post hook is called again
//		wp_update_post( $args );
//
//		// hang the hook again
//		add_action('save_post', 'quizs_function_excerpt');
//	}
//    }
//}
//add_action('save_post', 'quizs_function_excerpt');

function job_img_fun() {
    $args = array(
        'post_type' => 'job_listing',
        'posts_per_page' => -1,
        'author' => 741
    );
    $posts = get_posts($args);
    echo '<ol>';
    foreach ($posts as $pst) {
        $v = get_post_meta($pst->ID, 'great_logo_of_the_company', true);
//        update_post_meta($pst->ID, $meta_key = 'great_logo_of_the_company', $meta_value = '341');
        echo '<li>' . $v . ' - ' . $pst->post_title . '</li>';
    }
    echo '</ol>';
}

add_shortcode('job_img', 'job_img_fun');


add_action('job_manager_job_filters_before', 'add_job_btn_field',2);