<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;

class CallbackUrlController extends AbstractController
{
    public function actionIndex()
    {
        $code = $this->getGet('code');
        var_dump($code);


        $client1 = 'c3b0f5ad4d2d45fcb7add8f7adae1e78';
        $secret1 = 'Xcr8APOn3nJ3J0xQbuXFsiTssFh1uctewOUsQDzm';

        $basic = base64_encode($client1 . ':' . $secret1);

        $url = 'https://login.eveonline.com/oauth/token';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&code=' . $code);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $basic,
            'Content-Type: application/x-www-form-urlencoded',
            'Host: login.eveonline.com'
        ]);

//        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeOutConnection); // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
//        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeOut);                  // The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);                      // cache false
//        curl_setopt($curl, CURLOPT_HEADER, 0);                                // TRUE to include the header in the output.


        $result = curl_exec($curl);

        var_dump($result);
    }
}