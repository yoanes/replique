<?php
/**
 * SKT Nature One functions and definitions
 *
 * @package SKT Nature One
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
function skt_natureone_content($limit) {
$content = explode(' ', get_the_content(), $limit);
if (count($content)>=$limit) {
array_pop($content);
$content = implode(" ",$content).'...';
} else {
$content = implode(" ",$content);
}	
$content = preg_replace('/\[.+\]/','', $content);
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
return $content;
}


if ( ! function_exists( 'skt_natureone_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function skt_natureone_setup() {

	if ( ! isset( $content_width ) )
		$content_width = 640; /* pixels */

	load_theme_textdomain( 'nature-one', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );
	add_image_size('nature-one-homepage-thumb',240,145,true);
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'nature-one' ),
	) );
	register_nav_menus( array(
		'footer' => __('Footer Menu', 'nature-one'),
	));
	add_theme_support( 'custom-background', array(
		'default-color' => '303030'
	) );
	add_editor_style( 'editor-style.css' );
}
endif; // skt_natureone_setup
add_action( 'after_setup_theme', 'skt_natureone_setup' );


function skt_natureone_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'nature-one' ),
		'description'   => __( 'Appears on blog page sidebar', 'nature-one' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="sidebar-blog">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h3 class="blog-widget-title">',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Page Sidebar', 'nature-one' ),
		'description'   => __( 'Appears on inner pages', 'nature-one' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

}
add_action( 'widgets_init', 'skt_natureone_widgets_init' );

define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once get_template_directory().'/inc/options-framework.php';

// Loads options.php from child or parent theme
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );


function skt_natureone_fonts_url() {
    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Oswald, translate this to 'off'. Do not translate
    * into your own language.
    */
    $oswald = _x( 'on', 'Oswald font: on or off', 'nature-one' );
 
    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $open_sans = _x( 'on', 'Open Sans font: on or off', 'nature-one' );
 
    if ( 'off' !== $oswald || 'off' !== $open_sans ) {
        $font_families = array();
 
        if ( 'off' !== $oswald ) {
            $font_families[] = 'Oswald:400,700,400italic';
        }
 
        if ( 'off' !== $open_sans ) {
            $font_families[] = 'Open Sans:700italic,400,800,600';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

function skt_natureone_favicon() {
	if( of_get_option('favicon',true) != '') { ?>
<link rel="icon" type="image/x-icon" href="<?php echo esc_url(of_get_option('favicon',true)); ?>" >
<?php } }
add_action('wp_head', 'skt_natureone_favicon');

function skt_natureone_enqueue_styles() {
global $wp_styles;
// Load the main stylesheet
wp_enqueue_style( 'nature-one', get_stylesheet_uri() );
/**
* Load our IE-only stylesheet for all versions of IE:
* <!--[if lt IE 9]> ... <![endif]-->
*
* NOTE: It is also possible to just check and see if the $is_IE global in WordPress is set to true before
* calling the wp_enqueue_style() function. If you are trying to load a stylesheet for all browsers
* EXCEPT for IE, then you would HAVE to check the $is_IE global since WordPress doesn't have a way to
* properly handle non-IE conditional comments.
*/
wp_enqueue_style( 'nature-one-ie', get_stylesheet_directory_uri() . "/css/ie.css", array( 'nature-one-style' ) );
$wp_styles->add_data( 'nature-one-ie', 'conditional', 'IE' );
}
add_action('wp_enqueue_scripts', 'skt_natureone_enqueue_styles');


function skt_natureone_scripts() {
		wp_enqueue_style( 'nature-one-fonts', skt_natureone_fonts_url(), array(), null );
	if( of_get_option('bodyfontface',true) != '' ){
		wp_enqueue_style( 'skt_natureone-gfonts-body', '//fonts.googleapis.com/css?family='.rawurlencode(of_get_option('bodyfontface',true)) );
	}
	if ( of_get_option('navfontface', true) != '' ) {
		wp_enqueue_style( 'skt_natureone-gfonts-nav', '//fonts.googleapis.com/css?family='.rawurlencode(of_get_option('navfontface',true)) );
	}
	wp_enqueue_style( 'skt_natureone-editor-style', get_template_directory_uri().'/editor-style.css' );
	wp_enqueue_style( 'skt_natureone-base-style', get_template_directory_uri().'/css/style_base.css' );
	wp_enqueue_style( 'skt_natureone_responsive-style', get_template_directory_uri().'/css/theme-responsive.css');
	wp_enqueue_style( 'skt_natureone-nivo-style', get_template_directory_uri().'/css/nivo-slider.css' );
	wp_enqueue_script( 'skt_natureone-customscripts', get_template_directory_uri() . '/js/custom.js', array('jquery') );
	wp_enqueue_script( 'skt_natureone-lightbox-scripts', get_template_directory_uri().'/js/lightbox.js' );
	wp_enqueue_script( 'skt_natureone-nivo-scripts', get_template_directory_uri().'/js/jquery.nivo.slider.js' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'skt_natureone_scripts' );


function skt_natureone_custom_head_codes() { 
	if ( function_exists('of_get_option') ){
		if ( of_get_option('style2', true) != '' ) {
			echo "<style>". esc_html( of_get_option('style2', true) ) ."</style>";
		}
		echo "<style>";
			if( of_get_option('colorscheme', true) != ''){
				echo ".header .header-inner .nav ul li.current_page_item a, .header .header-inner .nav ul li a:hover, .slide_info h2, a, .postmeta a, .entry-meta a, h3.blog-widget-title, h1.screen-reader-text, h3#reply-title, h2.blog-title, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price{color:".of_get_option('colorscheme',true)."}";
			}
			if( of_get_option('colorscheme',true) != ''){
				echo "section h2 span{border-bottom:6px solid ".of_get_option('colorscheme', true)."}";
			}
			if( of_get_option('colorscheme',true) != ''){
				echo "#slider-page{ border-bottom:7px solid ".of_get_option('colorscheme',true).";}";
			}
			if( of_get_option('colorscheme',true) != ''){
				echo "#slider-page:after{  border-top-color: ".of_get_option('colorscheme',true).";}";
			}
			if( of_get_option('colorscheme',true) != ''){
				echo ".pagination ul li .current, .pagination ul li a:hover, input.search-submit:hover, .post-password-form input[type=submit]:hover, #footer .footer-top, #commentform input#submit, a.added_to_cart, .blog-meta{background-color:".of_get_option('colorscheme', true)."}";
			}
			if( of_get_option('colorscheme',true) != ''){
			echo "#commentform input#submit{border-color:".of_get_option('colorscheme', true)."}";
			}
		echo "</style>";
	}
}
add_action('wp_head', 'skt_natureone_custom_head_codes');


function skt_natureone_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<div class="pagination"><div><ul>';
		echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
		foreach ( $page_format as $page ) {
			echo "<li>$page</li>";
		}
		echo '</ul></div></div>';
	}
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load custom functions file.
 */
require get_template_directory() . '/inc/custom-functions.php';


function skt_natureone_custom_blogpost_pagination( $wp_query ){
	$big = 999999999; // need an unlikely integer
	if ( get_query_var('paged') ) { $pageVar = 'paged'; }
	elseif ( get_query_var('page') ) { $pageVar = 'page'; }
	else { $pageVar = 'paged'; }
	$pagin = paginate_links( array(
		'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' 		=> '?'.$pageVar.'=%#%',
		'current' 		=> max( 1, get_query_var($pageVar) ),
		'total' 		=> $wp_query->max_num_pages,
		'prev_text'		=> '&laquo; Prev',
		'next_text' 	=> 'Next &raquo;',
		'type'  => 'array'
	) ); 
	if( is_array($pagin) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		echo '<div class="pagination"><div><ul>';
		echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
		foreach ( $pagin as $page ) {
			echo "<li>$page</li>";
		}
		echo '</ul></div></div>';
	} 
}

// get slug by id
function skt_natureone_get_slug_by_id($id) {
	$post_data = get_post($id, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug; 
}