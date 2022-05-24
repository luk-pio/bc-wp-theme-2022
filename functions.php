<?php

$roots_includes = array(
  './functions/setup.php',
  './functions/components.php',
  './functions/utils.php',
  './functions/header.php',
  './functions/woocommerce/shared.php',
  './functions/woocommerce/product-categories.php',
  './functions/woocommerce/archive-product.php',
  './functions/woocommerce/single-product.php',
  './functions/woocommerce/checkout.php',
);

foreach ($roots_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
  }
  require_once $filepath;
}
unset($file, $filepath);