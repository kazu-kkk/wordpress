<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

?>

</div><!-- #content -->

<?php get_template_part('template-parts/footer/footer', 'instagram-widget'); ?>

<footer id="colophon" class="site-footer" role="contentinfo" style="background-color: #f8f9fa; padding: 20px; text-align: center;">
	<div class="inner-wrap">
		<p>&copy; <?php echo date('Y'); ?> Designpedia. All Rights Reserved.</p>
		<nav class="footer-navigation">
			<ul style="list-style: none; padding: 0; margin: 0; display: inline-flex; gap: 15px;">
				<li><a href="https://bento.me/hk1203" style="text-decoration: none; color: #007bff;">About</a></li>
				<li><a href="/privacy" style="text-decoration: none; color: #007bff;">Privacy Policy</a></li>
				<li><a href="/contact" style="text-decoration: none; color: #007bff;">Contact</a></li>
			</ul>
		</nav>
	</div><!-- .inner-wrap -->
</footer>
<!-- #colophon -->
</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>

</html>