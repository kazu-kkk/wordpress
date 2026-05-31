# Design System — inspiro-child

> **カラーパレット**
>
> | 役割 | 値 |
> |---|---|
> | ブランドブルー | `#2B53EC` |
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

- メインビジュアル記事カード (`width: 1100px; height: 446px`)
- ホバー: タイトル色変化 + 画像ズームイン
- 背景グラデーション: ブランドブルー75% → `#F5F7FF`

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

- 3カラム横並び (`width: 354px` 各カード)
- サムネイル高さ固定 `207px`、ホバー: ズームイン + タイトル色変化

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

- 横型カード: サムネイル `200×150px` + テキストエリア `459px`
- ホバー: タイトル色変化 + 画像ズームイン

---

### 7. `span.tag` / `a.tag` — タグバッジ
**ファイル**: `style_add.scss`

```html
<span class="tag">タグ名</span>
<a class="tag" href="#">タグ名</a>
```

- ブランドブルー背景、白文字、`border-radius: 5px`
- `font-size: 13px; padding: 5px 8px`

---

### 8. `.title-h2__text` — セクション見出し（アイコン付き）
**ファイル**: `style_add.scss`

```html
<h2 class="title-h2__text title-h2__text--pick-up">ピックアップ</h2>
<h2 class="title-h2__text title-h2__text--new">新着記事</h2>
<h2 class="title-h2__text title-h2__text--category">カテゴリ</h2>
<h2 class="title-h2__text title-h2__text--popular-tag">人気タグ</h2>
<h2 class="title-h2__text title-h2__text--sns">SNS</h2>
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
      <p class="blogcard_link">example.com</p>
    </div>
  </a>
</div>
```

- PC: サムネイル幅 `180px`固定 + テキスト横並び
- SP: サムネイル幅 `110px`
- ホバー: カードが上に浮き上がる

---

### 13. `ul.checklist` — チェックリスト
**ファイル**: `_checklist.scss`

```html
<ul class="checklist">
  <li>チェック項目A</li>
  <li>チェック項目B</li>
</ul>
```

- `::before` でブランドブルーの ✔ アイコン
- PC: `font-size: 16px` / SP: `14px`

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

- ブランドブルーのボーダー (`border: 2px solid #2B53EC`)
- 各アイテム: SVGチェックアイコン付き、ボールド
- SP: `padding: 20px 24px`

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

### 18. `.about-content` — Aboutページ本文
**ファイル**: `_bento.scss`

```html
<div class="about-content">
  <h2>見出し</h2>
  <p>テキスト</p>
</div>
```

- `h2` に青いアクセントライン（`.article-text h2` と同デザイン）
- 内部リンク: ブランドブルー + アンダーライン

---

### 19. `.side-nav` — サイドナビ（SP向けメニュー）
**ファイル**: `_side-nav.scss`, `_header.scss`

- SPのハンバーガーメニュー展開時に表示
- プロフィールカード + カテゴリリンク + 検索ウィジェット
- `.search-suggestions` — インクリメンタルサーチのサジェストリスト（JS連携）

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
