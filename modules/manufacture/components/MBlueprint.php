<?php

namespace app\modules\manufacture\components;

use app\models\dump\InvTypes;

class MBlueprint
{
    public $invType;
    public $quantity;
    public $me = 0;
    public $te = 0;

    public $mItems = [];

    public function __construct(InvTypes $invType, $quantity = 1)
    {
        $this->invType = $invType;
        $this->quantity = $quantity;

        $this->loadComponents();
    }

    public function setME($me)
    {
        $this->me = $me;
        return $this;
    }

    public function setTE($te)
    {
        $this->te = $te;
        return $this;
    }


    private function loadComponents()
    {
//        var_dump($this->invType->typeID);
//        echo '<br/><br/>';
        $iam = $this->invType->getIndustryActivityMaterials()->andWhere(['activityID' => '1'])->all();

        if (!empty($iam)) {
            foreach ($iam as $invTypeMaterial) {

//                if(!in_array($invTypeMaterial->invType->typeID,[21026, 28845,29094,29098,29072,29060,11890,20186,21010,21028,21038,21018,29102,29108,29056])){
//                    var_dump($invTypeMaterial->invType->getAttributes());
//                    die('22');
//                }
                $this->mItems[] = MManager::createItem($invTypeMaterial->materialTypeID, $invTypeMaterial->quantity);
            }
        }

        return $this;
    }

    /**
     * @return array|MItem[]
     */
    public function getItems()
    {
        return $this->mItems;
    }


    public function isTypeID($typeID)
    {
//        return ($this->invType->typeID == $typeID);
    }

    /**
     * @return InvTypes
     */
    public function getInvType()
    {
        return $this->invType;
    }
}