<?php
/*
 Plugin Name: Custom Plugin
 Plugin URI: http://example.com/
 Description: A custom plugin for WordPress.
 Version: 1.0
 Author: Your Name
 Author URI: http://example.com/
*/

// Custom functionality
function custom_plugin_function() {
    echo '<p>This is a custom plugin output.</p>';
}
add_action('wp_footer', 'custom_plugin_function');
?>
