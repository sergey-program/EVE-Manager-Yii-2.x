<?php

namespace app\calls\account;

use app\calls\extend\AbstractCall;
use app\models\api\account\ApiKeyInfo;

/**
 * Class CallApiKeyInfo
 *
 * @package app\calls\account
 */
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
     * @param string $result
     *
     * @return bool
     */
    public function doUpdate($result)
    {
        $xml = $this->createXmlObject($result);

        /** @var ApiKeyInfo $apiKeyInfo */
        $apiKeyInfo = ApiKeyInfo::findOne(['id' => $this->apiID]);

        if (!$apiKeyInfo) {
            $apiKeyInfo = new ApiKeyInfo();
            $apiKeyInfo->apiID = $this->apiID;
        }

        $dataKey = self::getXmlAttr($xml->result->key);

        $apiKeyInfo->timeUpdated = time();
        $apiKeyInfo->accessMask = $dataKey['accessMask'];
        $apiKeyInfo->type = $dataKey['type'];
        $apiKeyInfo->expires = $dataKey['expires'] ? strtotime($dataKey['expires']) : null;

        return $apiKeyInfo->save();
    }
}