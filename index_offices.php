<?php

require_once 'Sdek.php';
require_once 'CurlSender.php';

$sdek = new Sdek();

$offices = $sdek->getPostOffices('308000');

print '<pre>';
print_r($offices);
print '</pre>';
