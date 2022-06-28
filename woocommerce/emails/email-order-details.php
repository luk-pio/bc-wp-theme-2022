<?php

/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
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

defined('ABSPATH') || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action('woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email); ?>

<div style="margin-bottom: 40px;">
    <table cellspacing="0" cellpadding="6" style="">

        <?php
        echo wc_get_email_order_items( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            $order,
            array(
                'show_sku'      => $sent_to_admin,
                'show_image'    => true,
                'image_size'    => array(128, 192),
                'plain_text'    => $plain_text,
                'sent_to_admin' => $sent_to_admin,
            )
        );
        ?>


        <div class="bc-divider-container">
            <img src="<?php echo bc_get_email_attachment_url("img-line1"); ?>" alt="divider line"/>
        </div>

	<tr>
    <td style="padding:16px 0;">
    <div class="col-sml" style="display:inline-block;width:100%;max-width:200px;vertical-align:top;text-align:left;margin-left:32px">
            <?php echo email_animation("add-to-cart-2")  ?>
    </div>
    <div class="col-lge" style="display:inline-block;width:100%;max-width:265px;vertical-align:top;padding-bottom:20px;padding-top:40px;padding-left:55px">
                <?php
                $item_totals = $order->get_order_item_totals();

                if ($item_totals) {
                    $i = 0;
                    foreach ($item_totals as $total) {
                        $i++;
                ?>
                        <div class="totals-row" style="width:100%; display: inline-block;font-size:14px">
                            <div class="totals-label text-light " style="display: inline-block; float: left;">
                                <?php echo wp_kses_post($total['label']); ?></div>
                            <div class="totals-value text-dark" style="display: inline-block; float:right;">
                                <?php echo wp_kses_post($total['value']); ?></div>
                        </div>
                <?php
                    }
                }
                ?>

            </div>
        </div>
    </td>
    </tr>
    </table>
</div>

<?php do_action('woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email); ?>