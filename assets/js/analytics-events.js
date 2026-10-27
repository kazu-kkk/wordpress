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

    // ----------------------------------------------------
    // 7. テキストコピー検知 (text_copy)
    // ----------------------------------------------------
    document.addEventListener('copy', () => {
        const selection = window.getSelection();
        if (!selection || selection.rangeCount === 0) return;

        // コピー対象が記事本文内かどうか判定
        const container = selection.getRangeAt(0).commonAncestorContainer;
        const targetElement = container.nodeType === Node.ELEMENT_NODE ? container : container.parentElement;

        if (!targetElement || !targetElement.closest('.entry-content, .article-text, .site-content-contain')) {
            return;
        }

        const selectedText = selection.toString().trim();
        if (!selectedText) return;

        // 個人情報（メールアドレス・電話番号等）の除外・マスキング
        const sanitizedText = selectedText
            .replace(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g, '[EMAIL]')
            .replace(/\b\d{2,4}[- ]?\d{2,4}[- ]?\d{3,4}\b/g, '[TEL]')
            .replace(/\s+/g, ' ');

        sendEvent('text_copy', {
            copied_text: sanitizedText.slice(0, 100),
            text_length: selectedText.length,
            page_url: window.location.href
        });
    });

    // ----------------------------------------------------
    // 8. レイジクリック検知 (rage_click)
    // ----------------------------------------------------
    let clickHistory = [];
    let lastRageClickTime = 0;

    document.addEventListener('click', (e) => {
        const now = Date.now();

        // 直近の検知後のクールダウン（連続重複発火防止）
        if (now - lastRageClickTime < 1500) {
            return;
        }

        const currentClick = {
            x: e.clientX,
            y: e.clientY,
            target: e.target,
            time: now
        };

        // 1秒以内のクリック履歴のみ保持
        clickHistory = clickHistory.filter(item => (now - item.time) <= 1000);
        clickHistory.push(currentClick);

        // 同一要素（または包含関係）または半径50px以内のクリックを抽出
        const matchingClicks = clickHistory.filter(item => {
            const isSameElement = (item.target === currentClick.target) ||
                                  (item.target.contains && item.target.contains(currentClick.target)) ||
                                  (currentClick.target.contains && currentClick.target.contains(item.target));

            const distance = Math.hypot(item.x - currentClick.x, item.y - currentClick.y);
            const isWithinRadius = distance <= 50;

            return isSameElement || isWithinRadius;
        });

        if (matchingClicks.length >= 3) {
            lastRageClickTime = now;
            clickHistory = [];

            const el = currentClick.target;
            let targetTag = el.tagName ? el.tagName.toLowerCase() : 'unknown';
            if (el.className && typeof el.className === 'string') {
                const classList = el.className.trim().split(/\s+/).filter(Boolean);
                if (classList.length > 0) {
                    targetTag += '.' + classList.slice(0, 2).join('.');
                }
            }

            const targetText = (el.innerText || el.textContent || '')
                .trim()
                .replace(/\s+/g, ' ')
                .slice(0, 30);

            sendEvent('rage_click', {
                target_tag: targetTag,
                target_text: targetText
            });
        }
    }, { passive: true });

    // ----------------------------------------------------
    // 9. 検索結果「0件」検知 (search_no_results)
    // ----------------------------------------------------
    if (document.body.classList.contains('search')) {
        const hasNoResults = document.querySelector('.no-results, .not-found') !== null ||
                             document.querySelectorAll('.top-page-content-article article, .content-area article').length === 0;

        if (hasNoResults) {
            const urlParams = new URLSearchParams(window.location.search);
            let searchTerm = urlParams.get('s') || '';
            if (!searchTerm) {
                const searchInput = document.querySelector('input[name="s"]');
                if (searchInput && searchInput.value) {
                    searchTerm = searchInput.value;
                }
            }

            sendEvent('search_no_results', {
                search_term: searchTerm.trim()
            });
        }
    }

    // ----------------------------------------------------
    // 10. 精読（本当の読了）検知 (engaged_read)
    // ----------------------------------------------------
    if (document.body.classList.contains('single')) {
        let hasFiredEngagedRead = false;
        let scrollReached75 = false;
        let timeReached45 = false;
        const startTime = Date.now();

        const checkAndSendEngagedRead = () => {
            if (hasFiredEngagedRead) return;
            if (scrollReached75 && timeReached45) {
                hasFiredEngagedRead = true;
                window.removeEventListener('scroll', throttledScrollCheck);

                const titleEl = document.querySelector('.article-title') ||
                                document.querySelector('h1.entry-title') ||
                                document.querySelector('h1');
                const articleTitle = titleEl ? titleEl.innerText.trim() : document.title;
                const readingTime = Math.round((Date.now() - startTime) / 1000);

                sendEvent('engaged_read', {
                    article_title: articleTitle,
                    reading_time: readingTime
                });
            }
        };

        // ページ滞在45秒タイマー
        setTimeout(() => {
            timeReached45 = true;
            checkAndSendEngagedRead();
        }, 45000);

        // スクロール率75%判定（requestAnimationFrameでスロットル）
        let isScrolling = false;
        const throttledScrollCheck = () => {
            if (isScrolling || hasFiredEngagedRead) return;
            isScrolling = true;
            requestAnimationFrame(() => {
                const scrollTop = window.scrollY || document.documentElement.scrollTop;
                const winHeight = window.innerHeight || document.documentElement.clientHeight;
                const docHeight = Math.max(
                    document.body.scrollHeight, document.documentElement.scrollHeight,
                    document.body.offsetHeight, document.documentElement.offsetHeight
                );

                if (docHeight > winHeight) {
                    const scrollPercent = (scrollTop + winHeight) / docHeight;
                    if (scrollPercent >= 0.75) {
                        scrollReached75 = true;
                        checkAndSendEngagedRead();
                    }
                }
                isScrolling = false;
            });
        };

        window.addEventListener('scroll', throttledScrollCheck, { passive: true });
        throttledScrollCheck();
    }

    // ----------------------------------------------------
    // 11. 404エラー遭遇検知 (error_404)
    // ----------------------------------------------------
    if (document.body.classList.contains('error404')) {
        sendEvent('error_404', {
            broken_url: window.location.href,
            referrer: document.referrer || ''
        });
    }
});
