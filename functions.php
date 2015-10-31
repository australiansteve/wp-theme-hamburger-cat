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

include( get_template_directory() . '/widget-header.php');

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

}
endif; // hamburgercat_setup
add_action( 'after_setup_theme', 'hamburgercat_setup' );

/**
 * Enqueue styles.
 */

if ( !function_exists( 'hamburgercat_styles' ) ) :

	function hamburgercat_styles() {

		// Conditional css for debug or production mode

		if ( WP_DEBUG ) :

			// Enqueue our debug stylesheet [development mode - non-minified]
			wp_enqueue_style( 'hamburgercat_styles', get_stylesheet_directory_uri() . '/assets/dist/css/app.css', '', '9' );
			wp_enqueue_style( 'fontawesome_styles', get_stylesheet_directory_uri() . '/assets/dist/css/font-awesome.css', '', '9' );
			wp_enqueue_style( 'home_styles', get_stylesheet_directory_uri() . '/style.css', '', '9' );

		else :

			// Enqueue our minified stylesheet [production mode - minified stylesheet]
			wp_enqueue_style( 'hamburgercat_styles', get_stylesheet_directory_uri() . '/assets/dist/css/app.min.css', '', '9' );
			wp_enqueue_style( 'fontawesome_styles', get_stylesheet_directory_uri() . '/assets/dist/css/font-awesome.min.css', '', '9' );
			wp_enqueue_style( 'home_styles', get_stylesheet_directory_uri() . '/style.css', '', '9' );

		endif;


	}


add_action( 'wp_enqueue_scripts', 'hamburgercat_styles' );

endif;




/**
 * Enqueue scripts.
 */
function hamburgercat_scripts() {

	// Add modernizer.js for shimming HTML5 elements that older browsers may not detect and for mobile detection
	wp_enqueue_script ( 'modernizr', get_template_directory_uri() . '/assets/components/modernizr/modernizr.js', '', '', false );

	// Add fastclick.js file to footer (for help with devices with touch UIs)
	wp_enqueue_script ( 'fastclick_js', get_template_directory_uri() . '/assets/components/fastclick/lib/fastclick.js', '', '', true );

	// Add core Foundation js to footer
	wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/components/foundation/js/foundation.min.js', array( 'jquery' ), '5', true );

	// Add our concatenated js file
	if ( WP_DEBUG ) {

		// Enqueue our full version if in development mode
		wp_enqueue_script( 'hamburgercat_appjs', get_template_directory_uri() . '/assets/dist/js/app.js', array( 'jquery' ), '', true );

	} else {

		// Enqueue minified js if in production mode
		wp_enqueue_script( 'hamburgercat_appjs', get_template_directory_uri() . '/assets/dist/js/app.min.js', array( 'jquery' ), '', true );
	}

	wp_enqueue_script( 'hamburgercat-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'hamburgercat-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hamburgercat_scripts' );

function enqueue_widget_scripts($hook) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

    wp_enqueue_script('thickbox', null, array('jquery'));
    wp_enqueue_script('media-upload');
    wp_enqueue_style('thickbox');
	wp_enqueue_script( 'hamburgercat-image-uploads', get_template_directory_uri() . '/js/widget-header.js' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_widget_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

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

add_filter('wp_head','foundation_header');

function foundation_header(){
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(document).foundation();
		});
	</script>
	<?php
}

add_filter( 'wp_nav_menu', 'hamburgercat_nav_menu', 10, 2 );

function hamburgercat_nav_menu( $menu ){
	$menu = str_replace('current-menu-item', 'current-menu-item active', $menu);
	return $menu;
}
