<?php

class cCharacter extends cObjectAbstract implements cObjectInterface
{
    /**
     * @param ApiAccountCharacters $oModel
     *
     * @return $this
     */
    public function setModel($oModel)
    {
        if ($oModel instanceof ApiAccountCharacters) {

            $this->oModel = $oModel;
        }

        return $this;
    }

    /**
     * @param string|int $sID
     *
     * @return $this
     */
    public function loadModel($sID)
    {
        $this->setModel(clCharacter::loadOne($sID, false));

        return $this;
    }

    /**
     * @return string|int
     */
    public function getCharacterID()
    {
        return $this->oModel->characterID;
    }

    /**
     * @return string
     */
    public function getCharacterName()
    {
        return $this->oModel->characterName;
    }

    /**
     * @return string|int
     */
    public function getCorporationID()
    {
        return $this->oModel->corporationID;
    }

    /**
     * @return string
     */
    public function getCorporationName()
    {
        return $this->oModel->corporationName;
    }

    /**
     * @return string|int|null
     */
    public function getAllianceID()
    {
        return $this->oModel->allianceID;
    }

    /**
     * @return string|null
     */
    public function getAllianceName()
    {
        return $this->oModel->allianceName;
    }

    /**
     * @return string|int|null
     */
    public function getFactionID()
    {
        return $this->oModel->factionID;
    }

    /**
     * @return string|null
     */
    public function getFactionName()
    {
        return $this->oModel->factionName;
    }

    /**
     * List of orders;
     *
     * @param string|int|null $sStationID Filter for station;
     *
     * @return array
     */
    public function getOrders($sStationID = null)
    {
        return clOrder::loadAllAsList($this->getCharacterID(), $sStationID);
    }

    /**
     * List of stations where character has orders;
     *
     * @return array
     */
    public function getOrdersAsStationList()
    {
        return clOrder::loadAllAsStationList($this->getCharacterID());
    }

    /**
     * @param string|int|null $sStationID
     *
     * @return string|int
     */
    public function getOrdersCount($sStationID = null)
    {
        $aAttr = array('characterID' => $this->getCharacterID(), 'orderState' => 0);

        if ($sStationID) {
            $aAttr['stationID'] = $sStationID;
        }

        return ApiCharacterMarketOrders::model()->countByAttributes($aAttr);
    }

    /**
     * List of demands;
     *
     * @param string|int|null $sStationID Filter for station;
     *
     * @return array
     */
    public function getDemands($sStationID = null)
    {
        return clDemand::loadAllAsList($this->getCharacterID(), $sStationID);
    }

    /**
     * List of stations where character has demands;
     *
     * @return array
     */
    public function getDemandsAsStationList()
    {
        return clDemand::loadAllAsStationList($this->getCharacterID());
    }

    /**
     * @param string|int|null $sStationID
     * @param string|null     $sDemandsType
     *
     * @return string|int
     */
    public function getDemandsCount($sStationID = null, $sDemandsType = null)
    {
        $aAttr = array('characterID' => $this->getCharacterID());

        if ($sStationID) {
            $aAttr['stationID'] = $sStationID;
        }

        if ($sDemandsType) {
            $aAttr['demandType'] = $sDemandsType;
        }

        return MarketDemand::model()->countByAttributes($aAttr);
    }

}