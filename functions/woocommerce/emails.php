<?php

function bc_woocommerce_emails()
{
    // remove_action('woocommerce_email_header', 'WC_Emails::email_header()', 10);
    // add_action('woocommerce_email_header', 'bc_email_header', 10);
}
add_action("after_setup_theme", "bc_woocommerce_emails");

function bc_get_email_attachment_url($slug) {
return str_replace("https", "http", bc_get_attachment_url_by_slug($slug));
}

function bc_email_header()
{
?>
    <div style="margin:auto; margin-top: 40px">
        <img src="<?php echo bc_get_email_attachment_url('logo-berenika') ?>"></img>
    </div>
    <div style="margin:auto">
        <img src="<?php echo bc_get_email_attachment_url('logo-czarnota') ?>"></img>
    </div>
<?php
}

function email_animation($slug)
{
    $animation_content = bc_get_email_attachment_url($slug);
    $wl_anim = "<div class='wl-animation-container'>
    <img src=" . $animation_content . " alt='waiting list animation'></img></div>";
    return $wl_anim;
}

function add_footer_email_anim($shortcode)
{
    return $shortcode . email_animation("waiting-list-2");
}


add_filter('cwgsubscribe_message', 'add_footer_email_anim');
add_filter('cwginstock_message', 'add_footer_email_anim');