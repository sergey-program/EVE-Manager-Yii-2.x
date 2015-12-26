<?php

namespace app\models\extend;

use app\calls\account\CallApiKeyInfo;
use app\calls\account\CallCharacters;

/**
 * Class AbstractApi. Used as extender for Api model to execute api update.
 *
 * @package app\models\extend
 *
 * @property int    $id
 * @property int    $keyID
 * @property string $vCode
 */
abstract class AbstractApi extends AbstractActiveRecord
{
    /**
     * @return $this
     */
    public function updateApiKeyInfo()
    {
        $call = new CallApiKeyInfo();
        $call->apiID = $this->id;
        $call->keyID = $this->keyID;
        $call->vCode = $this->vCode;
        $call->update();

        return $this;
    }

    /**
     * @return $this
     */
    public function updateCharacters()
    {
        $call = new CallCharacters();
        $call->apiID = $this->id;
        $call->keyID = $this->keyID;
        $call->vCode = $this->vCode;
        $call->update();

        return $this;
    }
}