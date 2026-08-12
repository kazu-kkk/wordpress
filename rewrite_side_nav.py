import re

with open('side-nav.php', 'r', encoding='utf-8', errors='surrogateescape') as f:
    content = f.read()

# 各ブロックを抽出
profile_pattern = re.compile(r'(<\?php if \( is_front_page\(\) \|\| is_page_template\(\'page-templates/page-top-preview\.php\'\) \) : \?>\s*<!-- プロフィールカード -->.*?<\?php endif; \?>)', re.DOTALL)
search_pattern = re.compile(r'(<!-- 記事検索 -->\s*<div class="search-widget">.*?</div>)', re.DOTALL)
category_pattern = re.compile(r'(<!-- カテゴリ一覧 -->\s*<h2 class="widget-title">CATEGORY</h2>\s*<ul class="side-nav-category-list">.*?</ul>)', re.DOTALL)
tag_pattern = re.compile(r'(<!-- 人気タグ -->\s*<div class="popular-tag">.*?</div>)', re.DOTALL)
trend_pattern = re.compile(r'(<\?php if \( is_front_page\(\) \|\| is_page_template\(\'page-templates/page-top-preview\.php\'\) \) : \?>\s*<!-- デザイントレンド -->.*?<\?php endif; \?>)', re.DOTALL)
ad_pattern = re.compile(r'(<!-- 広告エリア -->\s*<div class="ad-widget" style="margin-top: 30px; text-align: center;">.*?</div>)', re.DOTALL)

# 抽出
profile_match = profile_pattern.search(content)
search_match = search_pattern.search(content)
category_match = category_pattern.search(content)
tag_match = tag_pattern.search(content)
trend_match = trend_pattern.search(content)
ad_match = ad_pattern.search(content)

if not (profile_match and search_match and category_match and tag_match and trend_match and ad_match):
    print("Match error")
    if not profile_match: print("profile missing")
    if not search_match: print("search missing")
    if not category_match: print("category missing")
    if not tag_match: print("tag missing")
    if not trend_match: print("trend missing")
    if not ad_match: print("ad missing")
    exit(1)

profile_code = profile_match.group(1)
search_code = search_match.group(1)
category_code = category_match.group(1)
tag_code = tag_match.group(1)
trend_code = trend_match.group(1)
ad_code = ad_match.group(1)

# 新しい構造の組み立て
new_content = """<aside id="custom-side-nav" class="widget-area">
    {search}

    {profile}

    {ad}

    <!-- スクロール追従エリア -->
    <div class="sticky-sidebar-wrapper">
        {trend}

        {category}

        {tag}
    </div>
</aside>
"""

new_content = new_content.format(
    search=search_code,
    profile=profile_code,
    ad=ad_code,
    trend=trend_code,
    category=category_code,
    tag=tag_code
)

with open('side-nav.php', 'w', encoding='utf-8', errors='surrogateescape') as f:
    f.write(new_content)

print("Rewrite complete")
