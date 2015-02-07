<?php

class CallAccountApiKeyInfo extends CallAbstract implements CallInterface
{
    protected $sFileType = 'account';
    protected $sFileName = 'apikeyinfo';
    private $aData = array();

    /**
     * @return void
     */
    public function setupStorage()
    {
        $this
            ->getStorage()
            ->setCallName('ApiKeyInfo')
            ->setRequire('keyID', cCallStorage::ALIAS_URL)
            ->setRequire('vCode', cCallStorage::ALIAS_URL)
            ->setRequire('apiID');
    }

    /**
     * @return void
     */
    public function parseResult()
    {
        if (!$this->cCallResult->isError()) {
            $oXml = $this->cCallResult->getXmlObject();
            $this->aData = cCallParser::getXmlAttr($oXml->result->key);
        }
    }

    /**
     * @return void
     */
    public function updateResult()
    {
        if (!empty($this->aData) && $this->getStorage()->checkRequire('ApiKeyInfo')) {
            $sApiID = $this->getStorage()->getVar('apiID');
            $oApiInfo = ApiAccountApiKeyInfo::model()->findByAttributes(array('apiID' => $sApiID));

            if ($oApiInfo) {
                $oApiInfo->setScenario('create');
            } else {
                $oApiInfo = new ApiAccountApiKeyInfo('create');
            }

            $oApiInfo->attributes = array(
                'apiID' => $sApiID,
                'accessMask' => $this->aData['accessMask'],
                'type' => $this->aData['type'],
                'expires' => ($this->aData['expires']) ? date($this->aData['expires']) : null
            );

            if ($oApiInfo->validate()) {
                $oApiInfo->save();
            }
        }
    }
}