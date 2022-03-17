<?php

/**
 * Setup Theme
 */
function setup()
{
    add_theme_support("post-thumbnails");
}
add_action("after_setup_theme", "setup");

function EnqueueMyStyles() {
    wp_enqueue_style('my-custom-style', get_template_directory_uri() . '/css/my-custom-style.css', false, '20150320');

    wp_enqueue_style('my-main-style', get_stylesheet_uri(), false, '20150320');
}
add_action('wp_enqueue_scripts', 'EnqueueMyStyles');
