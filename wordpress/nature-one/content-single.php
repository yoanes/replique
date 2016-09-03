<?php
/**
 * @package SKT Nature One
 */
?>
<div class="blog-post-repeat">
<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>

        <h2 class="blog-title"><?php the_title(); ?></h2>

    <div class="entry-content">
        <div class="postmeta">
            <div class="post-date"><?php echo get_the_date(); ?></div><!-- post-date -->
            <div class="post-comment"> | <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></div>
            <div class="clear"></div>
        </div><!-- postmeta -->
		<?php 
        if (has_post_thumbnail() ){
			$thumb_id = get_post_thumbnail_id();
					  $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); ?>
	            <div class="post-thumb"><img src="<?php echo $thumb_url[0]; ?>" class="alignleft" width="200px" height="139px" /></div>
		<?php }
        ?>
        <?php the_content(); ?>
        <?php
        wp_link_pages( array(
            'before' => '<div class="page-links">' . __( 'Pages:', 'nature-one' ),
            'after'  => '</div>',
        ) );
        ?>
        <div class="postmeta">
            <div class="post-categories"><?php echo skt_natureone_getPostCategories();?></div>
            <div class="post-tags"><?php the_tags(' | Tags: ', ', ', '<br />'); ?> </div>
            <div class="clear"></div>
        </div><!-- postmeta -->
    </div><!-- .entry-content -->
   
    <footer class="entry-meta">
        <?php edit_post_link( __( 'Edit', 'nature-one' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->

</article>
</div>