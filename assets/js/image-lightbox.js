/**
 * Image Lightbox (画像拡大モーダル)
 * 記事詳細ページおよび検証ページで、画像をタップ/クリックした際に
 * 黒いオーバーレイとともに拡大表示し、背景タップ/クリックで解除するスクリプト
 */
document.addEventListener('DOMContentLoaded', () => {
    // 1. モーダルHTML要素の動的生成
    let lightbox = document.getElementById('c-image-lightbox');
    if (!lightbox) {
        lightbox = document.createElement('div');
        lightbox.id = 'c-image-lightbox';
        lightbox.className = 'c-image-lightbox';
        lightbox.setAttribute('aria-hidden', 'true');
        lightbox.setAttribute('role', 'dialog');
        lightbox.setAttribute('aria-modal', 'true');
        lightbox.setAttribute('aria-label', '拡大画像プレビュー');
        lightbox.innerHTML = `
            <div class="c-image-lightbox__backdrop"></div>
            <button type="button" class="c-image-lightbox__close" aria-label="閉じる">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="c-image-lightbox__container">
                <div class="c-image-lightbox__content">
                    <img class="c-image-lightbox__img" src="" alt="">
                    <div class="c-image-lightbox__caption"></div>
                </div>
            </div>
        `;
        document.body.appendChild(lightbox);
    }

    const lightboxImg = lightbox.querySelector('.c-image-lightbox__img');
    const lightboxCaption = lightbox.querySelector('.c-image-lightbox__caption');
    const backdrop = lightbox.querySelector('.c-image-lightbox__backdrop');

    const imageFileRegex = /\.(png|jpe?g|webp|gif|svg|avif)($|\?)/i;

    /**
     * モーダルを開く
     * @param {string} src 画像URL
     * @param {string} alt 代替テキスト
     * @param {string} caption キャプションテキスト
     */
    const openLightbox = (src, alt, caption) => {
        if (!src) return;
        lightboxImg.src = src;
        lightboxImg.alt = alt || '';
        
        if (caption) {
            lightboxCaption.textContent = caption;
            lightboxCaption.style.display = 'block';
        } else {
            lightboxCaption.textContent = '';
            lightboxCaption.style.display = 'none';
        }

        lightbox.classList.add('is-active');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.classList.add('lightbox-open');
    };

    /**
     * モーダルを閉じる
     */
    const closeLightbox = () => {
        if (!lightbox.classList.contains('is-active')) return;
        lightbox.classList.remove('is-active');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('lightbox-open');
        
        // アニメーション完了後にsrcをクリア
        setTimeout(() => {
            if (!lightbox.classList.contains('is-active')) {
                lightboxImg.src = '';
            }
        }, 300);
    };

    /**
     * 画像クリックイベントのハンドリング（イベント委譲）
     */
    document.addEventListener('click', (e) => {
        const targetImg = e.target.closest('.article-text img, .article-sub-thumbnail img, .js-lightbox-trigger img, img.js-lightbox-trigger');
        if (!targetImg) return;

        // 除外対象のチェック
        // 1. ブログカード内の画像、シェアボタン、広告ウィジェット、明示的除外クラス
        if (targetImg.closest('.blogcard, .c-share, .ad-widget, .no-lightbox, [data-no-lightbox]')) {
            return;
        }

        // 2. 親が a タグの場合のリンクチェック
        const parentLink = targetImg.closest('a');
        if (parentLink) {
            const href = parentLink.getAttribute('href') || '';
            // 画像ファイルへの直リンクであればlightboxを開く
            if (imageFileRegex.test(href)) {
                e.preventDefault();
                const caption = targetImg.closest('figure')?.querySelector('figcaption')?.textContent.trim() || targetImg.getAttribute('alt') || '';
                openLightbox(href, targetImg.getAttribute('alt'), caption);
                return;
            }
            // 別ページへのリンクなら通常リンク挙動を維持し、lightboxは起動しない
            return;
        }

        // 通常の画像（リンクなし）
        // Lazyload等の考慮: data-src, currentSrc, src を優先度順に取得
        let src = targetImg.getAttribute('data-src') || targetImg.currentSrc || targetImg.src;
        if (src && src.startsWith('data:image')) {
            src = targetImg.getAttribute('data-src') || targetImg.src;
        }
        if (!src || src.startsWith('data:image')) return;

        const caption = targetImg.closest('figure')?.querySelector('figcaption')?.textContent.trim() || targetImg.getAttribute('alt') || '';

        openLightbox(src, targetImg.getAttribute('alt'), caption);
    });

    /**
     * 閉じる操作：
     * 「閉じるときは普通に画像以外の黒い背景部分（オーバーレイ）をタップもしくはクリックで解除」
     */
    // 1. モーダル内のクリックイベント
    lightbox.addEventListener('click', (e) => {
        // 画像自体またはキャプションをクリックした場合は閉じない
        if (e.target.closest('.c-image-lightbox__img') || e.target.closest('.c-image-lightbox__caption')) {
            return;
        }
        // 背景・コンテナ・閉じるボタンなどの場合は閉じる
        closeLightbox();
    });

    // 2. Escキーで閉じる
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('is-active')) {
            closeLightbox();
        }
    });
});
