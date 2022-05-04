<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <title><?php wp_title(); ?></title>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600&display=swap">

    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <?php wp_head(); ?>

</head>

<body id="bc-body">
    <header id="bc-header" class="<?php if (!is_front_page()) echo 'visible' ?>">
        <div class="bc-header-container">
            <?php echo bc_mobile_menu() ?>
            <a id="bc-logo-container-header" class="bc-logo-container" href="<?php echo get_site_url() ?>">
                <span id="bc-logo-berenika" class="bc-logo-part">
                    <?php get_template_part("static/icons/Logo", "Berenika.svg"); ?>
                </span>
                <span id="bc-logo-czarnota" class="bc-logo-part">
                    <?php get_template_part("static/icons/Logo", "Czarnota.svg"); ?>
            </a>
            <nav id="desktop-nav" class="hidden-mobile">
                <?php echo bc_get_desktop_nav(); ?>
            </nav>
            <div id="header-container-right">
                <div id="desktop-lang-switcher" class="hidden-mobile">
                    <?php echo bc_get_lang_switcher() ?>
                </div>
                <button id="bag-button">
                    <div id="bc-bag" class="icon">
                        <?php get_template_part("static/icons/Icon", "Bag.svg"); ?>
                    </div>
                </button>
            </div>
        </div>
    </header>