<?php

class cCurlManager implements cCurlManagerInterface
{
    private $hHandle; // main multi_curl handle
    private $aHandle; // calls handles (source)
    private $aResult; // array of cCallResult

    /**
     *
     */
    public function __construct()
    {
        $this->hHandle = curl_multi_init();
    }

    /**
     * @param        $hHandle (link on curl)
     * @param string $sAlias
     *
     * @return $this
     */
    public function addHandle($hHandle, $sAlias = '')
    {
        if (!isset($this->aHandle[$sAlias])) {
            $this->aHandle[$sAlias] = $hHandle;
            curl_multi_add_handle($this->hHandle, $hHandle);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $stillRunning = null;

        do { // execute curl multi (first run)
            $status = curl_multi_exec($this->hHandle, $stillRunning);
        } while ($status === CURLM_CALL_MULTI_PERFORM);


        while ($stillRunning && $status == CURLM_OK) { // loop for execution
            if (curl_multi_select($this->hHandle) === CURLM_CALL_MULTI_PERFORM) {
                usleep(100);
            }

            do {
                $status = curl_multi_exec($this->hHandle, $stillRunning);
            } while ($status == CURLM_CALL_MULTI_PERFORM);
        }

        // get content of all calls
        foreach ($this->aHandle as $sAlias => $hSource) {
            $this->aResult[$sAlias] = new cCallResult(curl_multi_getcontent($hSource), curl_error($hSource));

            curl_multi_remove_handle($this->hHandle, $hSource);
        }

        curl_multi_close($this->hHandle);

        return $this;
    }

    /**
     * @param string|null $sAlias
     *
     * @return array|null
     */
    public function getResult($sAlias = null)
    {
        if (is_null($sAlias)) {
            return $this->aResult;
        }

        if (isset($this->aResult[$sAlias])) {
            return $this->aResult[$sAlias];
        }

        return null;
    }
}