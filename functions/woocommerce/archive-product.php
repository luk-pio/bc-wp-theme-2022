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

    $image_id = wc_get_product()->get_gallery_image_ids()[0];
    if ($image_id) {
        echo wp_get_attachment_image($image_id, 'product-image');
    } else {  //assuming not all products have galleries set
        echo wp_get_attachment_image(wc_get_product()->get_image_id(),  'product-image');
    }
}