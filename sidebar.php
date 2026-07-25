<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

?>

<aside id="side-nav" class="side-nav" tabindex="-1">
	<div class="side-nav__close-button">
		<button type="button" class="navbar-toggle">
			<span class="screen-reader-text"><?php esc_html_e( 'Toggle navigation', 'inspiro' ); ?></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div class="side-nav__scrollable-container">
		<div class="side-nav__wrap">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<nav class="mobile-menu-wrapper" aria-label="<?php echo esc_attr_x( 'Mobile Menu', 'menu', 'inspiro' ); ?>" role="navigation">
					<?php
						wp_nav_menu(
							array(
								'menu_class'     => 'nav navbar-nav',
								'theme_location' => 'primary',
								'container'      => '',
							) 
						);
					?>
				</nav>

                <!-- SP用追加コンテンツ (side-navから移植) -->
                <div class="mobile-side-nav-content">
                    <div id="custom-side-nav-mobile" style="padding-top: 20px; border-top: 1px solid #eee; margin-top: 20px;">
                        
                        <!-- プロフィールカード -->
                        <div class="profile-card">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/yuny_logo.png"
                                alt="プロフィール画像" class="profile-avatar">

                            <h2 class="profile-name">Yuny</h2>
                            <p class="profile-bio">UX・UI/グラフィックデザイナー<br>モーションや写真、映像や3Dも時々触ります</p>
                        </div>

                        <!-- 記事検索 -->
                        <div class="search-widget">
                            <h2 class="widget-title">SEARCH</h2>
                            <div class="search-container">
                                <input type="text" id="article-search-input-mobile" class="article-search-input-mobile" placeholder="キーワード検索..." autocomplete="off">
                                <ul id="search-suggestions-mobile" class="search-suggestions"></ul>
                            </div>
                        </div>

                        <!-- カテゴリ一覧 -->
                        <h2 class="widget-title">カテゴリ</h2>
                        <ul class="side-nav-category-list">
                            <?php
                            // 除外するカテゴリIDを指定
                            $exclude_ids = array(2, 4, 5); // 除外したいカテゴリのID

                            // カテゴリを取得してリスト表示（除外指定を追加）
                            $categories = get_categories(array(
                                'exclude' => $exclude_ids,
                                'orderby' => 'term_order', // Category Order and Taxonomy Terms Order用
                                'order'   => 'ASC',
                            ));
                            foreach ($categories as $category) {
                                echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                            }
                            ?>
                        </ul>

                        <!-- 広告エリア -->
                        <div class="ad-widget" style="margin-top: 30px; text-align: center;">
                            <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
                            <div id="im-1eae1085f45c43698d0a456571986d00">
                                <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                                <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1937823,type:"banner",display:"inline",elementid:"im-1eae1085f45c43698d0a456571986d00"})</script>
                            </div>
                        </div>
                    </div>
                </div>

			<?php endif ?>
		</div>
	</div>
</aside>
<div class="side-nav-overlay"></div>
