<?php
// Enqueue custom styles and scripts
function custom_theme_scripts() {
    wp_enqueue_style('custom-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');
?>
