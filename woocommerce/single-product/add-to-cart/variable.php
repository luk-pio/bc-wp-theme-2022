<?php

/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined('ABSPATH') || exit;

global $product;

$attribute_keys  = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="variations_form cart"
    action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
    method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>"
    data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. 
                                                                                                                                                                                                                                                                                        ?>">
    <?php do_action('woocommerce_before_variations_form'); ?>

    <?php if (empty($available_variations) && false !== $available_variations) : ?>
    <p class="stock out-of-stock">
        <?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?>
    </p>
    <?php else : ?>
    <div class="variations-wrapper">
        <?php foreach ($attributes as $attribute_name => $options) : ?>
        <?php foreach ($options as $option) : ?>
        <label>
            <input type="radio" name="<?php echo $attribute_name ?>" value="<?php echo $option ?>">
            <span>
                <?php echo esc_html(apply_filters('woocommerce_variation_option_name', $option, null, $attribute_name, $product)) ?>
            </span>
            </input>
        </label>

        <?php endforeach; ?> <?php endforeach; ?>
    </div>
    <div class="size-guide-button">
        <span>
            <?php _e("size guide", "bc_theme"); ?>
        </span>
    </div>
    <div>
        <?php bc_single_add_to_cart() ?>
    </div>
    <?php endif; ?>

    <?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php
do_action('woocommerce_after_add_to_cart_form');