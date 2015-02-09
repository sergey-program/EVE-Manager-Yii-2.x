<?php

namespace app\calls\_extend;

abstract class AbstractCall
{
    public $hCurl;
    private $iTimeOutConnection = 10;
    private $iTimeOut = 10;

    abstract public function getUrl();

    abstract public function doUpdate($sResult);

    /**
     * @return string
     */
    protected function getApiUrl()
    {
        return 'https://api.eveonline.com/';
    }

    /**
     * @return $this
     */
    public function createCurlHandle()
    {
        $this->hCurl = curl_init();

        curl_setopt($this->hCurl, CURLOPT_URL, $this->getUrl());
        curl_setopt($this->hCurl, CURLOPT_CONNECTTIMEOUT, $this->iTimeOutConnection); // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
        curl_setopt($this->hCurl, CURLOPT_TIMEOUT, $this->iTimeOut); // The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($this->hCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->hCurl, CURLOPT_FRESH_CONNECT, true); // cache false
        curl_setopt($this->hCurl, CURLOPT_HEADER, 0); // TRUE to include the header in the output.

        return $this;
    }

    /**
     * @return $this
     */
    public function update()
    {
        $this->createCurlHandle();
        $sResult = curl_exec($this->hCurl);
        $this->doUpdate($sResult);

        return $this;
    }

    public static function getXmlAttr($oXml)
    {
        $aResult = null;

        if (is_object($oXml)) {
            foreach ($oXml->attributes() as $sKey => $sVal) {
                $aResult[$sKey] = (string)$sVal;
            }
        }

        return $aResult;
    }

    /**
     * @param string $sXml
     * @param bool   $bDie
     *
     * @return \SimpleXMLElement
     */
    protected function createXmlObject($sXml, $bDie = true)
    {
        $oXml = simplexml_load_string($sXml, 'SimpleXmlIterator', LIBXML_NOCDATA);

        if ($bDie && $oXml->error) {
            die('Error in xml result file.');
        }

        return $oXml;
    }

    protected function print_r($data)
    {
        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}