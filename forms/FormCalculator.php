<?php

namespace app\forms;

use app\components\eve\ItemCollection;
use app\components\eve\ItemFactory;
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
    public $percentReprocess;

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
            [['input', 'percentPrice', 'percentReprocess'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'input' => 'Input'
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
        $itemFactory = new ItemFactory();
        $rows = explode("\n", $this->input);

        foreach ($rows as $row) {
            $columns = explode("\t", $row);
            $quantity = trim(preg_replace("/\s+/u", '', $columns[1]));

            if (is_numeric($quantity)) {
                $itemFactory->addType(trim($columns[0]), $quantity);
            }
        }

        // redefine collection with new items
        $this->itemCollection->setItems($itemFactory->loadItems()->getItems());

        return $this;
    }
}