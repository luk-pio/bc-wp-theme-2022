<?php

// SINGLE PRODUCT PAGE
function bc_woocommerce_checkout()
{

    remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
    add_action('woocommerce_before_checkout_form', "bc_checkout_return_to_shop", 20);
    add_action("woocommerce_review_order_before_order_total", "woocommerce_checkout_coupon_form", 10);
    // add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 15);
}
add_action("after_setup_theme", "bc_woocommerce_checkout");

function bc_checkout_return_to_shop()
{
    echo '<a class="bc-checkout-navigation" href="/">';

    get_template_part("static/icons/Icon", "ArrowLeft.svg");

    _e("Back to Shop", "bc-theme");
    echo '</a>';
}



// Hook in
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

function custom_override_checkout_fields($fields)
{
    unset($fields['order']['order_comments']);

    foreach (['billing', 'shipping'] as $ktype) {
        unset($fields[$ktype][$ktype . '_company']);
        unset($fields[$ktype][$ktype . '_address_2']);
        $fields[$ktype][$ktype . '_country']['priority'] = 79;
        unset($fields[$ktype][$ktype . '_address_1']['class'][0]);
        $fields[$ktype][$ktype . '_address_1']['class'][] = 'form-row-first';
        $fields[$ktype][$ktype . '_city']['class'][] = 'form-row-last';
        $fields[$ktype][$ktype . '_postcode']['class'][] = 'form-row-first';
        $fields[$ktype][$ktype . '_country']['class'][] = 'form-row-first';
        $fields[$ktype][$ktype . '_state']['class'][] = 'form-row-last';

        foreach ($fields[$ktype] as $key => $field) {
            $fields[$ktype][$key]['class'][] = 'bc-form-control';
            $field['placeholder'] = 'a';
            $label_classes = $field['label_class'];
            if ($label_classes) {
                $label_classes ?? $field['label_class'][] = 'bc-wc-form-label';
            } else {
                $fields[$ktype][$key]['label_class'] = ['bc-wc-form-label'];
            }
        }
    }

    return $fields;
}