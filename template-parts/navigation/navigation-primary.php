<?php

/**
 * Displays top navigation
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

$search_show        = inspiro_get_theme_mod('header_search_show');
$search_display     = $search_show ? 'block' : 'none';

$header_layout_type = inspiro_get_theme_mod('header-layout-type');
$header_menu_style  = inspiro_get_theme_mod('header-menu-style');

?>
<div id="site-navigation" class="navbar">
	<div class="header-inner inner-wrap <?php echo sanitize_html_class($header_layout_type); ?> <?php echo sanitize_html_class($header_menu_style); ?>">

		<div class="header-logo-wrapper">
			<div class="custom-logo-link">

				<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr(get_option('custom_title_option')); ?>" class="custom-logo-text">
					<img src="https://www.ds-pedia.com/wp-content/uploads/2025/01/header-log.png" alt="">
				</a>

			</div>

		</div>

		<?php if (has_nav_menu('primary')) : ?>
			<div class="header-navigation-wrapper">
				<nav class="primary-menu-wrapper navbar-collapse collapse" aria-label="<?php echo esc_attr_x('Top Horizontal Menu', 'menu', 'inspiro'); ?>" role="navigation">
					<?php
					wp_nav_menu(
						array(
							'menu_class'     => 'nav navbar-nav dropdown sf-menu',
							'theme_location' => 'primary',
							'container'      => '',
						)
					);
					?>
				</nav>
			</div>
		<?php endif ?>

		<div class="header-widgets-wrapper">
			<?php if (is_active_sidebar('header_social')) : ?>
				<div class="header_social">
					<?php dynamic_sidebar('header_social'); ?>
				</div>
			<?php endif ?>

			<div id="sb-search" class="sb-search" style="display: <?php echo esc_attr($search_display); ?>;">
				<?php get_template_part('template-parts/header/search', 'form'); ?>
			</div>

			<!-- 後で読む（ブックマーク）一覧リンク -->
			<a href="<?php echo esc_url(home_url('/reading-list/')); ?>" class="header-bookmark-link js-header-bookmark-link" aria-label="後で読む記事一覧" title="後で読む記事一覧">
				<i data-lucide="bookmark" class="header-bookmark-icon"></i>
				<span class="header-bookmark-badge js-bookmark-badge" style="display: none;">0</span>
			</a>

			<?php if (has_nav_menu('primary') || is_active_sidebar('sidebar')) : ?>
				<button type="button" class="navbar-toggle">
					<span class="screen-reader-text"><?php esc_html_e('Toggle sidebar &amp; navigation', 'inspiro'); ?></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<?php endif ?>
		</div>
	</div><!-- .inner-wrap -->
</div><!-- #site-navigation -->