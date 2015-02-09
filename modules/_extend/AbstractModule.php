<?php

namespace app\modules\_extend;

use app\modules\character\components\ViewCharacter;
use yii\base\Module;

class AbstractModule extends Module
{
    /**
     * @param string $sFileName
     * @param string $sFolderName
     *
     * @return $this
     */
    public function loadConfig($sFileName = 'main', $sFolderName = 'config')
    {
        $sConfigPath = $this->getBasePath() . DS . $sFolderName . DS . $sFileName . '.php';

        if (file_exists($sConfigPath)) {
            \Yii::configure($this, require($sConfigPath));
        }

        return $this;
    }
}