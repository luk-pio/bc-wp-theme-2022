<?php
function bc_woocommerce_archive_product()
{
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    add_action('woocommerce_before_shop_loop', 'bc_page_meta_wrapper_end', 40);
    add_action('woocommerce_before_shop_loop_item_title', 'bc_product_thumbnail_wrapper_begin', 5);
    add_action('woocommerce_before_shop_loop_item_title', 'bc_product_archive_waiting_list', 10);
    add_action('woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image', 11);
    add_action('woocommerce_before_shop_loop_item_title', 'bc_product_thumbnail_wrapper_end', 20);

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

function bc_product_archive_waiting_list()
{
    global $product;

    if ($product->get_stock_status() == "outofstock") : ?>
<div class="bc-product-waiting-list-container">
    <div class="bc-product-waiting-list">
        <?php echo _e('Waiting List', 'bc-theme'); ?>
    </div>
</div>
<?php endif;
}

function bc_product_thumbnail_wrapper_begin()
{
    echo '<div class="bc-product-thumbnail-wrapper">';
}
function bc_product_thumbnail_wrapper_end()
{
    echo '</div>';
}