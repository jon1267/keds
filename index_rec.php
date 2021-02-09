<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

$sdek = new Sdek();

//$orders = '72753031-ae37-4918-ba34-8a578c56e85f';
//$orders = [
//    ['order_uuid' => '72753031-99af-4d78-836d-67e17c6f1124'],
//    ['order_uuid' => '72753031-897a-4aa8-abaa-be508a3bc208'],
//];

//$receipt = $sdek->receiptRequest('72753031-ae37-4918-ba34-8a578c56e85f');
//$receipt = $sdek->receiptRequest($orders);
//echo '-------------------- запрос формирования квитанции к заказу -----------------------<br>';
//echo '<pre>'.print_r($receipt,1).'</pre>';

$receiptPdf = $sdek->receiptReceive('72753031-83b0-44b8-9e49-1509b152b44e');
//$receiptPdf = $sdek->receiptReceive($receipt->entity->uuid);
echo '-------------------- имя pdf квитанции к заказу -----------------------<br>';
echo '<pre>'.print_r($receiptPdf,1).'</pre>';

// тест на открытие пдф файла квитанции (все кроме $sdek = new Sdek(); убрать или закомм )
//$order = $sdek->orderRequest($sdek->orderData137());
//$receipt = $sdek->receiptRequest($order->entity->uuid);
//$sdek->printPdf('https://api.edu.cdek.ru/v2/print/orders/'.$receipt->entity->uuid.'.pdf');

// тест на открытие пдф файла квитанции если есть ссылка на файл (72753031-befb-4e94-9281-3e04881aace6.pdf)
//$sdek->printPdf('https://api.edu.cdek.ru/v2/print/orders/72753031-befb-4e94-9281-3e04881aace6.pdf');