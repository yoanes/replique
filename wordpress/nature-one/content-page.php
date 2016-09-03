<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package SKT Nature One
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'nature-one' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content --><div class="clear"></div>
	<?php edit_post_link( __( 'Edit', 'nature-one' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
