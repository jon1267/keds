<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

$sdek = new Sdek();

// request for new order create
$order = $sdek->orderRequest($sdek->orderData137());
echo '-------------------- create new order (internet shop tarif 137) -----------------------<br>';
echo '<pre>'.print_r($order,1).'</pre>';

// get all statuses for order {OK if order successfully created}
$allStatuses = $sdek->orderAllStatuses($order->entity->uuid);
echo '---------------------- order all statuses info ---------------------------------<br>';
echo '<pre>'.print_r($allStatuses,1).'</pre>';

// get last status for order {OK if order successfully created}
$lastStatus = $sdek->orderLastStatus($order->entity->uuid);
echo '---------------------- order last status info ---------------------------------<br>';
echo '<pre>'.print_r($lastStatus ,1).'</pre>';

// get FOOL info about order  {OK if order successfully created}
$orderInfo = $sdek->orderInfo($order->entity->uuid);
echo '---------------------- order FOOL info that has SDEK ----------------------------<br>';
echo '<pre>'.print_r($orderInfo,1).'</pre>';
