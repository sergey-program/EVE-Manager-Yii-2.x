<?php

namespace app\modules\calculators\widgets;

use app\components\items\Item;
use yii\base\Widget;

/**
 * Class ReprocessItemWidget
 *
 * @package app\modules\calculators\widgets
 */
class ReprocessItemWidget extends Widget
{
    /** @var Item $item */
    public $item;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('reprocess-item', ['item' => $this->item]);
    }
}