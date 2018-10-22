<?php

namespace app\forms;

use app\components\items\Item;
use app\components\items\ItemCollection;
use app\models\dump\InvTypes;
use yii\base\Model;

/**
 * Class FormCalculator
 *
 * @package app\forms
 */
class FormCalculator extends Model
{
    /** @var string $input */
    public $input;
    /** @var int|float $pricePercent */
    public $percentPrice;
    /** @var  int|float $reprocessPercent */
    public $percentReprocess = 55; // @todo default rule not working,recheck

    /** @var ItemCollection|null $itemCollection */
    private $itemCollection;

    /**
     * @return void
     */
    public function init()
    {
        $this->itemCollection = new ItemCollection();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['input', 'trim'],
            ['input', 'required'],
            ['percentReprocess', 'default', 'value' => 55],
            [['input', 'percentPrice'], 'safe'],

        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'input' => 'Input',
            'percentReprocess' => 'reprocess'
        ];
    }

    ### functions

    /**
     * @return ItemCollection|null
     */
    public function getItemCollection()
    {
        return $this->itemCollection;
    }

    /**
     * @return $this
     */
    public function parse()
    {
        $rows = explode("\n", $this->input);

        foreach ($rows as $row) {
            $columns = explode("\t", $row);
            $quantity = trim(preg_replace("/\s+/u", '', $columns[1]));

            $typeName = str_replace('*', '', trim($columns[0]));

            if (is_numeric($quantity)) {

                $invType = InvTypes::find()->where(['typeName' => $typeName])->cache(60 * 60 * 24)->one();

                if ($invType) {
                    $this->itemCollection->addItem(new Item(['invType' => $invType, 'quantity' => $quantity]));
                }
            }
        }

        // redefine collection with new items
//        $this->itemCollection->setItems($itemFactory->loadItems()->getItems());

        return $this;
    }
}