<?php

/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined('ABSPATH') || exit;

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ($items as $item_id => $item) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';

	if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
		continue;
	}

	if (is_object($product)) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image($image_size);
	}

?>
	<tr>
    <td style="padding:16px 0;">
    <div class="col-sml" style="display:inline-block;width:100%;vertical-align:top;text-align:left;margin-left:8px">
		<div style="max-width: 150px;display: inline-block;">
        <?php

			// Show title/image etc.
			
			if ($show_image) {
				echo str_replace("https", "http", wp_kses_post(apply_filters('woocommerce_order_item_thumbnail', $image, $item)));
			}

			?>
		   </div>
        <div style="max-width: 100px; font-size: 12px;display: inline-block;padding-right:30px">
            <?php
				// Product name.
				echo wp_kses_post(apply_filters('woocommerce_order_item_name', $item->get_name(), $item, false));
				?>
        </div>

    <div class="col-lge" style="display:inline-block;width:100%;max-width:100px;vertical-align:center;padding-bottom:20px;font-size:12px">
        <?php
			$qty          = $item->get_quantity();
			$refunded_qty = $order->get_qty_refunded_for_item($item_id);

			if ($refunded_qty) {
				$qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ($refunded_qty * -1)) . '</ins>';
			} else {
				$qty_display = esc_html($qty);
			}
			echo "<span>QTY: </span>";
			echo wp_kses_post(apply_filters('woocommerce_email_order_item_quantity', $qty_display, $item));
			?>
    </div>
    <div class="col-lge" style="display:inline-block;width:100%;vertical-align:center;padding-bottom:20px;font-size:12px;text-align:end;max-width:155px;">
        <?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?>
    </div>
</div>
    </td>
	</tr>

<?php

	if ($show_purchase_note && $purchase_note) {
	?>
<div>
    <div colspan="3">
        <?php
				echo wp_kses_post(wpautop(do_shortcode($purchase_note)));
				?>
    </div>
</div>
<?php
	}
	?>

<?php endforeach; ?>