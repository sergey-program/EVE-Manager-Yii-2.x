<?php

namespace app\modules\station\models;

use app\models\api\eve\ConquerableStation;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SearchConquerableStation
 *
 * @package app\modules\station\models
 */
class SearchConquerableStation extends ConquerableStation
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['stationID', 'solarSystemID'], 'integer'],
            [['stationName'], 'safe']
        ];
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
        $query = ConquerableStation::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        if (!$this->load($params) && !$this->validate()) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'stationID', $this->stationID])
            ->andFilterWhere(['like', 'solarSystemID', $this->solarSystemID])
            ->andFilterWhere(['like', 'stationName', $this->stationName]);

        return $dataProvider;
    }
}