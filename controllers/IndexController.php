<?php

namespace app\controllers;

use app\controllers\extend\AbstractController;

/**
 * Class IndexController
 *
 * @package app\controllers
 */
class IndexController extends AbstractController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this
            ->getView()
            ->addBread('Dashboard')
            ->setPageTitle('Dashboard')
            ->setPageDescription('Main page');

        return $this->render('index');
    }

    public function actionAuth()
    {
        $url = 'https://login.eveonline.com/oauth/authorize/?';

        $client1 = 'c3b0f5ad4d2d45fcb7add8f7adae1e78';
        $secret1 = 'Xcr8APOn3nJ3J0xQbuXFsiTssFh1uctewOUsQDzm';

        $client2 = 'a0c140acd33b41fd9c51aff2323043dd';
        $secret2 = 'oMpIsyQgISPYIYAwhVeVabFOxdBCZT1h1xbdbi4K';

        $url .= 'response_type=code';
//        $url .= 'response_type=token';
        $url .= '&redirect_uri=http://eve-manager/callback-url';
        $url .= '&client_id=' . $client1;
//        $url .= '&scope=characterContactsRead%20characterContactsWrite';
        $url .= '&scope=characterAssetsRead';
        $url .= '&state=uniquestate123';

        $access_token = '5AyI2_crDJ8BU858uAvIZHVXBNtZMtCLO_bcs7GQOTQiIAZ0cVK6PL42AM_pUsDm_OgyhvCyNPouIsyCCVzEmQ2';
//        $token_type = "Bearer";

//        $url = 'https://api.eveonline.com/char/AssetList.xml.aspx?accessToken='.$access_token;

        return $this->redirect($url);
    }
}
