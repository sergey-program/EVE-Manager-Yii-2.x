<?php

namespace app\modules\character\models\_search;

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
            ['stationID', 'integer'],
            [['orderState', 'typeID'], 'safe']
        ];
    }

    public function attributes()
    {
        return parent::attributes();
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($aParam)
    {
        $oQuery = MarketOrder::find();
        $oDataProvider = new ActiveDataProvider(['query' => $oQuery]);

        if (!$this->load($aParam) && !$this->validate()) {
            return $oDataProvider;
        }

        $oQuery
            ->andFilterWhere(['stationID' => $this->stationID])
            ->andFilterWhere(['orderState' => $this->orderState])
            ->andFilterWhere(['characterID' => $this->characterID]);

        return $oDataProvider;
    }
}