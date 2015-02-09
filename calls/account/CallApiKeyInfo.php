<?php

namespace app\calls\account;

use app\calls\_extend\AbstractCall;
use app\models\api\account\ApiKeyInfo;

class CallApiKeyInfo extends AbstractCall
{
    public $keyID;
    public $vCode;
    public $apiID;

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://api.eveonline.com/account/ApiKeyInfo.xml.aspx?keyID=' . $this->keyID . '&vCode=' . $this->vCode;
    }

    /**
     * @param string $sResult
     */
    public function doUpdate($sResult)
    {
        $oXml = $this->createXmlObject($sResult);
        $mApiKeyInfo = ApiKeyInfo::findOne(['id' => $this->apiID]);

        if (!$mApiKeyInfo) {
            $mApiKeyInfo = new ApiKeyInfo();
            $mApiKeyInfo->apiID = $this->apiID;
        }

        $aDataKey = self::getXmlAttr($oXml->result->key);
        $mApiKeyInfo->accessMask = $aDataKey['accessMask'];
        $mApiKeyInfo->type = $aDataKey['type'];
        $mApiKeyInfo->expires = $aDataKey['expires'] ? $aDataKey['expires'] : null;

        if ($mApiKeyInfo->validate()) {
            $mApiKeyInfo->save();
        }
    }
}