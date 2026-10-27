import re

with open('front-page.php', 'r', encoding='utf-8', errors='surrogateescape') as f:
    content = f.read()

# 既存の「最新の投稿」内の広告を置換
old_ad = """                    <!-- スマホ用インフィード広告 -->
                    <div class="sp-only-infeed-ad">
                        <div style="font-size: 10px; color: #999; margin-bottom: 5px; text-align: center;">スポンサーリンク</div>
                        <div class="ad-widget-content">
                            <!-- i-mobileタグ (SP用を流用) -->
                            <div id="im-1eae1085f45c43698d0a456571986d00">
                                <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                                <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1937823,type:"banner",display:"inline",elementid:"im-1eae1085f45c43698d0a456571986d00"})</script>
                            </div>
                        </div>
                    </div>"""

new_ad = """                    <!-- インフィード広告 -->
                    <div class="infeed-ad-container">
                        <div style="font-size: 10px; color: #999; margin-bottom: 5px; text-align: center;">スポンサーリンク</div>
                        <div class="ad-widget-content">
                            <?php if ( wp_is_mobile() ) : ?>
                            <div id="im-1eae1085f45c43698d0a456571986d00">
                                <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                                <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1937823,type:"banner",display:"inline",elementid:"im-1eae1085f45c43698d0a456571986d00"})</script>
                            </div>
                            <?php else : ?>
                            <div id="im-91b0abf8dd8043e3a85b798346681f1d">
                                <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                                <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1937816,type:"banner",display:"inline",elementid:"im-91b0abf8dd8043e3a85b798346681f1d"})</script>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>"""

content = content.replace(old_ad, new_ad)

# 他のセクションの間にも追加
# 各セクションは <?php endif; ?> で終わっていることが多いので、その直前か直後に追加する。
# 「デザイントレンドセクション (4.)」の終わりを探す
# <!-- 5. デザインナレッジセクション --> の手前
# セクション間に広告を入れるためのHTML
section_ad = """            <!-- セクション間広告 -->
            <div class="infeed-ad-container" style="margin-bottom: 40px;">
                <div style="font-size: 10px; color: #999; margin-bottom: 5px; text-align: center;">スポンサーリンク</div>
                <div class="ad-widget-content">
                    <?php if ( wp_is_mobile() ) : ?>
                    <div id="im-1eae1085f45c43698d0a456571986d00">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594669,asid:1937823,type:"banner",display:"inline",elementid:"im-1eae1085f45c43698d0a456571986d00"})</script>
                    </div>
                    <?php else : ?>
                    <div id="im-91b0abf8dd8043e3a85b798346681f1d">
                        <script async src="https://imp-adedge.i-mobile.co.jp/script/v1/spot.js?20220104"></script>
                        <script>(window.adsbyimobile=window.adsbyimobile||[]).push({pid:85175,mid:594668,asid:1937816,type:"banner",display:"inline",elementid:"im-91b0abf8dd8043e3a85b798346681f1d"})</script>
                    </div>
                    <?php endif; ?>
                </div>
            </div>\n\n"""

# デザイントレンドセクション (4) の終わり
content = content.replace('<!-- 5. デザインナレッジセクション -->', section_ad + '            <!-- 5. デザインナレッジセクション -->')

# ツール・開発環境セクション (6) の手前
content = content.replace('<!-- 6. ツール・開発環境セクション -->', section_ad + '            <!-- 6. ツール・開発環境セクション -->')

# 広告の重複を少し避けるなら2つくらいで十分かもしれない
# とりあえず上記2か所に追加

with open('front-page.php', 'w', encoding='utf-8', errors='surrogateescape') as f:
    f.write(content)

print("Updated front-page.php")
