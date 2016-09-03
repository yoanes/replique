<?php
/**
 * @package SKT Nature One
 * Setup the WordPress core custom functions feature.
 *
*/

add_action('admin_enqueue_scripts', 'skt_natureone_optionsframework_custom_scripts');
	function skt_natureone_optionsframework_custom_scripts( $hook ) {
    if ( 'appearance_page_iamone-options' != $hook ) {
        return;
    }
    wp_enqueue_script( 'nature-one-option-script', get_template_directory_uri().'/js/optionframework-custom.js' );
}
	

// custom javascript for head
function skt_natureone_hook_custom_javascript(){
	wp_enqueue_script('skt_natureone_cus', get_template_directory_uri().'/js/hook-custom-script.js');	
}
add_action('wp_enqueue_scripts','skt_natureone_hook_custom_javascript');


// get_the_content format text
function skt_natureone_get_the_content_format( $str ){
	$raw_content = apply_filters( 'the_content', $str );
	$content = str_replace( ']]>', ']]&gt;', $raw_content );
	return $content;
}
// the_content format text
function skt_natureone_the_content_format( $str ){
	echo skt_natureone_get_the_content_format( $str );
}


// remove excerpt more
function skt_natureone_excerpt_more( $more ) {
	return '... ';
}
add_filter('excerpt_more', 'skt_natureone_excerpt_more');

// get post categories function
function skt_natureone_getPostCategories(){
	$categories = get_the_category();
	$catOut = '';
	$separator = ', ';
	$catOutput = '';
	if($categories){
		foreach($categories as $category) {
			$catOutput .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'nature-one' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
		}
		$catOut = __('Categories: ','nature-one').trim($catOutput, $separator);
	}
	return $catOut;
}

define('SKT_URL','http://www.sktthemes.net');
define('SKT_THEME_URL','http://www.sktthemes.net/themes');
define('SKT_THEME_PRO_URL','http://www.sktthemes.net/themes/nature-wordpress-theme');
define('SKT_THEME_DOC','http://sktthemesdemo.net/documentation/nature-one-documentation');