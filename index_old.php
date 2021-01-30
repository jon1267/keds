<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

// курл1 - получение Bearer token
$link1 = 'https://api.edu.cdek.ru/v2/oauth/token?';
$data1 = [
    'grant_type' =>'client_credentials',
    'client_id' => 'epT5FMOa7IwjjlwTc1gUjO1GZDH1M1rE',
    'client_secret' => 'cYxOu9iAMZYQ1suEqfEvsHld4YQzjY0X'
];

$curl=CurlSender::init($link1);
$res = $curl->post($data1,0);
$status = $curl->getStatus();
$curl->close();

$parse1 = json_decode($res);

echo '<pre>'.print_r($parse1,1).'</pre>';
echo '<br>';

// курл2 - заказ типа 'интернет магазин'
$link2 = 'https://api.edu.cdek.ru/v2/orders?';
$header1 = 'Content-Type: application/json';
$header2 = 'Authorization: Bearer '. $parse1->access_token;
$sdek = new Sdek();
$data2 = json_encode($sdek->orderData());

$curl2 = CurlSender::init($link2);
$curl2->setHeaders([$header1, $header2]);
$result2 = $curl2->post($data2, 1);
$status2 = $curl2->getStatus();
$curl2->close();

$parse2 = json_decode($result2);
echo '<pre>'.print_r($parse2,1).'</pre>';
echo '<br>';

echo '<pre>'.print_r($parse2->entity->uuid,1).'</pre>';
echo '<pre>'.print_r($parse2->requests[0]->request_uuid,1).'</pre>';
//echo '<pre>'.print_r( $header1,1).'</pre>';
//echo '<pre>'.print_r( $header2,1).'</pre>';

// курл3 (GET) информация о заказе
/*$link3 = 'https://api.edu.cdek.ru/v2/orders/'.$parse2->entity->uuid;
$curl3 = CurlSender::init($link3);
$curl3->setHeaders([$header1, $header2]);
$result3 = $curl3->get();
$status3 = $curl3->getStatus();
$curl3->close();
$parse3 = json_decode($result3);
echo '<pre>'.print_r($parse3,1).'</pre>';*/

// формирование ШК места к заказу
$link4 = 'https://api.edu.cdek.ru/v2/print/barcodes';
$curl4 = CurlSender::init($link4);
$curl4->setHeaders([$header1, $header2]);
$data4 = json_encode([
    'orders' => [
        'order_uuid' => $parse2->requests[0]->request_uuid, //entity !found
        //'order_uuid' => $parse2->entity->uuid, //entity invalid
        //'order_uuid' => '72753034-bd61-45fc-be66-da4a03ed2ed8',//entity !found
    ],
    'copy_count' => 1,
    'format' => 'A4'
]);
$result4 = $curl4->post($data4, 1);
$status4 = $curl4->getStatus();
$curl4->close();
$parse4 = json_decode($result4);
echo '<pre>'.print_r($parse4,1).'</pre>';
echo '<pre>'.print_r($status4,1).'</pre>';