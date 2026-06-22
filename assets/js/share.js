document.addEventListener('DOMContentLoaded', () => {
    // 1. コピー機能の実装
    const copyBtn = document.querySelector('.js-share-copy');
    if (copyBtn) {
        copyBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const url = copyBtn.getAttribute('data-url');
            if (!url) return;

            if (navigator.clipboard) {
                navigator.clipboard.writeText(url)
                    .then(() => {
                        showToast('URLをコピーしました');
                    })
                    .catch((err) => {
                        console.error('Failed to copy: ', err);
                        fallbackCopy(url);
                    });
            } else {
                fallbackCopy(url);
            }
        });
    }

    // 2. GA4 イベントトラッキングの実装
    const shareBtns = document.querySelectorAll('.js-share-btn');
    shareBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const method = btn.getAttribute('data-share-method');
            if (method) {
                trackShare(method);
            }
        });
    });

    /**
     * GA4 イベントトラッキングを送信
     * @param {string} method 
     */
    function trackShare(method) {
        if (typeof gtag === 'function') {
            gtag('event', 'share', {
                method: method,
                content_type: 'post',
                item_id: window.location.href
            });
        }
    }

    /**
     * クリップボードAPIが非対応の場合のフォールバック処理
     * @param {string} text 
     */
    function fallbackCopy(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed'; // 画面外に配置
        textArea.style.left = '-9999px';
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            showToast('URLをコピーしました');
        } catch (err) {
            console.error('Fallback copy failed: ', err);
            showToast('コピーに失敗しました');
        }
        document.body.removeChild(textArea);
    }

    /**
     * トースト通知の表示処理
     * @param {string} message 
     */
    function showToast(message) {
        // 既存のトーストがあれば削除
        const existingToast = document.querySelector('.c-toast');
        if (existingToast) {
            existingToast.remove();
        }

        // トースト要素の作成
        const toast = document.createElement('div');
        toast.className = 'c-toast';
        toast.textContent = message;
        document.body.appendChild(toast);

        // クラス付与でフェードイン
        setTimeout(() => {
            toast.classList.add('is-show');
        }, 10);

        // 2秒後にフェードアウトし、削除
        setTimeout(() => {
            toast.classList.remove('is-show');
            toast.addEventListener('transitionend', () => {
                toast.remove();
            }, { once: true });
        }, 2000);
    }
});
