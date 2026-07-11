<?php

/**
 * Template part for displaying article header
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

$cover_height = inspiro_get_theme_mod('cover-size');

$featured_image_show = inspiro_get_theme_mod('display_featured_image');

?>

<?php
if (is_sticky() && is_home()) {
	echo inspiro_get_theme_svg('thumb-tack');
}
?>

<?php get_template_part('template-parts/post/article/post-thumbnail', get_post_format()); ?>

<?php
/*
 * If a regular post or page, and not the front page, show the featured image as header cover image.
 */
if ((is_single() || (is_page() && ! inspiro_is_frontpage())) && has_post_thumbnail(get_the_ID()) && $featured_image_show) {
	echo '<div class="entry-cover-image ' . $cover_height . '">';
	echo '<div class="single-featured-image-header">';
	echo get_the_post_thumbnail(get_the_ID(), 'inspiro-featured-image');
	echo '</div><!-- .single-featured-image-header -->';
}
?>

<header class="entry-header">

	<?php
	if ((is_single() || (is_page() && ! inspiro_is_frontpage()))) {
		echo '<div class="inner-wrap">';
	}

	if (is_single()) {
		the_title('<h1 class="entry-title">', '</h1>');
	} elseif (is_front_page() && is_home()) {
		the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
	} else {
		the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
	}

	if ('post' === get_post_type()) {
		if (is_single()) {
			echo '<div class="entry-meta">';
			inspiro_single_entry_meta();
			echo '</div><!-- .entry-meta -->';
		} else {
			?>
			<div class="top-page-article-meta" style="display: flex; flex-direction: column; align-items: flex-start; margin-top: auto;">
				<p class="top-page-article-date" style="color: #666; font-size: 12px; margin: 0 0 6px 0; padding: 0; line-height: 1;"><?php the_time('Y.m.d'); ?></p>
				<div class="top-page-article-tags" style="display: flex; flex-wrap: wrap; gap: 4px; align-items: flex-start;">
					<?php
					$displayed_terms = array(); // 表示済みタグ名を記録
					$categories = get_the_category();
					if (!empty($categories)) {
						foreach ($categories as $cat) {
							if ($cat->name === '記事') continue;
							if (in_array($cat->name, $displayed_terms)) continue;
							echo '<span class="tag" style="margin:0;">' . esc_html($cat->name) . '</span>';
							$displayed_terms[] = $cat->name;
						}
					}
					$tags = get_the_tags();
					if (!empty($tags)) {
						foreach ($tags as $tag) {
							if (in_array($tag->name, $displayed_terms)) continue;
							echo '<span class="tag" style="margin:0;">' . esc_html($tag->name) . '</span>';
							$displayed_terms[] = $tag->name;
						}
					}
					?>
				</div>
			</div>
			<?php
		}
	}

	if ((is_single() || (is_page() && ! inspiro_is_frontpage()))) {
		echo '</div><!-- .inner-wrap -->';
	}
	?>
</header><!-- .entry-header -->

<?php
if ((is_single() || (is_page() && ! inspiro_is_frontpage())) && has_post_thumbnail(get_the_ID()) && $featured_image_show) {
	echo '</div><!-- .entry-cover-image -->';
}
?>