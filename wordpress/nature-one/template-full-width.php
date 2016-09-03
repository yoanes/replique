<?php
/**
Template name: Full Width

 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Nature One
 */

get_header(); ?>

<div class="content-area">
    <div class="middle-align">
        <div class="site-main" id="sitefull">
			<?php while ( have_posts() ) : the_post(); ?>
            	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
        <?php if(get_post_meta( $post->ID, 'subtitle', true ) != ''){ ?>
		<div class="subheading"><?php echo esc_html( get_post_meta( $post->ID, 'subtitle', true ) ); ?></div><!-- subheading -->
        <?php } ?>
	</header><!-- .entry-header -->
				<?php get_template_part( 'content', 'page' ); ?>
				<?php
				//If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
				?>
			<?php endwhile; // end of the loop. ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="page-bottom middle-align">
		<?php while( have_posts() ) : the_post(); ?>
			<header class="entry-header">
            <?php if(get_post_meta( $post->ID, 'shorttitle', true ) != '') { ?>
            	<h1 class="entry-title"><?php echo esc_html( get_post_meta( $post->ID, 'shorttitle', true ) ); ?></h1>
            <?php } ?>
                <?php echo do_shortcode( get_post_meta( $post->ID, 'shortcodes', true ) ); ?>
            </header>
           <?php endwhile; ?>
</div><!-- page-bottom -->

<?php get_footer(); ?>