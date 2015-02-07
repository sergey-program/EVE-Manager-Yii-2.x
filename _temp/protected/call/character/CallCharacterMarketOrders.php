<?php

class CallCharacterMarketOrders extends CallAbstract
{
    protected $sFileType = 'char';
    protected $sFileName = 'marketOrders';
    private $aData = array();

    /**
     * @return void
     */
    public function setupStorage()
    {
        $this
            ->getStorage()
            ->setCallName('Character Marker Order')
            ->setRequire('keyID', cCallStorage::ALIAS_URL)
            ->setRequire('vCode', cCallStorage::ALIAS_URL)
            ->setRequire('characterID', cCallStorage::ALIAS_URL);
    }

    /**
     * @return void
     */
    public function parseResult()
    {
        if (!$this->cCallResult->isError()) {
            $oXml = $this->cCallResult->getXmlObject();

            if (isset($oXml->result->rowset->row)) {
                foreach ($oXml->result->rowset->row as $oRow) {
                    $this->aData[] = cCallParser::getXmlAttr($oRow);
                }
            }
        }
    }

    /**
     * @return void
     */
    public function updateResult()
    {
        if (!empty($this->aData) && $this->getStorage()->checkRequire()) {
            $sCharacterID = $this->getStorage()->getVar('characterID', cCallStorage::ALIAS_URL);

            ApiCharacterMarketOrders::model()->updateAll(array('characterID' => $sCharacterID), 'orderState = :orderState', array(':orderState' => ApiCharacterMarketOrders::ORDER_STATE_CLOSED));

            foreach ($this->aData as $aOrder) {
                $oOrder = ApiCharacterMarketOrders::model()->findByAttributes(array('characterID' => $sCharacterID, 'orderID' => $aOrder['orderID']));

                if ($oOrder) {
                    $oOrder->setScenario('create');
                } else {
                    $oOrder = new ApiCharacterMarketOrders('create');
                }

                $oOrder->attributes = array(
                    'characterID' => $sCharacterID,
                    'orderID' => $aOrder['orderID'],
                    'stationID' => $aOrder['stationID'],
                    'volEntered' => $aOrder['volEntered'],
                    'volRemaining' => $aOrder['volRemaining'],
                    'minVolume' => $aOrder['minVolume'],
                    'orderState' => $aOrder['orderState'],
                    'typeID' => $aOrder['typeID'],
                    'range' => $aOrder['range'],
                    'accountKey' => $aOrder['accountKey'],
                    'duration' => $aOrder['duration'],
                    'escrow' => $aOrder['escrow'],
                    'price' => $aOrder['price'],
                    'bid' => $aOrder['bid'],
                    'issued' => date($aOrder['issued'])
                );

                if ($oOrder->validate()) {
                    $oOrder->save();
                }
            }
        }
    }
}