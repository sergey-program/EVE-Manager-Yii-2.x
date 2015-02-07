<?php

class clCharacter
{
    /**
     * Load all characters;
     *
     * @param bool $bAsComponent
     *
     * @return array
     */
    public static function loadAll($bAsComponent = true)
    {
        $aCharacter = array();

        foreach (ApiAccountCharacters::model()->findAll() as $oCharacter) {
            $aCharacter[] = ($bAsComponent) ? new cCharacter($oCharacter) : $oCharacter;
        }

        return $aCharacter;
    }

    /**
     * Load one character by characterID;
     *
     * @param string|int $sCharacterID
     * @param bool       $bAsComponent
     *
     * @return ApiAccountCharacters|cCharacter|null
     */
    public static function loadOne($sCharacterID, $bAsComponent = true)
    {
        $oCharacter = ApiAccountCharacters::model()->findByAttributes(array('characterID' => $sCharacterID));

        return ($bAsComponent) ? new cCharacter($oCharacter) : $oCharacter;
    }
}