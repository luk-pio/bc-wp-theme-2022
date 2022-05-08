<?php

// ALL WOOCOMMERCE PAGES
function bc_main_content_wrapper()
{
    // BEFORE MAIN CONTENT
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    add_action('woocommerce_before_main_content', 'bc_output_content_wrapper', 10);

    add_action('woocommerce_before_main_content', 'bc_page_meta_wrapper', 10);

    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}
add_action("after_setup_theme", "bc_main_content_wrapper");

function bc_output_content_wrapper()
{
    echo '<div class="bc-main">';
}

function bc_output_content_wrapper_end()
{
    echo '</div>';
}

function bc_page_meta_wrapper()
{
    echo '<div class="bc-page-meta">';
}
function bc_page_meta_wrapper_end()
{
    echo '</div>';
}

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


function bc_woocommerce_archive_product()
{
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    add_action('woocommerce_before_shop_loop', 'bc_page_meta_wrapper_end', 40);


    add_action('woocommerce_after_main_content', 'bc_divider', 5);
    add_action('woocommerce_after_main_content', 'bc_product_categories', 6);
}
add_action("after_setup_theme", "bc_woocommerce_archive_product");

function bc_divider()
{
    echo '<div class="bc-divider-container"><div class="bc-divider"></div></div>';
}