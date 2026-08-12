<?php
$content = file_get_contents('side-nav.php');

$profile_pattern = '/(<\?php if \( is_front_page\(\) \|\| is_page_template\(\'page-templates\/page-top-preview\.php\'\) \) : \?>\s*<!-- プロフィールカード -->.*?<\?php endif; \?>)/s';
$search_pattern = '/(<!-- 記事検索 -->\s*<div class="search-widget">.*?<\/div>)/s';
$category_pattern = '/(<!-- カテゴリ一覧 -->\s*<h2 class="widget-title">CATEGORY<\/h2>\s*<ul class="side-nav-category-list">.*?<\/ul>)/s';
$tag_pattern = '/(<!-- 人気タグ -->\s*<div class="popular-tag">.*?<\/div>)/s';
$trend_pattern = '/(<\?php if \( is_front_page\(\) \|\| is_page_template\(\'page-templates\/page-top-preview\.php\'\) \) : \?>\s*<!-- デザイントレンド -->.*?<\?php endif; \?>)/s';
$ad_pattern = '/(<!-- 広告エリア -->\s*<div class="ad-widget" style="margin-top: 30px; text-align: center;">.*?<\/div>)/s';

preg_match($profile_pattern, $content, $profile_match);
preg_match($search_pattern, $content, $search_match);
preg_match($category_pattern, $content, $category_match);
preg_match($tag_pattern, $content, $tag_match);
preg_match($trend_pattern, $content, $trend_match);
preg_match($ad_pattern, $content, $ad_match);

if(empty($profile_match) || empty($search_match) || empty($category_match) || empty($tag_match) || empty($trend_match) || empty($ad_match)) {
    echo "Match failed.\n";
    if(empty($profile_match)) echo "Profile missing\n";
    if(empty($search_match)) echo "Search missing\n";
    if(empty($category_match)) echo "Category missing\n";
    if(empty($tag_match)) echo "Tag missing\n";
    if(empty($trend_match)) echo "Trend missing\n";
    if(empty($ad_match)) echo "Ad missing\n";
    exit(1);
}

$new_content = '<aside id="custom-side-nav" class="widget-area">' . "\n    " .
    $search_match[1] . "\n\n    " .
    $profile_match[1] . "\n\n    " .
    $ad_match[1] . "\n\n    " .
    '<!-- スクロール追従エリア -->' . "\n    " .
    '<div class="sticky-sidebar-wrapper">' . "\n        " .
    $trend_match[1] . "\n\n        " .
    $category_match[1] . "\n\n        " .
    $tag_match[1] . "\n    " .
    '</div>' . "\n" .
    '</aside>';

file_put_contents('side-nav.php', $new_content);
echo "Success\n";
