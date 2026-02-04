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
                <a href="<?php echo get_category_link(get_cat_ID('記事')); ?>" class="button">記事一覧に戻る</a>
            </article>

    <?php
        endwhile;
    endif;
    ?>

</main><!-- #main -->


<?php
get_footer(); ?>