<?php

interface ParserInterface
{
    public function setXmlString($sXml);

    public function setXmlObject(SimpleXmlIterator $oXml);

    public function getXmlObject();

    public function parse();

    public function getData();
}