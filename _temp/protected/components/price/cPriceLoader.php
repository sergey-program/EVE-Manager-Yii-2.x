<?php

class cPriceLoader implements cPriceLoaderInterface
{
    private $cFetcher;
    private $aPrice;
    private $oXml;

    /**
     *
     */
    public function __construct()
    {
        $this->cFetcher = new cPriceFetcher();
    }

    /**
     * @param string|int $typeID
     *
     * @return $this
     */
    public function setTypeID($typeID)
    {
        $this->cFetcher->setTypeID($typeID);

        return $this;
    }

    /**
     * @param string|int $sSolarSystemID
     *
     * @return $this
     */
    public function setSolarSystemID($sSolarSystemID)
    {
        $this->cFetcher->setSolarSystemID($sSolarSystemID);

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->cFetcher->getUrl();
    }

    /**
     * @return $this
     */
    public function load()
    {
        $this->oXml = new SimpleXMLElement($this->cFetcher->getXmlContent());
        $this->parse();

        return $this;
    }

    /**
     *
     */
    public function parse()
    {
        foreach ($this->oXml->marketstat->type as $oType) {
            $aPrice['typeID'] = (string)$oType->attributes()->id;
            $aPrice['solarSystemID'] = $this->cFetcher->getSolarSystemID();
            $aPrice['buy'] = (array)$oType->buy;
            $aPrice['sell'] = (array)$oType->sell;
            $aPrice['all'] = (array)$oType->all;

            $this->aPrice[$aPrice['typeID']] = $aPrice;
        }
    }

    /**
     * @param string|int $sTypeID
     *
     * @return null
     */
    public function getPrice($sTypeID)
    {
        if (isset($this->aPrice[$sTypeID])) {
            return new cPrice($this->aPrice[$sTypeID]);
        }

        return null;
    }
}