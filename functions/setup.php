<?php

/**
 * Setup Theme
 */
function setup()
{
    add_theme_support("post-thumbnails");
    // Add dynamic title tag support
    add_filter('facebook_for_woocommerce_integration_pixel_enabled', '__return_false');
    add_theme_support("title-tag");
    add_image_sizes();
}
add_action("after_setup_theme", "setup");


function add_image_sizes()
{
    add_image_size('product-image', 600, 900, array('center', 'center'));
}

function bc_theme_mods()
{
    set_theme_mod('footer-animation', 'Animation-Footer');
}

add_action('init', 'bc_theme_mods');

function enqueue_my_scripts()
{

    wp_enqueue_script('alpine.js', "//unpkg.com/alpinejs", array(), '1.0.0', true);
    wp_enqueue_script('swiper.js', "//unpkg.com/swiper@6.8.4/swiper-bundle.min.js", array(), '1.0.0', true);
    wp_enqueue_script('index.js', get_template_directory_uri() . '/scripts/' . 'index.js', array('alpine.js', 'swiper.js'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_my_scripts');

function enqueue_my_styles()
{
    wp_enqueue_style('swiper.css', "//unpkg.com/swiper@6.8.4/swiper-bundle.min.css");
    wp_enqueue_style('main.css', get_stylesheet_uri(), false, '20150320');
}
add_action('wp_enqueue_scripts', 'enqueue_my_styles');

/**
 * Register menu
 */
function register_my_menus()
{
    register_nav_menus(
        array(
            'header-menu' => "Desktop Header Menu",
            'mobile-menu' => "Mobile menu",
            'footer-menu' => "Footer menu",
            'categories-menu' => "Categories Menu"
        )
    );
}
add_action('init', 'register_my_menus');


/*
 * Load i18n
 */
function my_theme_load_theme_textdomain()
{
    load_theme_textdomain('bc-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'my_theme_load_theme_textdomain');

// load textdomain and .mo file if "lang" is set
load_theme_textdomain('theme-domain', TEMPLATEPATH . '/lang');

/*
 * Add SVG file upload
 */
function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $new_filetypes['json'] = 'application/json';
    $file_types = array_merge($file_types, $new_filetypes);

    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');


// Woocommerce 
function woocommerce_setup()
{
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
}
add_action("after_setup_theme", "woocommerce_setup");

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 600,
        'gallery_thumbnail_image_width' => 600,
        'single_image_width' => 600,

        'product_grid' => array(
            'default_rows' => 3,
            'min_rows' => 2,
            'max_rows' => 4,
            'default_columns' => 3,
            'min_columns' => 2,
            'max_columns' => 4,
        ),
    ));
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

add_filter('woocommerce_get_image_size_gallery_thumbnail', function ($size) {
    return array(
        'width' => 600,
        'height' => 900,
        'crop' => 1,
    );
});
add_filter('woocommerce_get_image_size_thumbnail', function ($size) {
    return array(
        'width' => 600,
        'height' => 900,
        'crop' => 1,
    );
});
add_filter('woocommerce_get_image_size_single', function ($size) {
    return array(
        'width' => 600,
        'height' => 800,
        'crop' => 1,
    );
});

/**
 * Change a currency symbol
 */
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);

function change_existing_currency_symbol($currency_symbol, $currency)
{
    switch ($currency) {
        case 'PLN':
            $currency_symbol = 'PLN';
            break;
    }
    return $currency_symbol;
}