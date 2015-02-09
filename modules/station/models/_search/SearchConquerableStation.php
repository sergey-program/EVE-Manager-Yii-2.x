<?php

namespace app\modules\station\models\_search;

use app\models\api\eve\ConquerableStation;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchConquerableStation extends ConquerableStation
{
    /**
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

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
     * @param array|null $aParam
     *
     * @return ActiveDataProvider
     */
    public function search($aParam)
    {
        $oQuery = ConquerableStation::find();
        $oDataProvider = new ActiveDataProvider(['query' => $oQuery]);

        if (!$this->load($aParam) && !$this->validate()) {
            return $oDataProvider;
        }

        $oQuery
            ->andFilterWhere(['stationID' => $this->stationID])
            ->andFilterWhere(['solarSystemID' => $this->solarSystemID])
            ->andFilterWhere(['like', 'stationName', $this->stationName]);

        return $oDataProvider;
    }
}