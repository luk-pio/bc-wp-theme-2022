<?php

/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 5.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$address    = $order->get_formatted_billing_address();
$shipping   = $order->get_formatted_shipping_address();

?>
<tr>
<td style="padding: 16px 48px;">
<div class="col-sml" style="display:inline-block;width:100%;max-width:249px;vertical-align:top;text-align:left;">
    <h2 class="address-heading"><?php esc_html_e('Billing address', 'woocommerce'); ?></h2>

    <address class="address">
        <?php echo wp_kses_post($address ? $address : esc_html__('N/A', 'woocommerce')); ?>
        <?php if ($order->get_billing_phone()) : ?>
        <br /><?php echo $order->get_billing_phone(); ?>
        <?php endif; ?>
        <?php if ($order->get_billing_email()) : ?>
        <br /><?php echo esc_html($order->get_billing_email()); ?>
        <?php endif; ?>
    </address>

</div>
<?php if (!wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping) : ?>
<div class="col-lge" style="display:inline-block;width:100%;max-width:249px;vertical-align:top;padding-bottom:20px;">
    <h2 class="address-heading"><?php esc_html_e('Shipping address', 'woocommerce'); ?></h2>

    <address class="address">
        <?php echo wp_kses_post($shipping); ?>
        <?php if ($order->get_shipping_phone()) : ?>
        <br /><?php echo wc_make_phone_clickable($order->get_shipping_phone()); ?>
        <?php endif; ?>
    </address>
</div>
<?php endif; ?>
</td>
</tr>