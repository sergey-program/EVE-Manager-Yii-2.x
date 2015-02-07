<?php

interface cCallExecutorInterface
{
    public function addCall(CallAbstract $oCall);

    public function doFetch();

    public function doParse();

    public function doUpdate();
}