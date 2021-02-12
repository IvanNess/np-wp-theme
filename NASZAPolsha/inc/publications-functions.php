<?php

function wpb_author_info_box( $content ) {
 
global $post, $wpdb, $bp;
 
// Detect if it is a single post with a post author
if ( get_post_type() == 'publications' && isset( $post->post_author ) ) {
// Get author's display name 
$display_name = get_the_author_meta( 'display_name', $post->post_author );
 
// If display name is not available then use nickname as display name
if ( empty( $display_name ) )
$display_name = get_the_author_meta( 'nickname', $post->post_author );

// Get author's biographical information or description
$user_des = get_the_author_meta( 'user_description', $post->post_author );
if(!empty($user_des)) {
    $user_description = $user_des;
} else {
    $user_description = bp_activity_latest_update( $post->post_author );
}
// Get author's website URL 
$user_website = get_the_author_meta('user_url', $post->post_author);
 
// Get link to the author archive page
$user_posts = get_bloginfo('url').'/members/'.get_the_author_meta( 'nickname', $post->post_author ).'/listings/publications/';//get_author_posts_url( get_the_author_meta( 'ID' , 741));
  
if ( ! empty( $display_name ) )
 
$author_details = '<p class="author_name">Publication from the author: ' . $display_name . '</p>';
 
//if ( ! empty( $user_description ) )
// Author avatar and bio
 
$author_details .= '<p class="author_details">' . get_avatar( get_the_author_meta('user_email') , 90 ) .  $user_description . '</p>';
 
$author_details .= '<p class="author_links"><a href="'. $user_posts .'">View all posts by ' . $display_name . '</a>';  
 
// Check if author has a website in their profile
if ( ! empty( $user_website ) ) {
 
// Display author website link
$author_details .= ' | <a href="' . $user_website .'" target="_blank" rel="nofollow">Web-site</a></p>';
 
} else { 
// if there is no author website then just close the paragraph
$author_details .= '</p>';
}
 
// Pass all this info to post content  
$content = $content . '<div class="author_bio_section" >' . $author_details . '</div>';
}
return $content;
}
 
// Add our function to the post content filter 
//add_action( 'the_content', 'wpb_author_info_box' );
 
// Allow HTML in author bio section 
//remove_filter('pre_user_description', 'wp_filter_kses');

if (!function_exists('publications_cat_taxonomy')) :

    function publications_cat_taxonomy() {
        $labels = array(
            'name' => 'Categories',
            'singular_name' => 'Categories',
            'search_items' => 'Search Categories',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category:',
            'edit_item' => 'Edit Category:',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add new Category',
            'new_item_name' => 'New Category name',
            'menu_name' => 'Categories',
            'view_item' => 'View Categories'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'query_var' => true
        );

        register_taxonomy('publications_cat', 'publications', $args);
    }

endif;

add_action('init', 'publications_cat_taxonomy');

if (!function_exists('publications_tag_taxonomy')) :

    function publications_tag_taxonomy() {
        $labels = array(
            'name' => 'Tags',
            'singular_name' => 'Tag',
            'search_items' => 'Search Tags',
            'popular_items' => ( 'Popular Tags' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'all_items' => 'All Tags',
            'edit_item' => 'Edit Tag:',
            'update_item' => 'Update Tag',
            'add_new_item' => 'Add new Tag',
            'new_item_name' => 'New Tag name',
            'menu_name' => 'Tags',
            'view_item' => 'View tags'
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'query_var' => true
        );

        register_taxonomy('tag_publications', 'publications', $args);
    }

endif;

add_action('init', 'publications_tag_taxonomy');

if (!function_exists('register_publications')) :

    function register_publications() {
        $labels = array(
            'name' => 'Publications',
            'singular_name' => 'Publication',
            'add_new' => 'Add Publication',
            'add_new_item' => 'Add Publication',
            'edit_item' => 'Edit Publication',
            'new item' => 'New Publication',
            'all_items' => 'All Publications',
            'view_item' => 'View Publication',
            'search_items' => 'Search Publication',
            'not_found' => 'No publication found',
            'not_found_in_trash' => 'There are no publications in the trash',
            'menu_name' => 'Publications'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'taxonomies' => array('publications_cat', 'tag_publications'),
            'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
//            'rewrite' => true,
            'rewrite' => array('slug' => 'publications'),
            'hierarchical' => false,
            'has_archive' => true,
            'supports'           => array('title','editor','author','thumbnail','excerpt','comments'),
            'menu_icon' => 'dashicons-welcome-write-blog',
            'menu_position' => 5,
        );

        register_post_type('publications', $args);
    }

endif;

add_action('init', 'register_publications');