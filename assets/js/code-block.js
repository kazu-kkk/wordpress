/**
 * code-block.js
 * 記事内のコードブロック（<pre><code>）の右上にワンクリックコピーボタンを自動付与
 */
(function() {
    'use strict';

    function initCodeBlocks() {
        // 記事本文および一般的なコンテンツエリア内の pre 要素を対象にする
        const codeBlocks = document.querySelectorAll(
            '.article-text pre, .entry-content pre, .content pre, .comment-content pre, pre.wp-block-code'
        );

        codeBlocks.forEach(function(pre) {
            // 既にラップ済み、またはコンポーネントカタログ等の特殊なボックスは除外
            if (pre.closest('.code-block-wrapper') || pre.closest('.showcase-code-box')) {
                return;
            }

            const codeElem = pre.querySelector('code') || pre;

            // ラッパー要素の作成
            const wrapper = document.createElement('div');
            wrapper.className = 'code-block-wrapper';

            // コピーボタン（右上に配置）
            const copyBtn = document.createElement('button');
            copyBtn.type = 'button';
            copyBtn.className = 'code-block__copy-btn';
            copyBtn.setAttribute('aria-label', 'コードをクリップボードにコピー');
            copyBtn.innerHTML = `
                <svg class="code-block__icon code-block__icon--copy" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                </svg>
                <svg class="code-block__icon code-block__icon--check" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span class="code-block__copy-text">コピー</span>
            `;

            // DOM構造の再構築
            pre.parentNode.insertBefore(wrapper, pre);
            wrapper.appendChild(copyBtn);
            wrapper.appendChild(pre);

            // コピーイベントリスナー
            copyBtn.addEventListener('click', function() {
                // codeタグ内の改行・インデントを維持したままテキストを取得
                const textToCopy = (codeElem.innerText !== undefined) ? codeElem.innerText : codeElem.textContent;

                copyToClipboard(textToCopy, function(success) {
                    if (success) {
                        setCopiedState(copyBtn);

                        // GA4イベント送信（計測設定が存在する場合）
                        if (typeof gtag === 'function') {
                            gtag('event', 'code_copy', {
                                event_category: 'engagement',
                                code_length: textToCopy.length
                            });
                        }
                    } else {
                        alert('コードのコピーに失敗しました。');
                    }
                });
            });
        });
    }

    /**
     * クリップボードコピー処理（モダンAPI + フォールバック）
     */
    function copyToClipboard(text, callback) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                callback(true);
            }).catch(function(err) {
                console.warn('Clipboard API failed, fallback to execCommand:', err);
                fallbackCopy(text, callback);
            });
        } else {
            fallbackCopy(text, callback);
        }
    }

    /**
     * 非対応ブラウザ・非HTTPS環境向けフォールバック
     */
    function fallbackCopy(text, callback) {
        let successful = false;
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.top = '-9999px';
        textArea.style.left = '-9999px';
        textArea.setAttribute('readonly', '');
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            successful = document.execCommand('copy');
        } catch (err) {
            console.error('execCommand copy error:', err);
            successful = false;
        }

        document.body.removeChild(textArea);
        callback(successful);
    }

    /**
     * コピー成功時のボタン状態切り替え
     */
    function setCopiedState(button) {
        const copyIcon = button.querySelector('.code-block__icon--copy');
        const checkIcon = button.querySelector('.code-block__icon--check');
        const textElem = button.querySelector('.code-block__copy-text');

        button.classList.add('is-copied');
        if (copyIcon) copyIcon.style.display = 'none';
        if (checkIcon) checkIcon.style.display = 'inline-block';
        if (textElem) textElem.textContent = 'コピー完了！';

        setTimeout(function() {
            button.classList.remove('is-copied');
            if (copyIcon) copyIcon.style.display = 'inline-block';
            if (checkIcon) checkIcon.style.display = 'none';
            if (textElem) textElem.textContent = 'コピー';
        }, 2000);
    }

    // DOM読み込み完了時に実行
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCodeBlocks);
    } else {
        initCodeBlocks();
    }
})();
