<?php

class cDemand extends cObjectAbstract implements cObjectInterface
{
    const ORDER_TYPE_BUY = 1;
    const ORDER_TYPE_SELL = 0;

    private $cPrice;

    /**
     * @param MarketDemand $oModel
     *
     * @return $this
     */
    public function setModel($oModel)
    {
        if ($oModel instanceof MarketDemand) {
            $this->oModel = $oModel;
            $this->loadPrice();
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
        $this->setModel(clDemand::loadOne($sID, false));

        return $this;
    }

    public function loadPrice()
    {
        $this->cPrice = clPrice::loadOne($this->getTypeID());

        return $this;
    }

    /**
     * @return string|int
     */
    public function getID()
    {
        return $this->oModel->id;
    }

    /**
     * @return string|int
     */
    public function getStationID()
    {
        return $this->oModel->stationID;
    }

    /**
     * @return string
     */
    public function getStationName()
    {
        return 'not working';
    }

    /**
     * @return string
     */
    public function getDemandType()
    {
        return $this->oModel->demandType;
    }

    /**
     * @return string|int
     */
    public function getTypeID()
    {
        return $this->oModel->typeID;
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->oModel->oInvTypes->typeName;
    }

    /**
     * @return string|int
     */
    public function getQuantity()
    {
        return $this->oModel->quantity;
    }

    /**
     * @param string|int $sCharacterID
     *
     * @return array
     * @todo avoid duplicated calls
     */
    public function getOrders($sCharacterID)
    {
        $sBid = ($this->getDemandType() == MarketDemand::TYPE_SELL) ? 0 : 1;

        return clOrder::loadAllForDemand($sCharacterID, $this->getTypeID(), $this->getStationID(), $sBid);
    }

    /**
     * @param string|int $sCharacterID
     *
     * @return int|string
     */
    public function getNeed($sCharacterID)
    {
        $iReturn = $this->getQuantity();

        foreach ($this->getOrders($sCharacterID) as $cOrder) {
            $iReturn -= $cOrder->getVolRemaining();
        }

        return $iReturn;
    }

    public function getPriceSell($bWe = false)
    {
        $sMethod = (!$bWe) ? 'getSellMin' : 'getSellWe';

        return $this->cPrice->{$sMethod}();
    }

    public function getPriceBuy($bWe = false)
    {
        $sMethod = (!$bWe) ? 'getBuyMax' : 'getBuyWe';

        return $this->cPrice->{$sMethod}();
    }
}