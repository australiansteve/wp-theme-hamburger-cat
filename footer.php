<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Hamburgercat
 */
?>

			</div>
		</div>

<?php

	get_footer(); 

?>
	</div> <!-- #page -->

	<div id="spacer">
	</div>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div>
			<p class="footer">Website by: <a class="fa fa-copyright" href="http://australiansteve.com"><?php echo date("Y"); ?> AustralianSteve.com</a></p>
		</div>
	</footer><!-- #colophon -->

<?php wp_footer(); ?>
</body>
</html>
