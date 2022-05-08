<?php

$roots_includes = array(
  './functions/setup.php',
  './functions/single-product.php',
  './functions/utils.php',
  './functions/header.php',
  './functions/archive-product.php',
);

foreach ($roots_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error("Error locating `$file` for inclusion!", E_USER_ERROR);
  }
  require_once $filepath;
}
unset($file, $filepath);