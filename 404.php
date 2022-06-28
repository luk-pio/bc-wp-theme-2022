<?php
get_header();
bc_output_content_wrapper();
bc_checkout_return_to_shop();

?>

<div class="not-found">

    <h1><?php _e("404...", "bc-theme") ?></h1>
    <p>
        <?php _e("Page not found", "bc-theme") ?>
    </p>

</div>

<?php
bc_output_content_wrapper_end();
get_footer();