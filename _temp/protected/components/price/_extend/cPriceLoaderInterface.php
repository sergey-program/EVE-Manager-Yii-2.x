<?php

interface cPriceLoaderInterface
{
    public function setTypeID($sTypeID);

    public function setSolarSystemID($sSolarSystemID);

    public function load();

    public function parse();

    public function getUrl();

    public function getPrice($sTypeID);
}