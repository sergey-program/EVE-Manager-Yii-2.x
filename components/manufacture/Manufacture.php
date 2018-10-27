<?php

namespace app\components\manufacture;

use app\components\items\Item;
use app\modules\manufacture\Settings;
use yii\base\BaseObject;

class Manufacture extends BaseObject
{
    /** @var Item|null $product */
    public $product;
    /** @var array $materials */
    public $materials;
    /** @var Settings $settings */
    public $settings;

    /**
     * @param Item     $item
     * @param Settings $settings
     *
     * @return Manufacture
     */
    public static function create(Item $item, Settings $settings)
    {
        return new self(['product' => $item, 'settings' => $settings]);
    }
}