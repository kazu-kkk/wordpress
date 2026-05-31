<?php
/**
 * Template Name: Component Showcase
 * Description: A template to showcase all defined components for design system verification.
 */

get_header(); ?>

<!-- ショーケース専用のスタイル -->
<style>
.showcase-container {
    max-width: 1200px;
    margin: 40px auto 80px;
    padding: 0 20px;
    font-family: "Inter", "Hiragino Sans", "Meiryo", sans-serif;
    color: #333;
}

.showcase-header {
    background: linear-gradient(135deg, #2b53ec 0%, #1e3bb5 100%);
    padding: 48px 32px;
    border-radius: 24px;
    color: #fff;
    margin-bottom: 48px;
    box-shadow: 0 10px 30px rgba(43, 83, 236, 0.15);
    text-align: center;
}

.showcase-header h1 {
    font-size: 36px;
    font-weight: 800;
    margin: 0 0 12px;
    letter-spacing: -0.02em;
    color: #fff;
}

.showcase-header p {
    font-size: 16px;
    opacity: 0.9;
    margin: 0;
}

.showcase-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 40px;
    padding: 10px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

.showcase-nav a {
    padding: 10px 18px;
    font-size: 14px;
    font-weight: bold;
    color: #555;
    background-color: #f5f7ff;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.showcase-nav a:hover,
.showcase-nav a.active {
    background-color: #2b53ec;
    color: #fff;
}

.showcase-section {
    background: #fff;
    border-radius: 24px;
    padding: 40px;
    margin-bottom: 48px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
    border: 1px solid #eef2f7;
}

.showcase-section-title {
    font-size: 24px;
    font-weight: 700;
    color: #000;
    margin: 0 0 8px;
    padding-bottom: 16px;
    border-bottom: 2px solid #eef2f7;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.showcase-section-meta {
    font-size: 13px;
    color: #2b53ec;
    background: #eef2ff;
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 600;
}

.showcase-desc {
    font-size: 14px;
    color: #666;
    margin: 16px 0 24px;
    line-height: 1.6;
}

.showcase-preview-box {
    padding: 32px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}

.showcase-preview-box::before {
    content: "PREVIEW";
    position: absolute;
    top: 0;
    left: 0;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.1em;
    color: #94a3b8;
    background: #e2e8f0;
    padding: 4px 8px 4px 12px;
    border-bottom-right-radius: 8px;
}

.showcase-code-box {
    position: relative;
    border-radius: 12px;
    background: #1e1e1e;
    margin-top: 16px;
    overflow: hidden;
}

.showcase-code-box pre {
    margin: 0;
    padding: 20px;
    overflow-x: auto;
    font-family: "Courier New", Courier, monospace;
    font-size: 13px;
    color: #d4d4d4;
    line-height: 1.5;
}

.showcase-code-box::before {
    content: "HTML CODE";
    position: absolute;
    top: 0;
    right: 0;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.1em;
    color: #888;
    background: #2d2d2d;
    padding: 4px 12px;
    border-bottom-left-radius: 8px;
}

.copy-btn {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: #2b53ec;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
}

.copy-btn:hover {
    background: #1e3bb5;
}

/* 一部のコンポーネント用微調整（ショーケース内でのプレビューを見やすくするため） */
.showcase-dark-preview {
    background: #1a1a1a;
    color: #fff;
}
.showcase-dark-preview::before {
    background: #2d2d2d;
    color: #666;
}

/* 元のテーマとのバッティング防止 */
.showcase-preview-box table {
    margin: 0 !important;
}

/* スマホ表示 */
@media screen and (max-width: 768px) {
    .showcase-container {
        margin: 20px auto 40px;
        padding: 0 12px;
    }
    .showcase-header {
        padding: 32px 16px;
        margin-bottom: 24px;
    }
    .showcase-header h1 {
        font-size: 26px;
    }
    .showcase-section {
        padding: 20px;
        margin-bottom: 24px;
    }
    .showcase-preview-box {
        padding: 16px;
    }
}
</style>

<div class="showcase-container">
    <div class="showcase-header">
        <h1>Component Showcase</h1>
        <p>WordPressテーマ「inspiro-child」に定義済みのCSS/SCSSコンポーネント実物一覧ページ</p>
    </div>

    <!-- コンポーネントナビゲーション -->
    <div class="showcase-nav">
        <a href="#c-button">Button</a>
        <a href="#c-hero">Hero (FV)</a>
        <a href="#c-title">H2 Title</a>
        <a href="#c-tag">Tag</a>
        <a href="#c-article">Article (Single)</a>
        <a href="#c-related">Related Posts</a>
        <a href="#c-toc">TOC</a>
        <a href="#c-blogcard">Blogcard</a>
        <a href="#c-checklist">Checklist</a>
        <a href="#c-audience">Target Audience</a>
        <a href="#c-bento">Bento Grid</a>
        <a href="#c-footer">Footer</a>
        <a href="#c-contact">Contact Form</a>
    </div>

    <!-- 1. Button -->
    <section id="c-button" class="showcase-section">
        <div class="showcase-section-title">
            <span>1. 汎用ボタン (.button)</span>
            <span class="showcase-section-meta">style_add.scss</span>
        </div>
        <div class="showcase-desc">
            ブランドブルー背景に白文字の丸角ボタンです。ホバー時に背景色が反転し、枠線が表示されるスムーズなアニメーションが実装されています。
        </div>
        <div class="showcase-preview-box">
            <a href="#" class="button" style="margin: 0 auto;" onclick="return false;">ボタンラベル</a>
        </div>
        <div class="showcase-code-box">
            <pre><code class="html-code">&lt;a href="#" class="button"&gt;ボタンラベル&lt;/a&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 2. Hero Background -->
    <section id="c-hero" class="showcase-section">
        <div class="showcase-section-title">
            <span>2. ヒーロー背景 (.hero-background)</span>
            <span class="showcase-section-meta">style_add.scss</span>
        </div>
        <div class="showcase-desc">
            FV（ファーストビュー）用の背景エリアです。`position: sticky` でヘッダーの裏側に潜り込ませ、スクロール時にコンテンツが上に覆いかぶさる演出が施されています。
        </div>
        <div class="showcase-preview-box" style="padding: 0;">
            <div class="hero-background" style="position: relative; min-height: 200px; height: 200px;">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/yuny_logo.png" alt="Yuny" style="max-width: 250px;">
            </div>
        </div>
        <div class="showcase-code-box">
            <pre><code class="html-code">&lt;section class="hero-background"&gt;
  &lt;img src="path/to/logo.png" alt="Yuny"&gt;
&lt;/section&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 3. H2 Title -->
    <section id="c-title" class="showcase-section">
        <div class="showcase-section-title">
            <span>3. セクション見出し (.title-h2__text)</span>
            <span class="showcase-section-meta">style_add.scss</span>
        </div>
        <div class="showcase-desc">
            左側にアイコンSVGを配置したH2タイトルです。モディファイアクラスで各アイコン画像（記事、形状、タグ、SNSなど）を擬似要素で表示します。
        </div>
        <div class="showcase-preview-box" style="background: #fff;">
            <h2 class="title-h2__text title-h2__text--pick-up" style="margin-bottom: 20px;">ピックアップ</h2>
            <h2 class="title-h2__text title-h2__text--new" style="margin-bottom: 20px;">新着記事</h2>
            <h2 class="title-h2__text title-h2__text--category" style="margin-bottom: 20px;">カテゴリ</h2>
            <h2 class="title-h2__text title-h2__text--popular-tag" style="margin-bottom: 20px;">人気タグ</h2>
            <h2 class="title-h2__text title-h2__text--sns">SNS</h2>
        </div>
        <div class="showcase-code-box">
            <pre><code class="html-code">&lt;h2 class="title-h2__text title-h2__text--pick-up"&gt;ピックアップ&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--new"&gt;新着記事&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--category"&gt;カテゴリ&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--popular-tag"&gt;人気タグ&lt;/h2&gt;
&lt;h2 class="title-h2__text title-h2__text--sns"&gt;SNS&lt;/h2&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 4. Tag -->
    <section id="c-tag" class="showcase-section">
        <div class="showcase-section-title">
            <span>4. タグバッジ (.tag)</span>
            <span class="showcase-section-meta">style_add.scss</span>
        </div>
        <div class="showcase-desc">
            ブログのカテゴリやタグ表示に使用する小さなバッジ用スタイルです。
        </div>
        <div class="showcase-preview-box">
            <span class="tag">デザイン</span>
            <a href="#" class="tag" onclick="return false;">WordPress</a>
            <span class="tag">UI/UX</span>
        </div>
        <div class="showcase-code-box">
            <pre><code class="html-code">&lt;span class="tag"&gt;タグ名&lt;/span&gt;
&lt;a href="#" class="tag"&gt;タグ名&lt;/a&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 5. Article (Single) -->
    <section id="c-article" class="showcase-section">
        <div class="showcase-section-title">
            <span>5. 記事本文要素 (Single Page Elements)</span>
            <span class="showcase-section-meta">_single.scss</span>
        </div>
        <div class="showcase-desc">
            シングル記事ページで使用するタイトル、日付、見出し(H2: PC 28px/SP 22px, H3: PC 24px/SP 20px)およびテーブル(PC版・縦ヘッダー)などの装飾です。
        </div>
        <div class="showcase-preview-box" style="background: #fff; max-width: 720px; margin: 0 auto; padding: 24px; border: 1px solid #eee;">
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
                <p>見出し2の下部には太いグレーのボーダーが表示され、左側にはブランドブルーのショートアクセントラインが重ねられます。</p>
                
                <h3>1-1. 詳細を掘り下げるための見出し（H3）</h3>
                <p>見出し3はシンプルなボールドテキストで、記事の流れを階層的に整理します。</p>

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
        <div class="showcase-code-box">
            <pre><code class="html-code">&lt;!-- 記事ヘッダー --&gt;
&lt;h1 class="article-title"&gt;記事タイトル&lt;/h1&gt;
&lt;div class="article-sub"&gt;
    &lt;p class="article-sub-date"&gt;2026.05.31&lt;/p&gt;
    &lt;ul&gt;
        &lt;li&gt;&lt;a href="#"&gt;タグ&lt;/a&gt;&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;

&lt;!-- 本文内見出しとテーブル --&gt;
&lt;div class="article-text"&gt;
    &lt;h2&gt;見出し2（アクセント線付き）&lt;/h2&gt;
    &lt;h3&gt;見出し3&lt;/h3&gt;
    
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
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 6. Related Posts -->
    <section id="c-related" class="showcase-section">
        <div class="showcase-section-title">
            <span>6. 関連記事 (.related-posts)</span>
            <span class="showcase-section-meta">_single.scss</span>
        </div>
        <div class="showcase-desc">
            記事の下部に関連記事を表示する3カラムのグリッドカードです。ホバー時にカードが滑らかに浮き上がり、サムネイルがズームインします。
        </div>
        <div class="showcase-preview-box" style="background: #fff; padding: 24px;">
            <div class="related-posts" style="margin: 0;">
                <div class="related-posts__grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
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
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 7. TOC -->
    <section id="c-toc" class="showcase-section">
        <div class="showcase-section-title">
            <span>7. 目次 (.toc)</span>
            <span class="showcase-section-meta">_toc.scss</span>
        </div>
        <div class="showcase-desc">
            アコーディオン開閉式の美しい目次ボックスです。階層化に対応したリストスタイルと、アンカー到達時のフラッシュアニメーション機能が内蔵されています。
        </div>
        <div class="showcase-preview-box">
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
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 8. Blogcard -->
    <section id="c-blogcard" class="showcase-section">
        <div class="showcase-section-title">
            <span>8. ブログカード (.blogcard)</span>
            <span class="showcase-section-meta">_blogcard.scss</span>
        </div>
        <div class="showcase-desc">
            記事本文内で関連記事などの内部リンクをリッチにアピールするためのブログカードです。サムネイルとタイトル・抜粋・ドメインを一体化してスマートに表現します。
        </div>
        <div class="showcase-preview-box">
            <div class="blogcard" style="margin: 0;">
                <a href="#" onclick="return false;">
                    <div class="blogcard_thumbnail">
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #2b53ec 0%, #1e3bb5 100%);"></div>
                    </div>
                    <div class="blogcard_content">
                        <p class="blogcard_title">デザペディア — デザインやクリエイティブを学ぶ情報メディア</p>
                        <p class="blogcard_excerpt">UIデザインからWordPressテーマカスタマイズ、開発の効率化まで幅広く学べるデジタルマガジンです。</p>
                        <p class="blogcard_link">ds-pedia.com</p>
                    </div>
                </a>
            </div>
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
      &lt;p class="blogcard_link"&gt;example.com&lt;/p&gt;
    &lt;/div&gt;
  &lt;/a&gt;
&lt;/div&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 9. Checklist -->
    <section id="c-checklist" class="showcase-section">
        <div class="showcase-section-title">
            <span>9. チェックリスト (ul.checklist)</span>
            <span class="showcase-section-meta">_checklist.scss</span>
        </div>
        <div class="showcase-desc">
            擬似要素を使用してブランドブルーのチェックマークを自動で付与する、見やすくスタイリッシュな箇条書きリストです。
        </div>
        <div class="showcase-preview-box" style="background: #fff;">
            <ul class="checklist">
                <li>ユーザー体験を意識した情報設計</li>
                <li>統一されたカラーパレットと余白ルール</li>
                <li>レスポンシブデザインによる完璧なモバイル最適化</li>
            </ul>
        </div>
        <div class="showcase-code-box">
            <pre><code class="html-code">&lt;ul class="checklist"&gt;
  &lt;li&gt;チェック項目1&lt;/li&gt;
  &lt;li&gt;チェック項目2&lt;/li&gt;
  &lt;li&gt;チェック項目3&lt;/li&gt;
&lt;/ul&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 10. Target Audience -->
    <section id="c-audience" class="showcase-section">
        <div class="showcase-section-title">
            <span>10. 対象読者ブロック (.target-audience)</span>
            <span class="showcase-section-meta">_target-audience.scss</span>
        </div>
        <div class="showcase-desc">
            記事の導入部などで「この記事がどんな人に向いているか」を明示するための、囲み枠コンポーネントです。ブルーのボーダーとSVGチェックアイコンが視認性を高めます。
        </div>
        <div class="showcase-preview-box" style="background: #fff; padding: 24px;">
            <div class="target-audience" style="margin: 0;">
                <p class="target-audience__title">こんな人におすすめ</p>
                <ul class="target-audience__list">
                    <li class="target-audience__item">最新のフロントエンド/Webデザインに関心がある</li>
                    <li class="target-audience__item">WordPressの子テーマ構成を効率的に整理したい</li>
                    <li class="target-audience__item">一貫したUIデザインシステムを開発に適用したい</li>
                </ul>
            </div>
        </div>
        <div class="showcase-code-box">
            <pre><code class="html-code">&lt;div class="target-audience"&gt;
  &lt;p class="target-audience__title"&gt;こんな人におすすめ&lt;/p&gt;
  &lt;ul class="target-audience__list"&gt;
    &lt;li class="target-audience__item"&gt;項目テキスト1&lt;/li&gt;
    &lt;li class="target-audience__item"&gt;項目テキスト2&lt;/li&gt;
  &lt;/ul&gt;
&lt;/div&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 11. Bento Grid -->
    <section id="c-bento" class="showcase-section">
        <div class="showcase-section-title">
            <span>11. ベントグリッド (.bento-wrapper)</span>
            <span class="showcase-section-meta">_bento.scss</span>
        </div>
        <div class="showcase-desc">
            プロフィールページ用にデザインされた、カードが網の目のように組み合わさったグリッドレイアウトです。PCでは4カラム、SPでは2カラムに流動的に変化します。
        </div>
        <div class="showcase-preview-box" style="padding: 16px;">
            <div class="bento-wrapper" style="margin: 0; max-width: 100%;">
                <div class="bento-grid" style="grid-auto-rows: 150px; gap: 16px;">
                    <div class="bento-card profile-card" style="padding: 16px;">
                        <div class="profile-content" style="gap: 16px;">
                            <div class="profile-image">
                                <div style="width: 70px; height: 70px; border-radius: 50%; background: #ccc; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:24px; color:#fff;">Y</div>
                            </div>
                            <div class="profile-text">
                                <h1 style="font-size: 20px;">Yuny</h1>
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
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 12. Footer -->
    <section id="c-footer" class="showcase-section">
        <div class="showcase-section-title">
            <span>12. リッチフッター (.site-footer-rich)</span>
            <span class="showcase-section-meta">_footer.scss</span>
        </div>
        <div class="showcase-desc">
            背景色 `#1a1a1a` のシックなダークモードフッターです。ブランド紹介、ナビゲーション、丸角のスタイリッシュなタグクラウドなどが4カラムに整理されています。
        </div>
        <div class="showcase-preview-box showcase-dark-preview" style="padding: 24px;">
            <div class="site-footer-rich" style="padding: 20px 0; background: transparent;">
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
        &lt;p class="footer-desc"&gt;サイト紹介のテキスト...&lt;/p&gt;
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
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>

    <!-- 13. Contact Form -->
    <section id="c-contact" class="showcase-section">
        <div class="showcase-section-title">
            <span>13. お問い合わせフォーム (.wpcf7)</span>
            <span class="showcase-section-meta">_contact-form.scss</span>
        </div>
        <div class="showcase-desc">
            Contact Form 7 と連携して動作する、実装済みのお問い合わせフォームデザインです。入力フィールドのフォーカス時にアクセントカラーの枠線と淡いシャドウが広がります。
        </div>
        <div class="showcase-preview-box entry-content" style="background: #f5f7ff; padding: 40px 20px;">
            <div class="wpcf7" style="max-width: 640px; margin: 0 auto;">
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
                </form>
            </div>
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
    &lt;/p&gt;
  &lt;/form&gt;
&lt;/div&gt;</code></pre>
            <button class="copy-btn" onclick="copyCode(this)">COPY</button>
        </div>
    </section>
</div>

<!-- クリップボードへのコピーJS -->
<script>
function copyCode(button) {
    const pre = button.previousElementSibling;
    const code = pre.querySelector('code').innerText;
    
    navigator.clipboard.writeText(code).then(() => {
        const originalText = button.innerText;
        button.innerText = 'COPIED!';
        button.style.backgroundColor = '#2cb696';
        
        setTimeout(() => {
            button.innerText = originalText;
            button.style.backgroundColor = '#2b53ec';
        }, 1500);
    }).catch(err => {
        alert('コピーに失敗しました: ', err);
    });
}

// ナビゲーションスクロールでアクティブリンク切り替え
document.querySelectorAll('.showcase-nav a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        document.querySelectorAll('.showcase-nav a').forEach(a => a.classList.remove('active'));
        this.classList.add('active');
        
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
</script>

<?php get_footer(); ?>
