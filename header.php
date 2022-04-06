<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

    <title><?php wp_title(); ?></title>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        @font-face {
            font-family: Nunito;
            src: url("https://fonts.googleapis.com/css?family=Nunito");
            font-display: swap;
        }
    </style>

    <?php wp_head(); ?>

</head>

<body>
    <header class="bc-header">
        <div class="bc-header-container">
            <div id="mobile-menu-container">
                <div id="nav-burger" class="icon">
                    <?php get_template_part("static/icons/Icon", "Menu.svg"); ?>
                </div>
                <?php get_template_part("template-parts/lang", "picker") ?>
            </div>
            <div id="bc-logo-container-header" class="bc-logo-container">
                <span id="bc-logo-berenika" class="bc-logo-part">
                    <?php get_template_part("static/icons/Logo", "Berenika.svg"); ?>
                </span>
                <span id="bc-logo-czarnota" class="bc-logo-part">
                    <?php get_template_part("static/icons/Logo", "Czarnota.svg"); ?>
            </div>
            <nav id="desktop-nav" class="hidden-mobile">
                <?php
                wp_nav_menu(
                    array(
                        'menu' => 'header-menu',
                        'container' => '',
                        'theme_location' => 'header-menu',
                    )
                )
                ?>
            </nav>
            <div id="header-container-right">
                <div id="desktop-lang-picker" class="hidden-mobile">
                    <?php get_template_part("template-parts/lang", "picker") ?>
                </div>
                <button id="bag-button">
                    <div id="bc-bag" class="icon">
                        <?php get_template_part("static/icons/Icon", "Bag.svg"); ?>
                    </div>
                </button>
            </div>
        </div>
        <div id="bc-header-divider" class="bc-divider"></div>
    </header>

    <?php _e("English", "bc-theme"); ?>