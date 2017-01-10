<?php

namespace app\modules\prices\models;

use app\models\Price;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SearchPrice
 *
 * @package app\modules\prices\models
 */
class SearchPrice extends Price
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['typeID', 'integer'],
            ['type', 'integer'],
            ['typeName', 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['typeName']);
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array|null $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Price::find()->joinWith('invTypes');
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        if (!$this->load($params) && !$this->validate()) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['typeID' => $this->typeID])
            ->andFilterWhere(['type' => $this->type])
            ->andFilterWhere(['like', 'typeName', $this->getAttribute('typeName')]);

        return $dataProvider;
    }
}