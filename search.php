<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
				<?php if (have_posts()) : ?>
					<h1 class="page-title">
						<?php
						/* translators: Search query. */
						printf(esc_html__('Search Results for: %s', 'inspiro'), '<span>' . get_search_query() . '</span>');
						?>
					</h1>
				<?php else : ?>
					<h1 class="page-title"><?php esc_html_e('Nothing Found', 'inspiro'); ?></h1>
				<?php endif; ?>
			</header>

			<div class="top-page-content-article">
				<?php
				if (have_posts()) :
					while (have_posts()) :
						the_post();

						get_template_part('template-parts/post/content', get_post_format());
					endwhile;
				else :
					?>
					<div class="no-results not-found" style="margin-bottom: 40px; text-align: center;">
						<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'inspiro'); ?></p>
						<div style="margin-top: 20px; display: inline-block;">
							<?php get_search_form(); ?>
						</div>
					</div>
				<?php
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
		<aside class="right-contents">
			<?php get_template_part('side-nav'); ?>
		</aside>
	</div><!-- #primary -->

	<?php if ('side-right' === inspiro_get_theme_mod('layout_blog_page') && is_active_sidebar('blog-sidebar')) : ?>
		<aside id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar('blog-sidebar'); ?>
		</aside>
	<?php endif; ?>

</div><!-- .inner-wrap -->

<?php
get_footer();
