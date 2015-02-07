<?php

abstract class CallAbstract implements CallInterface
{
    protected $cCallUrl;
    protected $cCallResult;
    protected $cCallStorage;
    private $sUniqueID; // unique id for call
    private $hCurl; // curl handle
    // settings for cUrl
    private $iTimeOutConnection = 10;
    private $iTimeOut = 10;

    /**
     *
     */
    public function __construct()
    {
        $this->setupStorage();
        $this->sUniqueID = uniqid();
        $this->curlHandleCreate();
    }

    /**
     * After curl assign result object back to call class, for parsing and updating;
     *
     * @param cCallResult $cCallResult
     *
     * @return $this
     */
    public function setResult(cCallResult $cCallResult)
    {
        $this->cCallResult = $cCallResult;

        return $this;
    }

    /**
     * Return call url;
     *
     * @return string
     * @throws Exception
     */
    public function getUrl()
    {
        if (!$this->cCallUrl) {
            $this->cCallUrl = new cCallUrl($this->sFileType, $this->sFileName);

            if ($this->getStorage()->checkRequire(cCallStorage::ALIAS_URL)) {
                $this->cCallUrl->setVarArray($this->getStorage()->getVarsByAlias(cCallStorage::ALIAS_URL));
            }
        }

        return $this->cCallUrl->getUrl();
    }

    /**
     * @return cCallStorage
     */
    public function getStorage()
    {
        if (!$this->cCallStorage) {
            $this->cCallStorage = new cCallStorage();
        }

        return $this->cCallStorage;
    }

    /**
     * Alias for curl and other indexes in array;
     *
     * @return string
     * @throws Exception
     */
    public function getAlias()
    {
        if (!$this->sFileType || !$this->sFileName) {
            throw new Exception ('Cannot create alias, sFileName and sFileType empty.');
        }

        return $this->sFileType . '_' . $this->sFileName . '_' . $this->sUniqueID;
    }

    /**
     * Init handle for current object;
     *
     * @return $this
     */
    public function curlHandleCreate()
    {
        $this->hCurl = curl_init();

        return $this;
    }

    /**
     * Setup for current curl handle and return it;
     *
     * @return mixed
     * @throws Exception
     */
    public function curlHandleGet()
    {
        curl_setopt($this->hCurl, CURLOPT_URL, $this->getUrl());
        curl_setopt($this->hCurl, CURLOPT_CONNECTTIMEOUT, $this->iTimeOutConnection); // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
        curl_setopt($this->hCurl, CURLOPT_TIMEOUT, $this->iTimeOut); // The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($this->hCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->hCurl, CURLOPT_FRESH_CONNECT, true); // cache false
        curl_setopt($this->hCurl, CURLOPT_HEADER, 0); // TRUE to include the header in the output.

        return $this->hCurl;
    }

    /**
     * @param array $aData
     * @param bool  $bDump
     */
    protected function show($aData, $bDump = false)
    {
        if ($bDump) {
            var_dump($aData);
        } else {
            echo '<pre>';
            print_r($aData);
            echo '</pre>';
        }

        die();
    }

}