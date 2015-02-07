<?php

abstract class cApiAbstract extends cObjectAbstract implements cObjectInterface
{
    /**
     * @param Api $oModel
     *
     * @return $this
     */
    public function setModel($oModel)
    {
        if ($oModel instanceof Api) {
            $this->oModel = $oModel;
        }

        return $this;
    }

    /**
     * @param string|int $sID
     *
     * @return $this
     */
    public function loadModel($sID)
    {
        $this->setModel(Api::model()->findByAttributes(array('keyID' => $sID)));

        return $this;
    }

    /**
     * @return bool
     */
    public function hasCharacters()
    {
        return !empty($this->oModel->aCharacter);
    }

    /**
     * @return bool
     */
    public function hasInfo()
    {
        return !empty($this->oModel->oApiKeyInfo);
    }
}