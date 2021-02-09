<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

$sdek = new Sdek();

$order = $sdek->orderRequest($sdek->orderData137());

$barcode = $sdek->barcodeRequest($order->entity->uuid);

$sdek->printPdf('http://api.edu.cdek.ru/v2/print/barcodes/'.$barcode->entity->uuid.'.pdf');

// так теперь тоже заработало - если есть прямая ссылка на pdf файл - он нормально выводится
//$sdek->printPdf('http://api.edu.cdek.ru/v2/print/barcodes/72753031-26f8-42eb-b4e4-54a316664cdd.pdf');

//$barcodeReceive = $sdek->barcodeReceive('72753031-7f5a-4942-b27f-50b4c282f035');
//$barcodeReceive = $sdek->barcodeReceive('72753031-e645-4691-925f-cf24117419da');
//echo '-------------------- barcode receive -----------------------<br>';
//echo '<pre>'.print_r($barcodeReceive,1).'</pre>';