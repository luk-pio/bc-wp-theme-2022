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

/*
 * Load i18n
 */
function my_theme_load_theme_textdomain() {
  load_theme_textdomain( 'bc-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_theme_load_theme_textdomain' );

/*
 * Load the locale language
 */
add_filter('locale', 'language');

function language($locale) {
    $lang = get_locale_from_cookie($locale);
    return $lang; 
}
function get_locale_from_cookie($locale) {
  if(isset($_COOKIE["wp_locale"])) {
    return $_COOKIE["wp_locale"];
  } else {
    return $locale;
  }
}

// load textdomain and .mo file if "lang" is set
load_theme_textdomain('theme-domain', TEMPLATEPATH . '/lang');

/*
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
