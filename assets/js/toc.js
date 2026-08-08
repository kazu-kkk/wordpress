/**
 * Table of Contents (TOC) - トグル開閉 & スムーススクロール
 * - ページ内すべての #アンカーリンクに対してスムーズスクロールを適用
 * - ターゲット見出しへの到達時にハイライトアニメーションを付与
 */
(function () {
    document.addEventListener('DOMContentLoaded', function () {

        // ── TOC 開閉トグル ─────────────────────────────────
        var toc = document.querySelector('.toc');
        if (toc) {
            var tocHeader = toc.querySelector('.toc__header');
            var toggle    = toc.querySelector('.toc__toggle');

            tocHeader.addEventListener('click', function () {
                var isOpen = toc.classList.toggle('is-open');
                toggle.textContent = isOpen ? '閉じる' : '開く';
            });
        }

        // ── スムーススクロール（ページ内すべての #リンク） ────────────
        var headerEl  = document.querySelector('.header');
        var adminBar  = document.querySelector('#wpadminbar');

        function getOffset() {
            var headerHeight   = headerEl  ? headerEl.offsetHeight  : 90;
            var adminBarHeight = adminBar  ? adminBar.offsetHeight   : 0;
            return headerHeight + adminBarHeight + 24; // 24px 余白
        }

        function smoothScrollTo(target) {
            var top = target.getBoundingClientRect().top + window.pageYOffset - getOffset() - 16;
            window.scrollTo({ top: top, behavior: 'smooth' });
            highlightTarget(target);
        }

        // ── ハイライトアニメーション ─────────────────────────
        function highlightTarget(el) {
            el.classList.remove('toc-highlight'); // リセット（連続クリック対応）
            void el.offsetWidth;                  // reflow で animation をリセット
            el.classList.add('toc-highlight');

            // アニメーション終了後にクラスを除去
            el.addEventListener('animationend', function onEnd() {
                el.classList.remove('toc-highlight');
                el.removeEventListener('animationend', onEnd);
            });
        }

        // ページ内の全アンカーリンクにイベントを登録
        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                var href = link.getAttribute('href');
                if (!href || href === '#') return;
                var target = document.querySelector(href);
                if (!target) return;

                e.preventDefault();
                smoothScrollTo(target);
            });
        });
    });
})();
