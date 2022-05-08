<?php

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