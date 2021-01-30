<?php

class Sdek
{
    const NEW_TOKEN_LINK = 'https://api.edu.cdek.ru/v2/oauth/token?';
    const ORDER_REGISTER_LINK  = 'https://api.edu.cdek.ru/v2/orders?';
    const BARCODE_REQUEST_LINK = 'https://api.edu.cdek.ru/v2/print/barcodes';
    const CLIENT_ID = 'epT5FMOa7IwjjlwTc1gUjO1GZDH1M1rE';
    const CLIENT_SECRET = 'cYxOu9iAMZYQ1suEqfEvsHld4YQzjY0X';

    public function orderData()
    {
        return [
            //'number' => 'ddOererre7450813980068',
            //'comment' => 'Заказ инет-магазин',
            //'delivery_recipient_cost' => ['value' => 50],
            //'delivery_recipient_cost_adv' => ['sum' => 3000, 'threshold' => 200],
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
                    //'number' => "bar-001",
                    //'comment' => "Упаковка",
                    'height' => 10,
                    /*'items' => [
                        [
                            'ware_key' => "00055",
                            'payment' => ['value' => 3000],
                            'name' => "Товар",
                            'cost' => 300,
                            'amount' => 2,
                            'weight' => 700,
                            'url' => "www.item.ru"
                        ]
                    ],*/
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
            //'services' =>  [ [ 'code' => "DELIV_WEEKEND" ] ],
            'tariff_code' => 137,
        ];
    }

    public function tokenData()
    {
        return [
            'grant_type' =>'client_credentials',
            'client_id' => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET
        ];
    }

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

        return json_decode($res);
    }

    public function orderRequest(string $token)
    {
        $curl = CurlSender::init(self::ORDER_REGISTER_LINK);
        $data = json_encode($this->orderData());
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $token
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
    
    public function barcodeRequest(string $token, string $orderUuid)
    {
        $curl = CurlSender::init(self::BARCODE_REQUEST_LINK);
        $curl->setHeaders([
            'Content-Type: application/json',
            'Authorization: Bearer '. $token
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

    public function barcodeReceive()
    {

    }

}