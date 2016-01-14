<?php
/**
 * Hamburgercat functions and definitions
 *
 * @package Hamburgercat
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'hamburgercat_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hamburgercat_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Hamburgercat, use a find and replace
	 * to change 'hamburgercat' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'hamburgercat', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'hamburgercat' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	/*
	 * Register sidebars
	 *
	 */
	$sidebars = get_theme_mod('austeve_num_sidebars', 0);
    for ( $s = 1; $s <= $sidebars; $s++ ) {
        register_sidebar( array(
            'name'          => 'Front page content '.$s,
            'id'            => 'austeve_content_'.$s,
            'before_widget' => '<div class="columns">',
            'after_widget'  => '</div>',
            'before_title'  => '',
            'after_title'   => '',
        ) );
    }
}
endif; // hamburgercat_setup
add_action( 'after_setup_theme', 'hamburgercat_setup' );

/**
 * Enqueue styles.
 */

if ( !function_exists( 'hamburgercat_styles' ) ) :

	function hamburgercat_styles() {

		// Enqueue our debug stylesheet [development mode - non-minified]
		wp_enqueue_style( 'hamburgercat_styles', get_stylesheet_directory_uri() . '/assets/dist/css/app.css', '', '9' );
		wp_enqueue_style( 'fontawesome_styles', get_stylesheet_directory_uri() . '/assets/dist/css/font-awesome.css', '', '9' );
		wp_enqueue_style( 'home_styles', get_stylesheet_directory_uri() . '/style.css', '', '9' );

	}


	add_action( 'wp_enqueue_scripts', 'hamburgercat_styles' );


endif;


/**
 * Enqueue scripts.
 */
function hamburgercat_scripts() {

	// Add Foundation JS to footer
	wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/dist/js/foundation.js', array( 'jquery' ), '6.1.1', true );

	// Add our concatenated JS file after Foundation
	if ( WP_DEBUG ) {

		// Enqueue our full version if in development mode
		wp_enqueue_script( 'hamburgercat_appjs', get_template_directory_uri() . '/assets/dist/js/app.js', array( 'jquery' ), '', true );

	} else {

		// Enqueue minified js if in production mode
		wp_enqueue_script( 'hamburgercat_appjs', get_template_directory_uri() . '/assets/dist/js/app.min.js', array( 'jquery' ), '', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hamburgercat_scripts' );

function hamburgercat_layout_scripts() {

	wp_register_script( 'hamburgercat-layout-js', get_template_directory_uri() . '/js/front-page-layout.js', array( 'jquery' ), '6.1.1', true );

	$translation_array = array(
		'content1' => get_theme_mod('austeve_content_layout_1', ''),
		'content2' => get_theme_mod('austeve_content_layout_2', ''),
		'content3' => get_theme_mod('austeve_content_layout_3', ''),
		'content4' => get_theme_mod('austeve_content_layout_4', ''),
		'content5' => get_theme_mod('austeve_content_layout_5', ''),
		'content6' => get_theme_mod('austeve_content_layout_6', ''),
		'content7' => get_theme_mod('austeve_content_layout_7', ''),
		'content8' => get_theme_mod('austeve_content_layout_8', ''),
		'content9' => get_theme_mod('austeve_content_layout_9', '')
	);

	wp_localize_script( 'hamburgercat-layout-js', 'LAYOUTVARS', $translation_array );

	wp_enqueue_script( 'hamburgercat-layout-js');

}
add_action( 'wp_enqueue_scripts', 'hamburgercat_layout_scripts' );

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



add_filter( 'wp_nav_menu', 'hamburgercat_nav_menu', 10, 2 );

function hamburgercat_nav_menu( $menu ){
	$menu = str_replace('current-menu-item', 'current-menu-item active', $menu);
	return $menu;
}


/*******************************************************************************
* Make oembed elements responsive. Add Foundation's .flex-video class wrapper
* around any oembeds
*******************************************************************************/

add_filter( 'embed_oembed_html', 'hamburgercat_oembed_flex_wrapper', 10, 4 ) ;

function hamburgercat_oembed_flex_wrapper( $html, $url, $attr, $post_ID ) {
	$return = '<div class="flex-video">'.$html.'</div>';
	return $return;
}

/*******************************************************************************
* Custom login styles for the theme. Sass file is located in ./assets/login.scss
* and is spit out to ./assets/dist/css/login.css by gulp. Functions are here so
* that you can move it wherever works best for your project.
*******************************************************************************/

// Load the CSS
add_action( 'login_enqueue_scripts', 'hamburgercat_login_css' );

function hamburgercat_login_css() {
	wp_enqueue_style( 'hamburgercat_login_css', get_template_directory_uri() .
	'/assets/dist/css/login.css', false );
}

// Change header link to our site instead of wordpress.org
add_filter( 'login_headerurl', 'hamburgercat_remove_logo_link' );

function hamburgercat_remove_logo_link() {
	return get_bloginfo( 'url' );
}

// Change logo title in from WordPress to our site name
add_filter( 'login_headertitle', 'hamburgercat_change_login_logo_title' );

function hamburgercat_change_login_logo_title() {
	return get_bloginfo( 'name' );
}
