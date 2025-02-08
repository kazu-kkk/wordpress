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

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="inner-wrap">
		<nav class="footer-navigation">
			<ul>
				<li><a href="https://bento.me/hk1203">About</a></li>
				<li><a href="/privacy">Privacy Policy</a></li>
				<li><a href="/contact">Contact</a></li>
			</ul>
		</nav>
		<p>&copy; <?php echo date('Y'); ?> Designpedia. All Rights Reserved.</p>
	</div><!-- .inner-wrap -->
</footer>

<!-- #colophon -->
</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>

</html>