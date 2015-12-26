<?php

namespace app\components\eveCentral\extend;

/**
 * Class AbstractEveCentral
 *
 * @package app\components\eveCentral\extend
 */
abstract class AbstractEveCentral
{
    public $typeID;                     // array
    public $solarSystemID = 30000142;   // Jita 4-4

    /**
     * @param string|int $typeID
     *
     * @return $this
     */
    public function addTypeID($typeID)
    {
        $this->typeID[] = $typeID;

        return $this;
    }

    /**
     * @param string|int $solarSystemID
     *
     * @return $this
     */
    public function setSolarSystemID($solarSystemID)
    {
        $this->solarSystemID = $solarSystemID;

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
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());
        $content = curl_exec($curl);

        curl_close($curl);

        return $content;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $typeQuery = '';

        for ($i = 0; $i <= count($this->typeID) - 1; $i++) {
            $typeQuery .= 'typeid=' . $this->typeID[$i];

            if (isset($this->typeID[$i + 1])) {
                $typeQuery .= '&';
            }
        }

        return 'http://api.eve-central.com/api/marketstat?' . $typeQuery . '&usesystem=' . $this->solarSystemID;
    }
}