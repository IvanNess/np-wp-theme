<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
/* For wp-activate.php page */
if (defined('WP_INSTALLING') && WP_INSTALLING == true && !function_exists('kleo_setup')) {
    require_once dirname(__FILE__) . '/functions.php';
}
?><!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9]>
<html class="no-js lt-ie10" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <!-- Fav and touch icons -->
        <?php if (sq_option_url('favicon')) { ?>
            <link rel="shortcut icon" href="<?php echo sq_option_url('favicon'); ?>">
        <?php } ?>
        <?php if (sq_option_url('apple57')) { ?>
            <link rel="apple-touch-icon-precomposed" href="<?php echo sq_option_url('apple57'); ?>">
        <?php } ?>
        <?php if (sq_option_url('apple72')) { ?>
            <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo sq_option_url('apple72'); ?>">
        <?php } ?>
        <?php if (sq_option_url('apple114')) { ?>
            <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo sq_option_url('apple114'); ?>">
        <?php } ?>
        <?php if (sq_option_url('apple144')) { ?>
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo sq_option_url('apple144'); ?>">
        <?php } ?>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
        <![endif]-->

        <!--[if IE 7]>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/fontello-ie7.css">
        <![endif]-->

        <?php
        if (function_exists('bp_is_active')) {
            bp_head();
        }
        ?>


        <?php wp_head(); ?>

        <?php get_template_part('page-parts/google'); ?>
    
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '932629373603166');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=932629373603166&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<meta name="google-site-verification" content="oJ95CJgZPMYNmPFftHH39LoebsqUNNTzKxaIwv90esc" />

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-171800873-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-171800873-1');
</script>

<!-- Global site tag (gtag.js) - Google Ads: 616634771 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-616634771"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-616634771');
</script>


</head>

    <?php
    /*     * *************************************************
     * :: Some header customizations
     * ************************************************* */

    $site_style = sq_option('site_style', 'wide') == 'boxed' ? ' page-boxed' : '';
    $site_style = apply_filters('kleo_site_style', $site_style);
    ?>
    <body <?php body_class(); ?> <?php kleo_schema_org_markup(); ?>>
        <input type="hidden" class="current_domain_url" name="current_domain_url" value="<?php echo bloginfo('url'); ?>" data-cur_user="<?php echo get_current_user_id(); ?>">
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v2.10"; // uk_UA / ru_RU
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>    
        <?php do_action('kleo_after_body'); ?>

        <!-- PAGE LAYOUT
        ================================================ -->
        <!--Attributes-->
        <div class="kleo-page<?php echo $site_style; ?>">

            <!-- HEADER SECTION
            ================================================ -->
            <?php
            /**
             * Header section
             * @hooked kleo_show_header
             */
            do_action('kleo_header');
//        if (function_exists('informercurrency')) informercurrency();
            ?>


            <!-- MAIN SECTION
            ================================================ -->
            <div id="main">

                <?php
                /**
                 * Hook into this action if you want to display something before any Main content
                 *
                 */
                do_action('kleo_before_main');
                ?>