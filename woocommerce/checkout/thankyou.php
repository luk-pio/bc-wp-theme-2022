<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined('ABSPATH') || exit;
?>
<?php bc_checkout_return_to_shop() ?>

<div class="woocommerce-order">

    <h2><?php _e("Order Success!", "bc-theme") ?></h2>
    <p>
        <?php _e("Thank you for your purchase!", "bc-theme") ?>
    </p>
    <p>
        <?php _e("We have sent you a confirmation e-mail.", "bc-theme") ?>
    </p>

    <img class="thank-you-image" src="<?php echo bc_get_attachment_url_by_slug('order-success') ?>" alt="" />
</div>