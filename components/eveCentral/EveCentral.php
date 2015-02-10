<?php
namespace app\components\eveCentral;

use app\calls\_extend\AbstractCall;
use app\components\eveCentral\_extend\AbstractEveCentral;
use app\modules\prices\models\Price;
use yii\db\Expression;

class EveCentral extends AbstractEveCentral
{
    /**
     *
     */
    public function fetch()
    {
        $sXml = $this->getXmlContent();

        if (is_int(strpos($sXml, 'non-marketable'))) {
            return;
        }

        $oXml = new \SimpleXMLElement($sXml);

        if (!$oXml) {
            return;
        }

        foreach ($oXml->marketstat->type as $oRow) {
            $this->update($oRow);
        }
    }

    /**
     * @param \SimpleXMLElement $oRow
     */
    private function update(\SimpleXMLElement $oRow)
    {
        $aTypeID = AbstractCall::getXmlAttr($oRow);
        $iTypeID = $aTypeID['id'];

        // buy

        $mPrice = Price::findOne(['typeID' => $iTypeID, 'type' => Price::TYPE_BUY]);

        if (!$mPrice) {
            $mPrice = new Price();
            $mPrice->typeID = $aTypeID['id'];
            $mPrice->type = Price::TYPE_BUY;
        }

        $mPrice->volume = (string)$oRow->buy->volume;
        $mPrice->average = (string)$oRow->buy->avg;
        $mPrice->min = (string)$oRow->buy->min;
        $mPrice->max = (string)$oRow->buy->max;
        $mPrice->stdDev = (string)$oRow->buy->stddev;
        $mPrice->median = (string)$oRow->buy->median;
        $mPrice->percentile = (string)$oRow->buy->percentile;

        if ($mPrice->validate()) {
            $mPrice->save();
        }

        // sell

        $mPrice = Price::findOne(['typeID' => $iTypeID, 'type' => Price::TYPE_SELL]);

        if (!$mPrice) {
            $mPrice = new Price();
            $mPrice->typeID = $aTypeID['id'];
            $mPrice->type = Price::TYPE_SELL;
        }

        $mPrice->volume = (string)$oRow->sell->volume;
        $mPrice->average = (string)$oRow->sell->avg;
        $mPrice->min = (string)$oRow->sell->min;
        $mPrice->max = (string)$oRow->sell->max;
        $mPrice->stdDev = (string)$oRow->sell->stddev;
        $mPrice->median = (string)$oRow->sell->median;
        $mPrice->percentile = (string)$oRow->sell->percentile;

        if ($mPrice->validate()) {
            $mPrice->save();
        }
    }
}