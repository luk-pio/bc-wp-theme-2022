<?php

$roots_includes = array(
  './functions/setup.php',
  './functions/single-product.php',
);

foreach ($roots_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

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
    <div id="language-dropdown-hover-filler"></div>
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
      if ($title == "Shop" || $title == "Sklep") {
  ?>
<li class="desktop-shop-dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    <?php echo $title ?>
    <div class="desktop-category-hover-filler"></div>
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
    ?>
<ul class="product-categories-container">
    <?php foreach ($terms as $term) { ?>
    <a href=" <?php echo esc_url(get_term_link($term)) ?>" class=" <?php echo $term->slug ?> ">
        <li class="category"> <?php woocommerce_subcategory_thumbnail($term); ?>
            <div class="category-title-container">
                <h2 class="category-title"> <?php echo $term->name ?> </h2>
            </div>
        </li>
    </a>
    <?php } ?>
</ul>
<?php
  }
}


add_action('woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image');

function add_on_hover_shop_loop_image()
{

  $image_id = wc_get_product()->get_gallery_image_ids()[1];

  if ($image_id) {

    echo wp_get_attachment_image($image_id, 'product-image');
  } else {  //assuming not all products have galleries set

    echo wp_get_attachment_image(wc_get_product()->get_image_id(),  'product-image');
  }
}

function bc_get_gallery_image_html($attachment_id, $main_image = false, $classes)
{
  $flexslider        = (bool) apply_filters('woocommerce_single_product_flexslider_enabled', get_theme_support('wc-product-gallery-slider'));
  $gallery_thumbnail = wc_get_image_size('gallery_thumbnail');
  $thumbnail_size    = apply_filters('woocommerce_gallery_thumbnail_size', array($gallery_thumbnail['width'], $gallery_thumbnail['height']));
  $image_size        = apply_filters('woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single' : $thumbnail_size);
  $full_size         = apply_filters('woocommerce_gallery_full_size', apply_filters('woocommerce_product_thumbnails_large_size', 'full'));
  $thumbnail_src     = wp_get_attachment_image_src($attachment_id, $thumbnail_size);
  $full_src          = wp_get_attachment_image_src($attachment_id, $full_size);
  $alt_text          = trim(wp_strip_all_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
  $image             = wp_get_attachment_image(
    $attachment_id,
    $image_size,
    false,
    apply_filters(
      'woocommerce_gallery_image_html_attachment_image_params',
      array(
        'title'                   => _wp_specialchars(get_post_field('post_title', $attachment_id), ENT_QUOTES, 'UTF-8', true),
        'data-caption'            => _wp_specialchars(get_post_field('post_excerpt', $attachment_id), ENT_QUOTES, 'UTF-8', true),
        'data-src'                => esc_url($full_src[0]),
        'data-large_image'        => esc_url($full_src[0]),
        'data-large_image_width'  => esc_attr($full_src[1]),
        'data-large_image_height' => esc_attr($full_src[2]),
        'class'                   => esc_attr($main_image ? 'wp-post-image' : ''),
      ),
      $attachment_id,
      $image_size,
      $main_image
    )
  );

  return '<div data-thumb="' . esc_url($thumbnail_src[0]) . '" data-thumb-alt="' . esc_attr($alt_text) . '" class="' . $classes . '"><a href="' . esc_url($full_src[0]) . '">' . $image . '</a></div>';
}

function bc_show_product_thumbnails()
{
  global $post, $product;
  $attachment_ids = $product->get_gallery_image_ids();
  if (has_post_thumbnail()) {
    $thumbanil_id   = array(get_post_thumbnail_id());
    $attachment_ids = array_merge($thumbanil_id, $attachment_ids);
  }
  $product_video_thumb_id  = get_post_meta(get_the_ID(), '_product_video_thumb_url', true);
  $custom_thumbnail        = get_post_meta(get_the_ID(), '_custom_thumbnail', true);
  $product_video_thumb_url = wc_placeholder_img_src();
  if ($product_video_thumb_id) {
    $product_video_thumb_url = wp_get_attachment_image_url($product_video_thumb_id);
  }
  $gallery_thumbnail = wc_get_image_size('gallery_thumbnail');
  if (($attachment_ids && $product->get_image_id()) || !empty(get_post_meta(get_the_ID(), '_nickx_video_text_url', true))) {
    // if (get_option('nickx_place_of_the_video') == 'yes' && $extend->is_nickx_act_lic()) {
    //   get_video_thumbanil_html($product_video_thumb_url, $custom_thumbnail, $post);
    // }
    foreach ($attachment_ids as $attachment_id) {
      $props = wc_get_product_attachment_props($attachment_id, $post);
      if (!$props['url']) {
        continue;
      }
      echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<li class="swiper-slide ' . (($thumbanil_id[0] == $attachment_id) ? 'wp-post-image-thumb' : '') . '" title="%s">%s</li>', esc_attr($props['caption']), wp_get_attachment_image($attachment_id, "product-image", 0, array('data-skip-lazy' => 'true'))), $attachment_id);
    }
    // if (get_option('nickx_place_of_the_video') == 'no' && get_option('nickx_place_of_the_video') != 'yes' && get_option('nickx_place_of_the_video') != 'second' || !$extend->is_nickx_act_lic()) {
    //   get_video_thumbanil_html($product_video_thumb_url, $custom_thumbnail, $post);
    // }
  }
}