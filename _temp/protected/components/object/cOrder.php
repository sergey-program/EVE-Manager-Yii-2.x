<?php

class cOrder extends cObjectAbstract implements cObjectInterface
{
    /**
     * Assign already loaded model;
     *
     * @param ApiCharacterMarketOrders $oModel
     *
     * @return $this
     */
    public function setModel($oModel)
    {
        if ($oModel instanceof ApiCharacterMarketOrders) {
            $this->oModel = $oModel;
        }

        return $this;
    }

    /**
     * Load by orderID;
     *
     * @param string|int $sID
     *
     * @return $this
     */
    public function loadModel($sID)
    {
        $this->setModel(ApiCharacterMarketOrders::model()->findByAttributes(array('orderID' => $sID)));

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
    public function getOrderID()
    {
        return $this->oModel->orderID;
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
     * @return string
     */
    public function getStationID()
    {
        return $this->oModel->stationID;
    }

    /**
     * @return string|int
     */
    public function getVolEntered()
    {
        return $this->oModel->volEntered;
    }

    /**
     * @return string|int
     */
    public function getVolRemaining()
    {
        return $this->oModel->volRemaining;
    }

}