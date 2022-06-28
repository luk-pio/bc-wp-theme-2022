<?php

/**
 * Email Header
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-header.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 4.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title><?php echo get_bloginfo('name', 'display'); ?></title>
    <style>
    table,
    td,
    div,
    h1,
    p {
        font-family: Arial, sans-serif;
    }
    </style>

    <style>
    div#body_content_inner {
        font-family: "Poppins", sans-serif;
    }

    #bc-logo-container-email {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 32px;
    }

    #body_content_inner {
        text-align: center;
        font-size: 18px;
    }

    .thanks-for-order {
        font-size: 24px;
        font-weight: 500;
    }

    .order-details {
        margin: 4rem 0 2rem;
        text-align: start;
        text-transform: uppercase;
    }

    .order-details b {
        color: black;
        font-weight: 400;
    }

    .address-heading {
        font-weight: 400;
        font-size: 14px;
        color: rgba(0, 0, 0, 0.7);
        text-transform: uppercase;
        margin: 0 0 8px;
    }

    .address-container {
        width: 100%;
        gap: 8px;
    }

    .address {
        border: unset !important;
        padding: unset !important;
        text-align: start;
        font-weight: 500;
        font-size: 14px;
        color: #000;
        line-height: 23px;
        font-style: normal;
    }

    .address a {
        font-weight: 500;
    }

    .order-item {
        align-items: center;
        justify-content: space-between;
    }

    .order-item-metadata {
        text-align: start;
        display: flex;
        align-items: center;
        text-transform: uppercase;
    }

    .order-item-description {
        font-size: 14px;
        line-height: 16px;
        font-weight: 500;
    }

    .order-item-quantity {
        font-size: 14px;
        line-height: 16px;
        font-weight: 400;
    }

    .order-item-price {
        font-size: 14px;
        line-height: 16px;
    }

    .text-light {
        color: rgba(0, 0, 0, 0.7);
    }

    .text-dark {
        font-weight: 500;
        color: #000;
    }


    .order-totals-container {
        width: 100%;
        gap: 8px;
        margin-top: 32px;
    }

    .order-totals {
        display: flex;
        gap: 16px;
        flex-direction: column;
        font-size: 14px;
    }

    .totals-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .totals-label {
        text-transform: uppercase;
        font-size: 14px;
        font-weight: 400;
        color: #716C6C;
    }

    .totals-value {
        text-align: end;
        font-size: 14px;
        font-weight: 500;
    }

    .footer-text {
        font-size: 14px;
        line-height: 16px;
        font-weight: 400;
        text-align: start;
        margin-top: 32px;
    }

    .animation-container {
        justify-self: end;
        align-self: end;
        margin-bottom: 20px;
    }

    .add-to-cart-animation {
        margin: -30px -100px;
        width: 540px;
    }

    h3 {
        font-size: 24px;
        font-weight: 500;
        color: black;
        text-align: center;
    }

    .bc-button {
        text-transform: uppercase;
        text-decoration: none;
        border-radius: 4px;
        background-color: #FCDDEC;
        color: black;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.25);
        padding: 0.5rem 2rem;
    }
    </style>
</head>

<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0"
    offset="0">
    <div role="article" aria-roledescription="email" lang="en"
        style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#fff;">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <tr>
                <td align="center" style="padding:0;" valign="top">
                    <table role="presentation"
                        style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">

                        <div id="template_header_image">
                            <?php
                            if ($img = get_option('woocommerce_email_header_image')) {
                                echo '<p style="margin-top:0;"><img src="' . esc_url($img) . '" alt="' . get_bloginfo('name', 'display') . '" /></p>';
                            }
                            ?>
                        </div>
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Header -->
                                    <?php bc_email_header(); ?>
                                    <!-- End Header -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- Body -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                        <tr>
                                            <td valign="top" id="body_content">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div id="body_content_inner">