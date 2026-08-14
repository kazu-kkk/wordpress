<?php
// 本番用TOPページ（front-page.php）

// プレビューページ専用スタイルを wp_head フックで <head> 内の後方に追加
// （enqueueされた style_add.css より後に出力されるよう priority=20 を指定）
add_action( 'wp_head', function() { ?>
<style>

    /* --- #contentの背景を透明にして、背後のFVが見えるようにする --- */
    body #content.site-content {
        background-color: transparent;
        position: relative;
        z-index: auto;
    }
    
    /* --- プレビューページ専用の透明ヘッダー・ロゴフェードイン制御 --- */
    body .header-logo-wrapper {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-5px);
        transition: opacity 0.4s ease-out, visibility 0.4s ease-out, transform 0.4s ease-out;
    }
    
    /* 初期表示時（スクロール前）のヘッダースタイル */
    body:not(.has-scrolled-fv) .site-header {
        background: transparent;
        box-shadow: none;
    }
    
    body:not(.has-scrolled-fv) .site-header .navbar {
        background: transparent;
        background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 1%, rgba(0, 0, 0, 0) 100%);
        padding: 18px 0;
        box-shadow: none;
    }
    
    /* スクロール後（FV通過後）のヘッダースタイル */
    body.has-scrolled-fv .header-logo-wrapper {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    body.has-scrolled-fv .site-header .navbar {
        background: rgba(0, 0, 0, 0.9);
        box-shadow: 0px 0px 18px 1px rgba(0, 0, 0, 0.1);
        padding: 12px 0;
        transition: background 0.4s ease-out, padding 0.4s ease-out, box-shadow 0.4s ease-out;
    }
    
    /* 親要素の余計な余白をリセットし、FVが画面の一番上から始まるようにする */
    body .site-content,
    body #primary.content-area,
    body .inner-wrap {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }

    /* --- プレビュー用のFV背景スタイル --- */
    body .hero-background-preview {
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
    body .preview-content-wrapper {
        position: relative;
        z-index: 2;
        background-color: #F6F8FC;
        padding-top: 60px; /* ピックアップ見出しの上に適切な余白を設ける */
    }
    
    /* 上部バウンス時の見切れ防止 */
    body .hero-background-preview::before {
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
    body .hero-background-preview__content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        max-width: 600px;
        width: 100%;
        padding: 0 20px;
        box-sizing: border-box;
    }
    
    body .hero-background-preview .hero-text {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        margin: 0 0 15px 0;
        text-align: center;
    }
    
    body .hero-background-preview img {
        max-width: 100%;
        width: auto;
        height: auto;
        max-height: 15vh;
        display: block;
    }
    
    /* --- コンテンツ全体を覆う幅100%の重ね合わせ用ラッパー --- */
    body .preview-content-wrapper {
        position: relative;
        z-index: 2;
        background-color: #F5F7FF;
        width: 100%;
        box-sizing: border-box;
    }

    /* --- コンテンツエリアの重ね合わせ --- */
    body #page .inner-wrap--preview {
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
        body #page .inner-wrap--preview {
            padding: 40px 30px 120px;
        }
        
        body #page .pickup {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto 50px;
        }

        body #page .pickup-list {
            padding-left: 0;
            padding-right: 0;
            margin: 0;
            width: 100%;
            display: flex;
            gap: 20px;
        }

        body #page .pickup-article {
            flex: 1;
            min-width: 0;
            width: auto;
        }

        body #page .new-article {
            height: 150px;
            overflow: hidden;
            display: flex;
            background-color: #fff;
            border-radius: 8px;
            margin-top: 0; /* gap で隙間を作るため margin-top は 0 にする */
        }
        
        body #page .new-article-link {
            display: flex;
            width: 100%;
            height: 150px;
            text-decoration: none;
        }
        
        body #page .new-article__image {
            width: 200px;
            height: 150px;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        body #page .new-article__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        body #page .new-article-text {
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
        
        body #page .new-article-text-inner {
            width: 100%;
            display: block;
        }
        
        body #page .new-article-text__title {
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
        
        body #page .new-article-text__date {
            font-size: 13px;
            color: #000;       /* scss: #000 */
            margin: 0 0 5px 0;
        }
        
        body #page .new-article-text-meta {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: flex-start;
            overflow: hidden;
            height: 30px;
        }

        body #page .new-article-text__category,
        body #page .new-article-text__tag {
            flex-shrink: 0;
            line-height: 1.4;
        }
    }
    
    /* --- SP（スマホ）表示時の最適化とはみ出し防止 --- */
    @media screen and (max-width: 767px) {
        /* SP用のFVサイズ調整 */


        body #page .hero-background-preview .hero-text {
            font-size: 14px;
            font-weight: bold;
            color: #fff;
            margin: 0 0 15px 0;
            line-height: 1.5;
        }

        body #page .inner-wrap--preview {
            padding: 20px 16px 60px;
        }

        /* SP用のピックアップ記事と最新の投稿レイアウト・配色は style_add.scss (style_add.css) 側の定義が適用されるため、ここでは上書きを削除 */

        body #page #custom-side-nav {
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
        <h1 class="sr-only">デザペディア - Webデザイン・UX / UI・チュートリアルの情報メディアサイト</h1>
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
    <section class="pickup">
        <h2 class="title-h2__text title-h2__text--pick-up"><i data-lucide="pen-tool"></i> ピックアップ</h2>
        <ul class="pickup-list">
            <?php
            $pickup_post_ids = array(); // ピックアップ記事のIDを保持する配列
            
            // 1. pickupタグ記事を取得 (sync trigger)
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
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                foreach ($categories as $cat) {
                                    if ($cat->name === '記事') continue;
                                    if (in_array($cat->name, $displayed_terms)) continue;
                                    echo '<div class="pickup-article-text__category" style="margin: 0; display: block; flex-shrink: 0; line-height: 1.4;"><span class="tag">' . esc_html($cat->name) . '</span></div>';
                                    $displayed_terms[] = $cat->name;
                                }
                            }
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
            <section>
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
                        $new_article_count = 0;
                        while ($new_query->have_posts()) : $new_query->the_post();
                            $new_article_count++;
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
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            foreach ($categories as $cat) {
                                                if ($cat->name === '記事') continue;
                                                if (in_array($cat->name, $displayed_terms)) continue;
                                                echo '<div class="new-article-text__category"><span class="tag">' . esc_html($cat->name) . '</span></div>';
                                                $displayed_terms[] = $cat->name;
                                            }
                                        }
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

            <!-- セクション間広告 -->
            <div class="infeed-ad-container">
                <div style="font-size: 10px; color: #999; margin-bottom: 5px; text-align: center;">スポンサーリンク</div>
                <div class="ad-widget-content">
                    <?php if ( wp_is_mobile() ) : ?>
                    <div id="im-87f8b9da487a4aa7a4ecc361036180bc">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1940482,type:"banner",display:"inline",elementid:"im-87f8b9da487a4aa7a4ecc361036180bc"})</script>
                    </div>
                    <?php else : ?>
                    <div id="im-e206045a1c11488aaa530bd0a19b87a0">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1940497,type:"banner",display:"inline",elementid:"im-e206045a1c11488aaa530bd0a19b87a0"})</script>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 4. トレンドセクション -->
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
            ?>
            <section>
                <h2 class="title-h2__text title-h2__text--trend"><i data-lucide="trending-up"></i> デザイントレンド</h2>
                <div class="new-article-list">
                    <?php
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
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            foreach ($categories as $cat) {
                                                if ($cat->name === '記事') continue;
                                                if (in_array($cat->name, $displayed_terms)) continue;
                                                echo '<div class="new-article-text__category"><span class="tag">' . esc_html($cat->name) . '</span></div>';
                                                $displayed_terms[] = $cat->name;
                                            }
                                        }
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
                    ?>
                </div>
            </section>
            <?php endif; ?>

                        <!-- セクション間広告 -->
            <div class="infeed-ad-container">
                <div style="font-size: 10px; color: #999; margin-bottom: 5px; text-align: center;">スポンサーリンク</div>
                <div class="ad-widget-content">
                    <?php if ( wp_is_mobile() ) : ?>
                    <div id="im-79bc582a444246aca87dc93cdca59754">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1940489,type:"banner",display:"inline",elementid:"im-79bc582a444246aca87dc93cdca59754"})</script>
                    </div>
                    <?php else : ?>
                    <div id="im-bec26fec7d03424dbfa16819180f496b">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1940499,type:"banner",display:"inline",elementid:"im-bec26fec7d03424dbfa16819180f496b"})</script>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 5. デザインナレッジセクション -->
            <?php
            $knowledge_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 4,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post__not_in'   => $exclude_post_ids,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'name',
                        'terms'    => 'デザインナレッジ',
                    ),
                ),
            ));
            if ($knowledge_query->have_posts()) :
            ?>
            <section>
                <h2 class="title-h2__text title-h2__text--category"><i data-lucide="shapes"></i> デザインナレッジ</h2>
                <div class="new-article-list">
                    <?php
                        while ($knowledge_query->have_posts()) : $knowledge_query->the_post();
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
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            foreach ($categories as $cat) {
                                                if ($cat->name === '記事') continue;
                                                if (in_array($cat->name, $displayed_terms)) continue;
                                                echo '<div class="new-article-text__category"><span class="tag">' . esc_html($cat->name) . '</span></div>';
                                                $displayed_terms[] = $cat->name;
                                            }
                                        }
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
                    ?>
                </div>
            </section>
            <?php endif; ?>

                        <!-- セクション間広告 -->
            <div class="infeed-ad-container">
                <div style="font-size: 10px; color: #999; margin-bottom: 5px; text-align: center;">スポンサーリンク</div>
                <div class="ad-widget-content">
                    <?php if ( wp_is_mobile() ) : ?>
                    <div id="im-78fd508d0d2d4686a3e4941ddd3e1b4a">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1940490,type:"banner",display:"inline",elementid:"im-78fd508d0d2d4686a3e4941ddd3e1b4a"})</script>
                    </div>
                    <?php else : ?>
                    <div id="im-13abb2381d71418297813c8ecbfaff02">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1940498,type:"banner",display:"inline",elementid:"im-13abb2381d71418297813c8ecbfaff02"})</script>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 6. ツール・開発環境セクション -->
            <?php
            $tool_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 4,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post__not_in'   => $exclude_post_ids,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'name',
                        'terms'    => 'ツール・開発環境',
                    ),
                ),
            ));
            if ($tool_query->have_posts()) :
            ?>
            <section>
                <h2 class="title-h2__text title-h2__text--category"><i data-lucide="shapes"></i> ツール・開発環境</h2>
                <div class="new-article-list">
                    <?php
                        while ($tool_query->have_posts()) : $tool_query->the_post();
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
                                        $displayed_terms = array();
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            foreach ($categories as $cat) {
                                                if ($cat->name === '記事') continue;
                                                if (in_array($cat->name, $displayed_terms)) continue;
                                                echo '<div class="new-article-text__category"><span class="tag">' . esc_html($cat->name) . '</span></div>';
                                                $displayed_terms[] = $cat->name;
                                            }
                                        }
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
                    ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- 7. ビジネス・キャリアセクション -->
            <?php
            $career_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 4,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post__not_in'   => $exclude_post_ids,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'name',
                        'terms'    => 'ビジネス・キャリア',
                    ),
                ),
            ));
            if ($career_query->have_posts()) :
            ?>
            <section>
                <h2 class="title-h2__text title-h2__text--category"><i data-lucide="shapes"></i> ビジネス・キャリア</h2>
                <div class="new-article-list">
                    <?php
                        while ($career_query->have_posts()) : $career_query->the_post();
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
                                        $displayed_terms = array();
                                        $categories = get_the_category();
                                        if (!empty($categories)) {
                                            foreach ($categories as $cat) {
                                                if ($cat->name === '記事') continue;
                                                if (in_array($cat->name, $displayed_terms)) continue;
                                                echo '<div class="new-article-text__category"><span class="tag">' . esc_html($cat->name) . '</span></div>';
                                                $displayed_terms[] = $cat->name;
                                            }
                                        }
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
                    ?>
                </div>
            </section>
            <?php endif; ?>
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
