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

<main id="main" class="site-main" role="main">

	<div class="row" id="primary" class="content-area">

		<div class="small-12 columns"><!-- .columns start -->

	<?php 
			for($s = 1; $s <= get_theme_mod('austeve_num_sidebars', 0); $s++) {

	?>
				<div id="hc-content-<?php echo $s ; ?>" class="row hc-content">

					<?php dynamic_sidebar( 'austeve_content_'.$s ); ?>
					
				</div>
	<?php
			}
	?>

		</div><!-- .columns end -->

	</div><!-- #primary.row end -->

</main><!-- #main -->

<?php get_footer(); ?>
