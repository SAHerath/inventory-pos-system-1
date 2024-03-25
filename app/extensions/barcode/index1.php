<?php
require_once("vendor/autoload.php");

/* Start to develop here. Best regards https://php-download.com/ */

// instantiate the barcode class
$barcode = new \Com\Tecnick\Barcode\Barcode();

// generate a barcode
$bobj = $barcode->getBarcodeObj(
  'QRCODE,H',                     // barcode type and additional comma-separated parameters
  'Hello Supun Anuradha',          // data string to encode
  -4,                             // bar width (use absolute or negative value as multiplication factor)
  -4,                             // bar height (use absolute or negative value as multiplication factor)
  'black',                        // foreground color
  array(-2, -2, -2, -2)           // padding (use absolute or negative values as multiplication factors)
)->setBackgroundColor('white'); // background color

// output the barcode as HTML div (see other output formats in the documentation and examples)
echo $bobj->getHtmlDiv();
echo '<br>';
echo $bobj->getSvgCode();
echo '<br>';

// another example 

$bobj = $barcode->getBarcodeObj(
  'C128A',
  '0123456789',
  -3,
  -30,
  'black',
  array(0, 0, 0, 0)
);

echo $bobj->getHtmlDiv();
echo '<br>';
echo $bobj->getSvgCode();
echo '<br>';
