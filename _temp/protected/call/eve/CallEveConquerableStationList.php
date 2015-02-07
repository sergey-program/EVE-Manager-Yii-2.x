<?php
/**
 * Class CallEveConquerableStationList
 *
 * @todo change class name
 */
class CallEveConquerableStationList extends CallAbstract
{
    protected $sFileType = 'eve';
    protected $sFileName = 'conquerableStationList';
    private $aData = array();

    /**
     *
     */
    public function setupStorage()
    {
        // none
    }

    /**
     *
     */
    public function parseResult()
    {
        if (!$this->cCallResult->isError()) {
            $oXml = $this->cCallResult->getXmlObject();

            if (isset($oXml->result->rowset->row)) {
                foreach ($oXml->result->rowset->row as $oRow) {
                    $this->aData[] = cCallParser::getXmlAttr($oRow);
                }
            }

//            $this->show($oXml);
        }
    }

    /**
     *
     */
    public function updateResult()
    {
        if (!empty($this->aData)) {
            foreach ($this->aData as $aStation) {
                $oStation = ApiCommonConquerableStationList::model()->findByAttributes(array('stationID' => $aStation['stationID']));

                if ($oStation) {
                    $oStation->setScenario('create');
                } else {
                    $oStation = new ApiCommonConquerableStationList('create');
                }

                $oStation->attributes = array(
                    'stationID' => $aStation['stationID'],
                    'stationName' => $aStation['stationName'],
                    'stationTypeID' => $aStation['stationTypeID'],
                    'solarSystemID' => $aStation['solarSystemID'],
                    'corporationID' => $aStation['corporationID'],
                    'corporationName' => $aStation['corporationName']
                );

                if ($oStation->validate()) {
                    $oStation->save();
                }
            }
        }
    }
}