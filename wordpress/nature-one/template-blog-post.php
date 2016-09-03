<?php
/* Template Name: Blog */
get_header(); ?>

<div class="content-area">
    <div class="middle-align content_sidebar">
        <div class="site-main" id="sitemain">
			<?php 
            if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
            elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
            else { $paged = 1; }
            $query = new WP_Query( array( 'paged' => $paged ) ); ?>
            <?php if( $query->have_posts() ) : ?>
                <?php while( $query->have_posts() ) : $query->the_post(); ?>
                    <?php get_template_part( 'content', get_post_format() ); ?>
                <?php endwhile; ?>
                <?php skt_natureone_custom_blogpost_pagination( $query ); ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <?php get_template_part( 'no-results', 'index' ); ?>
            <?php endif; ?>
        </div>
        <?php get_sidebar();?>
        <div class="clear"></div>
    </div>
</div>

<?php get_footer(); ?>