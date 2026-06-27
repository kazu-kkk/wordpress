<?php

/**
 * Enqueue parent and child theme stylesheets
 */

function inspiro_child_enqueue_styles()
{
    // Enqueue parent theme stylesheet
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/assets/css/minified/style.min.css');

    // Enqueue child theme stylesheet
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));

    // Enqueue additional stylesheet
    wp_enqueue_style('additional-style', get_stylesheet_directory_uri() . '/assets/css/style_add.css', array('child-style'), filemtime(get_stylesheet_directory() . '/assets/css/style_add.css'));
}

add_action('wp_enqueue_scripts', 'inspiro_child_enqueue_styles', 11);

if (! function_exists('inspiro_child_theme_setup')) {
    function inspiro_child_theme_setup()
    {
        // クラスファイルを読み込む
        require_once get_stylesheet_directory() . '/inc/classes/class-inspiro-after-setup-theme.php';

        // クラスのインスタンスを作成
        if (class_exists('Inspiro_After_Setup_Theme')) {
            new Inspiro_After_Setup_Theme();
        }

        // 画像サイズを追加
        add_image_size('inspiro-custom-size', 600, 0, true); // 幅600px、高さ400px、トリミング（true）
    }
}
add_action('after_setup_theme', 'inspiro_child_theme_setup');

/**
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support('post-thumbnails');

/**
 * Display post thumbnails
 */
function display_post_thumbnails()
{
    if (has_post_thumbnail()) {
        the_post_thumbnail('thumbnail'); // Thumbnail size
        the_post_thumbnail('medium'); // Medium size
        the_post_thumbnail('large'); // Large size
        the_post_thumbnail('full'); // Full size
        the_post_thumbnail('inspiro-custom-size'); // Custom size
    }
}

/**
 * Function to display a link as a card
 */
function show_Linkcard($atts)
{
    $atts = shortcode_atts(array(
        'url' => '',
        'title' => '',
        'excerpt' => '',
        'image' => ''
    ), $atts);

    if (empty($atts['url'])) {
        return '';
    }

    // トランジェントキーを生成（URL単位でキャッシュ）
    $cache_key = 'ogp_' . md5($atts['url']);
    $ogp_data  = get_transient($cache_key);

    if ($ogp_data === false) {
        // Fetch OpenGraph data
        require_once get_stylesheet_directory() . '/OpenGraph.php';
        $graph = OpenGraph::fetch($atts['url']);

        $ogp_data = array(
            'title'       => $graph->title ?? '',
            'image'       => $graph->image ?? '',
            'description' => $graph->description ?? '',
        );

        // 24時間キャッシュ（画像が取れなかった場合は1時間後に再試行）
        $ttl = !empty($ogp_data['image']) ? DAY_IN_SECONDS : HOUR_IN_SECONDS;
        set_transient($cache_key, $ogp_data, $ttl);
    }

    // タイトル・説明文・画像（ショートコードの引数が指定されていれば優先）
    $Link_title       = !empty($atts['title']) ? $atts['title'] : ($ogp_data['title'] ?? '');
    $src              = !empty($atts['image']) ? $atts['image'] : ($ogp_data['image'] ?? '');
    $Link_description = !empty($atts['excerpt']) ? $atts['excerpt'] : wp_trim_words($ogp_data['description'] ?? '', 60, '…');

    // 画像が取得できない場合や指定がない場合はデフォルトのNO IMAGE画像を設定
    if (empty($src)) {
        $src = get_stylesheet_directory_uri() . '/assets/images/no_image.png';
    }

    $no_image_url = get_stylesheet_directory_uri() . '/assets/images/no_image.png';
    $xLink_img = '<div class="blogcard_thumbnail"><img src="' . esc_url($src) . '" alt="' . esc_attr($Link_title) . '" loading="lazy" onerror="this.onerror=null;this.src=\'' . esc_url($no_image_url) . '\';" /></div>';

    // HTML output
    return '
    <div class="blogcard ex">
        <a href="' . esc_url($atts['url']) . '" target="_blank" rel="noopener noreferrer">
            ' . $xLink_img . '
            <div class="blogcard_content">
                <div class="blogcard_title">' . esc_html($Link_title) . '</div>
                <div class="blogcard_excerpt">' . esc_html($Link_description) . '</div>
            </div>
            <div class="clear"></div>
        </a>
    </div>';
}
add_shortcode('sc_Linkcard', 'show_Linkcard');

/**
 * Include content-excerpt template part
 */
function include_content_excerpt()
{
    get_template_part('content', 'excerpt');
}
add_action('wp_footer', 'include_content_excerpt');

// Googleフォントを追加
function inspiro_child_enqueue_google_fonts()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', [], null);
}
add_action('wp_enqueue_scripts', 'inspiro_child_enqueue_google_fonts');

/**
 * Custom Favicon
 */
function inspiro_child_custom_favicon() {
    $favicon_url = get_stylesheet_directory_uri() . '/assets/images/yuny_logo.png';
    echo '<link rel="shortcut icon" href="' . esc_url($favicon_url) . '" />' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url($favicon_url) . '" />' . "\n";
}
add_action('wp_head', 'inspiro_child_custom_favicon');

/**
 * Identify Custom Post Types in Archives
 */
function inspiro_child_add_cpt_to_archives($query) {
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    // Check for category or tag archives
    if ( (is_category() || is_tag()) && empty($query->query_vars['suppress_filters']) ) {
        // Include 'post' and likely CPT names.
        $query->set('post_type', array('post', 'portfolio_item', 'portfolio'));
    }
}
add_action('pre_get_posts', 'inspiro_child_add_cpt_to_archives');


/**
 * Enqueue scripts for search suggestions
 */
function inspiro_child_enqueue_scripts() {
    wp_enqueue_script(
        'inspiro-search-suggestion',
        get_stylesheet_directory_uri() . '/assets/js/search-suggestion.js',
        array(),
        filemtime(get_stylesheet_directory() . '/assets/js/search-suggestion.js'),
        true
    );

    wp_localize_script('inspiro-search-suggestion', 'inspiroSearch', array(
        'root' => esc_url_raw(rest_url()),
        'nonce' => wp_create_nonce('wp_rest')
    ));

    // トップページでのみヘッダーロゴのスクロール制御JSを読み込む
    if (is_front_page() || is_home()) {
        wp_enqueue_script(
            'inspiro-header-logo',
            get_stylesheet_directory_uri() . '/assets/js/header-logo.js',
            array(),
            filemtime(get_stylesheet_directory() . '/assets/js/header-logo.js'),
            true
        );
    }

    // 記事ページ（single）でのみ目次JSとシェアJSを読み込む
    if (is_single()) {
        wp_enqueue_script(
            'inspiro-toc',
            get_stylesheet_directory_uri() . '/assets/js/toc.js',
            array(),
            filemtime(get_stylesheet_directory() . '/assets/js/toc.js'),
            true
        );

        wp_enqueue_script(
            'inspiro-share',
            get_stylesheet_directory_uri() . '/assets/js/share.js',
            array(),
            filemtime(get_stylesheet_directory() . '/assets/js/share.js'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'inspiro_child_enqueue_scripts');


/**
 * Add custom search widget to primary menu for mobile
 */


/**
 * Target Audience Component (Shortcode)
 */
function inspiro_child_target_audience($atts) {
    $atts = shortcode_atts(array(
        'point1' => '',
        'point2' => '',
        'point3' => '',
    ), $atts);

    $html = '<div class="target-audience">';
    $html .= '<div class="target-audience__title">この記事はこんな方に向けて書いています</div>';
    
    $has_points = false;
    $points_html = '<ul class="target-audience__list">';
    
    for ($i = 1; $i <= 3; $i++) {
        $point = $atts['point' . $i];
        if (!empty($point)) {
            $has_points = true;
            $points_html .= '<li class="target-audience__item">' . esc_html($point) . '</li>';
        }
    }
    $points_html .= '</ul>';

    if ($has_points) {
        $html .= $points_html;
    }

    $html .= '</div>';

    return $html;
}
add_shortcode('target_audience', 'inspiro_child_target_audience');

/**
 * トップページ（ホーム）の表示件数を最新8記事のみに制限する
 */
function inspiro_child_limit_home_posts($query) {
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    if (is_home() || is_front_page()) {
        $query->set('posts_per_page', 8);
    }
}
add_action('pre_get_posts', 'inspiro_child_limit_home_posts');

/**
 * アーカイブページのタイトルをカスタマイズ
 * "記事"カテゴリーの場合は「すべての記事」と表示する
 */
function inspiro_child_custom_archive_title($title) {
    if (is_category()) {
        $cat_title = single_term_title('', false);
        if (trim($cat_title) === '記事' || trim($cat_title) === 'article' || trim($cat_title) === 'Article') {
            $title = 'すべての記事';
        }
    }
    return $title;
}
add_filter('get_the_archive_title', 'inspiro_child_custom_archive_title', 999);

/**
 * 記事ページでヘッダーが透過する問題（has-header-imageクラスの付与）を解除する
 */
function inspiro_child_remove_header_image_class($classes) {
    if (is_single()) {
        $classes = array_diff($classes, array('has-header-image'));
    }
    return $classes;
}
add_filter('body_class', 'inspiro_child_remove_header_image_class', 999);

/**
 * Checklist Shortcodes
 */
function inspiro_child_checklist_shortcode($atts, $content = null) {
    // do_shortcodeで[check]を展開
    $content = do_shortcode($content);
    // wpautopによって追加される可能性のある不要な<p>や<br>を削除
    $content = str_replace(array('<p>', '</p>', '<br />', '<br>'), '', $content);
    return '<ul class="checklist">' . trim($content) . '</ul>';
}
add_shortcode('checklist', 'inspiro_child_checklist_shortcode');

function inspiro_child_check_shortcode($atts, $content = null) {
    return '<li>' . do_shortcode(trim($content)) . '</li>';
}
add_shortcode('check', 'inspiro_child_check_shortcode');

/**
 * Helper to resolve pin.it shortlinks to full Pinterest URLs
 */
function inspiro_child_resolve_pinterest_url($url) {
    if (strpos($url, 'pin.it') === false) {
        return $url;
    }
    
    $cache_key = 'resolved_pin_' . md5($url);
    $resolved = get_transient($cache_key);
    
    if ($resolved) {
        return $resolved;
    }

    $response = wp_remote_get($url, array('redirection' => 5, 'timeout' => 5));
    if (!is_wp_error($response)) {
        // wp_remote_get follows redirects and the final URL might be in the history or header.
        // Actually, if it follows redirects, we can just grab the final URL from the response or wait,
        // often Pinterest redirect ends with a 200 OK on the final page.
        // But since wp_remote_* functions might not easily expose the final URL, we can do a simple cURL or get_headers fallback.
        $headers = @get_headers($url, 1);
        if ($headers && isset($headers['Location'])) {
            $location = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
            // location could be another redirect: https://api.pinterest.com/url_shortener/...
            // we should probably just extract the pin ID if possible, but let's try to get headers again if it's api.pinterest
            if (strpos($location, 'api.pinterest.com') !== false) {
                $headers2 = @get_headers($location, 1);
                if ($headers2 && isset($headers2['Location'])) {
                    $location = is_array($headers2['Location']) ? end($headers2['Location']) : $headers2['Location'];
                }
            }
            if (!empty($location)) {
                // Ensure it's cleanly formatted (remove query strings like ?invite_code=...)
                $location = preg_replace('/\?.*/', '', $location);
                set_transient($cache_key, $location, MONTH_IN_SECONDS);
                return $location;
            }
        }
    }
    return $url;
}

/**
 * Pinterest Embed Shortcode (Official Widget)
 * [pinterest_embed url="https://www.pinterest.jp/pin/xxxxxx/"]
 */
function inspiro_child_pinterest_embed_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '',
        'size' => 'large', // small, medium, large
    ), $atts);

    if (empty($atts['url'])) {
        return '';
    }

    $final_url = inspiro_child_resolve_pinterest_url($atts['url']);

    return '<div class="pinterest-embed"><a data-pin-do="embedPin" data-pin-width="' . esc_attr($atts['size']) . '" href="' . esc_url($final_url) . '"></a><script async defer src="https://assets.pinterest.com/js/pinit.js"></script></div>';
}
add_shortcode('pinterest_embed', 'inspiro_child_pinterest_embed_shortcode');

/**
 * Pinterest Image Fetch Shortcode (OGP Scraping)
 * [pinterest_image url="https://www.pinterest.jp/pin/xxxxxx/"]
 */
function inspiro_child_pinterest_image_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url'    => '',
        'width'  => 'auto',
        'height' => '300px',
        'alt'    => 'Pinterest Image', // デフォルトのaltテキスト
    ), $atts);

    if (empty($atts['url'])) {
        return '';
    }

    $final_url = inspiro_child_resolve_pinterest_url($atts['url']);

    $cache_key = 'pinterest_ogp_' . md5($final_url);
    $image_url = get_transient($cache_key);

    if ($image_url === false) {
        if (!class_exists('OpenGraph')) {
            require_once get_stylesheet_directory() . '/OpenGraph.php';
        }
        $graph = OpenGraph::fetch($final_url);
        $image_url = $graph->image ?? '';

        $ttl = !empty($image_url) ? DAY_IN_SECONDS : HOUR_IN_SECONDS;
        set_transient($cache_key, $image_url, $ttl);
    }

    if (empty($image_url)) {
        return '<p>Pinterest画像の取得に失敗しました。</p>';
    }

    $width_val = $atts['width'];
    $height_val = $atts['height'];
    
    // pxなどの単位がない場合はpxを補完（autoなどの文字列はそのまま）
    $width_css = is_numeric($width_val) ? $width_val . 'px' : $width_val;
    $height_css = is_numeric($height_val) ? $height_val . 'px' : $height_val;

    // imgタグ用の属性値（autoなどの場合は出力しない）
    $img_width_attr = is_numeric($width_val) ? ' width="' . esc_attr($width_val) . '"' : '';
    $img_height_attr = is_numeric($height_val) ? ' height="' . esc_attr($height_val) . '"' : '';

    // 画像自体にサイズを指定し、親要素で中央寄せする構成に変更（余白ができなくなる）
    $unique_id = 'pin_' . md5($final_url . $width_css . $height_css . uniqid());
    
    $custom_css = "<style>
        .{$unique_id} {
            margin: 2rem auto;
            text-align: center;
        }
        .{$unique_id} a.pin-link {
            display: inline-block;
            max-width: 100%;
        }
        .{$unique_id} img {
            width: {$width_css} !important;
            height: {$height_css} !important;
            max-width: 100% !important;
            object-fit: contain !important;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .{$unique_id} .pin-source {
            margin-top: 8px;
            font-size: 12px;
            color: #666;
        }
        .{$unique_id} .pin-source a {
            color: #666;
            text-decoration: underline;
        }
        .{$unique_id} .pin-source a:hover {
            color: #2b53ec;
        }
    </style>";

    // alt属性の値を取得
    $alt_text = isset($atts['alt']) ? $atts['alt'] : 'Pinterest Image';

    return $custom_css . '<div class="' . esc_attr($unique_id) . ' pinterest-image-wrapper">
        <a href="' . esc_url($final_url) . '" target="_blank" rel="noopener noreferrer" class="pin-link">
            <img src="' . esc_url($image_url) . '" alt="' . esc_attr($alt_text) . '" class="pinterest-image" loading="lazy" ' . $img_width_attr . $img_height_attr . ' />
        </a>
        <div class="pin-source">出典：<a href="' . esc_url($final_url) . '" target="_blank" rel="noopener noreferrer">Pinterest</a></div>
    </div>';
}
add_shortcode('pinterest_image', 'inspiro_child_pinterest_image_shortcode');

/**
 * 記事本文に目次（TOC）を自動挿入する
 * - h2 / h3 を抽出し、IDを付与してアンカーリンクを生成
 * - 見出しが2つ以上ある場合のみ表示
 * - デフォルトは閉じた状態（JS側で開閉を制御）
 */
function inspiro_child_auto_toc($content) {
    if (!is_single()) {
        return $content;
    }

    // h2 / h3 を抽出
    preg_match_all('/<h([23])[^>]*>(.*?)<\/h[23]>/is', $content, $matches, PREG_SET_ORDER);

    if (count($matches) < 2) {
        return $content;
    }

    $toc_items = '';
    $used_ids  = [];
    $new_content = $content;

    foreach ($matches as $match) {
        $level = $match[1];                          // '2' or '3'
        $text  = wp_strip_all_tags($match[2]);       // プレーンテキスト

        // IDを生成（日本語OK、重複時は連番を付与）
        $raw_id  = sanitize_title($text);
        if (empty($raw_id)) {
            $raw_id = 'section';
        }
        $id = $raw_id;
        $i  = 1;
        while (in_array($id, $used_ids, true)) {
            $id = $raw_id . '-' . $i;
            $i++;
        }
        $used_ids[] = $id;

        // 元の見出しタグにIDを付与（最初の出現箇所のみ置換）
        $original_tag = $match[0];
        $with_id      = preg_replace('/<h' . $level . '([^>]*)>/', '<h' . $level . '$1 id="' . esc_attr($id) . '">', $original_tag, 1);
        $new_content  = preg_replace('/' . preg_quote($original_tag, '/') . '/', $with_id, $new_content, 1);

        $item_class  = 'toc__item--h' . $level;
        $toc_items  .= '<li class="toc__item ' . $item_class . '">';
        $toc_items  .= '<a class="toc__link" href="#' . esc_attr($id) . '">' . esc_html($text) . '</a>';
        $toc_items  .= '</li>';
    }

    $toc_html = '
<div class="toc">
    <div class="toc__header">
        <div class="toc__title">目次</div>
        <span class="toc__toggle">開く</span>
    </div>
    <div class="toc__body">
        <ul class="toc__list">' . $toc_items . '</ul>
    </div>
</div>';

    // 最初の h2 の直前に目次を挿入
    $new_content = preg_replace('/<h2/', $toc_html . '<h2', $new_content, 1);

    return $new_content;
}
add_filter('the_content', 'inspiro_child_auto_toc', 20);

/**
 * Add OGP Meta Tags to Head
 */
function inspiro_child_add_ogp()
{
    if (is_admin()) {
        return;
    }

    $og_title       = get_bloginfo('name');
    $og_description = 'デザペディアは、デザイナーやクリエイターのための情報メディアサイトです。最新のデザインニュース、クリエイティブなインスピレーション、業界のトレンド、役立つツールやチュートリアルを提供し、あなたのクリエイティブな活動をサポートします。';
    $og_url         = home_url('/');
    $og_type        = 'website';
    $og_image       = '';

    // デフォルト画像の設定（ロゴなど）
    if (has_custom_logo()) {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo_img_src = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($logo_img_src) {
            $og_image = $logo_img_src[0];
        }
    }
    
    // カスタムロゴが取得できない、または設定がない場合はデフォルトのブログロゴ画像を設定
    if (empty($og_image)) {
        $og_image = home_url('/wp-content/uploads/2025/01/ブログロゴ.png');
    }

    if (is_single() || is_page()) {
        $post_id = get_the_ID();
        $post = get_post($post_id);
        if ($post) {
            $og_title       = get_the_title($post_id);
            $og_url         = get_permalink($post_id);
            $og_type        = 'article';

            // 抜粋があれば使用し、なければ本文から120文字を自動生成
            $excerpt = $post->post_excerpt;
            if (empty($excerpt)) {
                $plain_content = wp_strip_all_tags(strip_shortcodes($post->post_content));
                $excerpt       = mb_substr($plain_content, 0, 120, 'UTF-8');
                if (mb_strlen($plain_content, 'UTF-8') > 120) {
                    $excerpt .= '…';
                }
            }
            $og_description = esc_attr($excerpt);

            if (has_post_thumbnail($post_id)) {
                $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
                if ($thumbnail_src) {
                    $og_image = $thumbnail_src[0];
                }
            }
        }
    }

    // OGP タグの出力
    echo "\n" . '<!-- OGP Meta Tags -->' . "\n";
    echo '<meta name="description" content="' . esc_attr($og_description) . '" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($og_title) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($og_description) . '" />' . "\n";
    echo '<meta property="og:url" content="' . esc_url($og_url) . '" />' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '" />' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . "\n";
    if (!empty($og_image)) {
        echo '<meta property="og:image" content="' . esc_url($og_image) . '" />' . "\n";
    }
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($og_title) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($og_description) . '" />' . "\n";
    if (!empty($og_image)) {
        echo '<meta name="twitter:image" content="' . esc_url($og_image) . '" />' . "\n";
    }
    echo '<!-- /OGP Meta Tags -->' . "\n";
}
add_action('wp_head', 'inspiro_child_add_ogp');

/**
 * 強制キャッシュ破り: style_add.cssのバージョンパラメータを動的（タイムスタンプ）に変換
 */
add_filter('style_loader_src', function($src, $handle) {
    if ($handle === 'inspiro-child-style' || $handle === 'additional-style' || strpos($src, 'style_add.css') !== false) {
        $src = remove_query_arg('ver', $src);
        $src = add_query_arg('ver', time(), $src);
    }
    return $src;
}, 9999, 2);

