<?php

/**
 * Setup Theme
 */
function setup()
{
    add_theme_support("post-thumbnails");
    // Add dynamic title tag support
    add_theme_support("title-tag");
}
add_action("after_setup_theme", "setup");

/**
 * Enqueue CSS
 */
function EnqueueMyStyles() {
    wp_enqueue_style('my-custom-style', get_template_directory_uri() . '/css/my-custom-style.css', false, '20150320');
    wp_enqueue_style('my-main-style', get_stylesheet_uri(), false, '20150320');
}
add_action('wp_enqueue_scripts', 'EnqueueMyStyles');

/**
 * Add SVG file upload
 */
function add_file_types_to_uploads($file_types){
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

/**
 * Register menu
 */
function register_my_menus() {
    register_nav_menus(
      array(
        'header-menu' => "Desktop Header Menu",
        'mobile-menu' => "Mobile menu",
        'footer-menu' => "Footer menu"
      )
     );
  }
add_action( 'init', 'register_my_menus' );
