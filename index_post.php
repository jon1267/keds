<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

$sdek = new Sdek();

// получить список офисов Sdek (очень много вариантов, комбинаций...) возможные варианты:  указать {OK}
// postal_code, city_code, country_code, region_code, type: ('PVZ', 'POSTAMAT', 'ALL') - все необязательные
//$data = ['region_code' => 81];
//$data = ['city_code' => 435];//44-Москва, 435-Краснодар
//$listDelivery = $sdek->deliveryPoints($data);
//echo '---------------------- list delivery office --------------------------<br>';
//echo '<pre>'.print_r($listDelivery,1).'</pre>';

// get post offices SDEK on post index of City {OK}
//$offices = $sdek->getPostOffices('308000');
//echo '---------------------- list delivery office 308000 -----------------------<br>';
//echo '<pre>'.print_r($offices,1).'</pre>';

// по названию города получить его SDEK коды: города, региона, и postal_codes - почтовые отделения {OK}
$cityCodes = $sdek->getSdekCityCodes('Краснодар');
echo '---------------------- list sdek ru city codes --------------------------<br>';
echo '<pre>'.print_r($cityCodes,1).'</pre>'.'<br>';

// все 84 Региона России (SDEK коды регионов) {OK}
$ruRegions = $sdek->getSdekRegionCodes();
echo '---------------------- 84 Региона России со SDEK кодами  --------------------------<br>';
echo '<pre>'.print_r($ruRegions,1).'</pre>'.'<br>';

// SDEK коды городов россии (если указать код региона SDEK, вернутся города по этому региону)
//$data = ['country_codes' => 'RU', 'region_code' => 16, 'size' => 1000 ,'page' => 1];
$data = ['country_codes' => 'RU', 'size' => 1000 ,'page' => 0];
$cities = $sdek->getSdekAllCities($data);
echo '---------------------- list sdek ru all cities --------------------------<br>';
echo 'Городов  - '. count($cities). ' стр. '. $data['page'];
echo '<pre>'.print_r($cities,1).'</pre>'.'<br>';
