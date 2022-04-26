<?php
// $roots_includes = array(
//   '/functions/body-class.php',
//   '/functions/connections.php'
// );

// foreach ($roots_includes as $file) {
//   if (!$filepath = locate_template($file)) {
//     trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
//   }

//   require_once $filepath;
// }
// unset($file, $filepath);

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
  wp_enqueue_script('custom-js', get_template_directory_uri() . '/scripts/index.js', array(), '1.0.0', true);
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
      'footer-menu' => "Footer menu",
      'categories-menu' => "Categories Menu"
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
  return $header ? ($header->guid) : '';
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
        <div class="chevron-icon" :class="open && 'rot-180'">
            <?php get_template_part("static/icons/Chevron", "Down.svg"); ?>
        </div>
    </div>
    <ul x-show="open" x-transition.opacity class="language-dropdown-list">
        <?php foreach ($languages_array as $name => $item) {
      ?>
        <?php
        $trp = TRP_Translate_Press::get_trp_instance();
        $url_converter = $trp->get_component('url_converter');
        $url = $url_converter->get_url_for_language($item["language_code"], false);
        ?>
        <a href="<?php echo esc_url($url); ?>">
            <li>
                <span><?php echo $item['short_language_name'] ?></span>
            </li>
        </a>
        <?php
      } ?>
    </ul>
</div><?php
      }
        ?>

<?php
// Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
// This code based on wp_nav_menu's code to get Menu ID from menu slug

function bc_get_current_collection()
{
  $the_slug = 'collection';
  $args = array(
    'name'        => $the_slug,
    'post_type'   => 'page',
    'post_status' => 'publish',
    'numberposts' => 1
  );
  $my_posts = get_posts($args);
  if ($my_posts) :
    return $my_posts[0];
  endif;
}

function bc_get_hompage()
{
  $the_slug = 'homepage';
  $args = array(
    'name'        => $the_slug,
    'post_type'   => 'page',
    'post_status' => 'publish',
    'numberposts' => 1
  );
  $my_posts = get_posts($args);
  if ($my_posts) :
    return $my_posts[0];
  endif;
}

function bc_category_menu()
{
  $menu_name = 'categories-menu';

  if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
    $menu = wp_get_nav_menu_object($locations[$menu_name]);

    $menu_items = wp_get_nav_menu_items($menu->term_id);

    $menu_list = '<ul id="menu-' . $menu_name . '">';

    foreach ((array) $menu_items as $key => $menu_item) {
      $title = $menu_item->title;
      $url = $menu_item->url;
      $menu_list .= '<a href="' . $url . '"><li><img class="category-menu-item-icon" src="' . bc_get_attachment_url_by_slug(strtolower($title)) . '" />' . $title . '</li></a>';
    }
    $menu_list .= '</ul>';
  } else {
    $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
  }
  return $menu_list;
}

function bc_mobile_menu()
{
?>
<div class="mobile-menu-container" x-data="{showMenu: false}" @click.away="showMenu = false">
    <div @click.prevent="showMenu = !showMenu" id="nav-burger" class="icon">
        <div id="nav-icon4" :class="showMenu && 'open'">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="mobile-menu-sidebar" :class="showMenu && 'menu-open'">
        <div class="mobile-menu-content">
            <?php $current_collection = bc_get_current_collection();
        if ($current_collection) {
          $collection_title = $current_collection->current_collection;
          $collection_url = get_permalink($current_collection->ID);
          echo '<div class="mobile-menu-heading"><a href="' . $collection_url . '"><h1>' . $collection_title . '</h1></a>';
          echo '<div id="mobile-menu-divider" class="bc-divider"></div></div>';
        }
        ?>

            <?php
        echo bc_category_menu();
        ?>

            <div id="mobile-menu-social">
                <a class="social-icon" href="https://www.instagram.com/berenika_cz/">
                    <?php get_template_part("static/icons/Icon", "IG.svg"); ?>
                </a>
                <a class="social-icon" href="https://pl-pl.facebook.com/BerenikaCzarnota/">
                    <?php get_template_part("static/icons/Icon", "FB.svg"); ?>
                </a>
            </div>
        </div>
    </div>
</div>


<?php
}

function bc_get_desktop_nav()
{
  $menu_name = 'header-menu';

  if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
    $menu = wp_get_nav_menu_object($locations[$menu_name]);

    $menu_items = wp_get_nav_menu_items($menu->term_id);

    echo '<ul id="menu-desktop-menu">';

    foreach ((array) $menu_items as $key => $menu_item) {
      $title = $menu_item->title;
      $url = $menu_item->url;
      if ($title == "Shop") {
  ?>
<li class="desktop-shop-dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    <?php echo $title ?>
    <div class="desktop-category-menu" x-show="open" x-transition.opacity>
        <div class="desktop-category-filler"></div>
        <?php echo bc_category_menu() ?>
    </div>
    <div class='chevron-icon' :class="open && 'rot-180'">
        <?php get_template_part("static/icons/Chevron", "Down.svg") ?>
    </div>
</li>
<?php
      } else echo '<a href="' . $url . '"><li>' . $title . '</li></a>';
    }
  } else {
    echo '<ul></ul>';
  }
}

function mytheme_add_woocommerce_support()
{
  add_theme_support('woocommerce', array(
    'thumbnail_image_width' => 200,
    'gallery_thumbnail_image_width' => 300,
    'single_image_width' => 500,

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

function bc_get_categories($args = array())
{
}

function bc_product_categories($args = array())
{
  $parentid = get_queried_object_id();
  $uncategorized_id = 15;

  $terms = get_terms(array('taxonomy' => 'product_cat', 'exclude' => array($parentid => $parentid, $uncategorized_id =>
  $uncategorized_id)));

  if ($terms) {
    echo '<ul class="product-cats">';

    foreach ($terms as $term) {
      echo '<li class="category">';
      woocommerce_subcategory_thumbnail($term);
      echo '<h2>';
      echo '<a href="' .  esc_url(get_term_link($term)) . '" class="' . $term->slug . '">';
      echo $term->name;
      echo '</a>';
      echo '</h2>';
      echo '</li>';
    }

    echo '</ul>';
  }
}

add_action('woocommerce_before_single_product', 'woocommerce_template_single_title', 15);

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 15);

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);