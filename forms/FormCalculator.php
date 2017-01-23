<?php

namespace app\forms;

use app\components\eve\ItemCollection;
use app\components\eve\ItemCreator;
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
    /** @var int|float $input */
    public $percent;

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
            [['input', 'percent'], 'safe'],
            ['percent', 'integer']
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
        $itemCreator = new ItemCreator();

        $rows = explode("\n", $this->input);

        foreach ($rows as $row) {
            $columns = explode("\t", $row);
            $quantity = trim(preg_replace("/\s+/u", '', $columns[1]));

            if (is_numeric($quantity)) {
                $itemCreator->addTypeName(trim($columns[0]), $quantity);
            }
        }

        foreach ($itemCreator->createItems()->getItems() as $item) {
            $this->itemCollection->addItem($item);
        }

        return $this;
    }
}