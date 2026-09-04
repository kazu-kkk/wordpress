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
    $cache_key = 'ogp_v6_' . md5($atts['url']);
    $ogp_data  = get_transient($cache_key);

    if ($ogp_data === false) {
        // Fetch OpenGraph data
        require_once get_stylesheet_directory() . '/OpenGraph.php';
        $graph = OpenGraph::fetch($atts['url']);

        if ($graph !== false) {
            $ogp_data = array(
                'title'       => $graph->title ?? '',
                'image'       => $graph->image ?? '',
                'description' => $graph->description ?? '',
            );
            
            // 24時間キャッシュ（画像が取れなかった場合は1時間後に再試行）
            $ttl = !empty($ogp_data['image']) ? DAY_IN_SECONDS : HOUR_IN_SECONDS;
            set_transient($cache_key, $ogp_data, $ttl);
        } else {
            // 取得失敗時はデフォルト値を設定し、短時間（5分）だけキャッシュする
            $ogp_data = array(
                'title'       => '',
                'image'       => '',
                'description' => '',
            );
            set_transient($cache_key, $ogp_data, 5 * MINUTE_IN_SECONDS);
        }
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


// Googleフォントとカスタムフォントを追加
function inspiro_child_enqueue_google_fonts()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap', [], null);
    wp_enqueue_style('gen-interface-jp-400', 'https://cdn.jsdelivr.net/npm/gen-interface-jp@0.8.0/cdn/400.css', [], null);
    wp_enqueue_style('gen-interface-jp-700', 'https://cdn.jsdelivr.net/npm/gen-interface-jp@0.8.0/cdn/700.css', [], null);
}
add_action('wp_enqueue_scripts', 'inspiro_child_enqueue_google_fonts');


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
    $theme_version = wp_get_theme()->get('Version');
    
    // ヘルパー関数: ファイルが存在する場合は更新日時を、存在しない場合はテーマバージョンを返す
    $get_file_version = function($relative_path) use ($theme_version) {
        $absolute_path = get_stylesheet_directory() . $relative_path;
        return file_exists($absolute_path) ? filemtime($absolute_path) : $theme_version;
    };

    // Lucide Icons はフッターで確実に出力するため、ここでは enqueue しない

    wp_enqueue_script(
        'inspiro-search-suggestion',
        get_stylesheet_directory_uri() . '/assets/js/search-suggestion.js',
        array(),
        $get_file_version('/assets/js/search-suggestion.js'),
        true
    );

    wp_localize_script('inspiro-search-suggestion', 'inspiroSearch', array(
        'root'    => esc_url_raw(rest_url()),
        'nonce'   => wp_create_nonce('wp_rest'),
        'homeUrl' => esc_url_raw(home_url('/')),
    ));

    // トップページでのみヘッダーロゴのスクロール制御JSを読み込む
    if (is_front_page() || is_home()) {
        wp_enqueue_script(
            'inspiro-header-logo',
            get_stylesheet_directory_uri() . '/assets/js/header-logo.js',
            array(),
            $get_file_version('/assets/js/header-logo.js'),
            true
        );
    }

    // 記事ページ（single）でのみ各種スクリプトを読み込む
    if (is_single()) {
        wp_enqueue_script(
            'inspiro-scroll-tracking',
            get_stylesheet_directory_uri() . '/assets/js/scroll-tracking.js',
            array(),
            $get_file_version('/assets/js/scroll-tracking.js'),
            true
        );

        wp_enqueue_script(
            'inspiro-toc',
            get_stylesheet_directory_uri() . '/assets/js/toc.js',
            array(),
            $get_file_version('/assets/js/toc.js'),
            true
        );

        wp_enqueue_script(
            'inspiro-share',
            get_stylesheet_directory_uri() . '/assets/js/share.js',
            array(),
            $get_file_version('/assets/js/share.js'),
            true
        );
    }

    // 全ページ共通のアナリティクスイベント計測JS
    wp_enqueue_script(
        'inspiro-analytics-events',
        get_stylesheet_directory_uri() . '/assets/js/analytics-events.js',
        array(),
        $get_file_version('/assets/js/analytics-events.js'),
        true
    );

    // 後で読む（ブックマーク）スクリプト（全ページ共通）
    wp_enqueue_script(
        'inspiro-reading-list',
        get_stylesheet_directory_uri() . '/assets/js/reading-list.js',
        array(),
        $get_file_version('/assets/js/reading-list.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'inspiro_child_enqueue_scripts', 20);

/**
 * [reading_list] ショートコード
 * 任意の固定ページやブロックで後で読む一覧を表示可能にする
 */
function inspiro_reading_list_shortcode() {
    ob_start();
    ?>
    <div class="reading-list-main" style="width: 100%;">
        <header class="reading-list-header">
            <div class="reading-list-header__content">
                <h1 class="reading-list-header__title">
                    <i data-lucide="bookmark" class="reading-list-header__icon"></i>
                    後で読むリスト
                </h1>
                <p class="reading-list-header__desc">ブラウザに一時保存した記事の一覧です。</p>
            </div>
            <div class="reading-list-header__actions">
                <span class="reading-list-header__count">保存中: <strong class="js-reading-list-count">0</strong> 件</span>
                <button type="button" class="reading-list-clear-btn js-reading-list-clear" style="display: none;" aria-label="保存した記事をすべて削除">
                    <i data-lucide="trash-2"></i>
                    <span>すべて削除</span>
                </button>
            </div>
        </header>

        <div class="reading-list-container js-reading-list-container">
            <div class="reading-list-loading js-reading-list-loading">
                <p>読み込み中...</p>
            </div>
        </div>

        <div class="reading-list-empty js-reading-list-empty" style="display: none;">
            <div class="reading-list-empty__icon-wrap">
                <i data-lucide="bookmark"></i>
            </div>
            <h2 class="reading-list-empty__title">保存された記事はありません</h2>
            <p class="reading-list-empty__desc">
                気になる記事を見つけたら、記事一覧や詳細ページの「しおりアイコン」を押して追加してください。
            </p>
            <div class="reading-list-empty__action">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="reading-list-empty__btn">
                    トップページへ戻る
                </a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('reading_list', 'inspiro_reading_list_shortcode');

/**
 * 固定ページ未作成でも /reading-list/ で「後で読む一覧」を表示可能にするルーティング
 */
add_action('template_redirect', function() {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $path = trim(parse_url($request_uri, PHP_URL_PATH), '/');

    if ($path === 'reading-list') {
        global $wp_query;
        status_header(200);
        $wp_query->is_404  = false;
        $wp_query->is_page = true;
        
        $template = get_stylesheet_directory() . '/page-reading-list.php';
        if (file_exists($template)) {
            include $template;
            exit;
        }
    }
});

/**
 * Initialize Lucide Icons in footer
 */
function inspiro_child_init_lucide_icons() {
    ?>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // DOMContentLoaded と、遅延した場合のための即時実行の両方で対応
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof lucide !== "undefined") {
                lucide.createIcons();
            }
        });
        // 既にDOMが構築済みの場合は即実行
        if (document.readyState === "complete" || document.readyState === "interactive") {
            if (typeof lucide !== "undefined") {
                lucide.createIcons();
            }
        }
    </script>
    <?php
}
add_action('wp_footer', 'inspiro_child_init_lucide_icons', 100);


/**
 * Add custom search widget to primary menu for mobile
 */


/**
 * Article Summary Component (Shortcode)
 */
function inspiro_child_article_summary($atts) {
    $atts = shortcode_atts(array(
        'point1' => '',
        'point2' => '',
        'point3' => '',
    ), $atts);

    $html = '<div class="article-summary">';
    $html .= '<div class="article-summary__title">この記事の要約</div>';
    
    $has_points = false;
    $points_html = '<ul class="article-summary__list">';
    
    for ($i = 1; $i <= 3; $i++) {
        $point = $atts['point' . $i];
        if (!empty($point)) {
            $has_points = true;
            $points_html .= '<li class="article-summary__item">' . esc_html($point) . '</li>';
        }
    }
    $points_html .= '</ul>';

    if ($has_points) {
        $html .= $points_html;
    }

    $html .= '</div>';

    return $html;
}
add_shortcode('article_summary', 'inspiro_child_article_summary');

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
    $a = shortcode_atts(array(
        'title' => '',
    ), $atts);

    // [check]テキスト[/check] の閉じタグありを処理
    $content = preg_replace('/\[check\](.*?)\[\/check\]/is', '<li>$1</li>', $content);
    // [check]テキスト の閉じタグなし（改行まで）を処理
    $content = preg_replace('/\[check\]([^\n\r]*)/i', '<li>$1</li>', $content);

    // 他のショートコードがあれば展開
    $content = do_shortcode($content);
    // wpautopによって追加される可能性のある不要な<p>や<br>を削除
    $content = str_replace(array('<p>', '</p>', '<br />', '<br>'), '', $content);
    
    $title_html = '';
    $wrapper_class = 'checklist-wrapper';
    
    if (!empty($a['title'])) {
        $title_html = '<div class="checklist-title">' . esc_html($a['title']) . '</div>';
        $wrapper_class .= ' has-title';
    } else {
        $wrapper_class .= ' no-title';
    }

    return '<div class="' . esc_attr($wrapper_class) . '">' . $title_html . '<ul class="checklist">' . trim($content) . '</ul></div>';
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

    if ( wp_is_mobile() ) {
        $ad_html = '
<div class="ad-widget" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
    <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
    <div id="im-b379ae08e658400daf60492490c57be3">
        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1940491,type:"banner",display:"inline",elementid:"im-b379ae08e658400daf60492490c57be3"})</script>
    </div>
</div>';
    } else {
        $ad_html = '
<div class="ad-widget" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
    <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
    <div id="im-659427e020b640f3b9e1dde8573c061a">
        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1940485,type:"banner",display:"inline",elementid:"im-659427e020b640f3b9e1dde8573c061a"})</script>
    </div>
</div>';
    }

    // 最初の h2 の直前に目次と広告を挿入
    $new_content = preg_replace('/<h2/', $toc_html . $ad_html . '<h2', $new_content, 1);

    return $new_content;
}
add_filter('the_content', 'inspiro_child_auto_toc', 20);



/**
 * Optimize Title Tag for SEO
 */
add_filter('document_title_parts', function($title) {
    if (is_front_page() || is_home()) {
        $title['title'] = 'デザペディア - Webデザイン・UX / UI・チュートリアルの情報メディアサイト';
        unset($title['tagline']); // サイトのキャッチフレーズ部分を削除してスッキリさせる
    }
    return $title;
});

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

/**
 * 記事カード・一覧表示用のタグ配列を取得するヘルパー関数
 * - 'pickup' タグを除外
 * - カテゴリー名（「その他」「記事」およびサイト内の全カテゴリー名）と同名のタグを除外
 * - 重複タグを除外
 *
 * @param int|WP_Post|null $post 投稿オブジェクトまたは投稿ID（nullの場合は現在のグローバル投稿）
 * @return WP_Term[]
 */
function inspiro_get_display_tags($post = null) {
    $post_obj = get_post($post);
    if (!$post_obj) {
        return array();
    }

    $tags = get_the_tags($post_obj->ID);
    if (empty($tags)) {
        return array();
    }

    // サイト内の全カテゴリー名および固定除外名を取得
    static $excluded_names = null;
    if ($excluded_names === null) {
        $cats = get_categories(array('hide_empty' => false));
        $excluded_names = !empty($cats) ? wp_list_pluck($cats, 'name') : array();
        $excluded_names[] = 'その他';
        $excluded_names[] = '記事';
        $excluded_names[] = 'pickup';
        $excluded_names = array_map('mb_strtolower', $excluded_names);
    }

    $filtered_tags = array();
    $displayed_terms = array();

    foreach ($tags as $tag) {
        $tag_name_lower = mb_strtolower($tag->name);
        if (in_array($tag_name_lower, $excluded_names, true)) {
            continue;
        }
        if (in_array($tag_name_lower, $displayed_terms, true)) {
            continue;
        }
        $filtered_tags[] = $tag;
        $displayed_terms[] = $tag_name_lower;
    }

    return $filtered_tags;
}

// オーバーライド: アーカイブページ等でのメタ情報出力 (TOPページと同じスタイル)
if ( ! function_exists( 'inspiro_entry_meta' ) ) {
	function inspiro_entry_meta() {
		?>
		<div class="top-page-article-meta" style="display: flex; flex-direction: column; align-items: flex-start; margin-top: auto;">
			<div class="top-page-article-tags" style="display: flex; flex-wrap: wrap; gap: 4px; align-items: flex-start;">
				<?php
				$tags = inspiro_get_display_tags();
				if (!empty($tags)) {
					foreach ($tags as $tag) {
						echo '<span class="tag" style="margin:0;">' . esc_html($tag->name) . '</span>';
					}
				}
				?>
			</div>
		</div>
		<?php
	}
}

/**
 * 記事本文の中段（3段落目の後）に広告を挿入する
 */
function inspiro_child_mid_content_ad( $content ) {
    if ( ! is_single() ) {
        return $content;
    }

    if ( wp_is_mobile() ) {
        $ad_html = '
<div class="ad-widget" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
    <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
    <div id="im-3466812c78e74fe0b5e01955bfb6b059">
        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1940492,type:"banner",display:"inline",elementid:"im-3466812c78e74fe0b5e01955bfb6b059"})</script>
    </div>
</div>';
    } else {
        $ad_html = '
<div class="ad-widget" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
    <span style="font-size: 10px; color: #999; display: block; margin-bottom: 5px;">スポンサーリンク</span>
    <div id="im-85786e2981794fb492a0489b6f3c5181">
        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1940486,type:"banner",display:"inline",elementid:"im-85786e2981794fb492a0489b6f3c5181"})</script>
    </div>
</div>';
    }

    // 文の流れを壊さないよう、2番目の <h2> タグの直前に挿入する
    $pattern = '/<h2/i';
    
    $count_h2 = 0;
    $new_content = preg_replace_callback( $pattern, function($matches) use (&$count_h2, $ad_html) {
        $count_h2++;
        if ( $count_h2 === 2 ) {
            return $ad_html . $matches[0];
        }
        return $matches[0];
    }, $content, -1, $count );
    
    // <h2>が2つ以上存在した場合は挿入したコンテンツを返す。ない場合は無理に挿入しない。
    if ( $count_h2 >= 2 ) {
        return $new_content;
    }

    return $content;
}
add_filter( 'the_content', 'inspiro_child_mid_content_ad', 25 );


/**
 * クリティカルに刺さる関連記事を取得する
 * 1. 手動指定 (カスタムフィールド: manual_related_posts)
 * 2. タグ一致数スコアリング (共通のタグが多い順)
 * 3. 同じカテゴリ (フォールバック)
 */
function inspiro_child_get_critical_related_posts($post_id, $limit = 3) {
    global $wpdb;
    $related_posts = array();
    $exclude_ids = array($post_id);

    // 1. 手動指定
    $manual_ids_string = get_post_meta($post_id, 'manual_related_posts', true);
    if (!empty($manual_ids_string) && is_string($manual_ids_string)) {
        // "123, 456" などのカンマ区切りを想定
        $manual_ids = array_map('intval', explode(',', $manual_ids_string));
        $manual_ids = array_filter($manual_ids);
        
        if (!empty($manual_ids)) {
            $manual_posts = get_posts(array(
                'post__in' => $manual_ids,
                'post_status' => 'publish',
                'posts_per_page' => $limit,
                'orderby' => 'post__in'
            ));
            
            foreach ($manual_posts as $mp) {
                $related_posts[] = $mp;
                $exclude_ids[] = $mp->ID;
            }
        }
    }

    $remaining_limit = $limit - count($related_posts);

    // 2. タグ一致数スコアリング
    if ($remaining_limit > 0) {
        $tags = wp_get_post_tags($post_id);
        if (!empty($tags)) {
            $tag_ids = wp_list_pluck($tags, 'term_id');
            $tag_ids_csv = implode(',', array_map('intval', $tag_ids));
            $exclude_ids_csv = implode(',', array_map('intval', $exclude_ids));

            // カスタムクエリ: 共通のタグを持つ記事を抽出し、共通するタグの数(tag_count)が多い順に並べる
            $sql = "
                SELECT p.ID, COUNT(t.term_taxonomy_id) AS tag_count
                FROM {$wpdb->posts} p
                INNER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                INNER JOIN {$wpdb->term_taxonomy} t ON tr.term_taxonomy_id = t.term_taxonomy_id
                WHERE t.term_id IN ({$tag_ids_csv})
                AND p.ID NOT IN ({$exclude_ids_csv})
                AND p.post_status = 'publish'
                AND p.post_type = 'post'
                GROUP BY p.ID
                ORDER BY tag_count DESC, p.post_date DESC
                LIMIT " . intval($remaining_limit) . "
            ";
            
            $tag_scored_ids = $wpdb->get_col($sql);
            
            if (!empty($tag_scored_ids)) {
                $tag_posts = get_posts(array(
                    'post__in' => $tag_scored_ids,
                    'post_status' => 'publish',
                    'posts_per_page' => $remaining_limit,
                    'orderby' => 'post__in'
                ));
                
                foreach ($tag_posts as $tp) {
                    $related_posts[] = $tp;
                    $exclude_ids[] = $tp->ID;
                }
            }
        }
    }

    $remaining_limit = $limit - count($related_posts);

    // 3. カテゴリでのフォールバック
    if ($remaining_limit > 0) {
        $cats = wp_get_post_categories($post_id);
        if (!empty($cats)) {
            $cat_posts = get_posts(array(
                'category__in' => $cats,
                'post__not_in' => $exclude_ids,
                'post_status' => 'publish',
                'posts_per_page' => $remaining_limit,
                'orderby' => 'date'
            ));
            
            foreach ($cat_posts as $cp) {
                $related_posts[] = $cp;
                $exclude_ids[] = $cp->ID;
            }
        }
    }

    return $related_posts;
}



/**
 * Add OGP Meta Tags to Head
 */
function inspiro_child_add_ogp()
{
    if (is_admin()) {
        return;
    }

    if (is_front_page() || is_home()) {
        $og_title = 'デザペディア - Webデザイン・UX / UI・チュートリアルの情報メディアサイト';
    } else {
        $og_title = get_bloginfo('name');
    }
    $og_description = 'デザペディアは、Webデザイン、UX / UI、チュートリアルなど、デザイナーやクリエイターのための情報メディアサイトです。最新のデザインニュース、クリエイティブなインスピレーション、業界のトレンド、役立つツールを提供し、あなたのクリエイティブな活動をサポートします。';
    $og_url         = home_url('/');
    $og_type        = 'website';
    $og_image       = '';

    // デフォルト画像の設定（サイト共通OGPバナー画像）
    $og_image = get_stylesheet_directory_uri() . '/assets/images/ogp.png';

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
            } else if (is_single()) {
                // OGP/Twitter Card Image Fallback (When Featured Image is missing)
                $first_img = '';
                if (preg_match_all('/<img[^>]+>/i', $post->post_content, $matches)) {
                    foreach ($matches[0] as $img_tag) {
                        if (preg_match('/src=[\'"]([^\'"]+)[\'"]/i', $img_tag, $src_match)) {
                            $src = $src_match[1];
                            if (preg_match('/data-src=[\'"]([^\'"]+)[\'"]/i', $img_tag, $data_src_match)) {
                                $src = $data_src_match[1];
                            }
                            $classes = '';
                            if (preg_match('/class=[\'"]([^\'"]+)[\'"]/i', $img_tag, $class_match)) {
                                $classes = $class_match[1];
                            }
                            if (
                                strpos($src, 'data:image') === false &&
                                strpos($src, 'logo') === false &&
                                strpos($src, 'header') === false &&
                                strpos($src, 'icon') === false &&
                                strpos($classes, 'avatar') === false
                            ) {
                                $first_img = preg_replace('/-\d+x\d+(?=\.[a-z]+$)/i', '', $src);
                                break;
                            }
                        }
                    }
                }
                if (!empty($first_img)) {
                    $og_image = $first_img;
                } else {
                    $og_image = get_stylesheet_directory_uri() . '/assets/images/ogp.png';
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
        if (strpos($og_image, 'http') !== 0 && strpos($og_image, '//') !== 0) {
            $og_image = home_url($og_image);
        }
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
