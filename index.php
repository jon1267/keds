<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

// get bearer token
$sdek = new Sdek();
$token = $sdek->tokenRequest();
echo '<pre>'.print_r($token,1).'</pre>'.'<br>';

// request for new internet order (need success result)
$order = $sdek->orderRequest($token->access_token);
echo '<pre>'.print_r($order,1).'</pre>'.'<br>';

// формирование ШК места к заказу
$barcode = $sdek->barcodeRequest($token->access_token, $order->requests[0]->request_uuid);
echo '<pre>'.print_r($barcode,1).'</pre>'.'<br>';