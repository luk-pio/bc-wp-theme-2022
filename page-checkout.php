<?php
get_header();
bc_output_content_wrapper();

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

<?php
bc_output_content_wrapper_end();
get_footer();
