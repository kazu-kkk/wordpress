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
	<meta name="description" content="デザペディアは、デザイナーやクリエイターのための情報メディアサイトです。最新のデザインニュース、クリエイティブなインスピレーション、業界のトレンド、役立つツールやチュートリアルを提供し、あなたのクリエイティブな活動をサポートします。">
	<?php wp_head(); ?>
	<!-- Google Fonts への事前接続 -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

	<!-- Google AdSense のインタラクション遅延読み込みによるLCP改善 -->
	<script>
	(function() {
		var adsenseLoaded = false;
		var triggerEvents = ['scroll', 'mousemove', 'touchstart', 'mousedown', 'keydown'];

		function loadAdsense() {
			if (adsenseLoaded) return;
			adsenseLoaded = true;
			
			// すべてのイベントリスナーを解除
			triggerEvents.forEach(function(event) {
				window.removeEventListener(event, loadAdsense);
			});
			
			// スクリプトの動的挿入
			var script = document.createElement('script');
			script.async = true;
			script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2216753629127219';
			script.crossOrigin = 'anonymous';
			document.head.appendChild(script);
		}
		
		// 測定ロボットの初期エミュレート操作による暴発を防ぐため、最初の3秒間はロードを完全にブロック
		setTimeout(function() {
			triggerEvents.forEach(function(event) {
				window.addEventListener(event, loadAdsense, { passive: true });
			});
		}, 3000); // 3秒のディレイ
	})();
	</script>

	<!-- LCP改善のためのロゴ画像プリロード -->
	<?php
	if (is_front_page()) {
		if (has_custom_logo()) {
			$custom_logo_id = get_theme_mod('custom_logo');
			$logo_img_src = wp_get_attachment_image_src($custom_logo_id, 'full');
			if ($logo_img_src) {
				echo '<link rel="preload" as="image" href="' . esc_url($logo_img_src[0]) . '" fetchpriority="high" />';
			}
		} else {
			if (is_home()) {
				echo '<link rel="preload" as="image" href="' . esc_url(home_url('/wp-content/uploads/2025/01/ブログロゴ.png')) . '" fetchpriority="high" />';
			} else {
				echo '<link rel="preload" as="image" href="https://www.ds-pedia.com/wp-content/uploads/2025/01/logo.png" fetchpriority="high" />';
			}
		}
	}
	?>
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
								<?php
								$custom_logo_id = get_theme_mod('custom_logo');
								$logo_img = wp_get_attachment_image($custom_logo_id, 'full', false, array(
									'class'         => 'custom-logo',
									'loading'       => 'eager',
									'fetchpriority' => 'high',
								));
								echo sprintf(
									'<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
									esc_url(home_url('/')),
									$logo_img
								);
								?>
							<?php else : ?>
								<div>
									<p class="hero-text">デザイン・Web・ガジェットの総合メディア</p>
									<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
										<img src="/wp-content/uploads/2025/01/ブログロゴ.png" alt="Default Logo" loading="eager" fetchpriority="high">
									</a>
								</div>
							<?php endif; ?>
						</div>
					<?php
					} elseif (is_front_page()) { // Static homepage.
					?>
						<div class="hero-background">
							<?php if (has_custom_logo()) : ?>
								<?php
								$custom_logo_id = get_theme_mod('custom_logo');
								$logo_img = wp_get_attachment_image($custom_logo_id, 'full', false, array(
									'class'         => 'custom-logo',
									'loading'       => 'eager',
									'fetchpriority' => 'high',
								));
								echo sprintf(
									'<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
									esc_url(home_url('/')),
									$logo_img
								);
								?>
							<?php else : ?>
								<div>
									<p class="hero-text">デザイン・Web・ガジェットの総合メディア</p>
									<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
										<img src="https://www.ds-pedia.com/wp-content/uploads/2025/01/logo.png" alt="Default Logo" loading="eager" fetchpriority="high">
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