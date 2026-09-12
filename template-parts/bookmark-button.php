<?php
/**
 * Template part for bookmark (read later) button
 *
 * @package Inspiro
 */

$post_id     = isset($args['post_id']) ? $args['post_id'] : get_the_ID();
$extra_class = isset($args['class']) ? $args['class'] : '';
$location    = isset($args['location']) ? $args['location'] : 'card';

$post_title = get_the_title($post_id);
$post_url   = get_permalink($post_id);
$thumb_url  = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : get_stylesheet_directory_uri() . '/assets/images/no_image.png';
$categories = get_the_category($post_id);
$cat_name   = !empty($categories) ? $categories[0]->name : '';
$post_date  = get_the_time('Y.m.d', $post_id);
?>
<button type="button"
        class="c-bookmark-btn js-bookmark-btn <?php echo esc_attr($extra_class); ?>"
        data-post-id="<?php echo esc_attr($post_id); ?>"
        data-title="<?php echo esc_attr($post_title); ?>"
        data-url="<?php echo esc_url($post_url); ?>"
        data-thumb="<?php echo esc_url($thumb_url); ?>"
        data-category="<?php echo esc_attr($cat_name); ?>"
        data-date="<?php echo esc_attr($post_date); ?>"
        data-location="<?php echo esc_attr($location); ?>"
        aria-label="後で読むに追加"
        title="後で読むに追加">
    <i data-lucide="bookmark" class="c-bookmark-btn__icon"></i>
</button>
