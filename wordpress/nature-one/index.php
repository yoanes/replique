<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Nature One
 */

get_header(); 
?>

<?php if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) : ?>

    <div class="content-area">
        <div class="middle-align content_sidebar">
            <div class="site-main" id="sitemain">
				<?php
                if ( have_posts() ) :
                    // Start the Loop.
                    while ( have_posts() ) : the_post();
                        /*
                         * Include the post format-specific template for the content. If you want to
                         * use this in a child theme, then include a file called called content-___.php
                         * (where ___ is the post format) and that will be used instead.
                         */
                        get_template_part( 'content', get_post_format() );
                
                    endwhile;
                    // Previous/next post navigation.
                    skt_natureone_pagination();
                
                else :
                    // If no content, include the "No posts found" template.
                     get_template_part( 'no-results', 'index' );
                
                endif;
                ?>
            </div>
            <?php get_sidebar();?>
            <div class="clear"></div>
        </div>
    </div>


<?php else: ?>
    
            <section style="background-color:#d0c90b;">
                    <div class="welcome-box middle-align">
                        	<div class="features-section">
                            	<?php if( of_get_option('boxfirst',true) == 1 ) { ?>
                                	<?php for($k=1;$k<5;$k++) { ?>
                        				<div class="feature-box">
                                        		<h5><?php _e('Dummy Title','nature-one'); ?></h5>
                                                <p><?php _e('Go to Appearance >> Theme Options >> Homepage Content.','nature-one'); ?></p>
                                        </div><!-- feature-box -->
                                        <?php } ?>
                        		<?php } else { ?>
                            		<?php if( of_get_option('boxfirst',false)) { ?>
                                    		<div class="feature-box">
                                            	<?php $boxfirst = new WP_Query('page_id='.of_get_option('boxfirst'));
														while($boxfirst->have_posts()) : $boxfirst->the_post(); ?>
                                                        	<?php if( has_post_thumbnail()) { ?>
                                                                <div class="feat-image"><?php the_post_thumbnail( array(85,85) ); ?></div><!-- feat-image -->
                                                            <?php } ?>
                                                            <h5><?php the_title(); ?></h5>
                                                            	<?php if( has_post_thumbnail() ) { ?>
                                                            		<?php echo skt_natureone_content(15); ?>
                                                                <?php } else { ?>
                                                                	<?php echo skt_natureone_content(32); ?>
                                                                <?php } ?>
                                                                <a href="<?php esc_url(the_permalink()); ?>"><?php _e('Read More','nature-one'); ?></a>
                                                        <?php endwhile; ?>
                                            </div><!-- box-first -->
                                    <?php } ?>
                            </div><!-- feature-section -->
                            <div class="features-section">
                            		<?php if( of_get_option('boxsecond',false)) { ?>
                                    		<div class="feature-box">
                                            	<?php $boxfirst = new WP_Query('page_id='.of_get_option('boxsecond'));
														while($boxfirst->have_posts()) : $boxfirst->the_post(); ?>
                                                        	<?php if( has_post_thumbnail()) { ?>
                                                                <div class="feat-image"><?php the_post_thumbnail( array(85,85) ); ?></div><!-- feat-image -->
                                                            <?php } ?>
                                                            <h5><?php the_title(); ?></h5>
                                                            	<?php if( has_post_thumbnail() ) { ?>
                                                            		<?php echo skt_natureone_content(15); ?>
                                                                <?php } else { ?>
                                                                	<?php echo skt_natureone_content(32); ?>
                                                                <?php } ?>
                                                                <a href="<?php esc_url(the_permalink()); ?>">><?php _e('Read More','nature-one'); ?></a>
                                                        <?php endwhile; ?>
                                            </div><!-- box-first -->
                                    <?php } ?>
                            </div><!-- feature-section -->
                            <div class="features-section">
                            		<?php if( of_get_option('boxthird',false)) { ?>
                                    		<div class="feature-box">
                                            	<?php $boxfirst = new WP_Query('page_id='.of_get_option('boxthird'));
														while($boxfirst->have_posts()) : $boxfirst->the_post(); ?>
                                                        	<?php if( has_post_thumbnail()) { ?>
                                                                <div class="feat-image"><?php the_post_thumbnail( array(85,85) ); ?></div><!-- feat-image -->
                                                            <?php } ?>
                                                            <h5><?php the_title(); ?></h5>
                                                            	<?php if( has_post_thumbnail() ) { ?>
                                                            		<?php echo skt_natureone_content(15); ?>
                                                                <?php } else { ?>
                                                                	<?php echo skt_natureone_content(32); ?>
                                                                <?php } ?>
                                                                <a href="<?php esc_url(the_permalink()); ?>">><?php _e('Read More','nature-one'); ?></a>
                                                        <?php endwhile; ?>
                                            </div><!-- box-first -->
                                    <?php } ?>
                            </div><!-- feature-section -->
                            <div class="features-section">
                            		<?php if( of_get_option('boxfourth',false)) { ?>
                                    		<div class="feature-box">
                                            	<?php $boxfirst = new WP_Query('page_id='.of_get_option('boxfourth'));
														while($boxfirst->have_posts()) : $boxfirst->the_post(); ?>
                                                        	<?php if( has_post_thumbnail()) { ?>
                                                                <div class="feat-image"><?php the_post_thumbnail( array(85,85) ); ?></div><!-- feat-image -->
                                                            <?php } ?>
                                                            <h5><?php the_title(); ?></h5>
                                                            	<?php if( has_post_thumbnail() ) { ?>
                                                            		<?php echo skt_natureone_content(15); ?>
                                                                <?php } else { ?>
                                                                	<?php echo skt_natureone_content(32); ?>
                                                                <?php } ?>
                                                                <a href="<?php esc_url(the_permalink()); ?>">><?php _e('Read More','nature-one'); ?></a>
                                                        <?php endwhile; ?>
                                            </div><!-- box-first -->
                                    <?php } } ?>
                            </div><!-- feature-section --><div class="clear"></div>
                     </div><!-- middle-align --><div class="clear"></div>
            </section><div class="clear"></div>
            <!-- section2 -->
            <section class="menu_page">
            	<div class="middle-align">
                	<?php $blogpost = new WP_Query('showposts='.of_get_option('blogdisplay')); ?>
                	<?php $j = 0; ?>
                	<?php if( of_get_option('bloghead',true) != 1) { ?><h2><span><?php echo of_get_option('bloghead',true); ?></span></h2><?php } else { ?><h2><span><?php _e('Whats New?','nature-one'); ?></span></h2> <?php } ?>
                		<?php if( $blogpost->have_posts() ) : while( $blogpost->have_posts() ) : $blogpost->the_post(); ?>
                        	<?php $j++; ?>
                        		<div class="blog-box" <?php if($j%2==0) {?> style="float:right" <?php } ?>>
                                		<div class="blog-meta"><?php echo get_the_time('j'); ?><br /><?php echo date('M'); ?></div><!-- blog-meta -->
                                        <div class="blog-right"><h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        						<?php echo skt_natureone_content(25); ?>
                                                                <a href="<?php esc_url(the_permalink()); ?>"><?php _e('Read More...','nature-one'); ?></a>
                                        </div><!-- blog-right -->
                                </div><!-- blog-box --><?php if($j%2==0) { ?><div class="clear"></div><?php } ?>
                        <?php  endwhile; else : endif; ?><div class="clear"></div>
                </div><!-- middle-align -->
            </section>
            		
<?php endif; ?>
<?php get_footer(); ?>
