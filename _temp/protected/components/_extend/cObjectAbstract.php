<?php

abstract class cObjectAbstract
{
    protected $oModel;

    /**
     * @param CActiveRecord|int|null $data
     */
    public function __construct($data = null)
    {
        if (is_object($data)) {
            $this->setModel($data);
        } elseif (is_numeric($data)) {
            $this->loadModel($data);
        }
    }
}