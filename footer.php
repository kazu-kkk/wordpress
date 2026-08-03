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

<footer id="colophon" class="site-footer-rich" role="contentinfo">
	<div class="inner-wrap">
		<div class="footer-grid">
			<!-- 1. Brand & SNS -->
			<div class="footer-col footer-brand">
				<div class="footer-logo">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="logo" class="footer-main-logo">
				</div>
				<p class="footer-desc">
					デザイナーやクリエイターのための情報メディア。<br>
					UX / UIデザインからキャリアまで、役立つ情報を発信中。
				</p>
				<div class="footer-sns">
					<a href="https://x.com/dspediabyyuny" target="_blank" aria-label="X (Twitter)">
						<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
					</a>
					<a href="https://www.instagram.com/dspedia_byyuny?igsh=MW1kZnF1YWc5aHpoag%3D%3D&utm_source=qr" target="_blank" aria-label="Instagram">
						<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
					</a>
				</div>
			</div>

			<!-- 2. Categories -->
			<div class="footer-col footer-menu">
				<h3 class="footer-heading">Categories</h3>
				<nav>
					<ul>
						<?php
							// サイドバーと同じロジックを使用
							$exclude_ids = array(2, 4, 5); // 除外したいカテゴリのID

							$categories = get_categories(array(
								'exclude' => $exclude_ids,
								'orderby' => 'term_order', // Category Order and Taxonomy Terms Order用
								'order'   => 'ASC',
							));
							foreach( $categories as $category ) {
								echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
							}
						?>
					</ul>
				</nav>
			</div>

			<!-- 3. Recommend/Tags -->
			<div class="footer-col footer-tags">
				<h3 class="footer-heading">Topics</h3>
				<div class="tag-cloud">
					<?php
						$tags = get_tags(array(
							'orderby' => 'count',
							'order' => 'DESC',
							'number' => 15,
							'ignore_term_order' => true // プラグインのカスタム順序設定を無視して確実に記事数順にする
						));
						if ($tags) {
                           $count = 0;
                           foreach ( $tags as $tag ) {
							   if (strtolower($tag->name) === 'pickup') continue;
							   if ($count >= 10) break;
							   echo '<a href="' . get_tag_link( $tag->term_id ) . '" class="tag-link">#' . $tag->name . '</a>';
							   $count++;
						   }
                        }
					?>
				</div>
			</div>

			<!-- 4. Info -->
			<div class="footer-col footer-info">
				<h3 class="footer-heading">Information</h3>
				<nav>
					<ul>
						<li><a href="/about/">About</a></li>
						<li><a href="/privacy">Privacy Policy</a></li>
						<li><a href="/contact">Contact</a></li>
					</ul>
				</nav>
			</div>
		</div>

		<div class="footer-bottom">
			<p class="copyright">&copy; <?php echo date('Y'); ?> デザペディア. All Rights Reserved.</p>
		</div>
	</div><!-- .inner-wrap -->
</footer>

<!-- #colophon -->
</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>

</html>