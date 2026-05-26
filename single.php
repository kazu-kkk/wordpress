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
                            <?php the_tags('<ul><li>', '</li><li>', '</li></ul>'); ?>
                        </div>
                    </div>

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

                </div>

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
                <section class="related-posts">
                    <h2 class="related-posts__title">関連記事</h2>
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
            </article>

    <?php
        endwhile;
    endif;
    ?>

</main><!-- #main -->


<?php
get_footer(); ?>