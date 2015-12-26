<?php

namespace app\calls\account;

use app\calls\extend\AbstractCall;
use app\models\api\account\Character;

/**
 * Class CallCharacters
 *
 * @package app\calls\account
 */
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
     * @param string $result
     *
     * @return bool
     */
    public function doUpdate($result)
    {
        $return = true;
        $xml = $this->createXmlObject($result);
        $characters = $xml->result->rowset->row;

        foreach ($characters as $character) {
            $data = self::getXmlAttr($character);
            $character = Character::findOne(['apiID' => $this->apiID, 'characterID' => $data['characterID']]);

            if (!$character) {
                $character = new Character();
                $character->apiID = $this->apiID;
            }
            
            $character->timeUpdated = time();
            $character->characterID = $data['characterID'];
            $character->characterName = $data['name'];
            $character->corporationID = $data['corporationID'];
            $character->corporationName = $data['corporationName'];
            $character->allianceID = $data['allianceID'] ? $data['allianceID'] : null;
            $character->allianceName = $data['allianceName'] ? $data['allianceName'] : null;
            $character->factionID = $data['factionID'] ? $data['factionID'] : null;
            $character->factionName = $data['factionName'] ? $data['factionName'] : null;

            $return = ($character->save() && $return);
        }

        return $return;
    }
}