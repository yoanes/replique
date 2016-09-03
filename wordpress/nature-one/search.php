<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package SKT Nature One
 */

get_header(); ?>

<div class="content-area">
    <div class="middle-align content_sidebar">
        <div class="site-main" id="sitemain">
			<?php if ( have_posts() ) : ?>
                <header>
                    <h2 class="blog-title"><?php printf( __( 'Search Results for: %s', 'nature-one' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
                </header>  
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'content', 'search' ); ?>
                <?php endwhile; ?>
                <?php skt_natureone_pagination(); ?>
            <?php else : ?>
                <?php get_template_part( 'no-results', 'search' ); ?>
            <?php endif; ?>
        </div>
        <?php get_sidebar();?>
        <div class="clear"></div>
    </div>
</div>

<?php get_footer(); ?>