<?php


function nashapolsha_copyright() {
    ?>
    <script>
        document.oncopy = function () {
            var bodyElement = document.body;
            var selection = getSelection();
            var href = document.location.href;
            var copyright = "<br><br>Source of material: <a href='" + href + "'>" + href + "</a><br>© <?php bloginfo('name'); ?>";
            var text = selection + copyright;
            var divElement = document.createElement('div');
            divElement.style.position = 'absolute';
            divElement.style.left = '-99999px';
            divElement.innerHTML = text;
            bodyElement.appendChild(divElement);
            selection.selectAllChildren(divElement);
            setTimeout(function () {
                bodyElement.removeChild(divElement);
            }, 0);
        };
    </script>
    <?php
}

add_action('wp_footer', 'nashapolsha_copyright', 95);

//start of name and email changing   
function change_fromemail($email) {
    return 'noreply@nashapolsha.pl';
}

function change_fromname($name) {
    return 'NASHAPolsha';
}

add_filter('wp_mail_from', 'change_fromemail');
add_filter('wp_mail_from_name', 'change_fromname');
//end of name and email changing

add_action('init', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {//&& !current_user_can('employer')) {
        show_admin_bar(false);
    }
}

function wpb_image_editor_default_to_gd( $editors ) {
	$gd_editor = 'WP_Image_Editor_GD';
	$editors = array_diff( $editors, array( $gd_editor ) );
	array_unshift( $editors, $gd_editor );
	return $editors;
}
 add_filter( 'wp_image_editors', 'wpb_image_editor_default_to_gd' );

//Let's make WordPress load the styled table for the console login page
function custom_login_page_css() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/login/login-styles.css" />';
}

add_action('login_head', 'custom_login_page_css');

add_action('admin_head', 'custom_admin_css');

function custom_admin_css() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/assets/css/admin.css" />';
}

//Changing fonts using Google Fonts for the console login page.
function custom_login_page_fonts() {
    echo '<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css" />';
}

add_action('login_head', 'custom_login_page_fonts');

//Add a jQuery “Fade-In” effect to the form for the console login page.
add_action('login_head', 'untame_fadein', 30);

function untame_fadein() {
    echo '<script type="text/javascript">// <![CDATA[
jQuery(document).ready(function() { jQuery("#loginform,#nav,#backtoblog").css("display", "none");          jQuery("#loginform,#nav,#backtoblog").fadeIn(3500);     
});
// ]]></script>';
}

/**
 * register_nav_menus
 */
register_nav_menus(array(
    'reklama_menu' => 'reklama menu',
    'pl_menu' => 'pl menu',
));

/**
 * Registers our main widget area and the front page widget areas.
 */
function naszapolshcha_widgets_init() {
    register_sidebar(array(
        'name' => 'Sidebar top navigation',
        'id' => 'sidebar-top_nav',
        'description' => 'Default sidebar top navigation',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Sidebar Buddypress',
        'id' => 'sidebar-buddypress',
        'description' => 'Sidebar for Buddypress',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Sidebar bbPress',
        'id' => 'sidebar-bbpress',
        'description' => 'Sidebar for bbPress',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Sidebar WP Job Manager',
        'id' => 'sidebar-wp-job-manager',
        'description' => 'Sidebar for WP Job Manager',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Google Analytics Dashboard',
        'id' => 'sidebar-ga',
        'description' => 'Sidebar for Google Analytics Dashboard',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Archive top sidebar',
        'id' => 'archive-top-sidebar',
        'description' => 'Sidebar for Archive top',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => 'Jobs sidebar',
        'id' => 'jobs-page',
        'description' => 'Sidebar for Jobs',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}

add_action('widgets_init', 'naszapolshcha_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function theme_enqueue_scripts() {

    // Load our main stylesheet.
    wp_enqueue_style('main-style', get_stylesheet_uri());
    if ('quizs' == get_post_type()) {
        wp_enqueue_style('quiz-style-theme', get_stylesheet_directory_uri() . '/assets/css/quiz-style.css', array('main-style'), '1.0');
    }
    
    wp_enqueue_style('flexslider-style-theme', get_stylesheet_directory_uri() . '/assets/css/flexslider.css', array('main-style'), '1.0');
    wp_enqueue_style('dop-style-theme', get_stylesheet_directory_uri() . '/assets/css/style.css', array('main-style'), '1.0');
    wp_enqueue_style('job-style-theme', get_stylesheet_directory_uri() . '/assets/css/job.css', '', '1.0');
    
    if ('quizs' == get_post_type()) {
        wp_enqueue_script('jquery.quiz-min-script', get_stylesheet_directory_uri() . '/assets/js/jquery.quiz-min.js', array('jquery'), '1.0', true);
    }
    wp_enqueue_script('flexslider-min-script', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), '2.0', true);
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype($output) {
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}

//add_filter('language_attributes', 'add_opengraph_doctype');
//Lets add Open Graph Meta Info

function insert_fb_in_head() {
    global $post;
    if (!is_singular()) //if it is not a post or a page
        return;
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="NASZAPolsha"/>';
    if (!has_post_thumbnail($post->ID)) { //the post does not have featured image, use a default image
        $default_image = "http://dev.nashapolsha.pl/wp-content/uploads/2016/10/AppleiPadRetinaIcon144px144px.png"; //replace this with a default image on your server or an image in your media library
        echo '<meta property="og:image" content="' . $default_image . '"/>';
    } else {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        echo '<meta property="og:image" content="' . esc_attr($thumbnail_src[0]) . '"/>';
    }
}

//add_action('wp_head', 'insert_fb_in_head', 5);


/* allow weak passwords */
function wc_ninja_remove_password_strength() {
    if (wp_script_is('wc-password-strength-meter', 'enqueued')) {
        wp_dequeue_script('wc-password-strength-meter');
    }
}

add_action('wp_print_scripts', 'wc_ninja_remove_password_strength', 100);

// custom
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/custom-functions.php' );
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/shortcode-functions.php' );
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/kleo-custom-functions.php' );

// plagins
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/woo-functions.php' );

// post type
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/publications-functions.php' );
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/quizs-functions.php' );
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/phrases-functions.php' );
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/addresses-functions.php' );
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/classifieds-functions.php' );
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/job-functions.php' );

// plugin custom type
//require_once( trailingslashit(get_stylesheet_directory()) . 'inc/jobs-functions.php' );
//require_once( trailingslashit(get_stylesheet_directory()) . 'inc/resume-functions.php' );
//require_once( trailingslashit(get_stylesheet_directory()) . 'inc/gd_classified-functions.php' );
// easysend_clicks
require_once( trailingslashit(get_stylesheet_directory()) . 'inc/easysend_clicks-functions.php' );



require_once( trailingslashit(get_stylesheet_directory()) . 'inc/thumbnails.php' );

