<?php

class DemandController extends AbstractController
{
    /**
     * @param string|int $sCharacterID
     */
    public function actionCharacter($sCharacterID)
    {
        $oDemand = new MarketDemand('create');

        if ($this->isPost('MarketDemand', $oDemand)) {
            $oDemand->characterID = $sCharacterID;

            if ($oDemand->validate()) {
                $oDemand->save();

                $this->redirect($this->createUrl('market/demand/character', array('sCharacterID' => $sCharacterID)));
            }
        }
        $aData = array(
            'oDemand' => $oDemand,
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