<?php

namespace app\calls\account;

use app\calls\_extend\AbstractCall;
use app\models\api\account\Character;

class CallCharacters extends AbstractCall
{
    public $apiID;
    public $keyID;
    public $vCode;

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://api.eveonline.com/account/Characters.xml.aspx?keyID=' . $this->keyID . '&vCode=' . $this->vCode;
    }

    /**
     * @param string $sResult
     */
    public function doUpdate($sResult)
    {
        $oXml = $this->createXmlObject($sResult);
        $aCharacters = $oXml->result->rowset->row;

        foreach ($aCharacters as $oCharacter) {
            $aData = self::getXmlAttr($oCharacter);
            $mCharacter = Character::findOne(['apiID' => $this->apiID, 'characterID' => $aData['characterID']]);

            if (!$mCharacter) {
                $mCharacter = new Character();
                $mCharacter->apiID = $this->apiID;
            }

            $mCharacter->characterID = $aData['characterID'];
            $mCharacter->characterName = $aData['name'];
            $mCharacter->corporationID = $aData['corporationID'];
            $mCharacter->corporationName = $aData['corporationName'];
            $mCharacter->allianceID = $aData['allianceID'] ? $aData['allianceID'] : null;
            $mCharacter->allianceName = $aData['allianceName'] ? $aData['allianceName'] : null;
            $mCharacter->factionID = $aData['factionID'] ? $aData['factionID'] : null;
            $mCharacter->factionName = $aData['factionName'] ? $aData['factionName'] : null;

            if ($mCharacter->validate()) {
                $mCharacter->save();
            }
        }
    }
}