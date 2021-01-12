<?php

/**
 * @desc Remove in all product type
 */
function wc_remove_all_quantity_fields($return, $product) {
    return true;
}

add_filter('woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2);
//update_option( 'job_manager_paid_listings_flow', 'before' );
////update_option( 'wp-job-manager-wc-paid-listings_licence_key', 1 );
////				update_option( 'wp-job-manager-wc-paid-listings_email', 'burhan.maxim@gmail.com' );
////				delete_option( 'wp-job-manager-wc-paid-listings_errors' );
//apply_filters( 'wcpl_enable_paid_job_listing_submission', true );
////add_filter( 'submit_job_steps', array( __CLASS__, 'submit_job_steps' ), 20 );
//
//add_filter( 'site_transient_update_plugins', 'sheensay_site_transient_update_plugins' ); // Вешаем функцию на специальный фильтр
//function sheensay_site_transient_update_plugins ( $value ) {
// 
//    unset( $value->response['wp-job-manager-wc-paid-listings/wp-job-manager-wc-paid-listings.php'] ); // Здесь указывается относительный путь к главному файлу плагина
// 
//    return $value;
//}

add_action('woocommerce_thankyou', 'autocomplete_all_orders');

function autocomplete_all_orders($order_id) {

    if (!$order_id) {
        return;
    }

    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item) {
        $product_id = $item->get_product_id();
        if ($product_id == '2921') {
            $post_id = get_post_meta($order_id, '_billing_wooccm11', true);
            if (!empty($post_id)) {
                $order->update_status('completed');
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
            }
        }
    }
}
