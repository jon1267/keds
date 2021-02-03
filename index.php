<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

$sdek = new Sdek();

// request for new 'internet shop' order {OK}
$order = $sdek->orderRequest($sdek->orderData137());
echo '-------------------- create new order (internet shop tarif 137) -----------------------<br>';
echo '<pre>'.print_r($order,1).'</pre>';

// request for new  delivery order {OK}
$order1 = $sdek->orderRequest($sdek->orderData136());
echo '-------------------- create new order (internet shop tarif 136) -----------------------<br>';
echo '<pre>'.print_r($order1,1).'</pre>';

// Fool info about order  {OK}
$orderInfo = $sdek->orderInfo($order->entity->uuid);
echo '---------------------- order type 1 fool info ---------------------------------<br>';
echo '<pre>'.print_r($orderInfo,1).'</pre>';

// Fool info about order1 {OK}
$orderInfo1 = $sdek->orderInfo($order1->entity->uuid);
echo '---------------------- order type 2 fool info ---------------------------------<br>';
echo '<pre>'.print_r($orderInfo1,1).'</pre>';

// delete order by $order->entity->uuid {OK}
$deletedOrder = $sdek->orderDelete($order->entity->uuid);
echo '---------------------- delete order 1 ---------------------------------<br>';
echo '<pre>'.print_r($deletedOrder,1).'</pre>';

// delete order1 by $order1->entity->uuid {OK}
$deletedOrder1 = $sdek->orderDelete($order1->entity->uuid);
echo '---------------------- delete order 2 ---------------------------------<br>';
echo '<pre>'.print_r($deletedOrder1,1).'</pre>';
