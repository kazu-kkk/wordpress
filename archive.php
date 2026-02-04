<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

get_header(); ?>

<div class="inner-wrap inner-wrap--top-page">

	<div id="primary" class="content-area">
		<main id="main" class="top-page-content" role="main">

			<header class="page-header">
				<?php
				the_archive_title('<h1 class="page-title">', '</h1>');
				the_archive_description('<div class="taxonomy-description">', '</div>');
				?>
			</header>

			<div class="top-page-content-article">
				<?php
				if (have_posts()) :
					while (have_posts()) :
						the_post();

						get_template_part('template-parts/post/content', get_post_format());
					endwhile;
				else :
					get_template_part('template-parts/post/content', 'none');
				endif;
				?>
			</div>

			<?php
			// ページネーション
			if (have_posts()) {
				the_posts_pagination(
					array(
						'prev_next' => false,
					)
				);
			}
			?>

		</main><!-- #main -->

		<!-- サイドナビを挿入 -->
		<?php get_template_part('side-nav'); ?>
	</div><!-- #primary -->

	<?php if ('side-right' === inspiro_get_theme_mod('layout_blog_page') && is_active_sidebar('blog-sidebar')) : ?>
		<aside id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar('blog-sidebar'); ?>
		</aside>
	<?php endif; ?>

</div><!-- .inner-wrap -->

<?php
get_footer();
?>