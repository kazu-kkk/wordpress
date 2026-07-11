<?php
/**
 * Template Name: Component Showcase
 * Description: A template to showcase all defined components for design system verification.
 */

// ==========================================================================
// 1. iframe内専用のプレビューレンダリングモード
// ==========================================================================
if (isset($_GET['component_preview'])) {
    // iframe内部でのWordPress管理バー（Admin Bar）の表示を強制的に無効化
    show_admin_bar(false);
    
    $comp_id = sanitize_text_field($_GET['component_preview']);
    ?>
    <!DOCTYPE html>
    <html lang="ja" style="background: transparent; margin-top: 0 !important; padding-top: 0 !important;">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Component Preview</title>
        <?php wp_head(); ?>
        <style>
            /* WordPress管理バーおよびインライン余白の徹底排除 */
            #wpadminbar {
                display: none !important;
            }
            html {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }
            /* iframe内専用の余白・レイアウトリセット */
            body {
                background-color: transparent !important;
                margin: 0;
                padding: 16px;
                font-family: "Verdana", "Hiragino Sans", "Meiryo", sans-serif;
                overflow: hidden; /* スクロールバーの二重出現を防止 */
            }
            /* 各要素の単体プレビュー向け微調整 */
            .hero-background {
                position: relative !important;
                min-height: auto !important;
            }
            .related-posts {
                margin: 0 auto !important;
                max-width: 100% !important;
            }
            .toc {
                margin: 0 !important;
                max-width: 100% !important;
            }
            .blogcard {
                margin: 0 !important;
                width: 100% !important;
            }
            .target-audience {
                margin: 0 !important;
                width: 100% !important;
            }
            .bento-wrapper {
                margin: 0 auto !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            .site-footer-rich {
                margin-top: 0 !important;
            }
            .wpcf7 {
                margin: 0 auto !important;
            }
        </style>
    </head>
    <body>
        <?php
        switch ($comp_id) {
            case 'c-button':
                echo '<a href="#" class="button" style="margin: 0 auto;" onclick="return false;">ボタンラベル</a>';
                break;

            case 'c-hero':
                ?>
                <div class="hero-background" style="position: relative; min-height: 200px; height: 200px;">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/yuny_logo.png" alt="Yuny" style="max-width: 250px; margin: 0 auto; display: block;">
                </div>
                <?php
                break;

            case 'c-title':
                ?>
                <h2 class="title-h2__text title-h2__text--pick-up" style="margin-bottom: 20px;">ピックアップ</h2>
                <h2 class="title-h2__text title-h2__text--new" style="margin-bottom: 20px;">新着記事</h2>
                <h2 class="title-h2__text title-h2__text--category" style="margin-bottom: 20px;">カテゴリ</h2>
                <h2 class="title-h2__text title-h2__text--popular-tag" style="margin-bottom: 20px;">人気タグ</h2>
                <h2 class="title-h2__text title-h2__text--sns">SNS</h2>
                <?php
                break;

            case 'c-tag':
                ?>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;">
                    <span class="tag">デザイン</span>
                    <a href="#" class="tag" onclick="return false;">WordPress</a>
                    <span class="tag">UI/UX</span>
                </div>
                <?php
                break;

            case 'c-article':
                ?>
                <div style="background: #fff; max-width: 100%; padding: 24px; border: 1px solid #eee; border-radius:12px;">
                    <div style="max-width: 720px; margin: 0 auto;">
                        <h1 class="article-title" style="margin-top:0;">魅力的なUIデザインを設計する手順とポイント</h1>
                        
                        <div class="article-sub" style="margin-bottom: 24px;">
                            <p class="article-sub-date">2026.05.31</p>
                            <ul>
                                <li><a href="#" onclick="return false;">UIデザイン</a></li>
                                <li><a href="#" onclick="return false;">設計</a></li>
                            </ul>
                        </div>

                        <div class="article-text">
                            <h2>1. 基本的な見出しの装飾（H2）</h2>
                            <p>見出し2の下部には太いグレーのボーダーが表示され、左側にはブランドブルーのショートアクセントラインが重ねられます。詳細は<a href="#" onclick="return false;">こちらのテスト用インラインリンク（ブランドブルー・下線付き）</a>からご確認ください。</p>
                            
                            <h3>1-1. 詳細を掘り下げるための見出し（H3）</h3>
                            <p>見出し3はシンプルなボールドテキストで、記事の流れを階層的に整理します。</p>

                            <blockquote class="wp-block-quote">
                                <p>デザインは単なる見た目ではなく、機能である。</p>
                                <cite>Steve Jobs</cite>
                            </blockquote>

                            <!-- テーブル -->
                            <div class="wp-block-table is-vertical-header" style="margin: 20px 0;">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>特徴</th>
                                            <th>ブランドブルー</th>
                                            <th>背景色</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>カラー値</td>
                                            <td>#2B53EC</td>
                                            <td>#F5F7FF</td>
                                        </tr>
                                        <tr>
                                            <td>主な役割</td>
                                            <td>アクセント・ボタン</td>
                                            <td>コンテンツ背景</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                break;

            case 'c-related':
                ?>
                <div class="related-posts" style="margin: 0; width:100%;">
                    <div class="related-posts__grid">
                        <a class="related-posts__card" href="#" onclick="return false;">
                            <div class="related-posts__thumb">
                                <div class="related-posts__thumb-fallback" style="height: 120px;"></div>
                            </div>
                            <div class="related-posts__body">
                                <p class="related-posts__date">2026.05.30</p>
                                <p class="related-posts__name">ユーザーを引きつけるUIカラー設計のベストプラクティス</p>
                            </div>
                        </a>
                        <a class="related-posts__card" href="#" onclick="return false;">
                            <div class="related-posts__thumb">
                                <div class="related-posts__thumb-fallback" style="height: 120px; background: linear-gradient(135deg, #2b53ec 0%, #aab4d0 100%);"></div>
                            </div>
                            <div class="related-posts__body">
                                <p class="related-posts__date">2026.05.29</p>
                                <p class="related-posts__name">Sass/SCSSの構成管理とインポート戦略を極める</p>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                break;

            case 'c-toc':
                ?>
                <div class="toc is-open" style="margin: 0; max-width: 100%;">
                    <div class="toc__header" onclick="this.parentElement.classList.toggle('is-open')">
                        <p class="toc__title">目次</p>
                        <span class="toc__toggle">閉じる / 開く</span>
                    </div>
                    <div class="toc__body" style="display: block;">
                        <ol class="toc__list">
                            <li class="toc__item toc__item--h2">
                                <a class="toc__link" href="#" onclick="return false;">1. UIデザインのトレンド</a>
                                <ol>
                                    <li class="toc__item toc__item--h3">
                                        <a class="toc__link" href="#" onclick="return false;">1-1. ベントグリッドの流行</a>
                                    </li>
                                    <li class="toc__item toc__item--h3">
                                        <a class="toc__link" href="#" onclick="return false;">1-2. ダークモード対応</a>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
                <?php
                break;

            case 'c-blogcard':
                ?>
                <div class="blogcard" style="margin: 0;">
                    <a href="#" onclick="return false;">
                        <div class="blogcard_thumbnail">
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #2b53ec 0%, #1e3bb5 100%);"></div>
                        </div>
                        <div class="blogcard_content">
                            <p class="blogcard_title">デザペディア — デザインやクリエイティブを学ぶ情報メディア</p>
                            <p class="blogcard_excerpt">UIデザインからWordPressテーマカスタマイズ、開発の効率化まで幅広く学べるデジタルマガジンです。</p>
                        </div>
                    </a>
                </div>
                <?php
                break;

            case 'c-checklist':
                ?>
                <ul class="checklist">
                    <li>ユーザー体験を意識した情報設計</li>
                    <li>統一されたカラーパレットと余白ルール</li>
                    <li>レスポンシブデザインによる完璧なモバイル最適化</li>
                </ul>
                <?php
                break;

            case 'c-audience':
                ?>
                <div class="target-audience" style="margin: 0;">
                    <p class="target-audience__title">こんな人におすすめ</p>
                    <ul class="target-audience__list">
                        <li class="target-audience__item">最新のフロントエンド/Webデザインに関心がある</li>
                        <li class="target-audience__item">WordPressの子テーマ構成を効率的に整理したい</li>
                        <li class="target-audience__item">一貫したUIデザインシステムを開発に適用したい</li>
                    </ul>
                </div>
                <?php
                break;

            case 'c-bento':
                ?>
                <div class="bento-wrapper" style="margin: 0; max-width: 100%;">
                    <div class="bento-grid" style="grid-auto-rows: 150px; gap: 16px;">
                        <div class="bento-card profile-card" style="padding: 16px;">
                            <div class="profile-content" style="gap: 16px;">
                                <div class="profile-image">
                                    <div style="width: 70px; height: 70px; border-radius: 50%; background: #ccc; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:24px; color:#fff;">Y</div>
                                </div>
                                <div class="profile-text">
                                    <h1 style="font-size: 20px; line-height: 1.2;">Yuny</h1>
                                    <p style="font-size: 13px;">UI/UX Designer</p>
                                </div>
                            </div>
                        </div>
                        <div class="bento-card social-card instagram" style="padding: 16px;">
                            <span>Instagram</span>
                        </div>
                        <div class="bento-card social-card youtube" style="padding: 16px;">
                            <span>YouTube</span>
                        </div>
                    </div>
                </div>
                <?php
                break;

            case 'c-footer':
                ?>
                <div class="site-footer-rich" style="padding: 20px 0; background: transparent; width:100%;">
                    <div class="footer-grid" style="margin-bottom: 20px;">
                        <div class="footer-col footer-brand">
                            <div class="footer-logo">
                                <span class="site-name">Yuny Theme</span>
                            </div>
                            <p class="footer-desc">美しいデザインと完璧なユーザー体験を提供するサイトです。</p>
                        </div>
                        <div class="footer-col footer-tags">
                            <div class="footer-heading">Tags</div>
                            <div class="tag-cloud">
                                <a href="#" onclick="return false;">UIデザイン</a>
                                <a href="#" onclick="return false;">WordPress</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                break;

            case 'c-contact':
                ?>
                <div class="wpcf7" style="max-width: 640px; margin: 0 auto; width:100%;">
                    <form action="#" method="post" onclick="event.preventDefault()">
                        <p>
                            <label> お名前 (必須)
                                <span class="wpcf7-form-control-wrap"><input type="text" name="your-name" placeholder=""></span>
                            </label>
                        </p>
                        <p>
                            <label> メールアドレス (必須)
                                <span class="wpcf7-form-control-wrap"><input type="email" name="your-email" placeholder=""></span>
                            </label>
                        </p>
                        <p>
                            <label> 件名
                                <span class="wpcf7-form-control-wrap"><input type="text" name="your-subject" placeholder=""></span>
                            </label>
                        </p>
                        <p>
                            <label> メッセージ内容 (任意)
                                <span class="wpcf7-form-control-wrap"><textarea name="your-message" placeholder=""></textarea></span>
                            </label>
                        </p>
                        <p style="margin-bottom: 0;">
                            <input type="submit" value="送信する">
                        </p>
                </div>
                <?php
                break;

            case 'c-header':
                ?>
                <div id="c-header-demo" class="home" style="padding: 20px; text-align: center;">
                    <p style="font-size: 13px; color: #666; margin-bottom: 16px; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;">
                        ※下のボックスは固定ヘッダーのデモです。ボタンを押してクラス切り替え（フェードイン）を確認できます。
                    </p>
                    <button class="showcase-ctrl-btn" onclick="document.getElementById('c-header-demo-box').classList.toggle('has-scrolled-fv');" style="margin-bottom: 20px; display: inline-flex; align-items: center; gap: 8px; justify-content: center; width: auto; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <i class="fa-solid fa-eye"></i> スクロール状態をトグル (has-scrolled-fv)
                    </button>
                    
                    <div id="c-header-demo-box" class="navbar" style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; background: none; background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 1%, rgba(0, 0, 0, 0) 100%); box-shadow: none; max-width: 600px; margin: 0 auto; transition: background 0.4s ease-out, box-shadow 0.4s ease-out;">
                        <div class="header-inner" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                            <div class="header-logo-wrapper" style="flex-shrink: 0;">
                                <div class="custom-logo-link">
                                    <a href="#" onclick="return false;" class="custom-logo-text">
                                        <img src="https://www.ds-pedia.com/wp-content/uploads/2025/01/header-log.png" alt="Logo" style="max-height: 35px; width: auto; display: inline-block;">
                                    </a>
                                </div>
                            </div>
                            <nav style="display: flex; gap: 20px; flex-shrink: 0; align-items: center;">
                                <span style="font-size: 14px; font-weight: bold; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif;">About</span>
                                <span style="font-size: 14px; font-weight: bold; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif;">Article</span>
                                <span style="font-size: 14px; font-weight: bold; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif;">Contact</span>
                            </nav>
                        </div>
                    </div>
                    
                    <style>
                        /* デモボックス内でのロゴ表示・非表示アニメーションの再現 */
                        #c-header-demo-box .header-logo-wrapper {
                            opacity: 0;
                            visibility: hidden;
                            transform: translateY(-5px);
                            transition: opacity 0.4s ease-out, visibility 0.4s ease-out, transform 0.4s ease-out;
                        }
                        #c-header-demo-box.has-scrolled-fv .header-logo-wrapper {
                            opacity: 1;
                            visibility: visible;
                            transform: translateY(0);
                        }
                        #c-header-demo-box.has-scrolled-fv {
                            background: rgba(0, 0, 0, 0.9) !important;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
                        }
                    </style>
                </div>
                <?php
                break;

            case 'c-share':
                ?>
                <div style="max-width: 600px; margin: 0 auto; padding: 20px 0;">
                    <?php get_template_part('template-parts/share-buttons'); ?>
                </div>
                <?php
                break;

            case 'c-pickup':
                ?>
                <section class="pickup" style="margin: 0; width: 100%;">
                    <ul class="pickup-list">
                        <li class="pickup-article">
                            <a href="#" class="pickup-article-link" onclick="return false;">
                                <div class="pickup-article__image" style="background: #ccc; height: 160px; display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size:12px; color:#999;">Dummy Image 1</span>
                                </div>
                                <div class="pickup-article-text">
                                    <p class="pickup-article-text__title">Dial-Up Delightとは？洗練されすぎた画面に疲れたZ世代が選ぶWebデザイン</p>
                                    <p class="pickup-article-text__date">2026.06.25</p>
                                    <div class="pickup-article-text__category">
                                        <span class="tag">デザイン</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="pickup-article">
                            <a href="#" class="pickup-article-link" onclick="return false;">
                                <div class="pickup-article__image" style="background: #ccc; height: 160px; display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size:12px; color:#999;">Dummy Image 2</span>
                                </div>
                                <div class="pickup-article-text">
                                    <p class="pickup-article-text__title">UI/UXカラー設計のベストプラクティスと実例紹介</p>
                                    <p class="pickup-article-text__date">2026.06.24</p>
                                    <div class="pickup-article-text__category">
                                        <span class="tag">UI/UX</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </section>
                <?php
                break;

            case 'c-new-list':
                ?>
                <section class="new" style="margin: 0; width: 100%;">
                    <div class="new-article-list">
                        <article class="new-article">
                            <a class="new-article-link" href="#" onclick="return false;">
                                <div class="new-article__image" style="background: #ccc; height: 160px; display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size:12px; color:#999;">Dummy Image 1</span>
                                </div>
                                <div class="new-article-text">
                                    <div class="new-article-text-inner">
                                        <p class="new-article-text__title">世界基準に学ぶ「伝わるデザイン」の基礎体力と、日常を変えるヒント</p>
                                        <p class="new-article-text__date">2026.06.25</p>
                                        <div class="new-article-text-meta">
                                            <div class="new-article-text__category">
                                                <span class="tag">画像・ガイドライン</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                        <article class="new-article">
                            <a class="new-article-link" href="#" onclick="return false;">
                                <div class="new-article__image" style="background: #ccc; height: 160px; display: flex; align-items: center; justify-content: center;">
                                    <span style="font-size:12px; color:#999;">Dummy Image 2</span>
                                </div>
                                <div class="new-article-text">
                                    <div class="new-article-text-inner">
                                        <p class="new-article-text__title">Sass/SCSSの構成管理とインポート戦略を極める</p>
                                        <p class="new-article-text__date">2026.06.24</p>
                                        <div class="new-article-text-meta">
                                            <div class="new-article-text__category">
                                                <span class="tag">ツール・実践導入</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    </div>
                </section>
                <?php
                break;

            case 'c-article-summary':
                ?>
                <div class="article-summary" style="margin: 0;">
                    <div class="article-summary__title">この記事の要約</div>
                    <ul class="article-summary__list">
                        <li class="article-summary__item">要約テキスト1：ここに記事の要約のポイントが入ります。</li>
                        <li class="article-summary__item">要約テキスト2：重要な要素を箇条書きで分かりやすく伝えます。</li>
                        <li class="article-summary__item">要約テキスト3：3つまでフリースペースで記述可能です。</li>
                    </ul>
                </div>
                <?php
                break;
            case 'c-trend-word':
                ?>
                <div class="trend-word-widget" style="margin: 0;">
                    <h2 class="widget-title">今日のトレンドワード</h2>
                    <div class="trend-word-card">
                        <h3 class="trend-word-title">グラスモーフィズム (Glassmorphism)</h3>
                        <p class="trend-word-desc">すりガラスのような半透明の背景と背景ぼかし(backdrop-filter)を活用したUIデザイン手法。奥行き感とモダンな印象を与えます。</p>
                        <a href="#" class="trend-word-link" onclick="return false;">この記事を読む</a>
                    </div>
                </div>
                <?php
                break;
        }
        ?>
        <?php wp_footer(); ?>
        <script>
            // iframe内部のサイズ変化を親ウインドウにリアルタイム通知する処理 (Auto-Resize用)
            function sendHeight() {
                try {
                    const height = document.body.scrollHeight;
                    window.parent.postMessage({
                        type: 'resize-iframe',
                        compId: '<?php echo esc_js($comp_id); ?>',
                        height: height
                    }, '*');
                } catch (e) {}
            }
            window.addEventListener('load', sendHeight);
            window.addEventListener('resize', sendHeight);
            // DOMの変更を監視して高さ変化に即応する
            const observer = new MutationObserver(sendHeight);
            observer.observe(document.body, { attributes: true, childList: true, subtree: true });
        </script>
    </body>
    </html>
    <?php
    exit;
}

// ==========================================================================
// 2. メインのショーケースダッシュボード画面
// ==========================================================================
?>

<!-- Google Fonts & FontAwesome for icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- ショーケース専用のスタイル -->
<style>
/* CSS Variables for design system */
:root {
    --sc-primary: #2b53ec;
    --sc-primary-hover: #1e3bb5;
    --sc-primary-light: #eef2ff;
    --sc-success: #10b981;
    --sc-dark: #0f172a;
    --sc-dark-light: #1e293b;
    --sc-text-main: #1e293b;
    --sc-text-sub: #64748b;
    --sc-bg-main: #f8fafc;
    --sc-bg-card: #ffffff;
    --sc-border: #e2e8f0;
    --sc-border-light: #f1f5f9;
    --sc-shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
    --sc-shadow-md: 0 10px 30px -10px rgba(15, 23, 42, 0.06);
    --sc-shadow-lg: 0 20px 40px -15px rgba(15, 23, 42, 0.1);
    --sc-radius-lg: 20px;
    --sc-radius-md: 12px;
    --sc-radius-sm: 8px;
    --sc-font-sans: 'Plus Jakarta Sans', 'Inter', "Hiragino Sans", "Meiryo", sans-serif;
    --sc-font-mono: 'Outfit', 'Courier New', monospace;
}

/* Base resets & layout */
.showcase-outer {
    background-color: var(--sc-bg-main);
    font-family: var(--sc-font-sans);
    color: var(--sc-text-main);
    padding: 40px 0 100px;
    min-height: 100vh;
    letter-spacing: -0.01em;
}

.showcase-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Header design */
.showcase-header {
    background: linear-gradient(135deg, var(--sc-dark) 0%, #1e1b4b 100%);
    padding: 60px 40px;
    border-radius: var(--sc-radius-lg);
    color: #fff;
    margin-bottom: 40px;
    box-shadow: var(--sc-shadow-lg);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.showcase-header::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(43, 83, 236, 0.15) 0%, rgba(0,0,0,0) 70%);
    border-radius: 50%;
    pointer-events: none;
}

.showcase-header h1 {
    font-family: 'Outfit', var(--sc-font-sans);
    font-size: 42px;
    font-weight: 800;
    margin: 0 0 16px;
    letter-spacing: -0.03em;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 16px;
}

.showcase-header h1 span.badge {
    font-size: 14px;
    font-weight: 600;
    background: rgba(43, 83, 236, 0.2);
    border: 1px solid rgba(43, 83, 236, 0.4);
    color: #a5b4fc;
    padding: 6px 14px;
    border-radius: 100px;
    letter-spacing: 0.05em;
    font-family: var(--sc-font-mono);
}

.showcase-header p {
    font-size: 17px;
    color: #94a3b8;
    margin: 0;
    line-height: 1.6;
    max-width: 700px;
}

/* 2 Column Layout */
.showcase-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 40px;
    align-items: start;
}

/* Sidebar Styling */
.showcase-sidebar {
    position: sticky;
    top: 120px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(226, 232, 240, 0.8);
    border-radius: var(--sc-radius-lg);
    padding: 24px;
    box-shadow: var(--sc-shadow-md);
    max-height: calc(100vh - 160px);
    overflow-y: auto;
}

.sidebar-title {
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    color: var(--sc-text-sub);
    letter-spacing: 0.1em;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--sc-border);
    display: flex;
    align-items: center;
    gap: 8px;
}

.showcase-nav {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.showcase-nav a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    font-size: 14px;
    font-weight: 600;
    color: var(--sc-text-sub);
    border-radius: var(--sc-radius-md);
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid transparent;
}

.showcase-nav a i {
    font-size: 14px;
    opacity: 0.7;
    width: 16px;
    text-align: center;
}

.showcase-nav a:hover {
    color: var(--sc-primary);
    background-color: var(--sc-primary-light);
}

.showcase-nav a.active {
    background-color: var(--sc-primary);
    color: #fff;
    box-shadow: 0 4px 12px rgba(43, 83, 236, 0.2);
    border-color: var(--sc-primary);
}

/* Sections & Cards */
.showcase-main {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.showcase-section {
    background: var(--sc-bg-card);
    border-radius: var(--sc-radius-lg);
    padding: 40px;
    box-shadow: var(--sc-shadow-md);
    border: 1px solid var(--sc-border);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    scroll-margin-top: 120px;
}

.showcase-section:hover {
    box-shadow: var(--sc-shadow-lg);
}

.showcase-section-title {
    font-family: 'Outfit', var(--sc-font-sans);
    font-size: 24px;
    font-weight: 800;
    color: var(--sc-dark);
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    letter-spacing: -0.02em;
}

.showcase-section-title span.title-group {
    display: flex;
    align-items: center;
    gap: 12px;
}

.showcase-section-title span.section-num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: var(--sc-primary-light);
    color: var(--sc-primary);
    font-size: 14px;
    font-weight: 700;
    font-family: var(--sc-font-mono);
}

.showcase-section-meta {
    font-family: var(--sc-font-mono);
    font-size: 12px;
    color: var(--sc-primary);
    background: var(--sc-primary-light);
    padding: 6px 12px;
    border-radius: 100px;
    font-weight: 700;
    border: 1px solid rgba(43, 83, 236, 0.15);
}

.showcase-desc {
    font-size: 15px;
    color: var(--sc-text-sub);
    margin: 0 0 28px;
    line-height: 1.7;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--sc-border-light);
}

/* PREVIEW WORKSPACE */
.showcase-preview-wrapper {
    position: relative;
    border: 1px solid var(--sc-border);
    border-radius: var(--sc-radius-lg);
    overflow: hidden;
    background: #ffffff;
    box-shadow: var(--sc-shadow-sm);
}

/* Control Bar */
.showcase-control-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--sc-bg-main);
    padding: 12px 20px;
    border-bottom: 1px solid var(--sc-border);
    flex-wrap: wrap;
    gap: 12px;
}

.showcase-control-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.showcase-control-label {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    color: var(--sc-text-sub);
    letter-spacing: 0.05em;
}

.showcase-ctrl-btn {
    background: #fff;
    border: 1px solid var(--sc-border);
    padding: 6px 12px;
    border-radius: var(--sc-radius-sm);
    font-size: 12px;
    font-weight: 700;
    color: var(--sc-text-main);
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: var(--sc-font-mono);
}

.showcase-ctrl-btn:hover {
    border-color: var(--sc-primary);
    color: var(--sc-primary);
}

.showcase-ctrl-btn.active {
    background: var(--sc-primary);
    border-color: var(--sc-primary);
    color: #fff;
}

/* BG buttons */
.showcase-bg-btn {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s ease;
    position: relative;
}

.showcase-bg-btn:hover {
    transform: scale(1.15);
}

.showcase-bg-btn.active {
    border-color: var(--sc-primary);
    box-shadow: 0 0 0 2px rgba(43, 83, 236, 0.2);
}

.showcase-bg-btn::after {
    content: "";
    position: absolute;
    inset: 2px;
    border-radius: 50%;
}

.showcase-bg-btn[data-bg="default"]::after { background: linear-gradient(135deg, #fff 50%, #f1f5f9 50%); }
.showcase-bg-btn[data-bg="white"]::after { background: #ffffff; }
.showcase-bg-btn[data-bg="gray"]::after { background: #f8fafc; }
.showcase-bg-btn[data-bg="dark"]::after { background: #1a1a1a; }

/* Code toggle button */
.showcase-code-toggle {
    background: transparent;
    border: 1px solid var(--sc-text-sub);
    color: var(--sc-text-main);
    padding: 6px 12px;
    border-radius: var(--sc-radius-sm);
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.showcase-code-toggle:hover {
    background: var(--sc-dark);
    color: #fff;
    border-color: var(--sc-dark);
}

.showcase-code-toggle.active {
    background: var(--sc-dark);
    color: #fff;
    border-color: var(--sc-dark);
}

/* Preview Box (Iframe Container) */
.showcase-preview-box {
    padding: 0; /* paddingを排除しiframe自身で管理させる */
    background: #f8fafc;
    min-height: 100px;
    transition: max-width 0.4s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s ease;
    margin: 0 auto;
    max-width: 100%;
    position: relative;
    overflow: hidden;
}

.showcase-iframe {
    width: 100%;
    border: none;
    display: block;
    background: transparent;
    transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 0 auto;
}

/* Responsive Simulated Width Classes for iframe */
.width-tablet {
    max-width: 768px;
    border-left: 1px dashed var(--sc-border);
    border-right: 1px dashed var(--sc-border);
}

.width-mobile {
    max-width: 375px;
    border-left: 1px dashed var(--sc-border);
    border-right: 1px dashed var(--sc-border);
}

/* CODE BOX WITH ACCORDION */
.showcase-code-box {
    background: var(--sc-dark);
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.showcase-code-box.is-open {
    max-height: 600px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.showcase-code-box pre {
    margin: 0;
    padding: 24px;
    overflow-x: auto;
    font-family: var(--sc-font-mono);
    font-size: 13px;
    color: #e2e8f0;
    line-height: 1.6;
    background: transparent;
    border: none;
}

.showcase-code-box::before {
    content: "HTML";
    position: absolute;
    top: 12px;
    right: 20px;
    font-family: var(--sc-font-mono);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.1em;
    color: rgba(255,255,255,0.3);
}

.copy-btn {
    position: absolute;
    bottom: 16px;
    right: 16px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: var(--sc-radius-sm);
    font-size: 11px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: var(--sc-font-mono);
}

.copy-btn:hover {
    background: var(--sc-primary);
    border-color: var(--sc-primary);
    box-shadow: 0 4px 12px rgba(43, 83, 236, 0.3);
}

/* DESIGN TOKENS GRID */
.tokens-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.token-card {
    border: 1px solid var(--sc-border-light);
    border-radius: var(--sc-radius-md);
    padding: 20px;
    background: var(--sc-bg-main);
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.token-color-preview {
    height: 120px;
    border-radius: var(--sc-radius-sm);
    border: 1px solid var(--sc-border);
    position: relative;
    box-shadow: var(--sc-shadow-sm);
}

.token-color-preview.brand { background-color: #2B53EC; }
.token-color-preview.brand-palette-1 { background-color: #180074; }
.token-color-preview.brand-palette-2 { background-color: #0f00a0; }
.token-color-preview.brand-palette-3 { background-color: #325df7; }
.token-color-preview.brand-palette-4 { background-color: #77b1ff; }
.token-color-preview.brand-palette-5 { background-color: #a0deff; }
.token-color-preview.bg-light { background-color: #F5F7FF; }
.token-color-preview.bg-dark { background-color: #1a1a1a; }
.token-color-preview.text-main { background-color: #333333; }
.token-color-preview.text-sub { background-color: #666666; }
.token-color-preview.border-light { background-color: #D6DCFA; }

.token-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.token-name {
    font-size: 15px;
    font-weight: 700;
    color: var(--sc-dark);
}

.token-value {
    font-family: var(--sc-font-mono);
    font-size: 13px;
    color: var(--sc-primary);
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.token-value:hover {
    text-decoration: underline;
}

/* TYPOGRAPHY TABLE */
.tokens-typo-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.tokens-typo-table th, .tokens-typo-table td {
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid var(--sc-border-light);
}

.tokens-typo-table th {
    font-weight: 700;
    color: var(--sc-dark);
    font-size: 14px;
}

.tokens-typo-table td {
    font-size: 14px;
}

.typo-spec {
    font-family: var(--sc-font-mono);
    font-size: 12px;
    color: var(--sc-text-sub);
}

.typo-preview-h2 {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}
.typo-preview-h3 {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
}
.typo-preview-body {
    font-size: 16px;
    margin: 0;
}

/* MOBILE FLOATING MENU */
.mobile-nav-toggle {
    display: none;
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--sc-primary);
    color: #fff;
    border: none;
    box-shadow: 0 4px 20px rgba(43, 83, 236, 0.4);
    z-index: 9999;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.mobile-nav-toggle:hover {
    transform: scale(1.1);
}

.mobile-overlay-menu {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.9);
    z-index: 9998;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mobile-overlay-menu.is-open {
    display: flex;
    opacity: 1;
}

.mobile-overlay-menu-content {
    background: var(--sc-bg-card);
    width: 85%;
    max-width: 360px;
    max-height: 80vh;
    border-radius: var(--sc-radius-lg);
    padding: 30px 24px;
    box-shadow: var(--sc-shadow-lg);
    overflow-y: auto;
    transform: scale(0.9);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.mobile-overlay-menu.is-open .mobile-overlay-menu-content {
    transform: scale(1);
}

.mobile-overlay-menu-content .showcase-nav {
    gap: 8px;
}

/* RESPONSIVE DESIGN */
@media screen and (max-width: 1024px) {
    .showcase-layout {
        grid-template-columns: 1fr;
    }
    .showcase-sidebar {
        display: none;
    }
    .mobile-nav-toggle {
        display: flex;
    }
}

@media screen and (max-width: 768px) {
    .showcase-outer {
        padding: 20px 0 60px;
    }
    .showcase-header {
        padding: 40px 24px;
        margin-bottom: 24px;
    }
    .showcase-header h1 {
        font-size: 32px;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    .showcase-section {
        padding: 20px;
        margin-bottom: 24px;
    }
    .showcase-preview-box {
        padding: 0;
    }
    .showcase-section-title span.section-num {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }
    .showcase-control-bar {
        padding: 10px 16px;
    }
}
</style>

<div class="showcase-outer">
    <div class="showcase-container">
        <!-- Header -->
        <div class="showcase-header">
            <h1>Yuny Component Showcase <span class="badge">v2.1</span></h1>
            <p>WordPressテーマ「inspiro-child」のために設計・開発された美しいUIコンポーネントシステム。プレビューにiframe方式を採用し、メディアクエリ（レスポンシブ崩れ）のリアルな動作検証が可能になりました。</p>
        </div>

        <div class="showcase-layout">
            <!-- Sidebar Navigation (Desktop) -->
            <aside class="showcase-sidebar">
                <div class="sidebar-title">
                    <i class="fa-solid fa-layer-group"></i> Design System
                </div>
                <div class="showcase-nav">
                    <a href="#tokens" class="active"><i class="fa-solid fa-palette"></i> 0. Design Tokens</a>
                    <a href="#c-button"><i class="fa-solid fa-square-caret-right"></i> 1. Button</a>
                    <a href="#c-hero"><i class="fa-solid fa-rectangle-ad"></i> 2. Hero (FV)</a>
                    <a href="#c-title"><i class="fa-solid fa-heading"></i> 3. H2 Title</a>
                    <a href="#c-tag"><i class="fa-solid fa-tags"></i> 4. Tag</a>
                    <a href="#c-article"><i class="fa-solid fa-file-lines"></i> 5. Article Elements</a>
                    <a href="#c-related"><i class="fa-solid fa-grip"></i> 6. Related Posts</a>
                    <a href="#c-toc"><i class="fa-solid fa-list-ol"></i> 7. TOC</a>
                    <a href="#c-blogcard"><i class="fa-solid fa-address-card"></i> 8. Blogcard</a>
                    <a href="#c-checklist"><i class="fa-solid fa-square-check"></i> 9. Checklist</a>
                    <a href="#c-audience"><i class="fa-solid fa-bullseye"></i> 10. Target Audience</a>
                    <a href="#c-bento"><i class="fa-solid fa-table-cells-large"></i> 11. Bento Grid</a>
                    <a href="#c-footer"><i class="fa-solid fa-window-minimize"></i> 12. Footer</a>
                    <a href="#c-contact"><i class="fa-solid fa-envelope"></i> 13. Contact Form</a>
                    <a href="#c-header"><i class="fa-solid fa-eye-slash"></i> 14. Header Logo Scroll</a>
                    <a href="#c-share"><i class="fa-solid fa-share-nodes"></i> 15. Share Buttons</a>
                    <a href="#c-pickup"><i class="fa-solid fa-grip-vertical"></i> 16. Pickup Articles</a>
                    <a href="#c-new-list"><i class="fa-solid fa-list"></i> 17. New Articles / Trends</a>
                    <a href="#c-article-summary"><i class="fa-solid fa-list-check"></i> 18. Article Summary</a>
                    <a href="#c-trend-word"><i class="fa-solid fa-lightbulb"></i> 19. Trend Word Widget</a>
                </div>
            </aside>

            <!-- Main Content Showcase -->
            <main class="showcase-main">

                <!-- 0. Design Tokens -->
                <section id="tokens" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">0</span>
                            <span>Design System Tokens</span>
                        </span>
                        <span class="showcase-section-meta">Global Palette</span>
                    </div>
                    <div class="showcase-desc">
                        テーマ「inspiro-child」で定義されているコアなデザイントークンです。カラーパレットやタイポグラフィの基本ルールを視覚化しています（カラーチップの値をクリックするとコピーできます）。
                    </div>
                    
                    <h3 style="font-size:18px; font-weight:700; margin-bottom:16px; color:var(--sc-dark);">Color Palette</h3>
                    <div class="tokens-grid">
                        <!-- Brand Blue -->
                        <div class="token-card">
                            <div class="token-color-preview brand"></div>
                            <div class="token-info">
                                <span class="token-name">ブランドブルー</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#2B53EC</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Brand Palette 1 -->
                        <div class="token-card">
                            <div class="token-color-preview brand-palette-1"></div>
                            <div class="token-info">
                                <span class="token-name">パレット 1</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#180074</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Brand Palette 2 -->
                        <div class="token-card">
                            <div class="token-color-preview brand-palette-2"></div>
                            <div class="token-info">
                                <span class="token-name">パレット 2</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#0f00a0</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Brand Palette 3 -->
                        <div class="token-card">
                            <div class="token-color-preview brand-palette-3"></div>
                            <div class="token-info">
                                <span class="token-name">パレット 3</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#325df7</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Brand Palette 4 -->
                        <div class="token-card">
                            <div class="token-color-preview brand-palette-4"></div>
                            <div class="token-info">
                                <span class="token-name">パレット 4</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#77b1ff</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Brand Palette 5 -->
                        <div class="token-card">
                            <div class="token-color-preview brand-palette-5"></div>
                            <div class="token-info">
                                <span class="token-name">パレット 5</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#a0deff</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Content BG -->
                        <div class="token-card">
                            <div class="token-color-preview bg-light"></div>
                            <div class="token-info">
                                <span class="token-name">背景 (コンテンツ用)</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#F5F7FF</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Dark BG -->
                        <div class="token-card">
                            <div class="token-color-preview bg-dark"></div>
                            <div class="token-info">
                                <span class="token-name">背景 (ダーク・フッター)</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#1A1A1A</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Main Text -->
                        <div class="token-card">
                            <div class="token-color-preview text-main"></div>
                            <div class="token-info">
                                <span class="token-name">テキスト (メイン)</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#333333</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Sub Text -->
                        <div class="token-card">
                            <div class="token-color-preview text-sub"></div>
                            <div class="token-info">
                                <span class="token-name">テキスト (サブ)</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#666666</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                        <!-- Border Light -->
                        <div class="token-card">
                            <div class="token-color-preview border-light"></div>
                            <div class="token-info">
                                <span class="token-name">ボーダー (薄青枠用)</span>
                                <span class="token-value" onclick="copyTokenText(this)" title="クリックでコピー"><code>#D6DCFA</code> <i class="fa-regular fa-copy"></i></span>
                            </div>
                        </div>
                    </div>

                    <h3 style="font-size:18px; font-weight:700; margin:32px 0 16px; color:var(--sc-dark);">Typography Hierarchy</h3>
                    <table class="tokens-typo-table">
                        <thead>
                            <tr>
                                <th style="width:25%;">要素 (階層)</th>
                                <th style="width:25%;">サイズ・スタイル</th>
                                <th style="width:50%;">実物サンプルプレビュー</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>記事見出し2 (H2)</strong></td>
                                <td><span class="typo-spec">28px (PC) / 22px (SP)<br>Font-Weight: 700</span></td>
                                <td><div class="typo-preview-h2" style="font-family:var(--sc-font-sans); color:var(--sc-dark);">基本的な見出しの装飾</div></td>
                            </tr>
                            <tr>
                                <td><strong>記事見出し3 (H3)</strong></td>
                                <td><span class="typo-spec">24px (PC) / 20px (SP)<br>Font-Weight: 700</span></td>
                                <td><div class="typo-preview-h3" style="font-family:var(--sc-font-sans); color:var(--sc-dark);">詳細を掘り下げるための見出し</div></td>
                            </tr>
                            <tr>
                                <td><strong>本文テキスト (Body)</strong></td>
                                <td><span class="typo-spec">16px (PC) / 14px (SP)<br>Font-Weight: 400</span></td>
                                <td><div class="typo-preview-body" style="font-family:\"Verdana\", \"Hiragino Sans\", \"Meiryo\", sans-serif; line-height:1.8; color:#333;">魅力的なUIデザインを設計する手順とポイントです。読みやすさを第一に考えたフォント選択。</div></td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <!-- 1. Button -->
                <section id="c-button" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">1</span>
                            <span>汎用ボタン (.button)</span>
                        </span>
                        <span class="showcase-section-meta">style_add.scss</span>
                    </div>
                    <div class="showcase-desc">
                        ブランドブルー背景に白文字の丸角ボタンです。ホバー時に背景色が反転し、枠線が表示されるスムーズなアニメーションが実装されています。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-button'); ?>" class="showcase-iframe" data-comp="c-button" style="height: 140px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;a href="#" class="button"&gt;ボタンラベル&lt;/a&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 2. Hero Background -->
                <section id="c-hero" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">2</span>
                            <span>ヒーロー背景 (.hero-background)</span>
                        </span>
                        <span class="showcase-section-meta">style_add.scss</span>
                    </div>
                    <div class="showcase-desc">
                        FV（ファーストビュー）用の背景エリアです。`position: sticky` でヘッダーの裏側に潜り込ませ、スクロール時にコンテンツが上に覆いかぶさる演出が施されています。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-hero'); ?>" class="showcase-iframe" data-comp="c-hero" style="height: 200px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;section class="hero-background"&gt;
  &lt;img src="path/to/logo.png" alt="Yuny"&gt;
&lt;/section&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 3. H2 Title -->
                <section id="c-title" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">3</span>
                            <span>セクション見出し (.title-h2__text)</span>
                        </span>
                        <span class="showcase-section-meta">style_add.scss</span>
                    </div>
                    <div class="showcase-desc">
                        左側にアイコンSVGを配置したH2タイトルです。モディファイアクラスで各アイコン画像（記事、形状、タグ、SNSなど）を擬似要素で表示します。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-title'); ?>" class="showcase-iframe" data-comp="c-title" style="height: 280px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;h2 class="title-h2__text title-h2__text--pick-up"&gt;ピックアップ&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--new"&gt;新着記事&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--category"&gt;カテゴリ&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--popular-tag"&gt;人気タグ&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--sns"&gt;SNS&lt;/h2&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 4. Tag -->
                <section id="c-tag" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">4</span>
                            <span>タグバッジ (.tag)</span>
                        </span>
                        <span class="showcase-section-meta">style_add.scss</span>
                    </div>
                    <div class="showcase-desc">
                        ブログのカテゴリやタグ表示に使用する小さなバッジ用スタイルです。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-tag'); ?>" class="showcase-iframe" data-comp="c-tag" style="height: 80px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;span class="tag"&gt;タグ名&lt;/span&gt;
&lt;a href="#" class="tag"&gt;タグ名&lt;/a&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 5. Article (Single) -->
                <section id="c-article" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">5</span>
                            <span>記事本文要素 (Single Page Elements)</span>
                        </span>
                        <span class="showcase-section-meta">_single.scss</span>
                    </div>
                    <div class="showcase-desc">
                        シングル記事ページで使用するタイトル、日付、見出し(H2: PC 28px/SP 22px, H3: PC 24px/SP 20px)、テーブル(PC版・縦ヘッダー)、およびインラインリンクなどの装飾です。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-article'); ?>" class="showcase-iframe" data-comp="c-article" style="height: 600px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;!-- 記事ヘッダー --&gt;
&lt;h1 class="article-title"&gt;記事タイトル&lt;/h1&gt;
&lt;div class="article-sub"&gt;
    &lt;p class="article-sub-date"&gt;2026.05.31&lt;/p&gt;
    &lt;ul&gt;
        &lt;li&gt;&lt;a href="#"&gt;タグ&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;!-- 本文内見出しとテーブル、リンク --&gt;
&lt;div class="article-text"&gt;
    &lt;h2&gt;見出し2（アクセント線付き）&lt;/h2&gt;
    &lt;p&gt;通常のテキスト中に表示される&lt;a href="#"&gt;インラインリンク（青色・下線付き）&lt;/a&gt;のスタイルです。&lt;/p&gt;
    &lt;h3&gt;見出し3&lt;/h3&gt;
    
    &lt;!-- 引用ブロック --&gt;
    &lt;blockquote class="wp-block-quote"&gt;
        &lt;p&gt;デザインは単なる見た目ではなく、機能である。&lt;/p&gt;
        &lt;cite&gt;Steve Jobs&lt;/cite&gt;
    &lt;/blockquote&gt;
    
    &lt;!-- 縦ヘッダーテーブル --&gt;
    &lt;div class="wp-block-table is-vertical-header"&gt;
        &lt;table&gt;
            &lt;thead&gt;
                &lt;tr&gt;
                    &lt;th&gt;ヘッダー&lt;/th&gt;
                    &lt;th&gt;値&lt;/th&gt;
                &lt;/tr&gt;
            &lt;/thead&gt;
            &lt;tbody&gt;
                &lt;tr&gt;
                    &lt;td&gt;左端(薄青縦ヘッダー)&lt;/td&gt;
                    &lt;td&gt;白セル&lt;/td&gt;
                &lt;/tr&gt;
            &lt;/tbody&gt;
        &lt;/table&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 6. Related Posts -->
                <section id="c-related" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">6</span>
                            <span>関連記事 (.related-posts)</span>
                        </span>
                        <span class="showcase-section-meta">_single.scss</span>
                    </div>
                    <div class="showcase-desc">
                        記事の下部に関連記事を表示する3カラムのグリッドカードです。ホバー時にカードが滑らかに浮き上がり、サムネイルがズームインします。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-related'); ?>" class="showcase-iframe" data-comp="c-related" style="height: 340px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;div class="related-posts"&gt;
  &lt;div class="related-posts__grid"&gt;
    &lt;a class="related-posts__card" href="#"&gt;
      &lt;div class="related-posts__thumb"&gt;
        &lt;img src="thumb.jpg" alt="画像"&gt;
      &lt;/div&gt;
      &lt;div class="related-posts__body"&gt;
        &lt;p class="related-posts__date"&gt;2026.05.30&lt;/p&gt;
        &lt;p class="related-posts__name"&gt;記事タイトル&lt;/p&gt;
      &lt;/div&gt;
    &lt;/a&gt;
  &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 7. TOC -->
                <section id="c-toc" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">7</span>
                            <span>目次 (.toc)</span>
                        </span>
                        <span class="showcase-section-meta">_toc.scss</span>
                    </div>
                    <div class="showcase-desc">
                        アコーディオン開閉式の美しい目次ボックスです。階層化に対応したリストスタイルと、アンカー到達時のフラッシュアニメーション機能が内蔵されています。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-toc'); ?>" class="showcase-iframe" data-comp="c-toc" style="height: 220px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;div class="toc is-open"&gt;
  &lt;div class="toc__header"&gt;
    &lt;p class="toc__title"&gt;目次&lt;/p&gt;
    &lt;span class="toc__toggle"&gt;閉じる&lt;/span&gt;
  &lt;/div&gt;
  &lt;div class="toc__body"&gt;
    &lt;ol class="toc__list"&gt;
      &lt;li class="toc__item toc__item--h2"&gt;
        &lt;a class="toc__link" href="#anchor"&gt;見出し2&lt;/a&gt;
        &lt;ol&gt;
          &lt;li class="toc__item toc__item--h3"&gt;
            &lt;a class="toc__link" href="#anchor-sub"&gt;見出し3&lt;/a&gt;
          &lt;/li&gt;
        &lt;/ol&gt;
      &lt;/li&gt;
    &lt;/ol&gt;
  &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 8. Blogcard -->
                <section id="c-blogcard" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">8</span>
                            <span>ブログカード (.blogcard)</span>
                        </span>
                        <span class="showcase-section-meta">_blogcard.scss</span>
                    </div>
                    <div class="showcase-desc">
                        記事本文内で関連記事などの内部リンクをリッチにアピールするためのブログカードです。サムネイルとタイトル・抜粋・ドメインを一体化してスマートに表現します。記事本文内のリンク下線（underline）の指定を受けないよう、下線が非表示に保護されています。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-blogcard'); ?>" class="showcase-iframe" data-comp="c-blogcard" style="height: 180px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;div class="blogcard"&gt;
  &lt;a href="#"&gt;
    &lt;div class="blogcard_thumbnail"&gt;
      &lt;img src="thumb.jpg" alt="サムネイル"&gt;
    &lt;/div&gt;
    &lt;div class="blogcard_content"&gt;
      &lt;p class="blogcard_title"&gt;記事タイトル&lt;/p&gt;
      &lt;p class="blogcard_excerpt"&gt;記事の抜粋文がここに入ります。&lt;/p&gt;
    &lt;/div&gt;
  &lt;/a&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 9. Checklist -->
                <section id="c-checklist" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">9</span>
                            <span>チェックリスト (ul.checklist)</span>
                        </span>
                        <span class="showcase-section-meta">_checklist.scss</span>
                    </div>
                    <div class="showcase-desc">
                        擬似要素を使用してブランドブルーのチェックマークを自動で付与する、見やすくスタイリッシュな箇条書きリストです。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-checklist'); ?>" class="showcase-iframe" data-comp="c-checklist" style="height: 180px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;ul class="checklist"&gt;
  &lt;li&gt;チェック項目1&lt;/li&gt;
  &lt;li&gt;チェック項目2&lt;/li&gt;
  &lt;li&gt;チェック項目3&lt;/li&gt;
&lt;/ul&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 10. Target Audience -->
                <section id="c-audience" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">10</span>
                            <span>対象読者ブロック (.target-audience)</span>
                        </span>
                        <span class="showcase-section-meta">_target-audience.scss</span>
                    </div>
                    <div class="showcase-desc">
                        記事の導入部などで「この記事がどんな人に向いているか」を明示するための、囲み枠コンポーネントです。ブルーのボーダーとSVGチェックアイコンが視認性を高めます。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-audience'); ?>" class="showcase-iframe" data-comp="c-audience" style="height: 240px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;div class="target-audience"&gt;
  &lt;p class="target-audience__title"&gt;こんな人におすすめ&lt;/p&gt;
  &lt;ul class="target-audience__list"&gt;
    &lt;li class="target-audience__item"&gt;項目テキスト1&lt;/li&gt;
    &lt;li class="target-audience__item"&gt;項目テキスト2&lt;/li&gt;
  &lt;/ul&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 11. Bento Grid -->
                <section id="c-bento" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">11</span>
                            <span>ベントグリッド (.bento-wrapper)</span>
                        </span>
                        <span class="showcase-section-meta">_bento.scss</span>
                    </div>
                    <div class="showcase-desc">
                        プロフィールページ用にデザインされた、カードが網の目のように組み合わさったグリッドレイアウトです。PCでは4カラム、SPでは2カラムに流動的に変化します。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-bento'); ?>" class="showcase-iframe" data-comp="c-bento" style="height: 380px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;div class="bento-wrapper"&gt;
  &lt;div class="bento-grid"&gt;
    &lt;!-- プロフィールカード (2x1) --&gt;
    &lt;div class="bento-card profile-card"&gt;
      &lt;div class="profile-content"&gt;
        &lt;div class="profile-image"&gt;&lt;img src="avatar.jpg" alt="Yuny"&gt;&lt;/div&gt;
        &lt;div class="profile-text"&gt;
          &lt;h1&gt;Yuny&lt;/h1&gt;
          &lt;p&gt;UI/UX Designer&lt;/p&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
    
    &lt;!-- 各ソーシャルカード (1x1) --&gt;
    &lt;a class="bento-card social-card instagram" href="#"&gt;...&lt;/a&gt;
    &lt;a class="bento-card social-card youtube" href="#"&gt;...&lt;/a&gt;
  &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 12. Footer -->
                <section id="c-footer" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">12</span>
                            <span>リッチフッター (.site-footer-rich)</span>
                        </span>
                        <span class="showcase-section-meta">_footer.scss</span>
                    </div>
                    <div class="showcase-desc">
                        背景色 `#1a1a1a` のシックなダークモードフッターです。ブランド紹介、ナビゲーション、丸角のスタイリッシュなタグクラウドなどが4カラムに整理されています。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-footer'); ?>" class="showcase-iframe" data-comp="c-footer" style="height: 320px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;footer class="site-footer-rich"&gt;
  &lt;div class="inner-wrap"&gt;
    &lt;div class="footer-grid"&gt;
      &lt;!-- 左端: ブランド・紹介 --&gt;
      &lt;div class="footer-col footer-brand"&gt;
        &lt;div class="footer-logo"&gt;
          &lt;span class="site-name"&gt;Yuny Theme&lt;/span&gt;
        &lt;/div&gt;
        &lt;p class="footer-desc"&gt;サイト紹介のテキスト...&lt;/p>
      &lt;/div&gt;
      
      &lt;!-- タグクラウド --&gt;
      &lt;div class="footer-col footer-tags"&gt;
        &lt;div class="footer-heading"&gt;Tags&lt;/div&gt;
        &lt;div class="tag-cloud"&gt;
          &lt;a href="#"&gt;タグ名1&lt;/a&gt;
          &lt;a href="#"&gt;タグ名2&lt;/a&gt;
        &lt;/div&gt;
      &lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;
&lt;/footer&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 13. Contact Form -->
                <section id="c-contact" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">13</span>
                            <span>お問い合わせフォーム (.wpcf7)</span>
                        </span>
                        <span class="showcase-section-meta">_contact-form.scss</span>
                    </div>
                    <div class="showcase-desc">
                        Contact Form 7 と連携して動作する、実装済みのお問い合わせフォームデザインです。入力フィールドのフォーカス時にアクセントカラーの枠線と淡いシャドウが広がる演出が施されています。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-contact'); ?>" class="showcase-iframe" data-comp="c-contact" style="height: 600px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;!-- WordPress内でContact Form 7プラグインを使用して自動生成 --&gt;
&lt;div class="wpcf7"&gt;
  &lt;form&gt;
    &lt;p&gt;
      &lt;label&gt; お名前 (必須)
        &lt;span class="wpcf7-form-control-wrap"&gt;&lt;input type="text" name="your-name"&gt;&lt;/span&gt;
      &lt;/label&gt;
    &lt;/p&gt;
    &lt;p&gt;
      &lt;label&gt; メールアドレス (必須)
        &lt;span class="wpcf7-form-control-wrap"&gt;&lt;input type="email" name="your-email"&gt;&lt;/span&gt;
      &lt;/label&gt;
    &lt;/p&gt;
    &lt;p&gt;
      &lt;label&gt; 件名
        &lt;span class="wpcf7-form-control-wrap"&gt;&lt;input type="text" name="your-subject"&gt;&lt;/span&gt;
      &lt;/label&gt;
    &lt;/p&gt;
    &lt;p&gt;
      &lt;label&gt; メッセージ内容 (任意)
        &lt;span class="wpcf7-form-control-wrap"&gt;&lt;textarea name="your-message"&gt;&lt;/textarea&gt;&lt;/span&gt;
      &lt;/label&gt;
    &lt;/p&gt;
    &lt;p&gt;
      &lt;input type="submit" value="送信する"&gt;
    &lt;/p>
  &lt;/form&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 14. Header Logo Scroll -->
                <section id="c-header" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">14</span>
                            <span>固定ヘッダーロゴ表示制御 (.has-scrolled-fv)</span>
                        </span>
                        <span class="showcase-section-meta">_header.scss</span>
                    </div>
                    <div class="showcase-desc">
                        TOPページ初期表示時のヘッダー左ロゴ非表示および、FV（ファーストビュー）スクロール後のフェードイン効果です。トグルボタンを押して、フェードインの滑らかなアニメーションをプレビューできます。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-header'); ?>" class="showcase-iframe" data-comp="c-header" style="height: 240px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;!-- TOPページのbodyに.has-scrolled-fvクラスが付与されることで、ロゴがフェードインし、ヘッダーに黒い帯（背景）が表示されます --&gt;
&lt;body class="home has-scrolled-fv"&gt;
  &lt;header id="masthead" class="site-header"&gt;
    &lt;div class="header-logo-wrapper"&gt;
      &lt;!-- ロゴマーク --&gt;
    &lt;/div&gt;
  &lt;/header&gt;
&lt;/body&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 15. Share Buttons -->
                <section id="c-share" class="showcase-section">
                    <div class="showcase-section-title">
                        <span class="title-group">
                            <span class="section-num">15</span>
                            <span>記事シェアボタン (.c-share)</span>
                        </span>
                        <span class="showcase-section-meta">_share.scss</span>
                    </div>
                    <div class="showcase-desc">
                        各種SNSへの共有リンク（X, Facebook, LINE）とクリップボードコピーボタンです。通常時はシンプルな細枠の白背景ですが、ホバー時に各SNSのブランドカラーへ滑らかに変化します。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-share'); ?>" class="showcase-iframe" data-comp="c-share" style="height: 160px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;!-- 記事詳細ページ（single.php）のタイトル下および本文下に表示されます --&gt;
&lt;div class="c-share"&gt;
    &lt;p class="c-share__title"&gt;SHARE&lt;/p&gt;
    &lt;ul class="c-share__list"&gt;
        &lt;li class="c-share__item c-share__item--twitter"&gt;
            &lt;a href="..." target="_blank" rel="nofollow noopener" aria-label="Xでシェア"&gt;
                &lt;svg class="c-share__icon"&gt;...&lt;/svg&gt;
            &lt;/&gt;
        &lt;/li&gt;
        &lt;!-- 他のSNSリンク... --&gt;
        &lt;li class="c-share__item c-share__item--copy"&gt;
            &lt;button class="c-share__copy-btn js-share-copy" data-url="[URL]" aria-label="URLをコピー"&gt;
                &lt;svg class="c-share__icon"&gt;...&lt;/svg&gt;
            &lt;/button&gt;
        &lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 16. Pickup Articles -->
                <section id="c-pickup" class="showcase-section">
                    <div class="showcase-section-title">
                          <span class="title-group">
                              <span class="section-num">16</span>
                              <span>ピックアップ記事リスト (.pickup)</span>
                          </span>
                        <span class="showcase-section-meta">style_add.scss</span>
                    </div>
                    <div class="showcase-desc">
                        おすすめ記事をカルーセル形式で表示するコンポーネントです。SP表示時はトバログ風の横スクロール（スワイプ）レイアウトとなり、左右の負のマージンによって画面端までスクロール領域が広がります。また、SP表示でも白背景・黒文字デザインが維持されます。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-pickup'); ?>" class="showcase-iframe" data-comp="c-pickup" style="height: 380px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;!-- TOPページのメインコンテンツエリア上部（フル幅）に配置されます --&gt;
&lt;section class="pickup"&gt;
    &lt;h2 class="title-h2__text title-h2__text--pick-up"&gt;ピックアップ&lt;/h2&gt;
    &lt;ul class="pickup-list"&gt;
        &lt;li class="pickup-article"&gt;
            &lt;a href="#" class="pickup-article-link"&gt;
                &lt;div class="pickup-article__image"&gt;
                    &lt;img src="..." alt="Image"&gt;
                &lt;/div&gt;
                &lt;div class="pickup-article-text"&gt;
                    &lt;p class="pickup-article-text__title"&gt;記事タイトル&lt;/p&gt;
                    &lt;p class="pickup-article-text__date"&gt;2026.06.25&lt;/p&gt;
                    &lt;div class="pickup-article-text__category"&gt;
                        &lt;span class="tag"&gt;カテゴリ&lt;/span&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/a&gt;
        &lt;/li&gt;
    &lt;/ul&gt;
&lt;/section&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 17. New Articles / Trends -->
                <section id="c-new-list" class="showcase-section">
                    <div class="showcase-section-title">
                          <span class="title-group">
                              <span class="section-num">17</span>
                              <span>最新の投稿 / トレンド (.new-article-list)</span>
                          </span>
                        <span class="showcase-section-meta">style_add.scss</span>
                    </div>
                    <div class="showcase-desc">
                        最新の投稿やカテゴリ別トレンド記事を表示するコンポーネントです。SP表示時はトバログ風の横スクロール（スワイプ）レイアウトとなり、左右の負のマージンによって画面端までスクロール領域が広がります。また、SP表示でもカード型（白背景・黒文字）デザインが維持されます。
                    </div>
                    <div class="showcase-preview-wrapper">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn active" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-new-list'); ?>" class="showcase-iframe" data-comp="c-new-list" style="height: 380px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;!-- 2カラムエリアのメインコンテンツエリア内に配置されます --&gt;
&lt;div class="new-article-list"&gt;
    &lt;article class="new-article"&gt;
        &lt;a href="#" class="new-article-link"&gt;
            &lt;div class="new-article__image"&gt;
                &lt;img src="..." alt="Image"&gt;
            &lt;/div&gt;
            &lt;div class="new-article-text"&gt;
                &lt;div class="new-article-text-inner"&gt;
                    &lt;p class="new-article-text__title"&gt;記事タイトル&lt;/p&gt;
                    &lt;p class="new-article-text__date"&gt;2026.06.25&lt;/p&gt;
                    &lt;div class="new-article-text-meta"&gt;
                        &lt;div class="new-article-text__category"&gt;
                            &lt;span class="tag"&gt;カテゴリ&lt;/span&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                &lt;/div&gt;
            &lt;/div&gt;
        &lt;/a&gt;
    &lt;/article&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 18. Article Summary -->
                <section id="c-article-summary" class="showcase-section">
                    <h2 class="showcase-section-title">
                        <span class="title-group"><span class="section-num">18</span> Article Summary</span>
                        <span class="showcase-section-meta">_article-summary.scss / functions.php</span>
                    </h2>
                    <p class="showcase-desc">
                        記事冒頭に挿入する、記事内容の要約を記載するためのコンポーネントです。[article_summary point1="要約1" point2="要約2" point3="要約3"] というショートコードで呼び出し、指定したテキストのみ箇条書き（トルツメ）で表示されます。
                    </p>

                    <div class="showcase-preview-wrapper" data-comp="c-article-summary">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-article-summary'); ?>" class="showcase-iframe" data-comp="c-article-summary" style="height: 200px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">[article_summary point1="要約テキスト1：ここに記事の要約のポイントが入ります。" point2="要約テキスト2：重要な要素を箇条書きで分かりやすく伝えます。" point3="要約テキスト3：3つまでフリースペースで記述可能です。"]</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

                <!-- 19. Trend Word Widget -->
                <section id="c-trend-word" class="showcase-section">
                    <h2 class="showcase-section-title">
                        <span class="title-group"><span class="section-num">19</span> Trend Word Widget</span>
                        <span class="showcase-section-meta">_side-nav.scss / side-nav.php</span>
                    </h2>
                    <p class="showcase-desc">TOPページのサイドバー最下部に表示される、今日のデザイントレンドをランダムで表示するウィジェットです。</p>
                    
                    <div class="showcase-preview-wrapper" data-comp="c-trend-word">
                        <div class="showcase-control-bar">
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">Width:</span>
                                <button class="showcase-ctrl-btn" data-width="100%">PC</button>
                                <button class="showcase-ctrl-btn" data-width="768px">Tablet</button>
                                <button class="showcase-ctrl-btn" data-width="375px">Mobile</button>
                            </div>
                            <div class="showcase-control-group">
                                <span class="showcase-control-label">BG:</span>
                                <button class="showcase-bg-btn active" data-bg="default"></button>
                                <button class="showcase-bg-btn" data-bg="white"></button>
                                <button class="showcase-bg-btn" data-bg="gray"></button>
                                <button class="showcase-bg-btn" data-bg="dark"></button>
                            </div>
                            <button class="showcase-code-toggle"><i class="fa-solid fa-code"></i> Show Code</button>
                        </div>
                        <div class="showcase-preview-box">
                            <iframe src="<?php echo add_query_arg('component_preview', 'c-trend-word'); ?>" class="showcase-iframe" data-comp="c-trend-word" style="height: 250px;"></iframe>
                        </div>
                        <div class="showcase-code-box">
                            <pre><code class="html-code">&lt;div class="trend-word-widget"&gt;
    &lt;h2 class="widget-title"&gt;今日のトレンドワード&lt;/h2&gt;
    &lt;div class="trend-word-card"&gt;
        &lt;h3 class="trend-word-title"&gt;ワード&lt;/h3&gt;
        &lt;p class="trend-word-desc"&gt;説明文&lt;/p&gt;
        &lt;a href="#" class="trend-word-link"&gt;この記事を読む&lt;/a&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-copy"></i> COPY</button>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>
</div>

<!-- Mobile Floating Nav Button -->
<button class="mobile-nav-toggle" id="mobileNavBtn" title="メニュー表示">
    <i class="fa-solid fa-compass"></i>
</button>

<!-- Mobile Overlay Navigation Menu -->
<div class="mobile-overlay-menu" id="mobileOverlayMenu">
    <div class="mobile-overlay-menu-content">
        <h3 style="font-size:16px; font-weight:800; margin-bottom:20px; text-transform:uppercase; color:var(--sc-dark); display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-layer-group" style="color:var(--sc-primary)"></i> Showcase Menu
        </h3>
        <div class="showcase-nav">
            <a href="#tokens" class="active"><i class="fa-solid fa-palette"></i> 0. Design Tokens</a>
            <a href="#c-button"><i class="fa-solid fa-square-caret-right"></i> 1. Button</a>
            <a href="#c-hero"><i class="fa-solid fa-rectangle-ad"></i> 2. Hero (FV)</a>
            <a href="#c-title"><i class="fa-solid fa-heading"></i> 3. H2 Title</a>
            <a href="#c-tag"><i class="fa-solid fa-tags"></i> 4. Tag</a>
            <a href="#c-article"><i class="fa-solid fa-file-lines"></i> 5. Article Elements</a>
            <a href="#c-related"><i class="fa-solid fa-grip"></i> 6. Related Posts</a>
            <a href="#c-toc"><i class="fa-solid fa-list-ol"></i> 7. TOC</a>
            <a href="#c-blogcard"><i class="fa-solid fa-address-card"></i> 8. Blogcard</a>
            <a href="#c-checklist"><i class="fa-solid fa-square-check"></i> 9. Checklist</a>
            <a href="#c-audience"><i class="fa-solid fa-bullseye"></i> 10. Target Audience</a>
            <a href="#c-bento"><i class="fa-solid fa-table-cells-large"></i> 11. Bento Grid</a>
            <a href="#c-footer"><i class="fa-solid fa-window-minimize"></i> 12. Footer</a>
            <a href="#c-contact"><i class="fa-solid fa-envelope"></i> 13. Contact Form</a>
            <a href="#c-header"><i class="fa-solid fa-eye-slash"></i> 14. Header Logo Scroll</a>
            <a href="#c-share"><i class="fa-solid fa-share-nodes"></i> 15. Share Buttons</a>
            <a href="#c-pickup"><i class="fa-solid fa-grip-vertical"></i> 16. Pickup Articles</a>
            <a href="#c-new-list"><i class="fa-solid fa-list"></i> 17. New Articles / Trends</a>
            <a href="#c-article-summary"><i class="fa-solid fa-list-check"></i> 18. Article Summary</a>
            <a href="#c-trend-word"><i class="fa-solid fa-lightbulb"></i> 19. Trend Word Widget</a>
        </div>
    </div>
</div>

<!-- JavaScript Logic -->
<script>
// 1. Copy Code helper
function copyCode(button) {
    const pre = button.previousElementSibling;
    const code = pre.querySelector('code').innerText;
    
    navigator.clipboard.writeText(code).then(() => {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-check"></i> COPIED!';
        button.style.backgroundColor = 'var(--sc-success)';
        button.style.borderColor = 'var(--sc-success)';
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.style.backgroundColor = '';
            button.style.borderColor = '';
        }, 1500);
    }).catch(err => {
        alert('コピーに失敗しました: ', err);
    });
}

// 2. Copy Token helper
function copyTokenText(element) {
    const codeElem = element.querySelector('code');
    const text = codeElem.innerText;
    
    navigator.clipboard.writeText(text).then(() => {
        const icon = element.querySelector('i');
        icon.className = 'fa-solid fa-check';
        icon.style.color = 'var(--sc-success)';
        
        const originalText = codeElem.style.color;
        codeElem.style.color = 'var(--sc-success)';
        
        setTimeout(() => {
            icon.className = 'fa-regular fa-copy';
            icon.style.color = '';
            codeElem.style.color = originalText;
        }, 1200);
    }).catch(err => {
        console.error('トークンのコピーに失敗しました:', err);
    });
}

// 3. Width Controller & Responsive Simulator (iframe resizing)
document.querySelectorAll('.showcase-ctrl-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const parentWrapper = this.closest('.showcase-preview-wrapper');
        const previewBox = parentWrapper.querySelector('.showcase-preview-box');
        const iframe = parentWrapper.querySelector('.showcase-iframe');
        const width = this.getAttribute('data-width');
        
        // Remove active from sibling buttons
        this.parentElement.querySelectorAll('.showcase-ctrl-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Reset classes
        previewBox.classList.remove('width-tablet', 'width-mobile');
        
        // Apply classes which constrain iframe width
        if (width === '768px') {
            previewBox.classList.add('width-tablet');
        } else if (width === '375px') {
            previewBox.classList.add('width-mobile');
        }
        
        // iframe内部にサイズが変更されたことを伝えるためのトリガー
        setTimeout(() => {
            if (iframe.contentWindow) {
                iframe.contentWindow.dispatchEvent(new Event('resize'));
            }
        }, 450); // アニメーション時間(400ms)待ってからリサイズを通知
    });
});

// 4. BG Changer
document.querySelectorAll('.showcase-bg-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const parentWrapper = this.closest('.showcase-preview-wrapper');
        const previewBox = parentWrapper.querySelector('.showcase-preview-box');
        const iframe = parentWrapper.querySelector('.showcase-iframe');
        const bg = this.getAttribute('data-bg');
        
        // Remove active from siblings
        this.parentElement.querySelectorAll('.showcase-bg-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Apply background class to preview box wrapper
        previewBox.classList.remove('is-dark');
        previewBox.style.backgroundColor = '';
        
        let iframeBg = 'transparent';
        let isDarkMode = false;
        
        if (bg === 'white') {
            previewBox.style.backgroundColor = '#ffffff';
            iframeBg = '#ffffff';
        } else if (bg === 'gray') {
            previewBox.style.backgroundColor = '#f8fafc';
            iframeBg = '#f8fafc';
        } else if (bg === 'dark') {
            previewBox.classList.add('is-dark');
            iframeBg = '#1a1a1a';
            isDarkMode = true;
        }
        
        // iframe内部の背景スタイルも同期する
        try {
            if (iframe.contentWindow && iframe.contentWindow.document.body) {
                iframe.contentWindow.document.body.style.backgroundColor = iframeBg;
                if (isDarkMode) {
                    iframe.contentWindow.document.body.style.color = '#ffffff';
                } else {
                    iframe.contentWindow.document.body.style.color = '';
                }
            }
        } catch (e) {}
    });
});

// 5. Code Toggle (Accordion)
document.querySelectorAll('.showcase-code-toggle').forEach(btn => {
    btn.addEventListener('click', function() {
        const parentWrapper = this.closest('.showcase-preview-wrapper');
        const codeBox = parentWrapper.querySelector('.showcase-code-box');
        
        this.classList.toggle('active');
        codeBox.classList.toggle('is-open');
        
        if (codeBox.classList.contains('is-open')) {
            this.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Hide Code';
        } else {
            this.innerHTML = '<i class="fa-solid fa-code"></i> Show Code';
        }
    });
});

// 6. Navigation Scroll & ScrollSpy
const spySections = document.querySelectorAll('.showcase-section');
const navLinks = document.querySelectorAll('.showcase-nav a');

function updateActiveNav() {
    let scrollPos = window.scrollY || document.documentElement.scrollTop;
    
    spySections.forEach((section, index) => {
        const sectionTop = section.offsetTop - 150;
        const sectionHeight = section.offsetHeight;
        
        if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
            navLinks.forEach(link => link.classList.remove('active'));
            
            const targetId = section.getAttribute('id');
            const targetLinks = document.querySelectorAll(`.showcase-nav a[href="#${targetId}"]`);
            targetLinks.forEach(link => link.classList.add('active'));
        }
    });
}

// Attach scroll listeners
window.addEventListener('scroll', updateActiveNav);
window.addEventListener('load', updateActiveNav);

// Click navigation scrolling
navLinks.forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Handle overlay closing if on mobile
        document.getElementById('mobileOverlayMenu').classList.remove('is-open');
        
        const targetId = this.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 120,
                behavior: 'smooth'
            });
        }
    });
});

// 7. Mobile Floating Nav Trigger
const mobileNavBtn = document.getElementById('mobileNavBtn');
const mobileOverlayMenu = document.getElementById('mobileOverlayMenu');

mobileNavBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    mobileOverlayMenu.classList.toggle('is-open');
});

// Close overlay when clicking outside content
mobileOverlayMenu.addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.remove('is-open');
    }
});

// ==========================================================================
// 8. HTML5 Window Message Listener (Dynamic iframe auto-resize)
// ==========================================================================
window.addEventListener('message', function(event) {
    // 同じオリジンからのメッセージのみ受け取る
    if (event.origin !== window.location.origin) return;
    
    const data = event.data;
    if (data && data.type === 'resize-iframe') {
        const compId = data.compId;
        const height = data.height;
        
        // 該当のiframeを見つけて高さをアップデート
        const iframe = document.querySelector(`.showcase-iframe[data-comp="${compId}"]`);
        if (iframe) {
            // 最低限の高さを確保しつつフィットさせる
            iframe.style.height = (height + 15) + 'px';
        }
    }
});
</script>

<?php get_footer(); ?>
