<?php

namespace app\components\eveCentral\_extend;

abstract class AbstractEveCentral
{
    public $aTypeID;
    public $solarSystemID = 30000142;

    /**
     * @param string|int $iTypeID
     *
     * @return $this
     */
    public function addTypeID($iTypeID)
    {
        $this->aTypeID[] = $iTypeID;

        return $this;
    }

    /**
     * @param string|int $iSolarSystemID
     *
     * @return $this
     */
    public function setSolarSystemID($iSolarSystemID)
    {
        $this->solarSystemID = $iSolarSystemID;

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