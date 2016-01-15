<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Hamburgercat
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="background-div">
		<div id="bgImage">&nbsp;</div>
	</div>

	<div id="page" class="hfeed site">

		<div class="row">

			<div class="small-12 columns" id="austeve-site-title">

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" >

					<h1 class="site-title">

						<?php 
						if (get_theme_mod('austeve_logo_image') === '')
						{
							echo bloginfo('name');
						}
						else
						{
							echo "<img class='blog-logo' src='".get_theme_mod('austeve_logo_image')."'/>";
						}
						?>

					</h1>

				</a>
				
			</div>

		</div>
