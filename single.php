<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Inspiro
 * @subpackage Inspiro_Lite
 * @since Inspiro 1.0.0
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="site-main container-fluid" role="main">

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>

            <article id="post-<?php the_ID(); ?>" class="content-wrapper">
                <div class="content">
                    <h1 class="article-title"><?php the_title(); ?></h1>
                    <div class="article-sub">
                        <p class="article-sub-date"><?php the_time('Y年m月d日'); ?></p>
                        <div>
                            <?php
                            $tags = get_the_tags();
                            if ($tags) {
                                $tag_links = array();
                                foreach ($tags as $tag) {
                                    if (strtolower($tag->name) === 'pickup') continue;
                                    $tag_links[] = '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" rel="tag">' . esc_html($tag->name) . '</a>';
                                }
                                if (!empty($tag_links)) {
                                    echo '<ul><li>' . implode('</li><li>', $tag_links) . '</li></ul>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <?php get_template_part('template-parts/share-buttons'); ?>

                    <!-- ここにサムネイルを追加 -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="article-sub-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    <!-- 追加ここまで -->

                    <div class="article-text">
                        <?php the_content(); ?>
                    </div>

                    <?php get_template_part('template-parts/share-buttons'); ?>

                    <?php
                    // ── 関連記事セクション ──────────────────────────────────────
                    $related_posts = [];

                    // クリティカルに刺さる関連記事を取得（手動指定優先 ＋ タグ一致数スコアリング）
                    $related_posts = inspiro_child_get_critical_related_posts(get_the_ID(), 3);

                    if ($related_posts) : ?>
                    <!-- 記事下広告 -->
                    <div class="ad-widget" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
                        <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
                        <?php if ( wp_is_mobile() ) : ?>
                        <div id="im-d42fdd9186c2432aa61cd743ae247b05">
                            <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                            <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1940493,type:"banner",display:"inline",elementid:"im-d42fdd9186c2432aa61cd743ae247b05"})</script>
                        </div>
                        <?php else : ?>
                        <div id="im-68a2d4103f124bc8bf3520f0e0742642">
                            <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                            <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1940487,type:"banner",display:"inline",elementid:"im-68a2d4103f124bc8bf3520f0e0742642"})</script>
                        </div>
                        <?php endif; ?>
                    </div>
                    <section class="related-posts">
                        <h2 class="related-posts__title">この記事も読まれています</h2>
                        <div class="new-article-list">
                            <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                            <?php $thumbnail_url = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : get_stylesheet_directory_uri() . '/assets/images/no_image.png'; ?>
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
                            <?php endforeach; wp_reset_postdata(); ?>
                        </div>
                    </section>
                    <?php endif; ?>

                    <a href="<?php echo get_category_link(get_cat_ID('記事')); ?>" class="button">記事一覧に戻る</a>
                </div>
            </article>

    <?php
        endwhile;
    endif;
    ?>

</main><!-- #main -->


<?php
get_footer(); ?>