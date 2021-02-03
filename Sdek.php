<?php

class Sdek
{
    const NEW_TOKEN_LINK = 'https://api.edu.cdek.ru/v2/oauth/token?';
    const ORDER_REGISTER_LINK  = 'https://api.edu.cdek.ru/v2/orders?';
    const ORDER_INFO_LINK  = 'https://api.edu.cdek.ru/v2/orders/';
    const BARCODE_REQUEST_LINK = 'https://api.edu.cdek.ru/v2/print/barcodes';
    const SDEK_DELIVERY_POINTS = 'http://api.cdek.ru/v2/deliverypoints?';
    const SDEK_REGION_CODES = 'https://api.edu.cdek.ru/v2/location/regions?';
    const SDEK_CITY_CODES = 'https://api.edu.cdek.ru/v2/location/cities/?';
    const CLIENT_ID = 'epT5FMOa7IwjjlwTc1gUjO1GZDH1M1rE';
    const CLIENT_SECRET = 'cYxOu9iAMZYQ1suEqfEvsHld4YQzjY0X';

    private $token;

    // $data[] example for order type=1 "internet shop" sklad - dver
    public function orderData137()
    {
        return [
            //'number' => 'ddOererre7450813980068',// надо какой-то номер но токо не именно этот...
            'comment' => 'Заказ 1 инет-магазин, tarif = 137, склад - дверь до 30 кг',
            'delivery_recipient_cost' => ['value' => 50],
            'delivery_recipient_cost_adv' => ['sum' => 3000, 'threshold' => 200],
            'from_location' => [
                'code' => 44,
                //'fias_guid' => "",
                //'postal_code' => "",
                //'longitude' => "",
                //'latitude' => "",
                //'country_code' => "",
                //'region' => "",
                //'sub_region' => "",
                'city' => "Москва",
                //'kladr_code' => "",
                'address' => "пр. Ленинградский, д.4",
             ],
            'to_location' => [
                'code' => 270,
                //'fias_guid' => "",
                //'postal_code' => "",
                //'longitude' => "",
                //'latitude' => "",
                //'country_code' => "",
                //'region' => "",
                //'sub_region' => "",
                'city' => "Новосибирск",
                //'kladr_code' => "",
                'address' => "ул. Блюхера, 32"
            ],
            'packages' => [
                [
                    'number' => "bar-001",
                    'comment' => "Упаковка",
                    'height' => 10,
                    'items' => [
                        [
                            'ware_key' => "00055",
                            'payment' => ['value' => 3000],
                            'name' => "Товар",
                            'cost' => 300,
                            'amount' => 2,
                            'weight' => 700,
                            'url' => "www.item.ru"
                        ]
                    ],
                    'length' => 10,
                    'weight' => 4000,
                    'width' => 10
                ]
            ],
            'recipient' => [
                'name' => "Иванов Иван",
                'phones' => [ ['number' => "+79134637228"] ]
            ],
            'sender' => [ 'name' => "Петров Петр"],
            'services' =>  [ [ 'code' => "DELIV_WEEKEND" ] ],
            'tariff_code' => 137,
        ];
    }

    // $data[] example for order type=1 "internet shop" sklad - sklad
    public function orderData136()
    {
        return [
            //'number' => 'ddOererre7450813980068',// надо какой-то номер но токо не именно этот...
            'tariff_code' => 136,
            'comment' => 'Заказ 2 инет-магазин, tarif = 136, склад - склад до 30 кг',
            'delivery_point'=> 'MSK203',// без этого сздавался с ошибками
            'delivery_recipient_cost' => ['value' => 50],
            'delivery_recipient_cost_adv' => ['sum' => 3000, 'threshold' => 200],
            'from_location' => [
                'code' => 44,
                'city' => "Москва",
                'address' => "пр. Ленинградский, д.4",
            ],
            /*'to_location' => [
                'code' => 270,
                'city' => "Новосибирск",
                'address' => "ул. Блюхера, 32"
            ],*/
            'packages' => [
                [
                    'number' => "bar-001",
                    'comment' => "Упаковка",
                    'height' => 10,
                    'items' => [
                        [
                            'ware_key' => "00055",
                            'payment' => ['value' => 3000],
                            'name' => "Товар",
                            'cost' => 300,
                            'amount' => 2,
                            'weight' => 700,
                            'url' => "www.item.ru"
                        ]
                    ],
                    'length' => 10,
                    'weight' => 4000,
                    'width' => 10
                ]
            ],
            'recipient' => [
                'name' => "Иванов Иван",
                'phones' => [ ['number' => "+79134637228"] ]
            ],
            'sender' => [ 'name' => "Петров Петр"],
            'services' =>  [ [ 'code' => "DELIV_WEEKEND" ] ],
            'print' => 'barcode',
        ];

    }

    // data needed for get token
    public function tokenData()
    {
        return [
            'grant_type' =>'client_credentials',
            'client_id' => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET
        ];
    }

    // request on get bearer token (need success result for all other requests!)
    public function tokenRequest()
    {
        $curl = CurlSender::init(self::NEW_TOKEN_LINK);//curl init
        $res  = $curl->post($this->tokenData(),0);//curl request
        $status = $curl->getStatus();//get last curl status
        $error = $curl->getError();//get last curl error
        $curl->close();
        $result = json_decode($res);

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    // register new order Sdek, with any type={1,2} or 'internet shop' or 'delivery'
    // depend on $orderData (or data for 'internet shop' or data for 'delivery')
    public function orderRequest($orderData)
    {
        $curl = CurlSender::init(self::ORDER_REGISTER_LINK);
        $data = json_encode($orderData);
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->getToken()
        ]);
        $res = $curl->post($data,1);
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();
        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    // get created order info. Need token & order uuid.
    public function orderInfo(string $orderUuid)
    {
        $curl = CurlSender::init(self::ORDER_INFO_LINK . $orderUuid);
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->getToken()
        ]);
        $res = $curl->get();
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    // delete order
    public function orderDelete(string $orderUuid)
    {
        $curl = CurlSender::init(self::ORDER_INFO_LINK . $orderUuid);
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->token ?? $this->getToken()
        ]);
        $res = $curl->delete();
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }
    
    // get list of delivery points 
    public function deliveryPoints($data)
    {
        $curl = CurlSender::init(self::SDEK_DELIVERY_POINTS . http_build_query($data));
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->getToken(),
        ]);
        $res = $curl->get();
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    // возвращает массив (сокращенный до ['code','name','address']) офисов СДЕК по почтовому индексу Города(!)
    // тут даются индексы типа '308000-Белгород', '350000-Краснодар', '190000 Санкт-Петербугр' итд. если дать
    // обычный почтовый индекс типа 121609 - все равно вернется список офисов SDEK для этого города.
    public function getPostOffices($index='')
    {
        if ($index == '') return [];

        $offices = [];
        $request =  $this->deliveryPoints(['postal_code' => $index]);

        if (count($request)) {

            foreach ($request as $key => $post) {
                $offices[$key]['code'] = $post->code;
                $offices[$key]['name'] = $post->name;
                $offices[$key]['address_comment'] = $post->address_comment;
            }
        }

        return $offices;
    }

    //get list of region cods (RU)
    public function getSdekRegionCodes()
    {
        $data = ['country_codes'=>'RU']; //if $data=[]; all regions SDEK in the world (us,ru,turkey, & so on)
        $curl = CurlSender::init(self::SDEK_REGION_CODES . http_build_query($data));
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->getToken(),
        ]);
        $res = $curl->get();
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    public function getSdekCityCodes( $city = 'Белгород') {
        $data=['city'=> $city];
        $curl = CurlSender::init(self::SDEK_CITY_CODES . http_build_query($data));
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->getToken(),
        ]);
        $res = $curl->get();
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    // заказ штрих кода места
    public function barcodeRequest(string $orderUuid)
    {
        $curl = CurlSender::init(self::BARCODE_REQUEST_LINK);
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->getToken()
        ]);
        $data = json_encode([
            'orders' => ['order_uuid' => $orderUuid, ],// orders can be many
            'copy_count' => 1,
            'format' => 'A4'
        ]);
        $res = $curl->post($data, 1);
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    // получение ШК места {$barcodeUuid == $barcode->entity->uuid - успешный результат $this->barcodeRequest(...)}
    public function barcodeReceive(string $barcodeUuid)
    {
        $curl = CurlSender::init(self::BARCODE_REQUEST_LINK .'/'. $barcodeUuid);
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $this->getToken(),
        ]);
        $res = $curl->get();
        $status = $curl->getStatus();
        $result = json_decode($res);
        $error = $curl->getError();
        $curl->close();

        if (!in_array($status, [200,201, 202, 204, 205])) {
            return ['result' => $result, 'status' => $status, 'error' => $error];
        }

        return $result;
    }

    public function printBarcode(string $pdfLink)
    {
        $curl = CurlSender::init($pdfLink);
        /*$curl->setHeaders([
            'Content-Type: application/pdf',
            'Authorization: Bearer '. $this->getToken()
        ]);*/

        header('Authorization: Bearer '. $this->getToken());
        header("Content-type: application/pdf");

        print $curl->get();
        $curl->close();

        exit;
    }

    // this return bearer token, or null
    private function getToken()
    {
        $token = $this->tokenRequest();
        return $this->token = $token->access_token ?? null;
    }
}