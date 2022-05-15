<?php

/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;

$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
    'woocommerce_single_product_image_gallery_classes',
    array(
        'woocommerce-product-gallery',
        'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
        'woocommerce-product-gallery--columns-' . absint($columns),
        'images',
    )
);
?>

<div id="product-carousel" class="swiper-carousel">
    <div id="single-product-swiper-button-container-left" class="swiper-button-container swiper-button-container-left">
        <button class="swiper-button">
            <div class="chevron-icon">
                <?php
                get_template_part("static/icons/Chevron", "Down.svg");
                ?>
            </div>
        </button>
    </div>

    <div id="single-product-swiper-container" class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            do_action('woocommerce_product_thumbnails');
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div id="single-product-swiper-button-container-right" class="swiper-button-container swiper-button-container-right">
        <button class="swiper-button">
            <div class="chevron-icon">
                <?php
                get_template_part("static/icons/Chevron", "Down.svg");
                ?>
            </div>
        </button>
    </div>
</div>