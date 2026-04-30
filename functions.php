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
        'excerpt' => ''
    ), $atts);

    // Fetch OpenGraph data
    require_once get_stylesheet_directory() . '/OpenGraph.php'; // Adjust path as necessary
    $graph = OpenGraph::fetch($atts['url']);

    // Get title and description from OGP tags
    $Link_title = $graph->title ?? $atts['title'];
    $src = $graph->image ?? '';
    $Link_description = wp_trim_words($graph->description ?? '', 60, '…');
    if (!empty($atts['excerpt'])) {
        $Link_description = $atts['excerpt']; // Use excerpt if OGP description is not available
    }

    $xLink_img = '<img src="' . esc_url($src) . '" />';

    // HTML output
    return '
    <div class="blogcard ex">
        <a href="' . esc_url($atts['url']) . '" target="_blank">
            <div class="blogcard_thumbnail">' . $xLink_img . '</div>
            <div class="blogcard_content">
                <div class="blogcard_title">' . esc_html($Link_title) . '</div>
                <div class="blogcard_excerpt">' . esc_html($Link_description) . '</div>
                <div class="blogcard_link">' . esc_url($atts['url']) . '</div>
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
