<?php
/**
 * SKT Nature One Theme Customizer
 *
 * @package SKT Nature One
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function skt_natureone_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	$wp_customize->add_section( 'skt_natureone_theme_options', array(
		'title'    => __( 'Natureone Front Page Options', 'skt_natureone' ),
		'priority' => 130,
	) );


	/* Front Page: Featured Page One */
	$wp_customize->add_setting( 'skt_natureone_featured_page_one_front_page', array(
		'default'           => '',
		'sanitize_callback' => 'skt_natureone_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control( 'skt_natureone_featured_page_one_front_page', array(
		'label'             => __( 'Front Page: Featured Page One', 'skt_natureone' ),
		'section'           => 'skt_natureone_theme_options',
		'priority'          => 8,
		'type'              => 'dropdown-pages',
	) );

	/* Front Page: Featured Page Two */
	$wp_customize->add_setting( 'skt_natureone_featured_page_two_front_page', array(
		'default'           => '',
		'sanitize_callback' => 'skt_natureone_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control( 'skt_natureone_featured_page_two_front_page', array(
		'label'             => __( 'Front Page: Featured Page Two', 'skt_natureone' ),
		'section'           => 'skt_natureone_theme_options',
		'priority'          => 9,
		'type'              => 'dropdown-pages',
	) );

	/* Front Page: Featured Page Three */
	$wp_customize->add_setting( 'skt_natureone_featured_page_three_front_page', array(
		'default'           => '',
		'sanitize_callback' => 'skt_natureone_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control( 'skt_natureone_featured_page_three_front_page', array(
		'label'             => __( 'Front Page: Featured Page Three', 'skt_natureone' ),
		'section'           => 'skt_natureone_theme_options',
		'priority'          => 10,
		'type'              => 'dropdown-pages',
	) );
	
	/* Front Page: Featured Page Four */
	$wp_customize->add_setting( 'skt_natureone_featured_page_four_front_page', array(
		'default'			=> '',
		'sanitize_callback'	=> 'skt_natureone_sanitize_dropdown_pages',
	) );
	$wp_customize->add_control('skt_natureone_featured_page_four_front_page',array(
		'label'             => __( 'Front Page: Featured Page Four', 'skt_natureone' ),
		'section'			=> 'skt_natureone_theme_options',
		'priority'			=> 11,
		'type'				=> 'dropdown-pages',
	));
}

add_action( 'customize_register', 'skt_natureone_customize_register' );

function skt_natureone_sanitize_dropdown_pages( $input ) {
	if ( is_numeric( $input ) ) {
		return intval( $input );
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function skt_natureone_customize_preview_js() {
	wp_enqueue_script( 'skt_natureone_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'skt_natureone_customize_preview_js' );
