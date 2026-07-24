/**
 * Desapedia - Analytics Events Tracking
 * Handles both GA4 (gtag.js) and GTM (dataLayer)
 */
document.addEventListener('DOMContentLoaded', () => {

    /**
     * Helper to send events to both GTM (if dataLayer exists) and direct GA4 (if gtag exists)
     * @param {string} eventName 
     * @param {object} params 
     */
    const sendEvent = (eventName, params = {}) => {
        // GTM (dataLayer) が導入されている場合は優先して使用する
        if (typeof dataLayer !== 'undefined' && Array.isArray(dataLayer)) {
            dataLayer.push({
                'event': eventName,
                ...params
            });
        }
        // GTMがなく、GA4 (gtag) が直接導入されている場合のみ実行する
        else if (typeof gtag === 'function') {
            gtag('event', eventName, params);
        }
    };

    // ----------------------------------------------------
    // 1. サイト全体共通・ナビゲーション
    // ----------------------------------------------------

    // ヘッダーナビクリック
    document.body.addEventListener('click', (e) => {
        const headerLink = e.target.closest('.header-link__text');
        if (headerLink) {
            sendEvent('click_header_nav', { 
                link_text: headerLink.innerText.trim(), 
                link_url: headerLink.href 
            });
        }
    });

    // SPメニュー開閉 (通常は header__hamburger など)
    document.body.addEventListener('click', (e) => {
        const toggleBtn = e.target.closest('.hamburger') || e.target.closest('.menu-toggle');
        if (toggleBtn) {
            sendEvent('toggle_sp_menu', {});
        }
    });

    // 汎用CTAボタン
    document.body.addEventListener('click', (e) => {
        const btn = e.target.closest('.button');
        if (btn) {
            sendEvent('click_cta_button', { 
                button_text: btn.innerText.trim(), 
                button_url: btn.href || ''
            });
        }
    });

    // 検索機能の利用 (サジェストのクリックなど)
    document.body.addEventListener('click', (e) => {
        const suggestLink = e.target.closest('.search-suggestions a');
        if (suggestLink) {
            sendEvent('search_execute', { 
                search_term: suggestLink.innerText.trim(), 
                type: 'suggestion_click'
            });
        }
    });

    const searchForms = document.querySelectorAll('form.search-form, form[role="search"]');
    searchForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const input = form.querySelector('input[name="s"]');
            if (input) {
                sendEvent('search_execute', { 
                    search_term: input.value.trim(), 
                    type: 'form_submit'
                });
            }
        });
    });

    // ----------------------------------------------------
    // 2. トップページ・アーカイブページ
    // ----------------------------------------------------

    // FV記事クリック
    document.body.addEventListener('click', (e) => {
        const fvLink = e.target.closest('.fv-article-link');
        if (fvLink) {
            const titleEl = fvLink.querySelector('.fv-article-text__title');
            sendEvent('click_fv_article', { 
                article_title: titleEl ? titleEl.innerText.trim() : '', 
                link_url: fvLink.href 
            });
        }
    });

    // ピックアップ記事クリック
    document.body.addEventListener('click', (e) => {
        const pickupContainer = e.target.closest('.pickup-article');
        if (pickupContainer) {
            const link = pickupContainer.tagName === 'A' ? pickupContainer : pickupContainer.querySelector('a');
            if (link) {
                const titleEl = pickupContainer.querySelector('.pickup-article-text__title');
                sendEvent('click_pickup_article', { 
                    article_title: titleEl ? titleEl.innerText.trim() : '', 
                    link_url: link.href 
                });
            }
        }
    });

    // 新着記事クリック
    document.body.addEventListener('click', (e) => {
        const newArticleLink = e.target.closest('.new-article-link');
        if (newArticleLink) {
            const titleEl = newArticleLink.querySelector('.new-article-text__title');
            sendEvent('click_new_article', { 
                article_title: titleEl ? titleEl.innerText.trim() : '', 
                link_url: newArticleLink.href 
            });
        }
    });

    // トレンドワードクリック
    document.body.addEventListener('click', (e) => {
        const trendLink = e.target.closest('.trend-word-link');
        if (trendLink) {
            const card = trendLink.closest('.trend-word-card');
            const titleEl = card ? card.querySelector('.trend-word-title') : null;
            sendEvent('click_trend_word', { 
                trend_word: titleEl ? titleEl.innerText.trim() : '', 
                link_url: trendLink.href 
            });
        }
    });

    // ----------------------------------------------------
    // 3. 記事詳細ページ (single)
    // ----------------------------------------------------

    // 目次 (TOC) 開閉
    document.body.addEventListener('click', (e) => {
        const toggleBtn = e.target.closest('.toc__toggle');
        if (toggleBtn) {
            const toc = toggleBtn.closest('.toc');
            const isOpen = toc && toc.classList.contains('is-open');
            sendEvent('toggle_toc', { state: isOpen ? 'close' : 'open' });
        }
    });

    // 目次内リンククリック
    document.body.addEventListener('click', (e) => {
        const tocLink = e.target.closest('.toc__link');
        if (tocLink) {
            sendEvent('click_toc_link', { 
                heading_text: tocLink.innerText.trim(), 
                anchor_id: tocLink.getAttribute('href') 
            });
        }
    });

    // タグ/カテゴリクリック
    document.body.addEventListener('click', (e) => {
        const tag = e.target.closest('a.tag');
        if (tag) {
            sendEvent('click_tag', { 
                tag_name: tag.innerText.trim(), 
                link_url: tag.href 
            });
        }
    });

    // ブログカードクリック
    document.body.addEventListener('click', (e) => {
        const blogCardLink = e.target.closest('.blogcard a');
        if (blogCardLink) {
            const titleEl = blogCardLink.querySelector('.blogcard_title');
            sendEvent('click_blogcard', { 
                article_title: titleEl ? titleEl.innerText.trim() : '', 
                link_url: blogCardLink.href 
            });
        }
    });

    // 関連記事クリック
    document.body.addEventListener('click', (e) => {
        const relatedCard = e.target.closest('.related-posts__card');
        if (relatedCard) {
            const titleEl = relatedCard.querySelector('.related-posts__name');
            sendEvent('click_related_post', { 
                article_title: titleEl ? titleEl.innerText.trim() : '', 
                link_url: relatedCard.href 
            });
        }
    });

    // ----------------------------------------------------
    // 4. プロフィール・Aboutページ
    // ----------------------------------------------------
    document.body.addEventListener('click', (e) => {
        const socialCard = e.target.closest('.bento-card.social-card');
        if (socialCard) {
            let platform = 'unknown';
            if (socialCard.classList.contains('instagram')) platform = 'Instagram';
            else if (socialCard.classList.contains('youtube')) platform = 'YouTube';
            else if (socialCard.classList.contains('note')) platform = 'note';
            else if (socialCard.classList.contains('twitter')) platform = 'Twitter';
            else if (socialCard.classList.contains('despedia')) platform = 'Despedia';
            
            sendEvent('click_social_card', { 
                platform: platform, 
                link_url: socialCard.href 
            });
        }
    });

    // ----------------------------------------------------
    // 5. お問い合わせ完了 (Contact Form 7)
    // ----------------------------------------------------
    document.addEventListener('wpcf7mailsent', function(event) {
        sendEvent('form_submit', { form_id: event.detail.contactFormId });
        sendEvent('generate_lead', { form_id: event.detail.contactFormId });
    }, false);

    // ----------------------------------------------------
    // 6. アフィリエイト/外部リンククリック
    // ----------------------------------------------------
    document.body.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (link && link.href) {
            const currentDomain = window.location.hostname;
            const linkHost = link.hostname;
            
            // 外部リンク判定 (mailto, tel除外)
            if (linkHost && linkHost !== currentDomain && !link.href.startsWith('mailto:') && !link.href.startsWith('tel:')) {
                // bento-cardやシェアボタン等の特定の外部リンクは既存イベントで処理しているため除外
                if (!link.closest('.bento-card') && !link.closest('.c-share__item')) {
                    sendEvent('click_outbound', { 
                        link_url: link.href, 
                        link_text: link.innerText.trim() || 'No Text'
                    });
                }
            }
        }
    });
});
