<?php
/**
 * Template part for displaying share buttons
 *
 * @package Inspiro
 */

$share_url   = get_permalink();
$share_title = get_the_title();

// 各SNSのシェア用URLのエンコード
$encoded_url   = rawurlencode($share_url);
$encoded_title = rawurlencode($share_title . ' | ' . get_bloginfo('name'));

// 各シェアリンクの作成
$twitter_url  = 'https://twitter.com/share?url=' . $encoded_url . '&text=' . $encoded_title;
$facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url;
$line_url     = 'https://social-plugins.line.me/lineit/share?url=' . $encoded_url;
?>

<div class="c-share">
    <p class="c-share__title">SHARE</p>
    <ul class="c-share__list">
        <!-- X (Twitter) -->
        <li class="c-share__item c-share__item--twitter">
            <a class="js-share-btn" href="<?php echo esc_url($twitter_url); ?>" target="_blank" rel="nofollow noopener" aria-label="Xでシェア" data-share-method="X">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </a>
        </li>
        <!-- Facebook -->
        <li class="c-share__item c-share__item--facebook">
            <a class="js-share-btn" href="<?php echo esc_url($facebook_url); ?>" target="_blank" rel="nofollow noopener" aria-label="Facebookでシェア" data-share-method="Facebook">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/>
                </svg>
            </a>
        </li>
        <!-- LINE -->
        <li class="c-share__item c-share__item--line">
            <a class="js-share-btn" href="<?php echo esc_url($line_url); ?>" target="_blank" rel="nofollow noopener" aria-label="LINEで送る" data-share-method="LINE">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M12 2C6.48 2 2 5.84 2 10.58c0 4.11 3.45 7.57 8.1 8.39.32.06.75.22.86.56l.33 1.96c.04.22.18.27.35.15l2.45-1.74c.26-.18.73-.13.99-.08 4.26.79 7.92-2.58 7.92-7.26C23 5.84 18.52 2 12 2z"/>
                </svg>
            </a>
        </li>
        <!-- Copy URL -->
        <li class="c-share__item c-share__item--copy">
            <button class="c-share__copy-btn js-share-copy js-share-btn" data-url="<?php echo esc_url($share_url); ?>" aria-label="URLをコピー" data-share-method="Copy">
                <svg class="c-share__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true">
                    <path fill="currentColor" d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                </svg>
            </button>
        </li>
    </ul>
</div>
