<?php

namespace app\modules\calculators\widgets;

use app\components\items\Item;
use yii\base\Widget;

/**
 * Class RefinedItemWidget
 *
 * @package app\modules\calculators\widgets
 */
class RefinedItemWidget extends Widget
{
    /** @var Item $item */
    public $item;

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function run()
    {
        return $this->render('refined-item', [
            'item' => $this->item,
            'collection' => \Yii::$app->actionRefine->runOne($this->item)
        ]);
    }
}