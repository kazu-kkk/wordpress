<?php
require_once('../../../wp-load.php'); // Path to wp-load.php from theme directory
// Assuming theme is in wp-content/themes/inspiro-child
$post_id = 1216; // The post ID from the image
$related = inspiro_child_get_critical_related_posts($post_id, 3);
print_r($related);
