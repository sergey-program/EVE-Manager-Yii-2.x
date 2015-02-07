<?php

interface cCallUrlInterface
{
    public function setVarSingle($sKey, $sValue);

    public function setVarArray($aVar);

    public function getVar($sKey);

    public function createUrl();

    public function getUrl();
}