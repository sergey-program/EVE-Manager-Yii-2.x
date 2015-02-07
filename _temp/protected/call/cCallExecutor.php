<?php

class cCallExecutor implements cCallExecutorInterface
{
    private $aCall = array();
    private $cCurlManager;

    /**
     *
     */
    public function __construct()
    {
        $this->cCurlManager = new cCurlManager();
    }

    /**
     * @param CallAbstract $oCall
     *
     * @return $this
     */
    public function addCall(CallAbstract $oCall)
    {
        $this->aCall[$oCall->getAlias()] = $oCall;

        return $this;
    }

    /**
     * @return $this
     */
    public function doFetch()
    {
        // add all handles to cCurlManager
        foreach ($this->aCall as $oCall) {

            $this->cCurlManager->addHandle($oCall->curlHandleGet(), $oCall->getAlias());
        }

        // fetch all data
        $this->cCurlManager->execute();

        // set back results
        foreach ($this->aCall as $oCall) {
            $oCall->setResult($this->cCurlManager->getResult($oCall->getAlias()));
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function doParse()
    {
        foreach ($this->aCall as $oCall) {
            $oCall->parseResult();
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function doUpdate()
    {
        foreach ($this->aCall as $oCall) {
            $oCall->updateResult();
        }

        return $this;
    }
}