<?php

namespace app\components\items;

/**
 * Class Item
 *
 * @package app\components\items
 */
class Item extends AbstractItem
{
//    use TraitBlueprint;
//    use TraitParentBlueprint;

    use TraitPrice;
//    use TraitReprocess;
//    use TraitParentItem;
    use TraitTotal;

    /**
     * @param int $size
     *
     * @return string
     */
    public function getImageSrc($size = 32)
    {
        return 'https://image.eveonline.com/Type/' . $this->typeID . '_' . $size . '.png';
    }

//    /**
//     * @param bool $withME
//     *
//     * @return float|int
//     */
//    public function getQuantity($withME = true)
//    {
//        $rawQuantity = parent::getQuantity();
//
//        if ($withME && $this->getParentBlueprint()) {
//            return $this->getParentBlueprint()->calculateQuantity($rawQuantity);
//        }
//
//        return $rawQuantity;
//    }
//
//    /**
//     * @param bool $withME
//     *
//     * @return float|int
//     */
//    public function getQuantityTotal($withME = true)
//    {
//        $quantity = $this->getQuantity($withME);
//
//        if ($this->getParentBlueprint()) {
//            return $quantity * $this->getParentBlueprint()->getRuns();
//        }
//
//        return $quantity;
//    }
}
