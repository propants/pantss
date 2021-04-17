<?php
if (isset($_COOKIE["order_id"])){
    $order_id = $_COOKIE["order_id"];
    $order_name = $_COOKIE["order_name"];
    $order_phone = $_COOKIE["order_phone"];
    $product_name = $_COOKIE["product_name"];
}

require_once('config.php');
require_once('lib/app.php');
$dbg_mod = is_debug($_debug);
global $invoice, $invoiceTemplate;

$tracker_pixels = array();
$check_pixel = False;

foreach ($pixels as $pixel_name) {
    if (isset($_COOKIE[$pixel_name])) {
        $tracker_pixels[$pixel_name] = $_COOKIE[$pixel_name];
        $check_pixel = True;
    }
}
if ($check_pixel) {
    if (isset($order_id)) {
        $lead = 1;
    }
    $product_price = $_COOKIE['product_price'];
    $product_currency = $_COOKIE['product_currency'];
}

//if (isset($_COOKIE["fb_pixel"])) {
//    if (isset($order_id)) {
//        $lead = 1;
//    }
//    $fb_pixel = $_COOKIE['fb_pixel'];
//    $product_price = $_COOKIE['product_price'];
//    $product_currency = $_COOKIE['product_currency'];
//}

$invoice_path = 'invoice2/' . (isset($invoice) ? $invoice : (isset($invoiceTemplate) ? $invoiceTemplate : 'index.php'));

require_once ($invoice_path);
