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
