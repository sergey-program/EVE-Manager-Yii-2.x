<?php

class CnqStationController extends AbstractController
{
    /**
     *
     */
    public function actionUpdate()
    {
        $oCall = new CallEveConquerableStationList();
        $oExecutor = new cCallExecutor();
        $oExecutor
            ->addCall($oCall)
            ->doFetch()
            ->doParse()
            ->doUpdate();

        $this->redirect($this->createUrl('index/index'));
    }
}