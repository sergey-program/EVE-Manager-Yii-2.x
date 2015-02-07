<?php

class cApi extends cApiAbstract
{
    /**
     * @return string
     */
    public function getID()
    {
        return $this->oModel->id;
    }

    /**
     * @return string|int
     */
    public function getKeyID()
    {
        return $this->oModel->keyID;
    }

    /**
     * @return string
     */
    public function getVCode()
    {
        return $this->oModel->vCode;
    }

    /**
     * @return array
     */
    public function getCharacters()
    {
        $aReturn = array();

        foreach ($this->oModel->aCharacter as $oCharacter) {
            $aReturn[] = new cCharacter($oCharacter);
        }

        return $aReturn;
    }

    /**
     * @return string|null
     */
    public function getAccessMask()
    {
        return ($this->hasInfo()) ? $this->oModel->oApiKeyInfo->accessMask : null;
    }

    /**
     * @return string|null
     */
    public function getType()
    {
        return ($this->hasInfo()) ? $this->oModel->oApiKeyInfo->type : null;
    }

    /**
     * @return string|null
     */
    public function getExpires()
    {
        return ($this->hasInfo()) ? $this->oModel->oApiKeyInfo->expires : null;
    }
}