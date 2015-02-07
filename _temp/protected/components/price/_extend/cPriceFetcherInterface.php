<?php

interface cPriceFetcherInterface
{
    public function setTypeID($sTypeID);

    public function setSolarSystemID($sSolarSystemID);

    public function getSolarSystemID();

    public function getXmlContent();

    public function getUrl();
}