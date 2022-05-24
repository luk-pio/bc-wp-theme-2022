<?php
get_header();

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
get_footer();