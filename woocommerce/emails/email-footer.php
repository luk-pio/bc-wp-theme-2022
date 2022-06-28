<?php

/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
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
?>
<div class="footer-text text-dark"
style="font-size: 14px;
       line-height: 16px;
       font-weight: 400;
       text-align: start;
       padding: 16px;
       margin-top: 32px;
       margin-bottom: 32px;
">
    <?php
    $shop_policy_url = get_permalink(get_page_by_title("Shop Policy"));
    $contact_url = get_permalink(get_page_by_title("Contact"));
    _e("If you have any questions regarding Shipping & Returns, visit the ", "bc-theme");
    echo '<a href="' . esc_url($shop_policy_url) . '#shipping" style="color: black;">';
    _e("Shop Policy. ", "bc-theme");
    echo '</a>';
    _e("To contact me directly please use the ", "bc-theme");
    echo '<a href="' . esc_url($contact_url) . '#contact" style="color: black;">';
    _e("Contact Form.", "bc-theme");
    echo '</a>';
    ?>
</div>


</div>
</td>
</tr>
</table>
<!-- End Content -->
</td>
</tr>
</table>
<!-- End Body -->
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</body>

</html>