<?php

/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.4
 */

defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) { // @codingStandardsIgnoreLine.
	return;
}

?>

<form class="checkout_coupon woocommerce-form-coupon" method="post">

    <h3><?php esc_html_e('DISCOUNT', 'woocommerce'); ?></h3>

    <div class="form-row-container">

        <p class="form-row form-row-first">
            <input type="text" name="coupon_code" class="input-text"
                placeholder="<?php esc_attr_e('Discount code', 'woocommerce'); ?>" id="coupon_code" value="" />
        </p>

        <p class="form-row form-row-last">
            <button type="submit" class="button" name="apply_coupon"
                value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply discount', 'woocommerce'); ?></button>
        </p>


    </div>

    <div class="clear"></div>
</form>