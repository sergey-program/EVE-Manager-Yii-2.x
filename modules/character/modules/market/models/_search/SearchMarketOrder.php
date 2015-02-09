<?php

namespace app\modules\character\modules\market\models\_search;

use app\models\api\character\MarketOrder;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
     * @param array $aParam
     *
     * @return ActiveDataProvider
     */
    public function search($aParam)
    {
        $oQuery = MarketOrder::find()->joinWith(['staStation', 'invTypes']);
        $oDataProvider = new ActiveDataProvider(['query' => $oQuery]);

        if (!$this->load($aParam) && !$this->validate()) {
            return $oDataProvider;
        }

        $oDataProvider->getSort()->attributes['stationName'] = ['asc' => ['staStations.stationName' => SORT_ASC], 'desc' => ['staStations.stationName' => SORT_DESC]];
        $oDataProvider->getSort()->attributes['typeName'] = ['asc' => ['invTypes.typeName' => SORT_ASC], 'desc' => ['invTypes.typeName' => SORT_DESC]];

        $oQuery
            ->andFilterWhere(['stationID' => $this->stationID])
            ->andFilterWhere(['like', 'stationName', $this->getAttribute('stationName')])
            ->andFilterWhere(['like', 'typeName', $this->getAttribute('typeName')])
            ->andFilterWhere(['orderState' => $this->orderState])
            ->andFilterWhere(['characterID' => $this->characterID]);


        return $oDataProvider;
    }
}