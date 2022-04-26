<?php
get_header();

$current_collection = bc_get_current_collection();
if ($current_collection) {
    $collection_title = $current_collection->current_collection;
    $collection_url = get_permalink($current_collection->ID);
?>
    <div class="homepage-hero-container">
        <h1 class="homepage-current-collection"> <?php echo $collection_title ?> </h1>
        <a href="<?php echo $collection_url ?>">
            <button>
                <?php _e("SEE MORE", "bc-theme"); ?>
            </button>
        </a>
    </div>
<?php
}

if (have_posts()) :
    while (have_posts()) : the_post();
        the_content();
    endwhile;
else :
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404);
    exit();
endif;
?>
<div class="homepage-content">

    <?php
    if (!function_exists('wc_get_products')) {
        return;
    }

    $paged                   = (get_query_var('page')) ? absint(get_query_var('page')) : 1; // if your custom loop is on a static front page then check for the query var 'page' instead of 'paged', see https://developer.wordpress.org/reference/classes/wp_query/#pagination-parameters
    $ordering                = WC()->query->get_catalog_ordering_args();
    $ordering['orderby']     = array_shift(explode(' ', $ordering['orderby']));
    $ordering['orderby']     = stristr($ordering['orderby'], 'price') ? 'meta_value_num' : $ordering['orderby'];
    $products_per_page       = 6;

    $products_ids            = wc_get_products(array(
        'tag' => array('homepage'),
        'status'               => 'publish',
        'limit'                => $products_per_page,
        'page'                 => $paged,
        'paginate'             => true,
        'return'               => 'ids',
        'orderby'              => $ordering['orderby'],
        'order'                => $ordering['order'],
    ));

    wc_set_loop_prop('current_page', $paged);
    wc_set_loop_prop('is_paginated', wc_string_to_bool(true));
    wc_set_loop_prop('page_template', get_page_template_slug());
    wc_set_loop_prop('per_page', $products_per_page);
    wc_set_loop_prop('total', $products_ids->total);
    wc_set_loop_prop('total_pages', $products_ids->max_num_pages);

    if ($products_ids) {
        do_action('woocommerce_before_shop_loop');
        woocommerce_product_loop_start();
        foreach ($products_ids->products as $featured_product) {
            $post_object = get_post($featured_product);
            setup_postdata($GLOBALS['post'] = &$post_object);
            wc_get_template_part('content', 'product');
        }
        wp_reset_postdata();
        woocommerce_product_loop_end();
        do_action('woocommerce_after_shop_loop');
    } else {
        do_action('woocommerce_no_products_found');
    }
    ?>

</div>

<?php
get_footer();
