<?php
/**
 * Template Name: 後で読む一覧
 * Description: 「後で読む」に保存した記事を表示する専用テンプレート（スラッグ reading-list で自動適用）
 *
 * @package Inspiro
 */

get_header(); ?>

<div class="inner-wrap inner-wrap--top-page inner-wrap--reading-list">
    <div id="primary" class="content-area">
        <main id="main" class="top-page-content reading-list-main" role="main">
            
            <header class="reading-list-header">
                <div class="reading-list-header__content">
                    <h1 class="reading-list-header__title">
                        <i data-lucide="bookmark" class="reading-list-header__icon"></i>
                        後で読むリスト
                    </h1>
                    <p class="reading-list-header__desc">ブラウザに一時保存した記事の一覧です。</p>
                </div>
                <div class="reading-list-header__actions">
                    <span class="reading-list-header__count">保存中: <strong class="js-reading-list-count">0</strong> 件</span>
                    <button type="button" class="reading-list-clear-btn js-reading-list-clear" style="display: none;" aria-label="保存した記事をすべて削除">
                        <i data-lucide="trash-2"></i>
                        <span>すべて削除</span>
                    </button>
                </div>
            </header>

            <!-- 記事一覧グリッド（JavaScriptで動的に生成） -->
            <div class="reading-list-container js-reading-list-container">
                <div class="reading-list-loading js-reading-list-loading">
                    <p>読み込み中...</p>
                </div>
            </div>

            <!-- 空状態（保存記事が0件のとき） -->
            <div class="reading-list-empty js-reading-list-empty" style="display: none;">
                <div class="reading-list-empty__icon-wrap">
                    <i data-lucide="bookmark"></i>
                </div>
                <h2 class="reading-list-empty__title">保存された記事はありません</h2>
                <p class="reading-list-empty__desc">
                    気になる記事を見つけたら、記事一覧や詳細ページの「しおりアイコン」を押して追加してください。
                </p>
                <div class="reading-list-empty__action">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="reading-list-empty__btn">
                        トップページへ戻る
                    </a>
                </div>
            </div>

        </main><!-- #main -->

        <!-- サイドナビ -->
        <aside class="right-contents">
            <?php get_template_part('side-nav'); ?>
        </aside>
    </div><!-- #primary -->
</div><!-- .inner-wrap -->

<?php get_footer(); ?>
