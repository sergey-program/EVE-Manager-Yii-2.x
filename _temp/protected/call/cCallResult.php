<?php

class cCallResult
{
    public $sXml; // xml as string
    public $oXml; // SimpleXmlIterator
    public $bError = false;
    public $sError = '';

    /**
     * @param string|null $sXml
     * @param string|null $sError
     */
    public function __construct($sXml = null, $sError = null)
    {
        if ($sXml) {
            $this->setXmlString($sXml);
            $this->setError($sError);
        }
    }

    /**
     * @param string $sXml
     *
     * @return $this
     */
    public function setXmlString($sXml)
    {
        $this->sXml = $sXml;
        $this->oXml = simplexml_load_string($sXml, 'SimpleXmlIterator', LIBXML_NOCDATA);

        return $this;
    }

    /**
     * @param string|null $sError
     *
     * @return $this
     */
    public function setError($sError = null)
    {
        if ($sError) {
            $this->sError = $sError;
            $this->bError = true;
        }

        return $this;
    }

    /**
     * @return SimpleXmlIterator
     */
    public function getXmlObject()
    {
        return $this->oXml;
    }

    /**
     * @return string
     */
    public function getError()
    {
        // can be only one description of error
        return $this->sError;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        // no curl error, xml object created well
        if (!$this->bError) {
            // check xml error
            if ($this->oXml && isset($this->oXml->error)) {
                $this->setError((string)$this->oXml->error);
            }
        }

        return $this->bError;
    }
}