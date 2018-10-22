<?php

namespace app\components\items;

/**
 * Class Item
 *
 * @package app\components\items
 */
class Item extends AbstractItem
{
    use TraitRequired;
    use TraitPrice;
    use TraitReprocessable;
}
