<?php
if (!function_exists('job_category_taxonomy')) :

    function job_category_taxonomy() {
        $labels = array(
            'name' => 'Категорії вакансій',
            'singular_name' => 'Категорія вакансії',
            'search_items' => 'Пошук Категорії вакансії',
            'all_items' => 'Усі Категорії вакансій',
            'parent_item' => 'Батьківська Категорія вакансії:',
            'edit_item' => 'Редагувати Категорію вакансії:',
            'update_item' => 'Обновити Категорію вакансії',
            'add_new_item' => 'Додати нову Категорію вакансії',
            'new_item_name' => 'Нова Категорія вакансії',
            'menu_name' => 'Категорії вакансій',
            'view_item' => 'Подивитися Категорію вакансії'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
//            'rewrite' => true,
            'rewrite' => array('slug' => 'job-category'),
            'query_var' => true
        );

        register_taxonomy('job_category', 'job', $args);
    }

endif;

add_action('init', 'job_category_taxonomy');

if (!function_exists('job_type_taxonomy')) :

    function job_type_taxonomy() {
        $labels = array(
            'name' => 'Типи зайнятості',
            'singular_name' => 'Тип зайнятості',
            'search_items' => 'Пошук Типу зайнятості',
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'Усі Типи зайнятості',
            'edit_item' => 'Редагувати Тип зайнятості:',
            'update_item' => 'Обновити Тип зайнятості',
            'add_new_item' => 'Додати новий Тип зайнятості',
            'new_item_name' => 'Новий Тип зайнятості',
            'menu_name' => 'Типи зайнятості',
            'view_item' => 'Посмотреть Тип зайнятості'
        );

        $args = array(
            'labels' => $labels,
//            'rewrite' => true,
            'rewrite' => array('slug' => 'job-type'),
            'hierarchical' => false,
            'query_var' => true
        );

        register_taxonomy('job_type', 'job', $args);
    }

endif;

add_action('init', 'job_type_taxonomy');

if (!function_exists('job_type_contract_taxonomy')) :

    function job_type_contract_taxonomy() {
        $labels = array(
            'name' => 'Тип договорів',
            'singular_name' => 'Тип договору',
            'search_items' => 'Пошук Типу договору',
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'Усі Тип договорів',
            'edit_item' => 'Редагувати Тип договору:',
            'update_item' => 'Обновити Тип договору',
            'add_new_item' => 'Додати новий Тип договору',
            'new_item_name' => 'Новий Тип договору',
            'menu_name' => 'Тип договорів',
            'view_item' => 'Посмотреть Тип договору'
        );

        $args = array(
            'labels' => $labels,
//            'rewrite' => true,
            'rewrite' => array('slug' => 'job-type-contract'),
            'hierarchical' => false,
            'query_var' => true
        );

        register_taxonomy('job_type_contract', 'job', $args);
    }

endif;

add_action('init', 'job_type_contract_taxonomy');

if (!function_exists('job_employment_taxonomy')) :

    function job_employment_taxonomy() {
        $labels = array(
            'name' => 'Тип працевлаштування',
            'singular_name' => 'Тип працевлаштування',
            'search_items' => 'Пошук Типу працевлаштування',
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'Усі Тип працевлаштування',
            'edit_item' => 'Редагувати Тип працевлаштування:',
            'update_item' => 'Обновити Тип працевлаштування',
            'add_new_item' => 'Додати новий Тип працевлаштування',
            'new_item_name' => 'Новий Тип працевлаштування',
            'menu_name' => 'Тип працевлаштування',
            'view_item' => 'Посмотреть Тип працевлаштування'
        );

        $args = array(
            'labels' => $labels,
//            'rewrite' => true,
            'rewrite' => array('slug' => 'job-employment'),
            'hierarchical' => false,
            'query_var' => true
        );

        register_taxonomy('job_employment', 'job', $args);
    }

endif;

add_action('init', 'job_employment_taxonomy');

if (!function_exists('register_job')) :

    function register_job() {
        $labels = array(
            'name' => 'Вакансії',
            'singular_name' => 'Вакансія',
            'add_new' => 'Додати нову Вакансію',
            'add_new_item' => 'Додати нову Вакансії',
            'edit_item' => 'Редагувати Вакансію',
            'new item' => 'Нова Вакансія',
            'all_items' => 'Всі Вакансії',
            'view_item' => 'Переглянути Вакансію',
            'search_items' => 'Пошук Вакансії',
            'not_found' => 'Не знайдено',
            'not_found_in_trash' => 'В корзине нет Вакансії',
            'menu_name' => 'Вакансії'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('job_category', 'job_type', 'job_type_contract', 'job_employment'),
            'rewrite' => array('slug' => 'job'),
//            'rewrite' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'author',
//                'excerpt',
//                'post-formats',
            ),
            'menu_icon' => 'dashicons-portfolio',
//            'menu_icon' => 'dashicons-awards',
            'menu_position' => 5,
        );
        register_post_type('job', $args);
    }

endif;

add_action('init', 'register_job');

//is_position_featured_top in post_class
function is_position_featured_top_job($classes) {
    global $post;
    $post = get_post($post);
    if ('job' == $post->post_type) {
        $is_position_featured_top = get_field('is_position_featured_top', $post->ID);
        $is_position_featured = get_field('is_position_featured', $post->ID);
        if (!empty($is_position_featured_top) && $is_position_featured_top == 1) {
            $classes[] = 'is_position_featured_top job_position_featured';
        } else {
            if (!empty($is_position_featured) && $is_position_featured == 1) {
                $classes[] = 'job_position_featured';
            } else {
                $classes[] = '';
            }
        }
    }
    return $classes;
}

add_filter('post_class', 'is_position_featured_top_job');

function job_pre_get_posts($query) {
    // do not modify queries in the admin
    if (is_admin()) {
        return $query;
    }
    // only modify queries for 'event' post type
    if (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'job') {

        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'is_position_featured_top');
    }
    // return
    return $query;
}

//add_action('pre_get_posts', 'job_pre_get_posts');

function add_job_btn_field() {
    echo '<a class="btn letter-spacing-2px btn-highlight text-uppercase btn_add_job" href="http://dev.nashapolsha.pl/submit-job/">+ Додати вакансію / Dodaj ogłoszenie</a>';
}

//add_action('job_manager_job_filters_after', 'jooble_img',1);

function jooble_img() {
    echo '<div class="widget widget_media_image" style="text-align: center;margin-bottom: 15px;"><a href="https://ua.jooble.org/"><noscript><img width="150" height="150" src="https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-1038x545.png" class="image wp-image-12612  attachment-medium size-medium" alt="jooble - это один сайт, на котором Вы можете искать работу по всему Интернету." style="max-width: 100%; height: auto;" srcset="https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-1038x545.png 1038w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-768x403.png 768w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-672x353.png 672w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-300x158.png 300w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-600x315.png 600w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble.png 1200w" sizes="(max-width: 1038px) 100vw, 1038px" /></noscript><img width="150" height="150" src="https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-1038x545.png" data-src="https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-1038x545.png" class="image wp-image-12612 attachment-medium size-medium lazyloaded smush-detected-img smush-image-12" alt="jooble - это один сайт, на котором Вы можете искать работу по всему Интернету." style="max-width: 100%; height: auto;" data-srcset="https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-1038x545.png 1038w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-768x403.png 768w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-672x353.png 672w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-300x158.png 300w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-600x315.png 600w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble.png 1200w" data-sizes="(max-width: 1038px) 100vw, 1038px" sizes="(max-width: 1038px) 100vw, 1038px" srcset="https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-1038x545.png 1038w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-768x403.png 768w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-672x353.png 672w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-300x158.png 300w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble-600x315.png 600w, https://dev.nashapolsha.pl/wp-content/uploads/2019/07/jooble.png 1200w"></a></div>';
}

class Max_Job_List_Widget extends WP_Widget {

    public function __construct() {
        $widget_details = array(
            'classname' => 'max-job-list',
            'description' => 'A simple jobs display widget'
        );

        parent::__construct('max-job-list', 'Max job List', $widget_details);
    }

    public function form($instance) {
        // Field Values
        $title = (!empty($instance['title']) ) ? $instance['title'] : '';
        $count = (!empty($instance['count']) ) ? $instance['count'] : 3;
        $orderby = (!empty($instance['orderby']) ) ? $instance['orderby'] : 'date';
        $order = (!empty($instance['order']) ) ? $instance['order'] : 'desc';

        // Field Options
        $orderby_options = array(
            'title' => 'title',
            'ID' => 'ID',
            'date' => 'date',
            'rand' => 'rand'
        );

        $order_options = array(
            'desc' => 'Descending',
            'asc' => 'Ascending'
        );
        ?>
        <div class='unread-posts'>
            <p>
                <label for="<?php echo $this->get_field_name('title'); ?>">Title: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_name('count'); ?>">Posts To Show: </label>
                <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_name('orderby'); ?>">Order By: </label>
                <select class='widefat'  id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                    <?php foreach ($orderby_options as $value => $name) : ?>
                        <option <?php selected($orderby, $value) ?> value='<?php echo $value ?>'><?php echo $name ?></option>
                    <?php endforeach ?>
                </select>
            </p>
            <p>
                <label for="<?php echo $this->get_field_name('order'); ?>">Order: </label>
                <select class='widefat'  id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                    <?php foreach ($orderby_options as $value => $name) : ?>
                        <option <?php selected($order, $value) ?> value='<?php echo $value ?>'><?php echo $name ?></option>
                    <?php endforeach ?>
                </select>
            </p>
        </div>
        <?php
    }

    public function widget($args, $instance) {

        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];
        }

        $args_post = array(
            'post_status' => 'publish',
            'post_type' => 'job',
            'posts_per_page' => $instance['count'],
            'orderby' => $instance['orderby'],
            'order' => $instance['order'],
        );

        query_posts($args_post);

        if (have_posts()) {
            ?>
            <ul class="job_listings">
                <?php
                while (have_posts()) :
                    the_post();
                    $post_id = get_the_id();
                    ?>
                    <li class="job_listing">
                        <a href="<?php the_permalink(); ?>">
                            <div class="content">
                                <div class="position">
                                    <h3><?php the_title(); ?></h3>
                                </div>
                                <ul class="meta">
                                    <li class="location"> <?php
										
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
                                        ?></li>
                                    <li class="company"><?php echo get_post_meta($post_id, '_company_name', true); ?></li>
                                </ul>
                            </div>
                        </a>
                    </li>
                <?php endwhile;
                ?>
            </ul>
            <?php
        } else {
            echo 'No posts found';
        }
        wp_reset_query();
        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count']) ) ? strip_tags($new_instance['count']) : 3;
        $instance['orderby'] = (!empty($new_instance['orderby']) ) ? strip_tags($new_instance['orderby']) : 'date';
        $instance['order'] = (!empty($new_instance['order']) ) ? strip_tags($new_instance['order']) : 'desc';
        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('Max_Job_List_Widget');
});

// добавляем запланированный хук
add_action('wp', 'job_order_activation');

function job_order_activation() {
    if (!wp_next_scheduled('job_order_activation_event')) {
        wp_schedule_event(time(), 'every_minute', 'job_order_activation_event');
    }
}

// добавляем функцию к указанному хуку
add_action('job_order_activation_event', 'job_order_activation_do_this');

function job_order_activation_do_this() {
    $processing = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'shop_order',
//    'post_status' => array_keys( wc_get_order_statuses() ),
        'post_status' => 'wc-processing',
        'meta_key' => 'job_order_done',
        'meta_value' => '1',
        'meta_compare' => '!='
    ));
    foreach ($processing as $order) {
        $order_id = $order->ID;
        $items = wc_get_order($order_id);
        foreach ($items->get_items() as $item) {
//        $product_name = $item->get_name();
            $product_id = $item->get_product_id();
//        $product_variation_id = $item->get_variation_id();
            if ($product_id == '2921') {
                $post_id = get_post_meta($order_id, '_billing_wooccm11', true);
                if (!empty($post_id)) {
                    $items->update_status('completed');
                    $day = current_time('Y-m-d');
                    $NewDate = date('Y-m-d', strtotime($day . " +7 days"));
                    $job = array();
                    $job['ID'] = $post_id;
                    $job['post_status'] = 'publish';
                    wp_update_post(wp_slash($job));
                    if (!update_post_meta($post_id, '_job_expires', $NewDate)) {
                        add_post_meta($post_id, '_job_expires', $NewDate, true);
                    }
                    if (!update_post_meta($post_id, '_job_order', $order_id)) {
                        add_post_meta($post_id, '_job_order', $order_id, true);
                    }
                    if (!update_post_meta($order_id, 'job_order_done', 1)) {
                        add_post_meta($order_id, 'job_order_done', 1, true);
                    }
                    echo $post_id;
                }
            }
        }
    }
    print_a($processing);
    echo '<hr>';
    $completed = get_posts(array(
        'numberposts' => -1,
        'post_type' => 'shop_order',
        'post_status' => 'wc-completed',
        'meta_key' => 'job_order_done',
        'meta_value' => '1',
        'meta_compare' => '!='
    ));
    print_a($completed);
    foreach ($completed as $order) {
        $order_id = $order->ID;
        $post_id = get_post_meta($order_id, '_billing_wooccm11', true);
        if (!empty($post_id)) {
            $job_order_id = get_post_meta($post_id, '_job_order', true);
            if ($job_order_id != $order_id) {
                $items = wc_get_order($order_id);
                foreach ($items->get_items() as $item) {
                    $product_id = $item->get_product_id();
                    if ($product_id == '2921') {
                        $day = current_time('Y-m-d');
                        $NewDate = date('Y-m-d', strtotime($day . " +7 days"));
                        $job = array();
                        $job['ID'] = $post_id;
                        $job['post_status'] = 'publish';
                        wp_update_post(wp_slash($job));
                        if (!update_post_meta($post_id, '_job_expires', $NewDate)) {
                            add_post_meta($post_id, '_job_expires', $NewDate, true);
                        }
                        if (!update_post_meta($post_id, '_job_order', $order_id)) {
                            add_post_meta($post_id, '_job_order', $order_id, true);
                        }
                        if (!update_post_meta($order_id, 'job_order_done', 1)) {
                            add_post_meta($order_id, 'job_order_done', 1, true);
                        }
                    } else {
                        if ($product_id == '2922') {
                            $day = current_time('Y-m-d');
                            $NewDate = date('Y-m-d', strtotime($day . " +7 days"));
                            $job = array();
                            $job['ID'] = $post_id;
                            $job['post_status'] = 'publish';
                            wp_update_post(wp_slash($job));
                            if (!update_post_meta($post_id, '_job_expires', $NewDate)) {
                                add_post_meta($post_id, '_job_expires', $NewDate, true);
                            }
                            if (!update_post_meta($post_id, '_job_order', $order_id)) {
                                add_post_meta($post_id, '_job_order', $order_id, true);
                            }
                            if (!update_post_meta($post_id, 'is_position_featured_top', 1)) {
                                add_post_meta($post_id, 'is_position_featured_top', 1, true);
                            }
                            if (!update_post_meta($order_id, 'job_order_done', 1)) {
                                add_post_meta($order_id, 'job_order_done', 1, true);
                            }
                        }
                    }
                }
            }
        }
    }
}

add_action('pre_get_posts', 'job_query_set', 1);

function job_query_set($query) {
    // Выходим, если это админ-панель или не основной запрос.
    if (is_admin() || !$query->is_main_query())
        return;

//	if( is_home() ){
//		// Выводим только 1 пост на главной странице
//		$query->set( 'posts_per_page', 1 );
//	}

//    if ($query->is_post_type_archive('job')) {
    if (false) {
        // Выводим 50 записей если это архив типа записи 'job'
        $query->set('meta_key', 'is_position_featured_top');
        $query->set('orderby', array(
		'meta_value_num' => 'ASC',
		'post_date'      => 'ASC',
	));
//        $query->set('order', 'ASC');
//        $query->set('meta_query', array(
//        array(
//            'key' => 'is_position_featured_top',
//            'value' => 1,
//            'compare' => 'LIKE',
//        )
//    ));
    }
//	if ( is_home() ) {
//  $query->set( 'post_type', 'event' );
//  $query->set( 'meta_key', '_start_date' );
//  $query->set( 'orderby', 'meta_value_num' );
//  $query->set( 'order', 'ASC' );
//  $query->set( 'meta_query', array(
//        array(
//              'key' => '_start_date'
//        ),
//        array(
//              'key' => '_end_date',
//              'value' => time(),
//              'compare' => '>=',
//              'type' => 'numeric'
//        )
//  ));
//  }
    return $query;
}
