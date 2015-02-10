<?php

namespace app\modules\prices\models\_search;

use app\modules\prices\models\Price;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
     * @param $aParam
     *
     * @return ActiveDataProvider
     */
    public function search($aParam)
    {
        $oQuery = Price::find()->joinWith('invTypes');
        $oDataProvider = new ActiveDataProvider(['query' => $oQuery]);

        if (!$this->load($aParam) && !$this->validate()) {
            return $oDataProvider;
        }

        $oQuery
            ->andFilterWhere(['typeID' => $this->typeID])
            ->andFilterWhere(['type' => $this->type])
            ->andFilterWhere(['like', 'typeName', $this->getAttribute('typeName')]);

        return $oDataProvider;
    }
}