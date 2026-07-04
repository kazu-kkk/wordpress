<aside id="custom-side-nav" class="widget-area">
    <?php if ( is_front_page() || is_page_template('page-templates/page-top-preview.php') ) : ?>
    <!-- プロフィールカード -->
    <div class="profile-card">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/yuny_logo.png"
            alt="プロフィール画像" class="profile-avatar">
        <h2 class="profile-name">Yuny</h2>
        <p class="profile-bio">UI/UX/グラフィックデザイナー<br>モーションや写真、映像や3Dも時々触ります</p>
    </div>
    <?php endif; ?>

    <!-- 記事検索 -->
    <div class="search-widget">
        <h2 class="widget-title">SEARCH</h2>
        <div class="search-container">
            <input type="text" id="article-search-input" placeholder="キーワード検索..." autocomplete="off">
            <ul id="search-suggestions" class="search-suggestions"></ul>
        </div>
    </div>

    <!-- カテゴリ一覧 -->
    <h2 class="widget-title">CATEGORY</h2>
    <ul class="side-nav-category-list">
        <?php
        $categories = get_categories(array(
            'orderby' => 'name',
            'order'   => 'ASC',
            'hide_empty' => true,
        ));
        foreach ($categories as $cat) {
            if ($cat->name === '記事') continue;
            echo '<li><a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a></li>';
        }
        ?>
    </ul>

    <!-- 人気タグ -->
    <div class="popular-tag">
        <h2 class="widget-title">人気のタグ</h2>
        <ul class="popular-tag-list">
            <?php
            // 「記事」カテゴリ（実際の記事）に属する投稿のみを取得
            $real_posts_query = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'name',
                        'terms'    => '記事',
                    ),
                ),
            ));

            $tag_counts = array();

            if ($real_posts_query->have_posts()) {
                while ($real_posts_query->have_posts()) {
                    $real_posts_query->the_post();
                    $post_tags = get_the_tags();
                    if (!empty($post_tags)) {
                        foreach ($post_tags as $tag) {
                            if (!isset($tag_counts[$tag->term_id])) {
                                $tag_counts[$tag->term_id] = array(
                                    'term_id' => $tag->term_id,
                                    'name'    => $tag->name,
                                    'count'   => 0,
                                );
                            }
                            $tag_counts[$tag->term_id]['count']++;
                        }
                    }
                }
                wp_reset_postdata();
            }

            // カウント数で降順にソート
            usort($tag_counts, function($a, $b) {
                return $b['count'] - $a['count'];
            });

            // 上位10件を取得
            $top_tags = array_slice($tag_counts, 0, 10);

            if (!empty($top_tags)) {
                foreach ($top_tags as $t) {
                    echo '<li><a href="' . esc_url(get_tag_link($t['term_id'])) . '" class="tag">' . esc_html($t['name']) . ' <span style="font-size: 0.9em; opacity: 0.8; font-weight: normal;">(' . intval($t['count']) . ')</span></a></li>';
                }
            } else {
                echo '<li>タグがありません</li>';
            }
            ?>
        </ul>
    </div>
</aside>