<aside id="custom-side-nav" class="widget-area">
    <h2 class="widget-title">カテゴリ</h2>
    <ul>
        <?php
        // 除外するカテゴリIDを指定
        $exclude_ids = array(2, 4, 5); // 除外したいカテゴリのID

        // カテゴリを取得してリスト表示（除外指定を追加）
        $categories = get_categories(array(
            'exclude' => $exclude_ids
        ));
        foreach ($categories as $category) {
            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
        }
        ?>
    </ul>
</aside>