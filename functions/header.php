<?php

function bc_get_lang_switcher()
{
    $languages_array = trp_custom_language_switcher();
    $current_language = bc_get_current_language();
    $index = array_search($current_language, array_keys($languages_array));
    $current_language = $languages_array[$current_language];
    array_splice($languages_array, $index, 1);
?>
<div class="lang-switcher" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    <div class="current-language">
        <?php echo $current_language['short_language_name'];
            ?>
        <div class="chevron-icon" :class="open && 'rot-180'">
            <?php get_template_part("static/icons/Chevron", "Down.svg"); ?>
        </div>
    </div>
    <div id="language-dropdown-hover-filler"></div>
    <ul x-show="open" x-transition.opacity class="language-dropdown-list">
        <?php foreach ($languages_array as $name => $item) {
            ?>
        <?php
                $trp = TRP_Translate_Press::get_trp_instance();
                $url_converter = $trp->get_component('url_converter');
                $url = $url_converter->get_url_for_language($item["language_code"], false);
                ?>
        <a href="<?php echo esc_url($url); ?>">
            <li>
                <span><?php echo $item['short_language_name'] ?></span>
            </li>
        </a>
        <?php
            } ?>
    </ul>
</div><?php
        }
            ?>

<?php
// Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
// This code based on wp_nav_menu's code to get Menu ID from menu slug

function bc_category_menu()
{
    $menu_name = 'categories-menu';

    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);

        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_list = '<ul id="menu-' . $menu_name . '">';

        foreach ((array) $menu_items as $key => $menu_item) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            $menu_list .= '<a href="' . $url . '"><li class="category-menu-item"><img class="category-menu-item-icon" src="' . bc_get_attachment_url_by_slug(strtolower($title)) . '" /><div>' . $title . '</div></li></a>';
        }
        $menu_list .= '</ul>';
    } else {
        $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
    }
    return $menu_list;
}

function bc_mobile_menu()
{
?>
<div class="mobile-menu-container" x-data="{showMenu: false}" @click.away="showMenu = false">
    <div @click.prevent="showMenu = !showMenu" id="nav-burger" class="icon">
        <div id="nav-icon4" :class="showMenu && 'open'">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="mobile-menu-sidebar" :class="showMenu && 'menu-open'">
        <div class="mobile-menu-content">
            <?php $current_collection = bc_get_current_collection();
                if ($current_collection) {
                    $collection_title = $current_collection->current_collection;
                    $collection_url = get_permalink($current_collection->ID);
                    echo '<div class="mobile-menu-heading"><a href="' . $collection_url . '"><h1>' . $collection_title . '</h1></a>';
                    echo '<div id="mobile-menu-divider" class="bc-divider"></div></div>';
                }
                ?>

            <?php
                echo bc_category_menu();
                ?>

            <div id="mobile-menu-social">
                <a class="social-icon" href="https://www.instagram.com/berenika_cz/">
                    <?php get_template_part("static/icons/Icon", "IG.svg"); ?>
                </a>
                <a class="social-icon" href="https://pl-pl.facebook.com/BerenikaCzarnota/">
                    <?php get_template_part("static/icons/Icon", "FB.svg"); ?>
                </a>
            </div>
        </div>
    </div>
</div>


<?php
}

function bc_get_desktop_nav()
{
    $menu_name = 'header-menu';

    if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
        $menu = wp_get_nav_menu_object($locations[$menu_name]);

        $menu_items = wp_get_nav_menu_items($menu->term_id);

        echo '<ul id="menu-desktop-menu">';

        foreach ((array) $menu_items as $key => $menu_item) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            if ($title == "Shop" || $title == "Sklep") {
    ?>
<li class="desktop-shop-dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
    <?php echo $title ?>
    <div class="desktop-category-hover-filler"></div>
    <div class="desktop-category-menu" x-show="open" x-transition.opacity>
        <div class="desktop-category-filler"></div>
        <?php echo bc_category_menu() ?>
    </div>
    <div class='chevron-icon' :class="open && 'rot-180'">
        <?php get_template_part("static/icons/Chevron", "Down.svg") ?>
    </div>
</li>
<?php
            } else echo '<a href="' . $url . '"><li>' . $title . '</li></a>';
        }
    } else {
        echo '<ul></ul>';
    }
}

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