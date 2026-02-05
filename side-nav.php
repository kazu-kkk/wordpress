<aside id="custom-side-nav" class="widget-area">


    <!-- プロフィールカード -->
    <div class="profile-card">
        <?php
        $upload_dir = wp_get_upload_dir();
        $profile_image_url = $upload_dir['baseurl'] . '/2025/01/cropped-433923002_301491172718535_3556504599640674491_n.jpg';
        ?>
        <img src="<?php echo esc_url($profile_image_url); ?>"
            alt="プロフィール画像" class="profile-avatar">

        <h2 class="profile-name">けーいち | H.K.</h2>
        <p class="profile-bio">UI/UX/グラフィックデザイナー | 都内勤務<br>モーションや写真、映像や3Dも時々触ります</p>
        <!-- <div class="profile-social">
            <a href="https://instagram.com" target="_blank" class="social-button"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram-icon.png" alt="Instagram"></a>
            <a href="https://twitter.com" target="_blank" class="social-button"><img src="<?php echo get_template_directory_uri(); ?>/images/x-icon.png" alt="X"></a>
            <a href="https://note.com" target="_blank" class="social-button"><img src="<?php echo get_template_directory_uri(); ?>/images/note-icon.png" alt="Note"></a>
        </div> -->
    </div>


    <!-- カテゴリ一覧 -->
    <h2 class="widget-title">カテゴリ</h2>
    <ul>
        <?php
        // 除外するカテゴリIDを指定
        $exclude_ids = array(2, 4, 5); // 除外したいカテゴリのID

        // カテゴリを取得してリスト表示（除外指定を追加）
        $categories = get_categories(array(
            'exclude' => $exclude_ids,
            'orderby' => 'term_order', // Category Order and Taxonomy Terms Order用
            'order'   => 'ASC',
        ));
        foreach ($categories as $category) {
            echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
        }
        ?>
    </ul>
</aside>