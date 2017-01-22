<?php

namespace app\forms;

use app\components\eve\Item;
use yii\base\Model;

/**
 * Class FormCalculator
 *
 * @package app\forms
 */
class FormCalculator extends Model
{
    const FILTER_PI = 'pi';

    /** @var string $input */
    public $input;
    /** @var int|float $input */
    public $percent;
    /** @var string $input */
    public $filter;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['input', 'trim'],
            ['input', 'required'],
            [['input', 'percent', 'filter'], 'safe'],
            ['percent', 'integer']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'filter' => 'Filter',
            'reprocess' => 'Only reprocessed materials'
        ];
    }

    ### functions

    /**
     * @return array
     */
    public function parse()
    {
        $items = [];
        $rows = explode("\n", $this->input);

        foreach ($rows as $row) {
            $columns = explode("\t", $row);
            $quantity = preg_replace("/\s+/u", '', $columns[1]);

            if (is_numeric($quantity)) {
                $items['input'][] = new Item(['typeName' => trim($columns[0]), 'quantity' => $quantity]);
            }
        }

        if ($this->filter == self::FILTER_PI) {
            foreach ($items['input'] as $item) {
                if (in_array($item->groupID, ['1033', '1042'])) { // t0 and t1 pi
                    $items['filter'][] = $item;
                }
            }
        }

        return $items;
    }
}