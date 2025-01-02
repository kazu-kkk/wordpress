<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'inspiro'); ?></a>

		<header id="masthead" class="site-header" role="banner">


			<!-- ナビゲーションメニュー -->
			<?php get_template_part('template-parts/navigation/navigation', 'primary'); ?>
		</header><!-- #masthead -->

		<div class="site-content-contain">
			<!-- Heroエリアを表示 -->
			<?php
			$hero_show = inspiro_get_theme_mod('hero_enable');
			?>

			<?php
			// Heroエリアを表示する条件
			if (! is_page_template('page-templates/homepage-no-hero.php')) {
				if (isset($paged) && $paged < 2 && $hero_show) {
					if (is_front_page() && is_home()) { // Default homepage.
			?>
						<div class="hero-background">
							<?php if (has_custom_logo()) : ?>
								<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<?php the_custom_logo(); ?>
								</a>
							<?php else : ?>
								<div>
									<p class="hero-text">デザイン・Web・ガジェットの総合メディア</p>
									<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
										<img src="https://www.ds-pedia.com/wp-content/uploads/2025/01/logo.png" alt="Default Logo">
									</a>
								</div>
							<?php endif; ?>
						</div>
					<?php
					} elseif (is_front_page()) { // Static homepage.
					?>
						<div class="hero-background">
							<?php if (has_custom_logo()) : ?>
								<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<?php the_custom_logo(); ?>
								</a>
							<?php else : ?>
								<div>
									<p class="hero-text">デザイン・Web・ガジェットの総合メディア</p>
									<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
										<img src="https://www.ds-pedia.com/wp-content/uploads/2025/01/logo.png" alt="Default Logo">
									</a>
								</div>
							<?php endif; ?>
						</div>
			<?php
					}
				}
			}
			?>
			<div id="content" class="site-content">