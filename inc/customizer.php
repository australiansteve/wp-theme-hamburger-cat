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
   	$wp_customize->add_setting( 'austeve_background_opacity' );
   	$wp_customize->add_setting( 'austeve_logo_image' );
   	$wp_customize->add_setting( 'austeve_num_sidebars' );

	$wp_customize->add_section( 'hamburgercat_bg_section' , array(
	    'title'       => __( 'Background', 'hamburgercat' ),
	    'priority'    => 30,
	    'description' => 'Upload a background image',
	) );

	$wp_customize->add_section( 'hamburgercat_images_section' , array(
	    'title'       => __( 'Images', 'hamburgercat' ),
	    'priority'    => 30,
	    'description' => 'Upload Images used in the theme here',
	) );

	//Number of sidebars
	$wp_customize->add_control(
	    new WP_Customize_Control(
	        $wp_customize,
	        'austeve_num_sidebars',
	        array(
	            'label'          => __( 'Rows of content:', 'hamburger_cat' ),
	            'section'        => 'static_front_page',
	            'settings'       => 'austeve_num_sidebars',
	            'type'           => 'select',
	            'choices'        => array(
	                '0'   => __( 'None' ),
	                '1'  => __( '1' ),
	                '2'  => __( '2' ),
	                '3'  => __( '3' ),
	                '4'  => __( '4' ),
	                '5'  => __( '5' ),
	                '6'  => __( '6' ),
	                '7'  => __( '7' ),
	                '8'  => __( '8' ),
	                '9'  => __( '9' )
	            )
	        )
	    )
	);

	//Background Image
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

   	//Background opacity
   	$wp_customize->add_control( 
   		'austeve_background_opacity', 
		array(
			'label'    => __( 'Opacity', 'hamburgercat' ),
			'section'  => 'hamburgercat_bg_section',
			'settings' => 'austeve_background_opacity',
			'type'     => 'text',
		)
	);

   	//Logo
   	$wp_customize->add_control( 
   		new WP_Customize_Image_Control( 
   			$wp_customize, 
   			'austeve_logo_image', 
   			array(
			    'label'    => __( 'Logo:', 'hamburgercat' ),
			    'section'  => 'title_tagline',
			    'settings' => 'austeve_logo_image',
			) 
		) 
	);

}
add_action( 'customize_register', 'hamburgercat_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hamburgercat_customize_preview_js() {
	wp_enqueue_script( 'hamburgercat_customizer', get_template_directory_uri().'/inc/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'hamburgercat_customize_preview_js' );


/**
 * Live CSS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hamburgercat_customize_css()
{
    ?>
        <style type="text/css">
            #bgImage { 
             	background-image: url(<?php echo get_theme_mod('austeve_background_image', ''); ?>);
             	opacity: <?php echo get_theme_mod('austeve_background_opacity', '1.0'); ?>;
            }
        </style>
    <?php
}
add_action( 'wp_head', 'hamburgercat_customize_css');
