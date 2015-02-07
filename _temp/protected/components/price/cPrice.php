<?php

class cPrice
{
    public $sTypeID;
    public $sSolarSystemID;

    public static $sPercentSell = 0.35;
    public static $sPercentBuy = 0.15;

    public $sBuyMin;
    public $sBuyMax;
    public $sBuyAvg;

    public $sSellMin;
    public $sSellMax;
    public $sSellAvg;

    public $sAllMin;
    public $sAllMax;
    public $sAllAvg;

    public $sSellWe;
    public $sBuyWe;

    /**
     * @param array $aData
     */
    public function __construct($aData)
    {
        $this->sTypeID = $aData['typeID'];
        $this->sSolarSystemID = $aData['solarSystemID'];

        $this->sBuyMin = $aData['buy']['min'];
        $this->sBuyMax = $aData['buy']['max'];
        $this->sBuyAvg = $aData['buy']['avg'];

        $this->sSellMin = $aData['sell']['min'];
        $this->sSellMax = $aData['sell']['max'];
        $this->sSellAvg = $aData['sell']['avg'];

        $this->sAllMin = $aData['all']['min'];
        $this->sAllMax = $aData['all']['max'];
        $this->sAllAvg = $aData['all']['avg'];

        $this->sSellWe = round($this->sSellMin * self::$sPercentSell + $this->sSellMin, -2);
        $this->sBuyWe = round($this->sBuyMax - $this->sBuyMax * self::$sPercentBuy, -2);
    }

    /**
     * @return int
     */
    public static function getPercentBuy()
    {
        return self::$sPercentBuy * 100;
    }

    /**
     * @return int
     */
    public static function getPercentSell()
    {
        return self::$sPercentSell * 100;
    }

    /**
     * @return string|float
     */
    public function getBuyMin()
    {
        return $this->sBuyMin;
    }

    /**
     * @return string|float
     */
    public function getBuyMax()
    {
        return $this->sBuyMax;
    }

    /**
     * @return float
     */
    public function getBuyWe()
    {
        return $this->sBuyWe;
    }

    /**
     * @return string|float
     */
    public function getSellMax()
    {
        return $this->sSellMax;
    }

    /**
     * @return string|float
     */
    public function getSellMin()
    {
        return $this->sSellMin;
    }

    /**
     * @return string|float
     */
    public function getSellWe()
    {
        return $this->sSellWe;
    }
}