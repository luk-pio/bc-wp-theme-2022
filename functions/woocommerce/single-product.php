<?php

// SINGLE PRODUCT PAGE
function bc_woocommerce_single_product()
{

    add_action('woocommerce_before_single_product', 'bc_page_meta_wrapper_end', 5);

    // BEFORE SINGLE PRODUCT SUMMARY
    add_action('woocommerce_before_single_product_summary', 'bc_single_product_summary_wrapper_start', 5);

    // SINGLE PRODUCT SUMMARY
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 15);
    // add_action('woocommerce_single_product_summary', 'bc_single_add_to_cart', 15);

    // AFTER SINGLE PRODUCT SUMMARY
    add_action('woocommerce_after_single_product_summary', 'bc_single_product_summary_wrapper_end', 5);

    remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
    add_action('woocommerce_product_thumbnails', 'bc_show_product_thumbnails', 20);

    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    // remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}
add_action("after_setup_theme", "bc_woocommerce_single_product");

function bc_single_add_to_cart()
{
    echo '<button type="submit" class="bc-button button alt disabled wc-variation-selection-needed add-to-cart">Add to cart</button>';
}

function bc_single_product_summary_wrapper_start()
{
    echo '<div class="single-product-content">';
}
function bc_single_product_summary_wrapper_end()
{
    echo '</div>';
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
            echo apply_filters(
                'woocommerce_single_product_image_thumbnail_html',
                sprintf(
                    '<li class="swiper-slide ' . (($thumbanil_id[0] == $attachment_id) ? 'wp-post-image-thumb' : '') . '" title="%s"><div class="swiper-zoom-container">%s</div></li>',
                    esc_attr($props['caption']),
                    wp_get_attachment_image($attachment_id, "product-image", 0, array('data-skip-lazy' => 'true'))
                ),
                $attachment_id
            );
        }
        // if (get_option('nickx_place_of_the_video') == 'no' && get_option('nickx_place_of_the_video') != 'yes' && get_option('nickx_place_of_the_video') != 'second' || !$extend->is_nickx_act_lic()) {
        //   get_video_thumbanil_html($product_video_thumb_url, $custom_thumbnail, $post);
        // }
    }
}

function variation_radio_buttons($html, $args)
{
    $args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
        'options'          => false,
        'attribute'        => false,
        'product'          => false,
        'selected'         => false,
        'name'             => '',
        'id'               => '',
        'class'            => '',
        'show_option_none' => __('Choose an option', 'woocommerce'),
    ));

    if (false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
        $selected_key     = 'attribute_' . sanitize_title($args['attribute']);
        $args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
    }

    $options               = $args['options'];
    $product               = $args['product'];
    $attribute             = $args['attribute'];
    $name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title($attribute);
    $id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
    $class                 = $args['class'];
    $show_option_none      = (bool)$args['show_option_none'];
    $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce');

    if (empty($options) && !empty($product) && !empty($attribute)) {
        $attributes = $product->get_variation_attributes();
        $options    = $attributes[$attribute];
    }

    $variations = $product->get_available_variations();
    $in_stock_attributes = array();
    if ($variations && $attribute) {
        foreach ($variations as $variation) {
            if ($variation['is_in_stock'] && isset($variation['attributes']) && isset($variation['attributes'][$name])) {
                $in_stock_attributes[$variation['attributes'][$name]] = true;
            }
        }
    }

    $radios = '<div class="variation-radios">';

    if (!empty($options)) {
        if ($product && taxonomy_exists($attribute)) {
            $terms = wc_get_product_terms($product->get_id(), $attribute, array(
                'fields' => 'all',
            ));

            foreach ($terms as $term) {
                if (in_array($term->slug, $options, true)) {
                    $id = $name . '-' . $term->slug;
                    $class = isset($in_stock_attributes[$term->slug]) ? 'in-stock' : 'out-of-stock';
                    $radios .= '<input type="radio" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr($term->slug) . '" ' . checked(sanitize_title($args['selected']), $term->slug, false) . '><label class="' . $class . '" for="' . esc_attr($id) . '">' . esc_html(apply_filters('woocommerce_variation_option_name', $term->name)) . '</label>';
                }
            }
        } else {
            foreach ($options as $option) {
                $id = $name . '-' . $option;
                $checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
                $radios    .= '<input type="radio" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr($option) . '" id="' . sanitize_title($option) . '" ' . $checked . '><label for="' . esc_attr($id) . '">' . esc_html(apply_filters('woocommerce_variation_option_name', $option)) . '</label>';
            }
        }
    }

    $radios .= '</div>';

    return $html . $radios;
}
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'variation_radio_buttons', 20, 2);

function variation_check($active, $variation)
{
    if (!$variation->is_in_stock() && !$variation->backorders_allowed()) {
        return false;
    }
    return $active;
}
add_filter('woocommerce_variation_is_active', 'variation_check', 10, 2);
