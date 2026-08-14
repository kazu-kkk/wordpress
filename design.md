# Design System — inspiro-child

> **カラーパレット**
>
> | 役割 | 値 |
> |---|---|
> | ブランドブルー | `#2B53EC` |
> | パレット 1 | `#180074` |
> | パレット 2 | `#0f00a0` |
> | パレット 3 | `#325df7` |
> | パレット 4 | `#77b1ff` |
> | パレット 5 | `#a0deff` |
> | 背景（コンテンツ） | `#F5F7FF` |
> | 背景（サイト全体・フッター） | `#1a1a1a` |
> | テキスト（メイン） | `#000 / #333` |
> | テキスト（サブ） | `#666 / #888` |
> | ボーダー（薄） | `#E8E8E8 / #D6DCFA` |
>
> **フォント**
>
> - 本文: `"Verdana", "Hiragino Sans", "Meiryo", sans-serif`
> - フッター: `"Inter", "Helvetica Neue", Arial, sans-serif`
> - ベント: `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, …`
>
> **ホバー挙動の共通仕様**
>
> - スマートフォンやタブレット等のタッチデバイス操作時における「タップ時の意図しないホバー状態の残留（背景色の変化や画像の拡大など）」を防ぐため、すべての `:hover` アニメーション・スタイルは `@media (hover: hover)` メディアクエリで囲まれています。マウスなどのポインティングデバイスが利用可能な環境でのみホバー演出が発生し、タッチデバイスでの操作時はホバー演出が無効化されます。

---

## コンポーネント一覧

---

### 1. `.button` — 汎用ボタン
**ファイル**: `style_add.scss`

```html
<a href="#" class="button">ボタンラベル</a>
```

- ブランドブルー (`#2B53EC`) 背景、白文字
- ホバー: 白背景 + ブルーボーダーに反転
- PC: `width: 228px` / SP: 幅 `100%`

---

### 2. `.hero-background` — ヒーロー（FV）エリア
**ファイル**: `style_add.scss`

```html
<section class="hero-background">
  <img src="logo.png" alt="ロゴ">
</section>
```

- `position: sticky; top: 0; z-index: 1` — スクロールで次セクションに覆われる演出
- 背景: ブランドブルー、上方バウンス対策の `::before` 付き
- SP: `padding: 30px 24px`、ロゴ `max-width: 80%`

---

### 3. `.header` / ヘッダー関連
**ファイル**: `style_add.scss`, `_header.scss`

```html
<header class="header">
  <div class="header__contents">
    <div class="header-logo__image">...</div>
    <nav>
      <ul class="header-link-list">
        <li><a class="header-link__text" href="#">メニュー</a></li>
      </ul>
    </nav>
  </div>
</header>
```

| クラス | 説明 |
|---|---|
| `.header` | 固定ヘッダー (`position: fixed; height: 90px; backdrop-filter: blur(12px)`) |
| `.header__contents` | 内側ラッパー `width: 1100px` |
| `.header-logo__image` | ロゴ画像コンテナ `height: 30px` |
| `.header-link__text` | ナビリンク（白文字） |
| `.header-link__textColorScroll` | スクロール後リンク色変化 (`#2B53EC`) |
| `.has-scrolled-fv` | **[NEW]** トップページにおいてFVを超えてスクロールした際に `body` に付与されるクラス。ヘッダー左ロゴ (`.header-logo-wrapper`) をフェードイン表示させ、ヘッダーに黒い帯（背景）を表示します。 |

**トップページロゴと黒帯のスクロール制御 (マイクロアニメーション)**:
- トップページ (`body.home`) の初期表示時は、ヘッダー左のロゴマーク (`.header-logo-wrapper`) は非表示 (`opacity: 0; visibility: hidden; transform: translateY(-5px)`) に設定され、ヘッダーの黒い帯（背景）も非表示（透明なグラデーション）になります。
- スクロール位置が FV (`.hero-background`) の高さを超えたあたりで `body` に `.has-scrolled-fv` が自動付与され、ロゴマークが上部からスライドダウンしつつ滑らかにフェードインし、同時にヘッダーの黒い帯がスムーズに表示されます。
- トップページ以外のページでは、常に表示されます。

**SP (≤767px)**: ハンバーガーメニュー展開。カード型メニューリンク。サジェスト付き検索ウィジェット表示。

---

### 4. `.fv` / FVセクション
**ファイル**: `style_add.scss`

```html
<section class="fv">
  <div class="fv-article">
    <a class="fv-article-link" href="#">
      <div class="fv-article-image"><img src="…"></div>
      <div class="fv-article-text">
        <p class="fv-article-text__title">タイトル</p>
        <p class="fv-article-text__date">2024.01.01</p>
        <div class="fv-article-text-category">
          <span class="fv-article-text-category__text">カテゴリ</span>
        </div>
      </div>
    </a>
  </div>
</section>
```

- **PC表示**: メインビジュアル記事カード (`width: 1100px; height: 446px`)、ホバー: タイトル色変化 + 画像ズームイン、背景グラデーション: ブランドブルー75% → `#F5F7FF`
- **SP表示**: 中央寄せ縦カード (`width: 350px`、`margin: 0 auto`)。白背景 (`#fff`) に枠線 (`border: 1px solid #e2e8f0`)、タイトルは黒文字 (`#000`)、日付はグレー (`#666`) に変更。

---

### 5. `.pickup` / ピックアップ記事リスト
**ファイル**: `style_add.scss`

```html
<section class="pickup">
  <ul class="pickup-list">
    <li class="pickup-article">
      <div class="pickup-article__image"><img src="…"></div>
      <div class="pickup-article-text">
        <p class="pickup-article-text__title">タイトル</p>
        <p class="pickup-article-text__date">2024.01.01</p>
        <div class="pickup-article-text__category">…</div>
      </div>
    </li>
  </ul>
</section>
```

- **PC表示**: 3カラム横並び (`width: 354px` 各カード)、サムネイル高さ固定 `207px`、ホバー: ズームイン + タイトル色変化
- **SP表示**: トバログ風横スクロール（カルーセル）レイアウト。左右の負のマージン (`margin: 0 -16px`) と親幅拡張 (`width: calc(100% + 32px)`) で画面端までスクロール領域を拡張。
  - カード幅: `280px` (`flex-shrink: 0`、スナップ配置 `scroll-snap-align: start`)
  - サムネイル高さ: `160px`
  - 配色: 白背景 (`#fff`) に枠線 (`border: 1px solid #e2e8f0`)、タイトルは黒文字 (`#000`)、日付はグレー (`#666`) に変更。

---

### 6. `.new-article` / 新着記事リスト
**ファイル**: `style_add.scss`

```html
<ul>
  <li class="new-article">
    <a class="new-article-link" href="#">
      <div class="new-article__image"><img src="…"></div>
      <div class="new-article-text">
        <p class="new-article-text__title">タイトル</p>
        <p class="new-article-text__date">2024.01.01</p>
        <div class="new-article-text__category">…</div>
        <div class="new-article-text__tag">…</div>
      </div>
    </a>
  </li>
</ul>
```

- **PC表示**: 横型カード: サムネイル `200×150px` + テキストエリア `459px`、ホバー: タイトル色変化 + 画像ズームイン
- **SP表示**: トバログ風横スクロール（カルーセル）レイアウト。左右の負のマージン (`margin: 0 -16px`) と親幅拡張 (`width: calc(100% + 32px)`) で画面端までスクロール領域を拡張。
  - カード幅: `280px` (`flex-shrink: 0`、スナップ配置 `scroll-snap-align: start`)
  - サムネイル高さ: `160px`
  - 配色: 白背景 (`#fff`) に枠線 (`border: 1px solid #e2e8f0`)、タイトルは黒文字 (`#000`)、日付はグレー (`#666`) に変更。

---

### 7. `span.tag` / `a.tag` — タグバッジ
**ファイル**: `style_add.scss`

```html
<span class="tag">タグ名</span>
<a class="tag" href="#">タグ名</a>
```

- ブランドブルー背景、白文字、`border-radius: 5px`
- `font-size: 13px; padding: 5px 8px`
- ホバー: 背景がブランドブルー (`#2B53EC`) に反転し、少し浮き上がる (`translateY(-2px)`) とともに影が付与される

---

### 8. `.title-h2__text` — セクション見出し（アイコン付き）
**ファイル**: `style_add.scss`

```html
<h2 class="title-h2__text title-h2__text--pick-up"><i data-lucide="pen-tool"></i> ピックアップ</h2>
<h2 class="title-h2__text title-h2__text--new"><i data-lucide="file-text"></i> 新着記事</h2>
<h2 class="title-h2__text title-h2__text--category"><i data-lucide="shapes"></i> カテゴリ</h2>
<h2 class="title-h2__text title-h2__text--popular-tag"><i data-lucide="tag"></i> 人気タグ</h2>
<h2 class="title-h2__text title-h2__text--sns"><i data-lucide="share-2"></i> SNS</h2>
```

- `padding-left: 40px` で左にSVGアイコン (`::before`)
- アイコン種別: `ico_article.svg` / `ico_shape.svg` / `ico_tag.svg` / `ico_connection.svg`

---

### 9. `.article-*` — 記事詳細（single）
**ファイル**: `_single.scss`

```html
<h1 class="article-title">記事タイトル</h1>
<div class="article-sub">
  <p class="article-sub-date">2024.01.01</p>
  <ul><!-- カテゴリ・タグリスト --></ul>
</div>
<div class="article-fv"><!-- FV画像 --></div>
<div class="article-sub-thumbnail"><img src="…"></div>
<div class="article-text">
  <h2>見出し2</h2>
  <h3>見出し3</h3>
  <p>本文</p>
</div>
```

| クラス | 説明 |
|---|---|
| `.article-title` | 記事タイトル `font-size: 36px`（SP: `26px`） |
| `.article-sub` | 日付 + カテゴリ/タグ横並び |
| `.article-sub-date` | 日付テキスト |
| `.article-fv` | FV画像エリア `height: 400px`（SP: `250px`） |
| `.article-sub-thumbnail` | サムネイル画像 |
| `.article-text` | 本文エリア。見出し2（`h2`: 28px / SP: 22px）に青いアクセントライン、見出し3（`h3`: 24px / SP: 20px）などの装飾を内包 |

**引用ブロック (`blockquote`, `.wp-block-quote`)**:
- 背景色: `#EFF4FF` (薄いブランドブルー)
- テキスト色: `#333`（通常フォントスタイル、太字 `500`）、出典元は `#666`
- 装飾: 不要なクォーテーションマークはなし（シンプルでクリーンなボックス）
- レイアウト: 余白たっぷり（PC `padding: 32px 40px`）、角丸 (`border-radius: 8px`)、ボーダーなし

**テーブルスタイル** (`.wp-block-table` 内):
- ヘッダー行: ブランドブルー背景
- `.is-vertical-header`: 縦ヘッダー（薄い青 `#EFF4FF`）
- `u-header-cell`: 任意のセルをヘッダー風にするユーティリティクラス

---

### 10. `.related-posts` — 関連記事
**ファイル**: `_single.scss`

```html
<section class="related-posts">
  <h2 class="related-posts__title">関連記事</h2>
  <div class="related-posts__grid">
    <a class="related-posts__card" href="#">
      <div class="related-posts__thumb"><img src="…"></div>
      <div class="related-posts__body">
        <p class="related-posts__date">2024.01.01</p>
        <p class="related-posts__name">記事タイトル</p>
      </div>
    </a>
  </div>
</section>
```

- PC: 3カラムグリッド / SP: 2カラム / 480px以下: 1カラム
- ホバー: カードが上に浮き上がる (`translateY(-4px)`)
- タイトル最大3行クランプ

---

### 11. `.toc` — 目次
**ファイル**: `_toc.scss`

```html
<div class="toc is-open">
  <div class="toc__header">
    <p class="toc__title">目次</p>
    <span class="toc__toggle">閉じる</span>
  </div>
  <div class="toc__body">
    <ol class="toc__list">
      <li class="toc__item toc__item--h2">
        <a class="toc__link" href="#h2-anchor">見出し2</a>
        <ol>
          <li class="toc__item toc__item--h3">
            <a class="toc__link" href="#h3-anchor">見出し3</a>
          </li>
        </ol>
      </li>
    </ol>
  </div>
</div>
```

- `.is-open` クラスで展開/折り畳み切り替え（JS連携）
- 背景: `#F5F7FF`、ボーダー: `#D6DCFA`
- `.toc-highlight` — アンカー到達時のハイライトアニメーション

---

### 12. `.blogcard` — ブログカード（内部リンク埋め込み）
**ファイル**: `_blogcard.scss`

```html
<div class="blogcard">
  <a href="…">
    <div class="blogcard_thumbnail"><img src="…"></div>
    <div class="blogcard_content">
      <p class="blogcard_title">記事タイトル</p>
      <p class="blogcard_excerpt">抜粋テキスト</p>
    </div>
  </a>
</div>
```

- PC: サムネイル幅 `180px`固定 + テキスト横並び、上下余白 `margin: 32px 0`
- SP: サムネイル幅 `110px`、上下余白 `margin: 24px 0`
- デザイン: シャドウをなくし、クリーンなボーダーのみのスタイル
- ホバー: 枠線の色が変わり、カードが上に浮き上がる
- **リンク下線の打ち消し**: 記事本文（`.article-text`）などのインラインリンク下線（`underline`）指定の影響を受けないよう、非ホバー・ホバー時ともに下線が表示されないようにスタイルを設定。

---

### 13. `ul.checklist` — チェックリスト
**ファイル**: `_checklist.scss`

```html
<div class="checklist-wrapper">
  <div class="checklist-title">ここにタイトルが入ります</div>
  <ul class="checklist">
    <li>チェック項目A</li>
    <li>チェック項目B</li>
  </ul>
</div>
```

- `::before` でブランドブルーのSVGチェックアイコン
- `title`属性を指定した場合、`.checklist-title`が付与され、背景色（`#f5f7ff`）と淡いブルーの細いボーダー（`border: 1px solid #c4d2f6`）がある角丸の枠線でグループ化されます。
- PC: `font-size: 18px` / SP: `16px` (本文と統一)

---

### 14. `.target-audience` — 対象読者ブロック
**ファイル**: `_target-audience.scss`

```html
<div class="target-audience">
  <p class="target-audience__title">こんな人におすすめ</p>
  <ul class="target-audience__list">
    <li class="target-audience__item">対象者の説明</li>
  </ul>
</div>
```

- 白背景 (`background-color: #ffffff`) にブランドブルーのボーダー (`border: 2px solid #2B53EC`) を配置し、内側余白を `32px` 確保
- 各アイテム: SVGチェックアイコン付き、ノーマルウェイト (`font-weight: normal`)
- タイトル: `font-size: 18px`、`font-weight: 600`
- SP: `padding: 20px 16px`、タイトル `font-size: 16px`、アイテム `font-size: 14px`に最適化され、よりコンパクトにまとまるよう調整

---

### 15. `.bento-*` — ベントグリッド（プロフィールページ）
**ファイル**: `_bento.scss`

```html
<div class="bento-wrapper">
  <div class="bento-grid">
    <div class="bento-card profile-card">
      <div class="profile-content">
        <div class="profile-image"><img src="…"></div>
        <div>
          <h1>名前</h1>
          <p>自己紹介</p>
        </div>
      </div>
    </div>
    <a class="bento-card social-card instagram" href="#">…</a>
    <a class="bento-card social-card youtube" href="#">…</a>
    <a class="bento-card social-card note" href="#">…</a>
    <a class="bento-card social-card twitter" href="#">…</a>
    <a class="bento-card social-card despedia" href="#">…</a>
  </div>
</div>
```

| クラス | グリッド | 説明 |
|---|---|---|
| `.profile-card` | 2×1 | プロフィール（アバター + 名前）|
| `.instagram` | 1×1 | Instagram ソーシャルカード（ピンク系） |
| `.youtube` | 1×1 | YouTube ソーシャルカード（赤系） |
| `.note` | 1×1 | note ソーシャルカード（緑系） |
| `.twitter` | 1×1 | X / Twitter カード（黒） |
| `.despedia` | 2×1 | サービス紹介カード（ブランドブルー） |

- PC: 4カラムグリッド / SP: 2カラム
- ホバー: `scale(1.02)` + 影強化

---

### 16. `.site-footer-rich` — リッチフッター
**ファイル**: `_footer.scss`

```html
<footer class="site-footer-rich">
  <div class="inner-wrap">
    <div class="footer-grid">
      <div class="footer-col footer-brand">…</div>
      <div class="footer-col footer-menu">…</div>
      <div class="footer-col footer-tags">…</div>
      <div class="footer-col footer-info">…</div>
    </div>
    <div class="footer-bottom">
      <p class="copyright">© 2024 …</p>
    </div>
  </div>
</footer>
```

| クラス | 説明 |
|---|---|
| `.footer-brand` | ロゴ + サイト紹介 + SNSアイコン |
| `.footer-menu` | ナビゲーションリンク |
| `.footer-tags` | タグクラウド (`.tag-cloud`) |
| `.footer-info` | その他リンク |

- 背景: `#1a1a1a`（ダーク）
- PC: 4カラムグリッド / タブレット: 2カラム / SP: 縦積み

---

### 17. `.contact-form` (wpcf7) — お問い合わせフォーム
**ファイル**: `_contact-form.scss`

```html
<!-- Contact Form 7 形式のお問い合わせフォーム -->
<div class="wpcf7">
  <form>
    <p>
      <label> お名前 (必須)
        <span class="wpcf7-form-control-wrap"><input type="text" name="your-name"></span>
      </label>
    </p>
    <p>
      <label> メールアドレス (必須)
        <span class="wpcf7-form-control-wrap"><input type="email" name="your-email"></span>
      </label>
    </p>
    <p>
      <label> 件名
        <span class="wpcf7-form-control-wrap"><input type="text" name="your-subject"></span>
      </label>
    </p>
    <p>
      <label> メッセージ内容 (任意)
        <span class="wpcf7-form-control-wrap"><textarea name="your-message"></textarea></span>
      </label>
    </p>
    <p>
      <input type="submit" value="送信する">
    </p>
  </form>
</div>
```

- 最大幅 `640px` 中央配置（フォーム全体の背景は少し淡い青色 `#F5F7FF`）
- 各入力エリアは白背景（`#fff`）に丸角 `border-radius: 8px`
- `input`, `textarea` にフォーカスした際、ブランドブルー（`#2b53ec`）の枠線と淡いシャドウが広がるアニメーション
- 送信ボタンはブランドブルー背景 → ホバーで白背景に反転

---

### 18. `.about-content` — Aboutページ本文およびインラインリンク仕様
**ファイル**: `_bento.scss`, `_single.scss`

```html
<div class="about-content">
  <h2>見出し</h2>
  <p>テキストの中の<a href="#">リンクテキスト</a></p>
</div>
<div class="article-text">
  <p>記事内の<a href="#">リンクテキスト</a></p>
</div>
```

- `h2` に青いアクセントライン（`.article-text h2` と同デザイン）
- インラインリンク共通仕様 (`a:not(...)`): ブランドブルー (`#2B53EC`) + アンダーライン。ホバー時は滑らかに不透明度が変化 (`opacity: 0.8`) し、下線が非表示になります。

---

### 19. `.side-nav` — サイドナビ（SP向けメニュー）
**ファイル**: `_side-nav.scss`, `_header.scss`

- SPのハンバーガーメニュー展開時に表示
- プロフィールカード + カテゴリリンク + 検索ウィジェット
- `.search-suggestions` — インクリメンタルサーチのサジェストリスト（JS連携）

---

### 20. `.c-share` — 記事シェアボタン
**ファイル**: `_share.scss`, `share-buttons.php`

```html
<div class="c-share">
    <p class="c-share__title">SHARE</p>
    <ul class="c-share__list">
        <li class="c-share__item c-share__item--twitter">
            <a href="#" target="_blank" rel="nofollow noopener" aria-label="Xでシェア">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </a>
        </li>
        <li class="c-share__item c-share__item--facebook">
            <a href="#" target="_blank" rel="nofollow noopener" aria-label="Facebookでシェア">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/>
                </svg>
            </a>
        </li>
        <li class="c-share__item c-share__item--line">
            <a href="#" target="_blank" rel="nofollow noopener" aria-label="LINEで送る">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M12 2C6.48 2 2 5.84 2 10.58c0 4.11 3.45 7.57 8.1 8.39.32.06.75.22.86.56l.33 1.96c.04.22.18.27.35.15l2.45-1.74c.26-.18.73-.13.99-.08 4.26.79 7.92-2.58 7.92-7.26C23 5.84 18.52 2 12 2z"/>
                </svg>
            </a>
        </li>
        <li class="c-share__item c-share__item--copy">
            <button class="c-share__copy-btn js-share-copy" data-url="https://example.com" aria-label="URLをコピー">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                </svg>
            </button>
        </li>
    </ul>
</div>
```

- 各種SNS（X、Facebook、LINE）への共有リンクおよびURLコピーボタンのセット。
- 通常時はシンプルなグレーの細線枠に白背景、ホバーすると滑らかなアニメーションで各サービスのブランドカラーに変化するインタラクション。
- URLコピーボタンをクリックした際、吹き出しトーストで「URLをコピーしました」と表示されるUI。

---

### 21. `.article-summary` — 記事要約ブロック
**ファイル**: `_article-summary.scss`

```html
<div class="article-summary">
  <div class="article-summary__title">この記事の要約</div>
  <ul class="article-summary__list">
    <li class="article-summary__item">要約テキスト1</li>
    <li class="article-summary__item">要約テキスト2</li>
    <li class="article-summary__item">要約テキスト3</li>
  </ul>
</div>
```

- ショートコード: `[article_summary point1="要約1" point2="要約2" point3="要約3"]`
- ブランドブルーの左ボーダー (`border-left: 4px solid #2B53EC`)、背景色 (`#F5F7FF`)
- 各アイテム: 青い丸の箇条書きスタイル（疑似要素）
- SP: `padding` および `font-size` を最適化
- 引数が省略された項目は非表示（トルツメ）となります。

---

### 22. `.trend-word-widget` — デザイントレンドウィジェット（TOPサイドバー用）
**ファイル**: `_side-nav.scss`, `side-nav.php`

```html
<div class="trend-word-widget">
  <h2 class="widget-title">今日のトレンドワード</h2>
  <div class="trend-word-card">
    <h3 class="trend-word-title">ワード</h3>
    <p class="trend-word-desc">説明文</p>
    <a href="#" class="trend-word-link">この記事を読む</a>
  </div>
</div>
```

- TOPページ（`front-page.php`）のサイドバー最下部に表示されるウィジェット。
- 白背景のカード型デザイン (`border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05)`)
- リンクボタンはブランドブルー (`#2B53EC`) ベース。ホバー時は `@media (hover: hover)` に則り、色を濃くして少し上に浮き上がるアニメーションを付与。

---

## ユーティリティ・グローバル設定

| クラス / セレクタ | 説明 |
|---|---|
| `.inner-wrap` | 最大幅 `1200px` 中央揃えコンテナ |
| `.content-wrapper` | PC: `padding: 0 100px 90px` / SP: フル幅 |
| `.content` | 記事コンテンツエリア `max-width: 1100px` |
| `.site-content` | `background-color: #F5F7FF; z-index: 2` |
| `html` | `scroll-behavior: smooth; scroll-padding-top: 160px (PC) / 120px (SP)` |
| `body` | フォント・背景色グローバル設定 |
| `.toc-highlight` | 目次クリック後のアンカーフラッシュアニメーション |

---

## ブレークポイント

| 名前 | 条件 |
|---|---|
| PC | `width >= 767px` |
| SP | `width <= 767px` |
| 極小SP | `max-width: 480px` / `max-width: 360px` |
| タブレット（フッターのみ） | `max-width: 1024px` |

---

## 実物検証・パーツ確認ページ (Component Showcase) の利用ガイド

開発環境およびローカル検証用のコンポーネント実物確認ページ（[[page-components.php](file:///Users/hirose/Documents/task/Site/inspiro-child/page-templates/page-components.php)]）は、UI改善やデザインシステム検討を強力にサポートするプレミアムダッシュボードUIへとリニューアルされました。

### 主な機能と検証方法

1. **Design System Tokens の視覚化 (最上部)**
   - サイトで利用されているコアカラーパレット（HEX値）やタイポグラフィ（フォントサイズ、ウェイト）の定義を視覚的に一覧できます。
   - カラーチップ下のHEXコードをクリックするだけで、クリップボードに自動コピーされます。

2. **インライン・レスポンシブシミュレーター (`Width:` コントロール)**
   - 各プレビューボックスの上部にある `PC` / `Tablet` / `Mobile` ボタンをクリックすると、プレビュー枠の幅が滑らかにアニメーションして伸縮します。
   - ブラウザ全体の幅を伸縮させなくても、各パーツがモバイルやタブレットでどのようにレスポンシブ崩れなく表示されるかをその場で即座に検証できます。

3. **背景色チェンジャー (`BG:` コントロール)**
   - 各プレビューボックスの上部にある丸型の背景色トグルを選択することで、背景を `Default` / `White` / `Soft Gray` / `Theme Dark` に瞬時に切り替えることができます。
   - 白文字や透過オブジェクト、およびダークモード用パーツ（フッターなど）が様々な背景色に対して十分なコントラストと視認性を保っているかを検証するのに役立ちます。

4. **ScrollSpy 付き左固定サイドナビゲーション (PCのみ)**
   - 画面のスクロール位置を検出し、現在検証しているパーツのメニュー項目が自動的にブランドブルーでハイライトされます。
   - サイドメニューをクリックすることで、目的のコンポーネント位置まで滑らかにオートスクロールします。
   - **SP表示時**: 画面右下にフローティングメニューボタンが表示され、タップするとメニューがスライドアップして表示されます。

5. **HTMLコードボックスのアコーディオン開閉**
   - プレビュー上部右側の `Show Code` ボタンをクリックすると、HTMLコードのソースボックスが滑らかにスライド展開します。
   - ソースコード内の `COPY` ボタンを押すことで、WordPressへのコピペ用コードを即座に取得できます。初期状態で折りたたまれているため、ページ全体のスクロール量を劇的に削減し、一覧性を高めています。

---

## アイコンライブラリ比較プレビュー

トンマナ調整のためのアイコンライブラリ候補です。VSCode等のMarkdownプレビューで各アイコンのビジュアルを比較できます。

| ライブラリ名 | Home | User | Search | Settings | Check |
|---|:---:|:---:|:---:|:---:|:---:|
| **Remix Icon** | <img src="https://raw.githubusercontent.com/Remix-Design/RemixIcon/master/icons/System/home-line.svg" width="32"> | <img src="https://raw.githubusercontent.com/Remix-Design/RemixIcon/master/icons/User/user-line.svg" width="32"> | <img src="https://raw.githubusercontent.com/Remix-Design/RemixIcon/master/icons/System/search-line.svg" width="32"> | <img src="https://raw.githubusercontent.com/Remix-Design/RemixIcon/master/icons/System/settings-3-line.svg" width="32"> | <img src="https://raw.githubusercontent.com/Remix-Design/RemixIcon/master/icons/System/check-line.svg" width="32"> |
| **Phosphor Icons**<br>(Regular) | <img src="https://raw.githubusercontent.com/phosphor-icons/core/main/assets/regular/house.svg" width="32"> | <img src="https://raw.githubusercontent.com/phosphor-icons/core/main/assets/regular/user.svg" width="32"> | <img src="https://raw.githubusercontent.com/phosphor-icons/core/main/assets/regular/magnifying-glass.svg" width="32"> | <img src="https://raw.githubusercontent.com/phosphor-icons/core/main/assets/regular/gear.svg" width="32"> | <img src="https://raw.githubusercontent.com/phosphor-icons/core/main/assets/regular/check.svg" width="32"> |
| **Lucide Icons** | <img src="https://unpkg.com/lucide-static@0.428.0/icons/home.svg" width="32"> | <img src="https://unpkg.com/lucide-static@0.428.0/icons/user.svg" width="32"> | <img src="https://unpkg.com/lucide-static@0.428.0/icons/search.svg" width="32"> | <img src="https://unpkg.com/lucide-static@0.428.0/icons/settings.svg" width="32"> | <img src="https://unpkg.com/lucide-static@0.428.0/icons/check.svg" width="32"> |
| **Material Design**<br>(MDI) | <img src="https://raw.githubusercontent.com/Templarian/MaterialDesign/master/svg/home-outline.svg" width="32"> | <img src="https://raw.githubusercontent.com/Templarian/MaterialDesign/master/svg/account-outline.svg" width="32"> | <img src="https://raw.githubusercontent.com/Templarian/MaterialDesign/master/svg/magnify.svg" width="32"> | <img src="https://raw.githubusercontent.com/Templarian/MaterialDesign/master/svg/cog-outline.svg" width="32"> | <img src="https://raw.githubusercontent.com/Templarian/MaterialDesign/master/svg/check.svg" width="32"> |

