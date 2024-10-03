<?php
/**
 * Enqueue parent and child theme stylesheets
 */

function inspiro_child_enqueue_styles() {
    // Enqueue parent theme stylesheet
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/assets/css/minified/style.min.css');
    
    // Enqueue child theme stylesheet
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
    
    // Enqueue additional stylesheet
    wp_enqueue_style('additional-style', get_stylesheet_directory_uri() . '/assets/css/style_add.css', array('child-style'));
}

add_action('wp_enqueue_scripts', 'inspiro_child_enqueue_styles', 11);

if ( ! function_exists( 'inspiro_child_theme_setup' ) ) {
    function inspiro_child_theme_setup() {
        // クラスファイルを読み込む
        require_once get_stylesheet_directory() . '/inc/classes/class-inspiro-after-setup-theme.php';

        // クラスのインスタンスを作成
        if ( class_exists( 'Inspiro_After_Setup_Theme' ) ) {
            new Inspiro_After_Setup_Theme();
        }

        // 画像サイズを追加
        add_image_size('inspiro-custom-size', 600, 0, true); // 幅600px、高さ400px、トリミング（true）
    }
}
add_action( 'after_setup_theme', 'inspiro_child_theme_setup' );

/**
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support('post-thumbnails');

/**
 * Display post thumbnails
 */
function display_post_thumbnails() {
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
function show_Linkcard($atts) {
    $atts = shortcode_atts(array(
        'url' => '',
        'title' => '',
        'excerpt' => ''
    ), $atts);

    // Fetch OpenGraph data
    require_once get_stylesheet_directory() . '/path/to/OpenGraph.php'; // Adjust path as necessary
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
function include_content_excerpt() {
    get_template_part('content', 'excerpt');
}
add_action('wp_footer', 'include_content_excerpt');
?>
