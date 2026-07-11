(function() {
    let scrollDepths = { 10: false, 25: false, 50: false, 75: false, 90: false, 100: false };
    
    // スクロールイベントの負荷を軽減するためのスロットル関数
    function throttle(fn, wait) {
        let time = Date.now();
        return function() {
            if ((time + wait - Date.now()) < 0) {
                fn();
                time = Date.now();
            }
        }
    }

    function checkScrollDepth() {
        let scrollTop = window.scrollY || document.documentElement.scrollTop;
        let docHeight = Math.max(
            document.body.scrollHeight, document.documentElement.scrollHeight,
            document.body.offsetHeight, document.documentElement.offsetHeight,
            document.body.clientHeight, document.documentElement.clientHeight
        );
        let winHeight = window.innerHeight || document.documentElement.clientHeight;
        
        // ページがウィンドウサイズより小さい場合はスクロール不要で100%とするか、何もしない
        if (docHeight <= winHeight) return;

        let scrollPercent = Math.round((scrollTop / (docHeight - winHeight)) * 100);

        for (let depth in scrollDepths) {
            if (scrollPercent >= parseInt(depth) && !scrollDepths[depth]) {
                scrollDepths[depth] = true;
                
                // GA4 (gtag.js) へのイベント送信
                // GA4のデフォルト「scroll」イベントは90%のみですが、ここで10,25,50,75,100も送信します。
                // ※GA4で既に登録されている「Percentage」を活用するため、パラメータ名を percentage にしています
                if (typeof gtag === 'function') {
                    gtag('event', 'scroll', {
                        'percentage': parseInt(depth)
                    });
                } 
                
                // Google Tag Manager (dataLayer) へのイベント送信
                if (typeof dataLayer !== 'undefined') {
                    dataLayer.push({
                        'event': 'custom_scroll',
                        'percentage': parseInt(depth)
                    });
                }
            }
        }
    }

    window.addEventListener('scroll', throttle(checkScrollDepth, 500), { passive: true });
})();
