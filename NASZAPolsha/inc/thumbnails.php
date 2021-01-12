<?php 

function add_image_insert_override($sizes){
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);        
    unset($sizes['blog-isotope']);
    unset($sizes['product_small_thumbnail']);
    unset($sizes['shop_catalog']);
    unset($sizes['shop_single']);
    unset($sizes['shop_single_small_thumbnail']);
    unset($sizes['shop_thumbnail']);
    unset($sizes['woocommerce_thumbnail']);
    unset($sizes['woocommerce_single']);
    unset($sizes['woocommerce_gallery_thumbnail']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'add_image_insert_override' );
add_filter('max_srcset_image_width', create_function('', 'return 1;'));

?>