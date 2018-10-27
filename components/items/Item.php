<?php

namespace app\components\items;

/**
 * Class Item
 *
 * @package app\components\items
 */
class Item extends AbstractItem
{
    use TraitBlueprint;
    use TraitRequired;
    use TraitPrice;
    use TraitReprocess;

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->loadBlueprint();
    }
}
