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

<div x-data="{swiper: null}" x-init="swiper = new Swiper($refs.container, {
      loop: true,
	  zoom: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      grabCursor: false,
      slidesPerView: 1,
      spaceBetween: 0,
  
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        1024: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
      },
    })
	var swiperSlide = document.getElementsByClassName('swiper-slide')
for(var index = 0; index< swiperSlide.length; index++){

}	
	
	" class="swiper-carousel">
    <div class="swiper-button-container swiper-button-container-left">
        <button @click="swiper.slidePrev()" class="swiper-button">
            <div class="chevron-icon">
                <?php get_template_part("static/icons/Chevron", "Down.svg"); ?>
            </div>
        </button>
    </div>

    <div class="swiper-container" x-ref="container">
        <div class="swiper-wrapper">

            <?php
            // if ($post_thumbnail_id) {
            // 	$html = wc_get_gallery_image_html($post_thumbnail_id, true);
            // } else {
            // 	$html .= sprintf('<div class="swiper-slide"><img src="%s" alt="%s" class="wp-post-image" /></div>', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
            // }

            // echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

            do_action('woocommerce_product_thumbnails');
            ?>

        </div>
        <div class="swiper-pagination" x-ref="swiper-pagination"></div>
    </div>
    <div class="swiper-button-container swiper-button-container-right">
        <button @click="swiper.slideNext()" class="swiper-button">
            <div class="chevron-icon">
                <?php get_template_part("static/icons/Chevron", "Down.svg"); ?>
            </div>
            <!-- <svg viewbox="0 0 20 20" fill="currentcolor" class="chevron-right w-6 h-6">
                <path fill-rule="evenodd"
                    d="m7.293 14.707a1 1 0 010-1.414l10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"></path>
            </svg> -->
        </button>
    </div>
</div>