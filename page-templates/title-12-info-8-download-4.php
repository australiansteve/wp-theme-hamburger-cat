<?php
/**
 * Template Name: Title (12), Info (8) - Download (4)
 * 
 * @package hamburgercat
 */

?>

<?php

	get_header(); 

?>
	<div class="row primary">
		<div class="small-12 columns">
			<div class="row">
				<div class="small-12 columns" id="austeve-site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<h1 class="site-title"><img id="header-image" src="http://localhost/theme-dev/wp-content/uploads/2015/09/header1.png"/></h1>
					</a>
				</div>
			</div>
			<div class="row">
				
				<div class="small-12 medium-4 medium-push-8 columns text-center austeve-shaded">
					<div>
						<a href="" class="download">Download<br/>Portfolio<br/>
						<i class="fa fa-download fa-3x show-for-small-only"></i>
						<i class="fa fa-download fa-5x hide-for-small"></i></a>
					</div>
				</div>

				<div class="small-12 medium-8 medium-pull-4 columns austeve-shaded">
					<div>

						<?php if ( have_posts() ) : ?>

							<?php /* Start the Loop */ ?>
							<?php while ( have_posts() ) : the_post(); ?>

								<?php
									/* Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'page-templates/partials/content-simple', get_post_format() );
								?>

							<?php endwhile; ?>

							<?php the_posts_navigation(); ?>

						<?php else : ?>

							<?php get_template_part( 'page-templates/partials/content-simple', 'none' ); ?>

						<?php endif; ?>

					</div>
				</div>
				

			</div>
		</div>
	</div>

<?php

	get_footer(); 

?>