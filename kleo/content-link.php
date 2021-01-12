<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>

<?php
$post_class = 'clearfix';
if ( is_single() && get_cfield( 'centered_text' ) == 1 ) {
	$post_class .= ' text-center';
}
?>

<!-- Begin Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class( array( $post_class ) ); ?>>

	<?php if ( kleo_postmeta_enabled() ) : ?>
		<div class="article-meta">
			<span class="post-meta">
				<?php kleo_entry_meta(); ?>
			</span>
			<?php edit_post_link( esc_html__( 'Edit', 'kleo' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!--end article-meta-->
	<?php endif; ?>

	<div class="article-content">

		<?php do_action( 'kleo_before_inner_article_loop' ); ?>

		<?php the_content( kleo_get_continue_reading() ); ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kleo' ),
			'after'  => '</div>',
		) ); ?>

		<?php do_action( 'kleo_after_inner_article_loop' ); ?>

	</div><!--end article-content-->

</article>
<!-- End  Article -->
