<?php
function bc_woocommerce_archive_product()
{
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    add_action('woocommerce_before_shop_loop', 'bc_page_meta_wrapper_end', 40);
    add_action('woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image');

    add_action('woocommerce_after_main_content', 'bc_divider', 5);
    add_action('woocommerce_after_main_content', 'bc_product_categories', 6);
}
add_action("after_setup_theme", "bc_woocommerce_archive_product");


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