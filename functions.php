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

function bc_theme_mods()
{
  set_theme_mod('footer-animation', 'Animation-Footer');
}

add_action('init', 'bc_theme_mods');


/**
 * Enqueue CSS
 */
function EnqueueMyStyles()
{
  wp_enqueue_style('my-custom-style', get_template_directory_uri() . '/css/my-custom-style.css', false, '20150320');
  wp_enqueue_style('my-main-style', get_stylesheet_uri(), false, '20150320');
}
add_action('wp_enqueue_scripts', 'EnqueueMyStyles');

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
  $file_types = array_merge($file_types, $new_filetypes);
  return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');

/**
 * Register menu
 */
function register_my_menus()
{
  register_nav_menus(
    array(
      'header-menu' => "Desktop Header Menu",
      'mobile-menu' => "Mobile menu",
      'footer-menu' => "Footer menu"
    )
  );
}
add_action('init', 'register_my_menus');

function bc_get_attachment_url_by_slug($slug)
{
  $args = array(
    'post_type' => 'attachment',
    'name' => sanitize_title($slug),
    'posts_per_page' => 1,
    'post_status' => 'inherit',
  );
  $_header = get_posts($args);
  $header = $_header ? array_pop($_header) : null;
  return $header ? ($header->ID) : '';
}

function bc_get_current_language()
{
  $trp = TRP_Translate_Press::get_trp_instance();
  $url_converter = $trp->get_component('url_converter');
  return $url_converter->get_lang_from_url_string() ?: "en_US";
}

function bc_get_lang_switcher()
{
  $languages_array = trp_custom_language_switcher();
  $current_language = bc_get_current_language();
  $index = array_search($current_language, array_keys($languages_array));
  $current_language = $languages_array[$current_language];
  array_splice($languages_array, $index, 1);
?>
<div class="lang-switcher" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    <div class="current-language">
        <?php echo $current_language['short_language_name'];
      ?>
        <div :class="open && 'rot-180'">
            <?php get_template_part("static/icons/Chevron", "Down.svg"); ?>
        </div>
    </div>
    <ul x-show="open" x-transition.opacity class="language-dropdown-list">
        <?php foreach ($languages_array as $name => $item) {
      ?>
        <li>
            <?php
          $trp = TRP_Translate_Press::get_trp_instance();
          $url_converter = $trp->get_component('url_converter');
          $url = $url_converter->get_url_for_language($item["language_code"], false);
          ?>
            <a href="<?php echo esc_url($url); ?>">
                <span><?php echo $item['short_language_name'] ?></span>
            </a>
        </li>
        <?php
      } ?>
    </ul>
</div><?php
      }