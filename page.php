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

		<div class="row">

			<div class="small-12 columns">
				Site title
			</div>

			<div class="small-12 medium-8 columns">
				Info
			</div>
			
			<div class="small-12 medium-4 columns">
				Download
			</div>
			
		</div>

		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- .columns end -->

<?php get_footer(); ?>
