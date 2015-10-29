<?php
/**
 * Hamburgercat Theme Customizer
 *
 * @package Hamburgercat
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hamburgercat_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	//All our sections, settings, and controls will be added here
   	$wp_customize->add_setting( 'austeve_background_image' );

	$wp_customize->add_section( 'hamburgercat_bg_section' , array(
	    'title'       => __( 'Background', 'hamburgercat' ),
	    'priority'    => 30,
	    'description' => 'Upload a background image',
	) );

   	$wp_customize->add_control( 
   		new WP_Customize_Image_Control( 
   			$wp_customize, 
   			'austeve_background_image', 
   			array(
			    'label'    => __( 'Image:', 'hamburgercat' ),
			    'section'  => 'hamburgercat_bg_section',
			    'settings' => 'austeve_background_image',
			) 
		) 
	);


}
add_action( 'customize_register', 'hamburgercat_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hamburgercat_customize_preview_js() {
	wp_enqueue_script( 'hamburgercat_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'hamburgercat_customize_preview_js' );
