<?php

interface CallInterface
{
    // in abstract

    /**
     * Return url for curl;
     */
    public function getUrl();

    /**
     * Storage for vars that should be required;
     */
    public function getStorage();

    /**
     * UniqueID for each call;
     */
    public function getAlias();

    /**
     * Create curl handle for call;
     */
    public function curlHandleCreate();

    /**
     * Return curl handle for call;
     */
    public function curlHandleGet();

    /**
     * Set result after cCurlManager received data;
     */
    public function setResult(cCallResult $cCallResult);

    // in class

    /**
     * Set required for call vars;
     */
    public function setupStorage();

    /**
     * Parsing to $this->aData;
     */
    public function parseResult();

    /**
     * Update DB using parsed data ($this->aData);
     */
    public function updateResult();
}