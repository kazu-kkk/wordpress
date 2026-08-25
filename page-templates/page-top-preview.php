<?php
/**
 * Template Name: TOP Renewal Preview
 * Description: A temporary template to preview the TOP page renewal layout with dummy data.
 */

// プレビューページ専用スタイルを wp_head フックで <head> 内の後方に追加
// （enqueueされた style_add.css より後に出力されるよう priority=20 を指定）
add_action( 'wp_head', function() { ?>
<style>

    /* --- #contentの背景を透明にして、背後のFVが見えるようにする --- */
    body.page-template-page-top-preview #content.site-content {
        background-color: transparent;
        position: relative;
        z-index: auto;
    }
    
    /* --- プレビューページ専用の透明ヘッダー・ロゴフェードイン制御 --- */
    body.page-template-page-top-preview .header-logo-wrapper {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-5px);
        transition: opacity 0.4s ease-out, visibility 0.4s ease-out, transform 0.4s ease-out;
    }
    
    /* 初期表示時（スクロール前）のヘッダースタイル */
    body.page-template-page-top-preview:not(.has-scrolled-fv) .site-header {
        background: transparent;
        box-shadow: none;
    }
    
    body.page-template-page-top-preview:not(.has-scrolled-fv) .site-header .navbar {
        background: transparent;
        background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 1%, rgba(0, 0, 0, 0) 100%);
        padding: 18px 0;
        box-shadow: none;
    }
    
    /* スクロール後（FV通過後）のヘッダースタイル */
    body.page-template-page-top-preview.has-scrolled-fv .header-logo-wrapper {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    body.page-template-page-top-preview.has-scrolled-fv .site-header .navbar {
        background: rgba(0, 0, 0, 0.9);
        box-shadow: 0px 0px 18px 1px rgba(0, 0, 0, 0.1);
        padding: 12px 0;
        transition: background 0.4s ease-out, padding 0.4s ease-out, box-shadow 0.4s ease-out;
    }
    
    /* 親要素の余計な余白をリセットし、FVが画面の一番上から始まるようにする */
    body.page-template-page-top-preview .site-content,
    body.page-template-page-top-preview #primary.content-area,
    body.page-template-page-top-preview .inner-wrap {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    /* --- プレビュー用のFV背景スタイル --- */
    body.page-template-page-top-preview .hero-background-preview {
        background-color: #2B53EC;
        text-align: center;
        padding: 90px 0 50px; /* ヘッダー分を考慮した上部余白 */
        min-height: 30vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: sticky;
        top: 0;
        z-index: 1;
        left: 0;
        width: 100%;
        box-sizing: border-box;
    }
    
    /* WordPress管理バー（黒いバー）表示時のズレ補正 */
    .admin-bar.page-template-page-top-preview .hero-background-preview {
        top: 32px;
    }
    @media screen and (max-width: 782px) {
        .admin-bar.page-template-page-top-preview .hero-background-preview {
            top: 46px;
        }
    }
    
    /* コンテンツエリア（FVの上に被さる） */
    body.page-template-page-top-preview .preview-content-wrapper {
        position: relative;
        z-index: 2;
        background-color: #F6F8FC;
        padding-top: 60px; /* ピックアップ見出しの上に適切な余白を設ける */
    }
    
    /* 上部バウンス時の見切れ防止 */
    body.page-template-page-top-preview .hero-background-preview::before {
        content: '';
        position: absolute;
        top: -500px;
        left: 0;
        width: 100%;
        height: 500px;
        background-color: #2B53EC;
        z-index: -1;
    }
    
    /* プレビュー用FV内のロゴ・テキスト --- */
    body.page-template-page-top-preview .hero-background-preview__content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        max-width: 600px;
        width: 100%;
        padding: 0 20px;
        box-sizing: border-box;
    }
    
    body.page-template-page-top-preview .hero-background-preview .hero-text {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        margin: 0 0 15px 0;
        text-align: center;
    }
    
    body.page-template-page-top-preview .hero-background-preview img {
        max-width: 100%;
        width: auto;
        height: auto;
        max-height: 15vh;
        display: block;
    }
    
    /* --- コンテンツ全体を覆う幅100%の重ね合わせ用ラッパー --- */
    body.page-template-page-top-preview .preview-content-wrapper {
        position: relative;
        z-index: 2;
        background-color: #F5F7FF;
        width: 100%;
        box-sizing: border-box;
    }

    /* --- コンテンツエリアの重ね合わせ --- */
    body.page-template-page-top-preview .inner-wrap--preview {
        position: relative;
        z-index: 2;
        background-color: transparent;
        box-sizing: border-box;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* --- PC時のカードサイズとフレックス構造の厳格な制御 --- */
    @media screen and (min-width: 768px) {
        body.page-template-page-top-preview .inner-wrap--preview {
            padding: 40px 30px 120px;
        }
        
        body.page-template-page-top-preview .pickup {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto 50px;
        }

        body.page-template-page-top-preview .pickup-list {
            padding-left: 0;
            padding-right: 0;
            margin: 0;
            width: 100%;
            display: flex;
            gap: 20px;
        }

        body.page-template-page-top-preview .inner-wrap--preview .content-area {
            display: flex;
            gap: 40px;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            /* 親テーマが #primary に付与する padding-left/right: 10px をリセット */
            padding-left: 0;
            padding-right: 0;
            float: none;
        }

        /* 親テーマの body:not(.page-layout-sidebar-right) #primary { padding-left: 10px } をリセット */
        body.page-template-page-top-preview #primary.content-area {
            padding-left: 0;
            padding-right: 0;
            max-width: 1100px;
            margin: 0 auto;
        }

        body.page-template-page-top-preview .inner-wrap--preview #main.top-page-content {
            flex: 1;
            min-width: 0;
            margin: 0;
            padding: 0;
            float: none;
            width: auto;
        }
        
        body.page-template-page-top-preview .inner-wrap--preview .right-contents {
            width: 300px;
            flex-shrink: 0;
            margin: 0;
            padding: 0;
            float: none;
        }

        body.page-template-page-top-preview .new-article {
            height: 150px;
            overflow: hidden;
            display: flex;
            background-color: #fff;
            border-radius: 8px;
            margin-top: 30px;
        }
        
        body.page-template-page-top-preview .new-article-link {
            display: flex;
            width: 100%;
            height: 150px;
            text-decoration: none;
        }
        
        body.page-template-page-top-preview .new-article__image {
            width: 200px;
            height: 150px;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        body.page-template-page-top-preview .new-article__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        body.page-template-page-top-preview .new-article-text {
            width: 100%;
            height: 150px;
            box-sizing: border-box;
            padding: 15px 20px;
            background-color: #fff;
            display: flex;
            align-items: center;
            flex-grow: 1;
            overflow: hidden;
        }
        
        body.page-template-page-top-preview .new-article-text-inner {
            width: 100%;
            display: block;
        }
        
        body.page-template-page-top-preview .new-article-text__title {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            margin: 0 0 5px 0;
            font-size: 20px;   /* scss: 20px */
            line-height: 1.5;  /* scss: 1.5 */
            font-weight: bold;
            color: #000;
        }
        
        body.page-template-page-top-preview .new-article-text__date {
            font-size: 13px;
            color: #000;       /* scss: #000 */
            margin: 0 0 5px 0;
        }
        
        body.page-template-page-top-preview .new-article-text-meta {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: flex-start;
            overflow: hidden;
            height: 30px;
        }

        body.page-template-page-top-preview .new-article-text__category,
        body.page-template-page-top-preview .new-article-text__tag {
            flex-shrink: 0;
            line-height: 1.4;
        }
    }
            margin: 0;
            float: none;
        }

        body.page-template-page-top-preview .inner-wrap--preview #main.top-page-content {
            width: 100%;
            max-width: 100%;
            padding: 0;
            margin: 0;
            float: none;
        }

        body.page-template-page-top-preview .inner-wrap--preview .right-contents {
            width: 100%;
            margin-top: 40px;
            padding: 0;
            float: none;
        }

        /* SP用のピックアップ記事と最新の投稿レイアウト・配色は style_add.scss (style_add.css) 側の定義が適用されるため、ここでは上書きを削除 */

        body.page-template-page-top-preview #custom-side-nav {
            width: 100%;
            padding: 0;
        }
    }



</style>
<?php }, 20 ); // end wp_head action

get_header(); ?>

<!-- 1. FV (ファーストビュー) -->

<section class="hero-background-preview">
    <div class="hero-background-preview__content">
        <p class="hero-text">UX / UI・デジタルクリエイティブの専門メディア</p>
        <a href="#" onclick="return false;">
            <?php if (has_custom_logo()) : ?>
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                echo wp_get_attachment_image($custom_logo_id, 'full', false, array(
                    'class'         => 'custom-logo',
                    'loading'       => 'eager',
                    'fetchpriority' => 'high',
                ));
                ?>
            <?php else : ?>
                <img src="/wp-content/uploads/2025/01/ブログロゴ.png" alt="デザペディア">
            <?php endif; ?>
        </a>
    </div>
</section>

<div class="preview-content-wrapper">
    <div class="inner-wrap inner-wrap--top-page inner-wrap--preview">

    <!-- 2. ピックアップ記事（フル幅） -->
    <section class="pickup" style="margin-bottom: 40px;">
        <h2 class="title-h2__text title-h2__text--pick-up"><i data-lucide="pen-tool"></i> ピックアップ</h2>
        <ul class="pickup-list">
            <?php
            $pickup_post_ids = array(); // ピックアップ記事のIDを保持する配列
            
            // 1. pickupタグ記事を取得
            $tag_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'tag'            => 'pickup',
                'orderby'        => 'date',
                'order'          => 'DESC'
            ));
            if ($tag_query->have_posts()) {
                while ($tag_query->have_posts()) {
                    $tag_query->the_post();
                    $pickup_post_ids[] = get_the_ID();
                }
                wp_reset_postdata();
            }

            // 2. 足りない分を最新記事で補完
            if (count($pickup_post_ids) < 3) {
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3 - count($pickup_post_ids),
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                );
                if (!empty($pickup_post_ids)) {
                    $args['post__not_in'] = $pickup_post_ids;
                }
                $latest_query = new WP_Query($args);
                if ($latest_query->have_posts()) {
                    while ($latest_query->have_posts()) {
                        $latest_query->the_post();
                        $pickup_post_ids[] = get_the_ID();
                    }
                    wp_reset_postdata();
                }
            }

            // 3. 表示用クエリ
            $pickup_query = new WP_Query(array(
                'post_type'      => 'post',
                'post__in'       => !empty($pickup_post_ids) ? $pickup_post_ids : array(0),
                'orderby'        => 'post__in',
                'posts_per_page' => 3
            ));

            if ($pickup_query->have_posts()) :
                while ($pickup_query->have_posts()) : $pickup_query->the_post();
                    $thumbnail_url = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : get_stylesheet_directory_uri() . '/assets/images/no_image.png';
            ?>
            <li class="pickup-article">
                <a href="<?php the_permalink(); ?>" class="pickup-article-link">
                    <div class="pickup-article__image">
                        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                    </div>
                    <div class="pickup-article-text">
                        <p class="pickup-article-text__title"><?php the_title(); ?></p>
                        <p class="pickup-article-text__date"><?php the_time('Y.m.d'); ?></p>
                        <div class="pickup-article-text-meta" style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: auto; align-items: flex-start; overflow: hidden; height: 30px;">
                            <?php
                            $displayed_terms = array(); // 表示済みタグ名を記録
                            $tags = get_the_tags();
                            if (!empty($tags)) {
                                foreach ($tags as $tag) {
                                    if (strtolower($tag->name) === 'pickup') continue;
                                    if (in_array($tag->name, $displayed_terms)) continue;
                                    echo '<div class="pickup-article-text__tag" style="margin: 0; display: block; flex-shrink: 0; line-height: 1.4;"><span class="tag">' . esc_html($tag->name) . '</span></div>';
                                    $displayed_terms[] = $tag->name;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </a>
            </li>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="padding: 20px;">記事がありません。</p>';
            endif;
            ?>
        </ul>
    </section>

    <!-- 2カラムエリア（最新の投稿＋トレンド ＋ サイドナビ） -->
    <div id="primary" class="content-area">
        <main id="main" class="top-page-content" role="main">
            <!-- 3. 最新の投稿 -->
            <section style="margin-bottom: 40px;">
                <h2 class="title-h2__text title-h2__text--new"><i data-lucide="file-text"></i> 最新の投稿</h2>
                <div class="new-article-list">
                    <?php
                    $latest_post_ids = array(); // 最新の投稿記事のIDを保持する配列
                    $new_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'post__not_in'   => $pickup_post_ids, // ピックアップ記事を除外
                    ));
                    if ($new_query->have_posts()) :
                        while ($new_query->have_posts()) : $new_query->the_post();
                            $latest_post_ids[] = get_the_ID(); // IDを保存
                            $thumbnail_url = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : get_stylesheet_directory_uri() . '/assets/images/no_image.png';
                    ?>
                    <article class="new-article">
                        <a href="<?php the_permalink(); ?>" class="new-article-link">
                            <div class="new-article__image">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                            <div class="new-article-text">
                                <div class="new-article-text-inner">
                                    <p class="new-article-text__title"><?php the_title(); ?></p>
                                    <p class="new-article-text__date"><?php the_time('Y.m.d'); ?></p>
                                    <div class="new-article-text-meta">
                                        <?php
                                        $displayed_terms = array(); // 表示済みタグ名を記録
                                        $tags = get_the_tags();
                                        if (!empty($tags)) {
                                            foreach ($tags as $tag) {
                                                if (strtolower($tag->name) === 'pickup') continue;
                                                if (in_array($tag->name, $displayed_terms)) continue;
                                                echo '<div class="new-article-text__tag"><span class="tag">' . esc_html($tag->name) . '</span></div>';
                                                $displayed_terms[] = $tag->name;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p style="padding: 20px;">記事がありません。</p>';
                    endif;
                    ?>
                </div>
            </section>

            <!-- 4. トレンドセクション -->
            <section style="margin-bottom: 40px;">
                <h2 class="title-h2__text title-h2__text--trend"><i data-lucide="trending-up"></i> デザイントレンド</h2>
                <div class="new-article-list">
                    <?php
                    // 以前取得したピックアップ記事と最新の投稿記事のIDをマージ
                    $exclude_post_ids = array_merge($pickup_post_ids, $latest_post_ids);

                    // 「デザイントレンド」カテゴリに属する最新の記事を取得
                    $trend_query = new WP_Query(array(
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'post__not_in'   => $exclude_post_ids, // ピックアップ記事と最新の投稿を除外
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'category',
                                'field'    => 'name',
                                'terms'    => 'デザイントレンド',
                            ),
                        ),
                    ));
                    if ($trend_query->have_posts()) :
                        while ($trend_query->have_posts()) : $trend_query->the_post();
                            $thumbnail_url = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : get_stylesheet_directory_uri() . '/assets/images/no_image.png';
                    ?>
                    <article class="new-article">
                        <a href="<?php the_permalink(); ?>" class="new-article-link">
                            <div class="new-article__image">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                            <div class="new-article-text">
                                <div class="new-article-text-inner">
                                    <p class="new-article-text__title"><?php the_title(); ?></p>
                                    <p class="new-article-text__date"><?php the_time('Y.m.d'); ?></p>
                                    <div class="new-article-text-meta">
                                        <?php
                                        $displayed_terms = array(); // 表示済みタグ名を記録
                                        $tags = get_the_tags();
                                        if (!empty($tags)) {
                                            foreach ($tags as $tag) {
                                                if (strtolower($tag->name) === 'pickup') continue;
                                                if (in_array($tag->name, $displayed_terms)) continue;
                                                echo '<div class="new-article-text__tag"><span class="tag">' . esc_html($tag->name) . '</span></div>';
                                                $displayed_terms[] = $tag->name;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p style="padding: 20px;">記事がありません。</p>';
                    endif;
                    ?>
                </div>
            </section>
        </main>

        <!-- 5. プレビュー用サイドバー -->
        <aside class="right-contents">
            <?php get_template_part('side-nav'); ?>
        </aside>
    </div>
</div>
</div>

<!-- 6. プレビューページ専用のスクロールイベント判定スクリプト -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var hero = document.querySelector('.hero-background-preview');
    if (!hero) return;

    function checkScroll() {
        var heroHeight = hero.offsetHeight;
        var threshold = Math.max(0, heroHeight - 90);

        if (window.scrollY >= threshold) {
            document.body.classList.add('has-scrolled-fv');
        } else {
            document.body.classList.remove('has-scrolled-fv');
        }
    }

    checkScroll();
    window.addEventListener('scroll', checkScroll, { passive: true });
    window.addEventListener('resize', checkScroll, { passive: true });
});
</script>

<?php get_footer(); ?>
