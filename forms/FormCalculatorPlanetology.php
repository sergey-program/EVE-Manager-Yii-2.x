<?php

namespace app\forms;

use app\components\eveCrest\MarketOrders;
use app\models\dump\InvTypes;
use yii\base\Model;

/**
 * Class FormCalculatorPlanetology
 *
 * @package app\forms
 *
 * @property string $list
 */
class FormCalculatorPlanetology extends Model
{
    public $list;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['list', 'safe']
        ];
    }

    ### functions

    /**
     * @return array
     */
    public function parse()
    {
        $result = [];
        $invTypeNames = [];

        // parse copy paste
        $rows = explode("\n", $this->list);

        if (is_array($rows)) {
            foreach ($rows as $row) {
                $item = explode("\t", $row);
                $invTypeNames[] = trim($item[0]);
                $result[] = ['typeName' => trim($item[0]), 'count' => $item[1]];
            }
        }

        // get typeID for parsed items
        /** @var InvTypes[] $items */
        $items = InvTypes::find()->where(['typeName' => $invTypeNames])->all();

        foreach ($result as $resultKey => $resultItem) {
            foreach ($items as $item) {
                if ($resultItem['typeName'] == $item->typeName) {
                    $result[$resultKey]['typeID'] = $item->typeID;

                    $result[$resultKey]['buy'] = MarketOrders::getPrice($item->typeID, MarketOrders::ORDER_TYPE_BUY);
                    $result[$resultKey]['sell'] = MarketOrders::getPrice($item->typeID, MarketOrders::ORDER_TYPE_SELL);
                }
            }
        }

        return $result;
    }
}