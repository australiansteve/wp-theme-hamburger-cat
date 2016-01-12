<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Hamburgercat
 */

get_header(); ?>

<div class="small-12 columns"><!-- .columns start -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php 
	for($s = 1; $s <= get_theme_mod('austeve_num_sidebars', 0); $s++) {

?>
		<div class="row">

			<?php dynamic_sidebar( 'austeve_content_'.$s ); ?>
			
		</div>
<?php
	}
?>
		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- .columns end -->

<?php get_footer(); ?>
