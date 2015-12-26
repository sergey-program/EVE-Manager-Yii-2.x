<?php

namespace app\modules\character\modules\market\models;

use app\models\api\character\MarketOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SearchMarketOrder
 *
 * @package app\modules\character\modules\market\models
 */
class SearchMarketOrder extends MarketOrder
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['stationID', 'typeID', 'orderState'], 'integer'],
            [['stationName', 'typeName'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['stationName', 'typeName']);
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
        $query = MarketOrder::find()->joinWith(['staStation', 'invTypes']);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        if (!$this->load($params) && !$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->getSort()->attributes['stationName'] = [
            'asc' => ['staStations.stationName' => SORT_ASC],
            'desc' => ['staStations.stationName' => SORT_DESC]
        ];
        $dataProvider->getSort()->attributes['typeName'] = [
            'asc' => ['invTypes.typeName' => SORT_ASC],
            'desc' => ['invTypes.typeName' => SORT_DESC]
        ];

        $query
            ->andFilterWhere(['stationID' => $this->stationID])
            ->andFilterWhere(['like', 'stationName', $this->getAttribute('stationName')])
            ->andFilterWhere(['like', 'typeName', $this->getAttribute('typeName')])
            ->andFilterWhere(['orderState' => $this->orderState])
            ->andFilterWhere(['characterID' => $this->characterID]);

        return $dataProvider;
    }
}