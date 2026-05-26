<?php
// Mocking WordPress functions
function shortcode_atts($pairs, $atts) { return array_merge($pairs, (array)$atts); }
function esc_attr($str) { return htmlspecialchars($str); }
function esc_url($str) { return htmlspecialchars($str); }

// The embed shortcode
function inspiro_child_pinterest_embed_shortcode($atts) {
    $atts = shortcode_atts(array(
        'url' => '',
        'size' => 'large',
    ), $atts);
    if (empty($atts['url'])) {
        return 'URL IS EMPTY';
    }
    return '<div class="pinterest-embed"><a data-pin-do="embedPin" data-pin-width="' . esc_attr($atts['size']) . '" href="' . esc_url($atts['url']) . '"></a><script async defer src="//assets.pinterest.com/js/pinit.js"></script></div>';
}

echo "Embed Output: " . inspiro_child_pinterest_embed_shortcode(['url' => 'https://www.pinterest.jp/pin/123456789/']) . "\n";
