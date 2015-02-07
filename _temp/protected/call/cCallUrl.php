<?php

class cCallUrl implements cCallUrlInterface
{
    private $sFileType;
    private $sFileName;
    private $sUrl;
    private $aVar = array();

    /**
     * @param string $sFileType
     * @param string $sFileName
     */
    public function __construct($sFileType, $sFileName)
    {
        $this->sFileType = $sFileType;
        $this->sFileName = $sFileName;
    }

    /**
     * Add single variable (single) to url;
     *
     * @param string $sKey
     * @param string $sValue
     *
     * @return $this
     */
    public function setVarSingle($sKey, $sValue)
    {
        if ($sKey && $sValue) {
            $this->aVar[$sKey] = $sValue;
        }

        return $this;
    }

    /**
     * Set variables (array) for url;
     *
     * @param array $aVar
     *
     * @return $this
     */
    public function setVarArray($aVar)
    {
        if (is_array($aVar)) {
            $this->aVar = $aVar;
        }

        return $this;
    }

    /**
     * @param string $sKey
     *
     * @return string|null
     */
    public function getVar($sKey)
    {
        return (isset($this->aVar[$sKey])) ? $this->aVar[$sKey] : null;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getUrl()
    {
        if (!$this->sUrl) {
            $this->sUrl = $this->createUrl();
        }

        return $this->sUrl;
    }

    /**
     * Create url for this call;
     *
     * @return string
     * @throws Exception
     */
    public function createUrl()
    {
        if (!$this->sFileType || !$this->sFileName) {
            throw new Exception('sFileType and sFileName cannot be null.');
        }

        $sUrl = 'https://api.eveonline.com' . '/' . $this->sFileType . '/' . $this->sFileName . '.xml.aspx';
        $bFirst = true;

        if (!empty($this->aVar)) {
            foreach ($this->aVar as $sName => $sValue) {
                if ($bFirst) {
                    $bFirst = false;
                    $sUrl .= '?';
                } else {
                    $sUrl .= '&';
                }

                $sUrl .= $sName . '=' . $sValue;
            }
        }

        return preg_replace('/ /', '%20', $sUrl);
    }
}