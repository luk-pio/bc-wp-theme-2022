<?php

function bc_product_categories($args = array())
{
    $parentid = get_queried_object_id();
    $uncategorized_id = 15;

    $terms = get_terms(array('taxonomy' => 'product_cat', 'exclude' => array($parentid => $parentid, $uncategorized_id =>
    $uncategorized_id)));

    if ($terms) {
?>
<ul class="product-categories-container">
    <?php foreach ($terms as $term) { ?>
    <a href=" <?php echo esc_url(get_term_link($term)) ?>" class=" <?php echo $term->slug ?> ">
        <li class="category"> <?php woocommerce_subcategory_thumbnail($term); ?>
            <div class="category-title-container">
                <h2 class="category-title"> <?php echo $term->name ?> </h2>
            </div>
        </li>
    </a>
    <?php } ?>
</ul>
<?php
    }
}
function bc_product_categories_homepage($args = array())
{
    $parentid = get_queried_object_id();
    $uncategorized_id = 15;

    $terms = get_terms(array('taxonomy' => 'product_cat', 'exclude' => array($parentid => $parentid, $uncategorized_id =>
    $uncategorized_id)));

    if ($terms) {
    ?>
<ul class="product-categories-container">
    <?php foreach ($terms as $term) {
                $secondary_thumb_url = get_term_meta($term->term_id, 'product_cat_secondary_thumbnail', true);
            ?>
    <a href=" <?php echo esc_url(get_term_link($term)) ?>" class=" <?php echo $term->slug ?> ">
        <li class="category homepage-category"> <?php
                                                            woocommerce_subcategory_thumbnail($term);
                                                            bc_subcategory_thumbnail_secondary($secondary_thumb_url);
                                                            ?>
            <div class="category-title-container">
                <h2 class="category-title"> <?php echo $term->name ?> </h2>
            </div>
        </li>
    </a>
    <?php } ?>
</ul>
<?php
    }
}

function bc_subcategory_thumbnail_secondary($image)
{
    // $small_thumbnail_size = apply_filters('subcategory_archive_thumbnail_size', 'woocommerce_thumbnail');
    // $dimensions           = wc_get_image_size($small_thumbnail_size);
    // $thumbnail_id         = get_term_meta($category->term_id, 'thumbnail_id', true);

    // if ($thumbnail_id) {
    //     $image        = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
    //     $image        = $image[0];
    //     $image_srcset = function_exists('wp_get_attachment_image_srcset') ? wp_get_attachment_image_srcset($thumbnail_id, $small_thumbnail_size) : false;
    //     $image_sizes  = function_exists('wp_get_attachment_image_sizes') ? wp_get_attachment_image_sizes($thumbnail_id, $small_thumbnail_size) : false;
    // } else {
    //     $image        = wc_placeholder_img_src();
    //     $image_srcset = false;
    //     $image_sizes  = false;
    // }

    if ($image) {
        // Prevent esc_url from breaking spaces in urls for image embeds.
        // Ref: https://core.trac.wordpress.org/ticket/23605.
        $image = str_replace(' ', '%20', $image);
        echo '<img src="' . esc_url($image) . '" alt="' . esc_attr("sladkj") . '"/>';
    }
}


// ADD extra thumbnail to product categories
function my_category_module()
{
    // this action is deprecated
    //add_action('edit_category_form_fields', 'add_image_cat');

    // Add these actions for edit and add
    add_action('edited_product_cat', 'save_image');
    add_action('create_product_cat', 'save_image');
    add_action('product_cat_edit_form_fields', 'edit_image_cat');
}
add_action('init', 'my_category_module');


function edit_image_cat($tag)
{
    $category_image = get_term_meta($tag->term_id, 'product_cat_secondary_thumbnail', true);
    ?>
<tr>
    <th scope="row" valign="top"><label for="product_cat_secondary_thumbnail">Secondary Thumbnail</label></th>
    <td>
        <?php
            if ($category_image != "") {
            ?>
        <img src="<?php echo $category_image; ?>" alt="" title="" />
        <?php
            }
            ?>
        <br />
        <!-- Add this html here -->
        <input type="text" class="regular-text" id="custom_category_image" name="product_cat_secondary_thumbnail"
            value="<?php echo $category_image; ?>">
        <button class="set_category_image button">Set Image url</button>

    </td>
</tr>

<?php
}

function save_image($term_id)
{
    if (isset($_POST['product_cat_secondary_thumbnail'])) {
        //load existing category featured option
        update_term_meta($term_id, 'product_cat_secondary_thumbnail', $_POST['product_cat_secondary_thumbnail']);
    }
}


// Enquey media elements
add_action('admin_enqueue_scripts', function () {
    if (is_admin())
        wp_enqueue_media();
});

// Add JS using admin_footer or enque thorugh hooks
add_action('admin_footer', 'my_footer_scripts');
function my_footer_scripts()
{
?>
<script>
jQuery(document).ready(function() {
    if (jQuery('.set_category_image').length > 0) {
        if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            jQuery('.set_category_image').on('click', function(e) {
                e.preventDefault();
                var button = jQuery(this);
                var url_input = jQuery("#custom_category_image");
                wp.media.editor.send.attachment = function(props, attachment) {
                    url_input.val(attachment.url);
                };
                wp.media.editor.open(button);
                return false;
            });
        }
    }
});
</script>
<?php
}