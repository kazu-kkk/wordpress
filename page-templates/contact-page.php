<?php

/**
 * Template Name: お問い合わせページ
 * Description: 固定ページ用のカスタムお問い合わせテンプレート
 *
 * @package Inspiro
 */

get_header(); ?>

<?php if ((is_page() && ! inspiro_is_frontpage()) && ! has_post_thumbnail(get_queried_object_id())) : ?>
    <div class="inner-wrap">
        <div id="primary" class="content-area">
        <?php endif ?>

        <main id="main" class="site-main container-fluid" role="main">

            <?php
            while (have_posts()) :
                the_post();
            ?>

                <article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> page type-page status-publish hentry">

                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <div class="entry-content">
                        <p class="contact-text">ご連絡は以下のリンクからお願いします。</p>

                        <!-- Instagramリンク -->
                        <div class="instagram-card-container">
                            <a href="https://www.instagram.com/dspedia_byyuny?igsh=MW1kZnF1YWc5aHpoag%3D%3D&utm_source=qr"
                                class="instagram-card"
                                target="_blank"
                                rel="noopener noreferrer">
                                <div class="instagram-avatar">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/yuny_logo.png" alt="Instagram Icon">
                                </div>
                                <div class="instagram-info">
                                    <p class="instagram-username">Yuny</p>
                                    <span class="instagram-button">Instagramで連絡する</span>
                                </div>
                            </a>
                        </div>
                    </div><!-- .entry-content -->

                </article><!-- #post -->

            <?php
            endwhile; // End the loop.
            ?>

        </main><!-- #main -->

        <?php if ((is_page() && ! inspiro_is_frontpage()) && ! has_post_thumbnail(get_queried_object_id())) : ?>
        </div><!-- #primary -->
    </div><!-- .inner-wrap -->
<?php endif ?>

<div style="height: 200px;"></div> <!-- 下部に高さ200pxを追加 -->

<?php
get_footer();
