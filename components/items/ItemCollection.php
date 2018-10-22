<?php

namespace app\components\items;
/**
 * Class ItemCollection
 *
 * @package app\components\items
 */
class ItemCollection extends AbstractItemCollection
{
    /**
     * @param $percent
     *
     * @return ItemCollection
     */
    public function reprocess($percent)
    {
        $result = new ItemCollection();

        foreach ($this->getItems() as $item) {
            $item->setReprocessPercent($percent);
            $item->reprocess();

            foreach ($item->getReprocessResult() as $rItem) {
                $result->addItemQuantity($rItem);
            }
        }

        return $result;
    }
}
