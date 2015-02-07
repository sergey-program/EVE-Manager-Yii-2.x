<?php

class OrderController extends AbstractController
{
    /**
     *
     */
    public function actionUpdate()
    {
        $clApi = clApi::loadAll();
        $oExecutor = new cCallExecutor();

        foreach ($clApi as $cApi) {

            if (!$cApi->hasCharacters()) {
                continue;
            }

            foreach ($cApi->getCharacters() as $cCharacter) {
                $oCallMarketOrders = new CallCharacterMarketOrders();
                $oCallMarketOrders
                    ->getStorage()
                    ->setVar('keyID', $cApi->getKeyID(), cCallStorage::ALIAS_URL)
                    ->setVar('vCode', $cApi->getVCode(), cCallStorage::ALIAS_URL)
                    ->setVar('characterID', $cCharacter->getCharacterID(), cCallStorage::ALIAS_URL);

                $oExecutor->addCall($oCallMarketOrders);
            }
        }

        $oExecutor
            ->doFetch()
            ->doParse()
            ->doUpdate();

        $this->redirect($this->createUrl('character/list'));
    }

    /**
     * @param string|int $sCharacterID
     */
    public function actionCharacter($sCharacterID)
    {
        $aData = array(
            'cCharacter' => new cCharacter($sCharacterID)
        );

        $this->render('character', $aData);
    }

    /**
     * @param string|int $sCharacterID
     * @param string|int $sStationID
     */
    public function actionStation($sCharacterID, $sStationID)
    {
        $aData = array(
            'cCharacter' => new cCharacter($sCharacterID),
            'cStation' => new cStation($sStationID)
        );

        $this->render('station', $aData);
    }
}