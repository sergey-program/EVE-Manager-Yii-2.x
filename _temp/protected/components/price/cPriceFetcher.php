<?php

class cPriceFetcher implements cPriceFetcherInterface
{
    public $aTypeID;
    public $solarSystemID;
    private $sSolarSystemID_jita = '';

    /**
     * @param int|string|array $typeID
     * @param int|string $sSolarSystemID
     */
    public function __construct($typeID = null, $sSolarSystemID = null)
    {
        if (!is_null($typeID)) {
            if (is_array($typeID)) {
                $this->aTypeID = $typeID;
            } else {
                $this->aTypeID[] = $typeID;
            }
        }

        if (!is_null($sSolarSystemID)) {
            $this->solarSystemID = $sSolarSystemID;
        }
    }

    /**
     * @param string|int $sTypeID
     *
     * @return $this
     */
    public function setTypeID($sTypeID)
    {
        $this->aTypeID[] = $sTypeID;

        return $this;
    }

    /**
     * @return int|string
     */
    public function getSolarSystemID()
    {
        return $this->solarSystemID;
    }

    /**
     * @param string|int $sSolarSystemID
     *
     * @return $this
     */
    public function setSolarSystemID($sSolarSystemID)
    {
        $this->solarSystemID = $sSolarSystemID;

        return $this;
    }

    /**
     * We use cUrl because of "allow_url_open = false" option (php.ini). By default it's true (on) but some hosting
     * disable them because xss. So to avoid this we will use curl, without it nothing (at all) will be updated.
     *
     * @return string
     */
    public function getXmlContent()
    {
        $hCurl = curl_init();
        curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($hCurl, CURLOPT_URL, $this->getUrl());
        $sContent = curl_exec($hCurl);
        curl_close($hCurl);

        return $sContent;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $sType = '';

        for ($i = 0; $i <= count($this->aTypeID) - 1; $i++) {
            $sType .= 'typeid=' . $this->aTypeID[$i];
            if (isset($this->aTypeID[$i + 1])) {
                $sType .= '&';
            }
        }

        return 'http://api.eve-central.com/api/marketstat?' . $sType . '&usesystem=' . $this->solarSystemID;
    }
}