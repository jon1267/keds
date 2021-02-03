<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

// get (bearer) token
$sdek = new Sdek();
/*
// request for new internet order (need success result of get token)
$order = $sdek->orderRequest($sdek->orderData());
echo '-------------------- create new order (type=1 internet shop) -----------------------<br>';
echo '<pre>'.print_r($order,1).'</pre>';

// формирование ШК места к заказу {OK}
$barcode = $sdek->barcodeRequest($order->entity->uuid);
echo '---------------------- barcode request --------------------------<br>';
echo '<pre>'.print_r($barcode,1).'</pre>'.'<br>';

// получение pdf файла ШК места {OK}
//$barcodePdf = $sdek->barcodeReceive($token->access_token, '72753031-ca18-4b60-b8a1-f6c2be2dfcda');
sleep(5);//time for create pdf file
$barcodePdf = $sdek->barcodeReceive($barcode->entity->uuid);
echo '---------------------- barcode pdf file --------------------------<br>';
echo '<pre>'.print_r($barcodePdf,1).'</pre>'.'<br>';
*/


// печать pdf file with barcode {Bad}
$printBarcode = $sdek->printBarcode('http://api.edu.cdek.ru/v2/print/barcodes/72753031-6218-4dfa-a741-a2af8fa1e039.pdf');
//print $printBarcode;
//echo '---------------------- print barcode pdf file --------------------------<br>';
//echo '<pre>'.print_r($printBarcode,1).'</pre>'.'<br>';