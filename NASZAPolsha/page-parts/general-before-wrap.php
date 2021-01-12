<?php
/**
 * Before content wrap
 * Used in all templates
 */
?>
<?php
$main_tpl_classes = apply_filters( 'kleo_main_template_classes', '' );

if ( kleo_has_shortcode( 'kleo_bp_' ) ) {
	$section_id = 'id="buddypress" ';
} else {
	$section_id = '';
}

$container = apply_filters( 'kleo_main_container_class', 'container' );

/**
 * Before main content - action
 */
do_action( 'kleo_before_content' );
if(is_post_type_archive('classifieds') || is_tax('classifiedcategory') || is_tax('classified_tags')){
    $classifieds_container = 'classifieds-container';
} else {
    $classifieds_container = '';
}
if (is_page_template('page-add-classifieds.php') || is_page_template('page-add-job.php') ) { 
    $form_add_classified = ' form_add_classified';
} else {
    $form_add_classified = '';
}
?>

<section class="container-wrap main-color <?php echo $classifieds_container.$form_add_classified;?>">
	<div id="main-container" class="<?php echo esc_attr( $container ); ?>">
		<?php if ( 'container' == $container ) { ?><div class="row"> <?php } ?>

			<div <?php echo $section_id; // PHPCS: XSS ok. ?>class="template-page <?php echo esc_attr( $main_tpl_classes ); ?>">
				<div class="wrap-content">
					
				<?php
				/**
				 * Before main content - action
				 */
				do_action( 'kleo_before_main_content' );
				?>
