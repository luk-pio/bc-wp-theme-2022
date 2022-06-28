<?php

/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if (!defined('ABSPATH')) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action('woocommerce_email_header', $email_heading, $email);
?>

<?php /* translators: %s: Customer first name */ ?>
<p style="font-size:24px;font-weight:500;color:black">
    <?php printf(esc_html__('Your order is on it\'s way!', 'woocommerce'), esc_html($order->get_billing_first_name())); ?>
</p>
<?php /* translators: %s: Order number */ ?>
<p>
	<?php printf(esc_html__('We know you can’t wait for your package to arrive. That is why you can track your order here:', 'woocommerce'), esc_html($order->get_order_number())); ?>
</p>

<a href="<?php echo $order->get_meta('order_tracking_url'); ?>">
    <button class="bc-button">
        <?php _e("Track your order", "bc-theme"); ?>
    </button>
</a>


<?php echo email_animation("waiting-list-2"); ?>

<tr>
<td style="padding:16px 48px;">

<div class="col-sml" style="display:inline-block;width:100%;max-width:249px;vertical-align:top;text-align:left;font-size:16px">
<?php echo wp_kses_post($before . sprintf(__('Order Number: <b>#%s</b>', 'woocommerce') . $after, $order->get_order_number())); ?>
</div>

<div class="col-lge" style="display:inline-block;width:100%;max-width:249px;vertical-align:top;padding-bottom:20px;font-size:16px">
<?php echo wp_kses_post(sprintf(__('Order Date: <b><time datetime="%s">%s</time></b>'), $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created()))); ?>
</div>

</td>
</tr>

<div class="bc-divider-container">
            <img src="<?php echo bc_get_email_attachment_url("img-line1"); ?>" alt="divider line"/>
</div>

<?php

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);
?>
<div class="bc-divider-container">
            <img src="<?php echo bc_get_email_attachment_url("img-line2"); ?>" alt="divider line"/>
</div>

<?php
/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email);

?>

<div class="bc-divider-container">
            <img src="<?php echo bc_get_email_attachment_url("img-line3"); ?>" alt="divider line"/>
</div>
<?php
/*

 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);


/**
 * Show user-defined additional content - this is set in each email's settings
 */
if ($additional_content) {
	echo wp_kses_post(wpautop(wptexturize($additional_content)));
}

?>
<?php
/*
* @hooked WC_Emails::email_footer() Output the email footer
*/
do_action('woocommerce_email_footer', $email);