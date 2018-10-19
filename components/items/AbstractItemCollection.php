<?php

namespace app\components\items;

use yii\base\BaseObject;

/**
 * Class AbstractItemCollection
 *
 * @package app\components\items
 *
 * @property ItemInterface[]|array $objects
 * @property int[]|array           $typeIDs
 */
abstract class AbstractItemCollection extends BaseObject
{
    /** @var AbstractItem[]|array $objects */
    private $objects = [];

    /**
     * @param ItemInterface $object
     *
     * @return $this
     */
    public function addObject(AbstractItem $object)
    {
        $this->objects[] = $object;

        return $this;
    }

    /**
     * @return AbstractItem[]|array
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @param int $typeID
     *
     * @return AbstractItem|mixed|null
     */
    public function getObject($typeID)
    {
        $result = null;

        foreach ($this->getObjects() as $object) {
            if ($object->isTypeID($typeID)) {
                $result = $object;
                break;
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getTypeIDs()
    {
        $result = [];

        foreach ($this->getObjects() as $object) {
            $result[] = $object->getTypeID();
        }

        return $result;
    }

    /**
     * @param bool $asc
     *
     * @return $this
     */
    public function sort($asc = true)
    {
        if ($asc) {
            ksort($this->objects);
        } else {
            krsort($this->objects);
        }

        return $this;
    }
}