<?php

class AjaxController extends AbstractController
{
    /**
     * Search stations using %LIKE% method;
     */
    public function actionFindStation()
    {
        $sql = '(SELECT sStation.stationID, sStation.stationName, sStation.stationTypeID
                    FROM dump_staStations as sStation WHERE sStation.stationName LIKE "%' . $_GET['q'] . '%")
                UNION
                (SELECT cStation.stationID, cStation.stationName, cStation.stationTypeID
                    FROM api_common_conquerableStationList as cStation WHERE cStation.stationName LIKE "%' . $_GET['q'] . '%")';

        $aReturn = Yii::app()->db->createCommand($sql)->queryAll();

        echo CJSON::encode($aReturn);
    }

    /**
     * Search item using %LIKE% method;
     */
    public function actionFindItem()
    {
        $sql = 'SELECT typeID, typeName FROM dump_invTypes
                WHERE typeName LIKE "%' . $_POST['queryString'] . '%" AND published ="1" ORDER BY typeName';

        $aReturn = Yii::app()->db->createCommand($sql)->queryAll();

        echo CJSON::encode($aReturn);
    }
}