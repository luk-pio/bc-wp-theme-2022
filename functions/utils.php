<?php
function bc_get_attachment_url_by_slug($slug)
{
    $args = array(
        'post_type' => 'attachment',
        'name' => sanitize_title($slug),
        'posts_per_page' => 1,
        'post_status' => 'inherit',
    );
    $_header = get_posts($args);
    $header = $_header ? array_pop($_header) : null;
    return $header ? ($header->guid) : '';
}

function bc_get_current_language()
{
    $trp = TRP_Translate_Press::get_trp_instance();
    $url_converter = $trp->get_component('url_converter');
    return $url_converter->get_lang_from_url_string() ?: "en_US";
}

function bc_get_current_collection()
{
    $the_slug = 'collection';
    $args = array(
        'name'        => $the_slug,
        'post_type'   => 'page',
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $my_posts = get_posts($args);
    if ($my_posts) :
        return $my_posts[0];
    endif;
}

function bc_get_hompage()
{
    $the_slug = 'homepage';
    $args = array(
        'name'        => $the_slug,
        'post_type'   => 'page',
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $my_posts = get_posts($args);
    if ($my_posts) :
        return $my_posts[0];
    endif;
}