<?php

interface cCurlManagerInterface
{
    public function addHandle($hHandle, $sAlias);

    public function execute();

    public function getResult();
}