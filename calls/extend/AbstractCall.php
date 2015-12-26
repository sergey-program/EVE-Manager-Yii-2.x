<?php

namespace app\calls\extend;

/**
 * Class AbstractCall
 *
 * @package app\calls\extend
 */
abstract class AbstractCall
{
    public $curl;

    private $timeOutConnection = 10;
    private $timeOut = 10;

    /**
     * @return string
     */
    abstract public function getUrl();

    abstract public function doUpdate($result);

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
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_URL, $this->getUrl());
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->timeOutConnection); // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeOut);                  // The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, true);                      // cache false
        curl_setopt($this->curl, CURLOPT_HEADER, 0);                                // TRUE to include the header in the output.

        return $this;
    }

    /**
     * @return $this
     */
    public function update()
    {
        $this->createCurlHandle();
        $result = curl_exec($this->curl);
        $this->doUpdate($result);

        return $this;
    }

    /**
     * @param \SimpleXMLElement $xml
     *
     * @return null
     */
    public static function getXmlAttr($xml)
    {
        $result = null;

        if (is_object($xml)) {
            foreach ($xml->attributes() as $key => $val) {
                $result[$key] = (string)$val;
            }
        }

        return $result;
    }

    /**
     * @param string $xml
     * @param bool   $die
     *
     * @return \SimpleXMLElement
     */
    protected function createXmlObject($xml, $die = true)
    {
        /** @var \SimpleXmlIterator $xmlObj */
        $xmlObj = simplexml_load_string($xml, 'SimpleXmlIterator', LIBXML_NOCDATA);

        if ($die && !$xmlObj) {
            die('Error in xml result file.');
        }

        return $xmlObj;
    }

    /**
     * Debug method.
     *
     * @param array $data
     */
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