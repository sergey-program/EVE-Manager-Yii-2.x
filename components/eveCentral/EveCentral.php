<?php

namespace app\components\eveCentral;

use app\calls\extend\AbstractCall;
use app\components\eveCentral\extend\AbstractEveCentral;
use app\models\Price;

/**
 * Class EveCentral
 *
 * @package app\components\eveCentral
 */
class EveCentral extends AbstractEveCentral
{
    /**
     *
     */
    public function fetch()
    {
        $xml = $this->getXmlContent();

        if (is_int(strpos($xml, 'non-marketable'))) {
            return false;
        }

        $xmlObj = new \SimpleXMLElement($xml);

        if (!$xmlObj) {
            return false;
        }

        foreach ($xmlObj->marketstat->type as $row) {
            $this->update($row);
        }

        return true;
    }

    /**
     * @param \SimpleXMLElement $row
     *
     * @return bool
     */
    private function update(\SimpleXMLElement $row)
    {
        $return = true;
        $type = AbstractCall::getXmlAttr($row);

        // buy
        /** @var Price $price */
        $price = Price::findOne(['typeID' => $type['id'], 'type' => Price::TYPE_BUY]);

        if (!$price) {
            $price = new Price();
            $price->typeID = $type['id'];
            $price->type = Price::TYPE_BUY;
        }

        $price->volume = (string)$row->buy->volume;
        $price->average = (string)$row->buy->avg;
        $price->min = (string)$row->buy->min;
        $price->max = (string)$row->buy->max;
        $price->stdDev = (string)$row->buy->stddev;
        $price->median = (string)$row->buy->median;
        $price->percentile = (string)$row->buy->percentile;
        $return = ($price->save() && $return);

        // sell
        /** @var Price $price */
        $price = Price::findOne(['typeID' => $type['id'], 'type' => Price::TYPE_SELL]);

        if (!$price) {
            $price = new Price();
            $price->typeID = $type['id'];
            $price->type = Price::TYPE_SELL;
        }

        $price->volume = (string)$row->sell->volume;
        $price->average = (string)$row->sell->avg;
        $price->min = (string)$row->sell->min;
        $price->max = (string)$row->sell->max;
        $price->stdDev = (string)$row->sell->stddev;
        $price->median = (string)$row->sell->median;
        $price->percentile = (string)$row->sell->percentile;
        $return = ($price->save() && $return);

        return $return;
    }
}