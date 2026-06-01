document.addEventListener('DOMContentLoaded', function () {
    // トップページ（body.home）でのみ動作させる
    if (!document.body.classList.contains('home')) {
        return;
    }

    var hero = document.querySelector('.hero-background');
    if (!hero) {
        return;
    }

    function checkScroll() {
        var heroHeight = hero.offsetHeight;
        // ヘッダーの高さ（約90px）を考慮し、FVを超える直前にロゴ表示が開始されるように調整
        var threshold = Math.max(0, heroHeight - 90);

        if (window.scrollY >= threshold) {
            document.body.classList.add('has-scrolled-fv');
        } else {
            document.body.classList.remove('has-scrolled-fv');
        }
    }

    // 初期読み込み時のチェック
    checkScroll();

    // スクロール時にパッシブリスナーでチェック
    window.addEventListener('scroll', checkScroll, { passive: true });
    // ウィンドウリサイズ時にも再チェック
    window.addEventListener('resize', checkScroll, { passive: true });
});
