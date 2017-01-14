<?php

namespace app\forms;

use app\components\eveCrest\MarketOrders;
use app\models\dump\InvTypes;
use yii\base\Model;

/**
 * Class FormCalculator
 *
 * @package app\forms
 *
 * @property string $list
 * @property int    $percent
 */
class FormCalculator extends Model
{
    public $list;
    public $percent;
    public $onlyPI;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['list', 'percent', 'onlyPI'], 'safe'],
            ['onlyPI', 'boolean'],
            ['percent', 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'onlyPI' => 'Use only PI',
            'percent' => 'Also count percent'
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
                $result[] = [
                    'typeName' => trim($item[0]),
                    'count' => preg_replace("/\s+/u", '', $item[1])
                ];
            }
        }

        // get typeID for parsed items
        /** @var InvTypes[] $invTypes */
        $invTypes = InvTypes::find()->where(['typeName' => $invTypeNames])->all();

        foreach ($result as $resultKey => $resultItem) {
            foreach ($invTypes as $invType) {
                if ($resultItem['typeName'] == $invType->typeName) {

                    if ($this->onlyPI && !in_array($invType->groupID, ['1033', '1042'])) {
                        unset($result[$resultKey]);
                        continue;
                    }

                    $result[$resultKey]['typeID'] = $invType->typeID;

                    $result[$resultKey]['buy'] = MarketOrders::getPrice($invType->typeID, MarketOrders::ORDER_TYPE_BUY);
                    $result[$resultKey]['sell'] = MarketOrders::getPrice($invType->typeID, MarketOrders::ORDER_TYPE_SELL);
                }
            }
        }

        return $result;
    }
}