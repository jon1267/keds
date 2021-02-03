<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

// get post offices for post index 308001
$sdek = new Sdek();

// получить список офисов Sdek (очень много вариантов, комбинаций...) возможные варианты:  указать
// postal_code, city_code, country_code, region_code, type: ('PVZ', 'POSTAMAT', 'ALL') - все необязательные
//$data = ['region_code' => 81];
//$data = ['city_code' => 44];
//$listDelivery = $sdek->deliveryPoints($data);
//echo '---------------------- list delivery office --------------------------<br>';
//echo '<pre>'.print_r($listDelivery,1).'</pre>';

// get post offices SDEK on post index of City {OK}
//$offices = $sdek->getPostOffices('308000');
//echo '---------------------- list delivery office 308000 -----------------------<br>';
//echo '<pre>'.print_r($offices,1).'</pre>';

// по названию города получить его SDEK коды: города, региона, и postal_codes - почтовые отделения {OK}
$сityCodes = $sdek->getSdekCityCodes('Краснодар');
echo '---------------------- list sdek ru city codes --------------------------<br>';
echo '<pre>'.print_r($сityCodes,1).'</pre>'.'<br>';

// все 84 Региона России (SDEK коды регионов) {OK}
$ruRegions = $sdek->getSdekRegionCodes();
echo '---------------------- list sdek ru code regions --------------------------<br>';
echo '<pre>'.print_r($ruRegions,1).'</pre>'.'<br>';