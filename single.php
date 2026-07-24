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

                    // 1) タグで検索
                    $tags = wp_get_post_tags(get_the_ID());
                    if ($tags) {
                        $tag_ids = wp_list_pluck($tags, 'term_id');
                        $related_posts = get_posts([
                            'tag__in'        => $tag_ids,
                            'post__not_in'   => [get_the_ID()],
                            'posts_per_page' => 3,
                            'post_status'    => 'publish',
                        ]);
                    }

                    // 2) タグで足りなければカテゴリでフォールバック
                    if (empty($related_posts)) {
                        $cats = wp_get_post_categories(get_the_ID());
                        if ($cats) {
                            $related_posts = get_posts([
                                'category__in'   => $cats,
                                'post__not_in'   => [get_the_ID()],
                                'posts_per_page' => 3,
                                'post_status'    => 'publish',
                            ]);
                        }
                    }

                    if ($related_posts) : ?>
                    <!-- 記事下広告 -->
                    <div class="ad-widget" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
                        <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
                        <?php if ( wp_is_mobile() ) : ?>
                        <div id="im-1eae1085f45c43698d0a456571986d00-bottom">
                            <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                            <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1937823,type:"banner",display:"inline",elementid:"im-1eae1085f45c43698d0a456571986d00-bottom"})</script>
                        </div>
                        <?php else : ?>
                        <div id="im-91b0abf8dd8043e3a85b798346681f1d-bottom">
                            <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                            <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1937816,type:"banner",display:"inline",elementid:"im-91b0abf8dd8043e3a85b798346681f1d-bottom"})</script>
                        </div>
                        <?php endif; ?>
                    </div>
                    <section class="related-posts">
                        <h2 class="related-posts__title">この記事も読まれています</h2>
                        <div class="related-posts__grid">
                            <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                            <a href="<?php the_permalink(); ?>" class="related-posts__card">
                                <div class="related-posts__thumb">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium'); ?>
                                    <?php else : ?>
                                        <div class="related-posts__thumb-fallback"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="related-posts__body">
                                    <p class="related-posts__date"><?php echo get_the_date('Y年m月d日'); ?></p>
                                    <p class="related-posts__name"><?php the_title(); ?></p>
                                </div>
                            </a>
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