<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package SKT Nature One
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ( (of_get_option('innerpageslider', true) != 'hide') || is_home() || is_front_page() ) { ?>
    <div class="slider-wrapper">
           <?php
		   	if ( of_get_option('slide1', true) == 1 ){ ?>
            		<div id="slider" class="nivoSlider">
                    		<img src="<?php echo get_template_directory_uri(); ?>/images/slides/slider1.jpg" />
					</div>
                    <div id="slidecaption1" class="nivo-html-caption" style="display:block;">
                        <div class="slide_info" style="top:-160px;z-index:99">
                        	<h2><?php _e('Natureone WordPress Theme','nature-one'); ?></h2>
                            <p><?php _e('Go to Appearance > Theme Options > Restore Defaults to setup the homepage','skt-naturone'); ?></p>
                        </div>
                    </div>
                    </div>
			<?php 	}
					else {
			$slAr = array();
			$m = 0;
			for ($i=1; $i<4; $i++) {
				if ( of_get_option('slide'.$i, true) != "" ) {
					$imgSrc 	= of_get_option('slide'.$i, true);
					$imgTitle	= of_get_option('slidetitle'.$i, true);
					$imgDesc	= of_get_option('slidedesc'.$i, true);
					if ( strlen($imgSrc) > 3 ) {
						$slAr[$m]['image_src'] = of_get_option('slide'.$i, true);
						$slAr[$m]['image_title'] = of_get_option('slidetitle'.$i, true);
						$slAr[$m]['image_desc'] = of_get_option('slidedesc'.$i, true);
						$m++;
					}
				}
				
			}
			$slideno = array();
			if( $slAr > 0 ){
				$n = 0;?>
                <div id="slider" class="nivoSlider">
                <?php 
                foreach( $slAr as $sv ){
                    $n++; ?><img src="<?php echo esc_url($sv['image_src']); ?>" alt="<?php echo esc_attr($sv['image_title']);?>" title="<?php if ( ($sv['image_title']!='') && ($sv['image_desc']!='') ) { echo esc_attr('#slidecaption'.$n) ; } ?>"/><?php
                    $slideno[] = $n;
                }
                ?>
                </div><?php
                foreach( $slideno as $sln ){ ?>
                    <div id="slidecaption<?php echo $sln; ?>" class="nivo-html-caption">
                    <div class="slide_info">
                        <?php if( of_get_option('slidetitle'.$sln, true) != '' ){ ?>
                            <h2><?php echo esc_html(of_get_option('slidetitle'.$sln, true)); ?></h2>
                        <?php } ?>
                        <?php if( of_get_option('slidedesc'.$sln, true) != '' ){ ?>
                            <p><?php echo esc_html(of_get_option('slidedesc'.$sln, true)); ?></p>
                        <?php } ?>
                    </div>
                    </div><?php 
                } ?>
                </div>
                <div class="clear"></div><?php 
			}
            ?>
        </div>
   
<?php } }  else { ?>
						<div id="slider-page">
                    	<?php if( is_single() || is_archive() || is_category() || is_404()) { ?> 
                                    	<img src="<?php echo esc_url(get_template_directory_uri().'/images/about-banner.jpg'); ?>" />
                                    <?php } elseif( is_page()) { ?>
                                    <?php while( have_posts() ) : the_post(); ?> 
                            		<?php if( has_post_thumbnail()) { ?>
                    						<?php the_post_thumbnail('full'); ?>
                                            <?php }  else { ?>
                            		<img src="<?php echo esc_url(get_template_directory_uri().'/images/about-banner.jpg'); ?>" />
                            		<?php } ?>
                                    <?php endwhile; ?> 
                                    <?php } ?>
                            </div><!-- slider-page -->
                            <div class="feature-shadow">
            								<img src="<?php echo esc_url(get_template_directory_uri().'/images/innerpage_slide_bg.png'); ?>" />
                        			</div><!-- feature-shadow -->
	<?php } ?>

<div class="header">
            		<div class="header-inner">
                    		<div class="logo">
                            		<a href="<?php echo esc_url(home_url('/')); ?>">
                                    	<?php if( of_get_option( 'logo', true ) != '' ) { 
													if( of_get_option('logo', true) == "http://1"){
														echo "<h1>".__('Logo','nature-one')."</h1>";
													}
													else 
													{
										; ?>
 	                                       <img src="<?php echo esc_url( of_get_option( 'logo', true )); ?>" / >
                                           
                                        <?php } } else { ?>
    	                                    <h1><?php bloginfo('name'); ?></h1>
                                            <?php bloginfo('description'); ?>
                                        <?php } ?>
                                    </a>
                             </div><!-- logo -->
                            <div class="toggle">
                            <a class="toggleMenu" href="#"><?php _e('Menu','nature-one'); ?></a>
                            </div><!-- toggle -->
                            <div class="nav">
								<?php wp_nav_menu( array( 'theme_location' => 'primary') ); ?>
                            </div><!-- nav -->
                            <div class="clear"></div>
                    </div><!-- header-inner -->
            </div><!-- header -->
      <div class="main-container">
         <?php if( function_exists('is_woocommerce') && is_woocommerce() ) { ?>
		 	<div class="content-area">
                <div class="middle-align content_sidebar">
                	<div id="sitemain" class="site-main">
         <?php } ?>