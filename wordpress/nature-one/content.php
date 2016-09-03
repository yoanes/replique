<?php
/**
 * @package SKT Nature One
 */
?>
<div class="blog-post-repeat">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header" style="margin-bottom:0">
            <h2 class="blog-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <?php if ( 'post' == get_post_type() ) : ?>
                <div class="postmeta">
                    <div class="post-date"><?php echo get_the_date(); ?></div><!-- post-date -->
                    <div class="post-comment"> | <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a></div>
                    <div class="post-categories"> | <?php echo skt_natureone_getPostCategories();?></div>
                    <div class="clear"></div>
                </div><!-- postmeta -->
            <?php endif; ?>
	        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
            	<?php $thumb_id = get_post_thumbnail_id();
					  $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); ?>
	            <div class="post-thumb"><img src="<?php echo $thumb_url[0]; ?>" class="alignleft" />
	        <?php else : ?>
	            <div class="post-thumb"><?php the_post_thumbnail(); ?>
	        <?php endif; ?>
            </div><!-- post-thumb -->
        </header><!-- .entry-header -->
    
        <?php if ( is_search() || !is_single() ) : // Only display Excerpts for Search ?>
            <div class="entry-summary">
                <?php echo skt_natureone_content(40); ?>
                <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read More &raquo;','nature-one'); ?></a>
            </div><!-- .entry-summary -->
        <?php else : ?>
            <div class="entry-content">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'nature-one' ) ); ?>
                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'nature-one' ),
                        'after'  => '</div>',
                    ) );
                ?>
            </div><!-- .entry-content -->
        <?php endif; ?>
    
        <footer class="entry-meta" style="display:none;">
            <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
                <?php
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( __( ', ', 'nature-one' ) );
                    if ( $categories_list && skt_natureone_categorized_blog() ) :
                ?>
                <span class="cat-links">
                    <?php printf( __( 'Posted in %1$s', 'nature-one' ), $categories_list ); ?>
                </span>
                <?php endif; // End if categories ?>
    
                <?php
                    /* translators: used between list items, there is a space after the comma */
                    $tags_list = get_the_tag_list( '', __( ', ', 'nature-one' ) );
                    if ( $tags_list ) :
                ?>
                <span class="tags-links">
                    <?php printf( __( 'Tagged %1$s', 'nature-one' ), $tags_list ); ?>
                </span>
                <?php endif; // End if $tags_list ?>
            <?php endif; // End if 'post' == get_post_type() ?>
    
            <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
            <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'nature-one' ), __( '1 Comment', 'nature-one' ), __( '% Comments', 'nature-one' ) ); ?></span>
            <?php endif; ?>
    
            <?php edit_post_link( __( 'Edit', 'nature-one' ), '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-meta -->
    </article><!-- #post-## -->
    <div class="spacer20"></div>
</div><!-- blog-post-repeat -->