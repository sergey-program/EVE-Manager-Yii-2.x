<?php

namespace app\modules\manufacture;

use yii\base\BaseObject;

class Settings extends BaseObject
{
    public $meBpo = 0;
    public $teBpo = 0;
    public $meHull = 0;
    public $teHull = 0;
    public $meRig = 0;
    public $teRig = 0;

    public $runs = 1;
}