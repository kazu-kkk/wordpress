/**
 * Reading List (Bookmark) Feature
 * LocalStorage management, UI sync, and GA4 event tracking
 */

(function () {
    'use strict';

    const STORAGE_KEY = 'yuny_reading_list';

    /**
     * LocalStorage ヘルパー
     */
    const ReadingListStorage = {
        getAll: function () {
            try {
                const data = localStorage.getItem(STORAGE_KEY);
                return data ? JSON.parse(data) : [];
            } catch (e) {
                console.error('Failed to read bookmarks from localStorage:', e);
                return [];
            }
        },
        save: function (list) {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(list));
            } catch (e) {
                console.error('Failed to save bookmarks to localStorage:', e);
            }
        },
        has: function (id) {
            const list = this.getAll();
            return list.some(item => String(item.id) === String(id));
        },
        add: function (item) {
            const list = this.getAll();
            if (!this.has(item.id)) {
                list.unshift({
                    id: String(item.id),
                    title: item.title || '',
                    url: item.url || '',
                    thumb: item.thumb || '',
                    category: item.category || '',
                    date: item.date || '',
                    addedAt: Date.now()
                });
                this.save(list);
                return true;
            }
            return false;
        },
        remove: function (id) {
            let list = this.getAll();
            const initialLength = list.length;
            list = list.filter(item => String(item.id) !== String(id));
            if (list.length !== initialLength) {
                this.save(list);
                return true;
            }
            return false;
        },
        clear: function () {
            const count = this.getAll().length;
            localStorage.removeItem(STORAGE_KEY);
            return count;
        }
    };

    /**
     * GA4 イベントトラッキング
     */
    function trackGA(eventName, params) {
        if (typeof gtag === 'function') {
            gtag('event', eventName, params);
        }
    }

    /**
     * トースト通知の表示
     */
    let toastTimeout = null;
    function showToast(message) {
        let toast = document.querySelector('.c-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.className = 'c-toast';
            document.body.appendChild(toast);
        }

        toast.textContent = message;
        toast.classList.add('is-show');

        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }

        toastTimeout = setTimeout(() => {
            toast.classList.remove('is-show');
        }, 2200);
    }

    /**
     * ヘッダーの件数バッジを更新
     */
    function updateHeaderBadge(count) {
        const badges = document.querySelectorAll('.js-bookmark-badge');
        badges.forEach(badge => {
            badge.textContent = count;
            if (count > 0) {
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        });
    }

    /**
     * ページ内の全ブックマークボタンの状態を同期
     */
    function updateAllButtons() {
        const buttons = document.querySelectorAll('.js-bookmark-btn');
        buttons.forEach(btn => {
            const id = btn.getAttribute('data-post-id');
            if (!id) return;

            const isSaved = ReadingListStorage.has(id);
            if (isSaved) {
                btn.classList.add('is-active');
                btn.setAttribute('aria-label', '後で読むから削除');
                btn.setAttribute('title', '後で読むから削除');
            } else {
                btn.classList.remove('is-active');
                btn.setAttribute('aria-label', '後で読むに追加');
                btn.setAttribute('title', '後で読むに追加');
            }
        });
    }

    /**
     * 「後で読む一覧」固定ページのレンダリング
     */
    function renderReadingListPage() {
        const container = document.querySelector('.js-reading-list-container');
        const emptyView = document.querySelector('.js-reading-list-empty');
        const countDisplay = document.querySelector('.js-reading-list-count');
        const clearBtn = document.querySelector('.js-reading-list-clear');

        if (!container) return; // 一覧ページではない

        const list = ReadingListStorage.getAll();
        if (countDisplay) {
            countDisplay.textContent = list.length;
        }

        if (list.length === 0) {
            container.innerHTML = '';
            container.style.display = 'none';
            if (emptyView) emptyView.style.display = 'block';
            if (clearBtn) clearBtn.style.display = 'none';
            return;
        }

        if (emptyView) emptyView.style.display = 'none';
        if (clearBtn) clearBtn.style.display = 'inline-flex';
        container.style.display = 'grid';

        let html = '';
        list.forEach(item => {
            const safeTitle = escapeHTML(item.title);
            const safeUrl = escapeHTML(item.url);
            const safeThumb = escapeHTML(item.thumb);
            const safeCategory = escapeHTML(item.category);
            const safeDate = escapeHTML(item.date);

            html += `
                <article class="reading-list-card js-reading-list-item" data-post-id="${escapeHTML(item.id)}">
                    <a href="${safeUrl}" class="reading-list-card__link js-reading-list-link" data-post-id="${escapeHTML(item.id)}" data-title="${safeTitle}">
                        <div class="reading-list-card__image" style="--thumb: url('${safeThumb}');">
                            <img src="${safeThumb}" alt="${safeTitle}" loading="lazy">
                        </div>
                        <div class="reading-list-card__body">
                            <h2 class="reading-list-card__title">${safeTitle}</h2>
                            <div class="reading-list-card__meta">
                                <time class="reading-list-card__date">${safeDate}</time>
                                ${safeCategory ? `<div class="reading-list-card__tag"><span class="tag">${safeCategory}</span></div>` : ''}
                            </div>
                        </div>
                    </a>
                    <button type="button" class="reading-list-card__remove-btn js-reading-list-remove" data-post-id="${escapeHTML(item.id)}" data-title="${safeTitle}" aria-label="リストから削除" title="リストから削除">
                        <i data-lucide="x"></i>
                    </button>
                </article>
            `;
        });

        container.innerHTML = html;

        // Lucide アイコンの再描画
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    /**
     * HTMLエスケープヘルパー
     */
    function escapeHTML(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    /**
     * 全体同期処理
     */
    function syncUI() {
        const list = ReadingListStorage.getAll();
        updateHeaderBadge(list.length);
        updateAllButtons();
        renderReadingListPage();
    }

    /**
     * 初期化
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncUI);
    } else {
        syncUI();
    }

    /**
     * イベントリスナー設定
     */
    // 1. ブックマークボタンのトグルクリック
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.js-bookmark-btn');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();

            const id = btn.getAttribute('data-post-id');
            const title = btn.getAttribute('data-title') || '';
            const url = btn.getAttribute('data-url') || '';
            const thumb = btn.getAttribute('data-thumb') || '';
            const category = btn.getAttribute('data-category') || '';
            const date = btn.getAttribute('data-date') || '';
            const location = btn.getAttribute('data-location') || 'unknown';

            if (!id) return;

            if (ReadingListStorage.has(id)) {
                // 解除
                ReadingListStorage.remove(id);
                showToast('後で読むから削除しました');
                trackGA('bookmark_remove', {
                    item_id: id,
                    item_name: title,
                    location: location
                });
            } else {
                // 追加
                ReadingListStorage.add({
                    id: id,
                    title: title,
                    url: url,
                    thumb: thumb,
                    category: category,
                    date: date
                });
                showToast('後で読むに追加しました');
                trackGA('bookmark_add', {
                    item_id: id,
                    item_name: title,
                    location: location
                });
            }

            syncUI();
        });

        // 2. 一覧ページでの個別削除ボタンクリック
        document.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.js-reading-list-remove');
            if (!removeBtn) return;

            e.preventDefault();
            e.stopPropagation();

            const id = removeBtn.getAttribute('data-post-id');
            const title = removeBtn.getAttribute('data-title') || '';

            if (!id) return;

            const card = removeBtn.closest('.js-reading-list-item');
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                card.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                setTimeout(() => {
                    ReadingListStorage.remove(id);
                    showToast('リストから削除しました');
                    trackGA('bookmark_remove', {
                        item_id: id,
                        item_name: title,
                        location: 'reading_list_page'
                    });
                    syncUI();
                }, 250);
            } else {
                ReadingListStorage.remove(id);
                showToast('リストから削除しました');
                trackGA('bookmark_remove', {
                    item_id: id,
                    item_name: title,
                    location: 'reading_list_page'
                });
                syncUI();
            }
        });

        // 3. 一覧ページでの「すべて削除」ボタンクリック
        document.addEventListener('click', (e) => {
            const clearBtn = e.target.closest('.js-reading-list-clear');
            if (!clearBtn) return;

            e.preventDefault();

            if (window.confirm('保存した記事をすべて削除してもよろしいですか？')) {
                const count = ReadingListStorage.clear();
                showToast('すべての記事を削除しました');
                trackGA('bookmark_clear_all', {
                    count: count
                });
                syncUI();
            }
        });

        // 4. 一覧ページでの記事リンククリック（GA4計測）
        document.addEventListener('click', (e) => {
            const link = e.target.closest('.js-reading-list-link');
            if (!link) return;

            const id = link.getAttribute('data-post-id');
            const title = link.getAttribute('data-title') || '';

            trackGA('bookmark_open_item', {
                item_id: id,
                item_name: title
            });
        });

    // 他タブでのストレージ更新を検知して同期
    window.addEventListener('storage', (e) => {
        if (e.key === STORAGE_KEY) {
            syncUI();
        }
    });
})();
