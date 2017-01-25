<?php

namespace app\modules\corporation\controllers;

use app\models\Corporation;
use app\models\CorporationMember;
use app\modules\corporation\controllers\extend\AbstractCorporationController;

class MemberTrackingController extends AbstractCorporationController
{
    public function actionIndex()
    {
        return $this->render('index', ['members' => CorporationMember::find()->all()]);
    }

    public function actionUpdate()
    {
        /** @var Corporation $corporation */
        $corporation = Corporation::find()->one();
        $token = $corporation->token->refreshAccessToken();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.eveonline.com/corp/MemberTracking.xml.aspx?extended=1&accessToken=' . $token->accessToken . '&accessType=corporation',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true
        ]);

        $resultString = curl_exec($curl);

        $xml = simplexml_load_string($resultString);

        $data = json_decode(json_encode($xml), true);
        $characterIDs = null;

        // @todo refactor updater, first remove all that not IN array, then update rest
        if (isset($data['result']['rowset']['row'])) {
            foreach ($data['result']['rowset']['row'] as $row) {
                $rowChar = $row['@attributes'];

                $member = CorporationMember::findOne(['characterID' => $rowChar['characterID']]);

                if (!$member) {
                    $member = new CorporationMember();
                    $member->characterID = $rowChar['characterID'];
                    $member->characterName = $rowChar['name'];
//                    $member->startDateTime = time(); // @todo datetime to int
                }

                $member->baseID = $rowChar['baseID'];
                $member->baseName = $rowChar['base'];
                $member->title = $rowChar['title'];
//                $member->logonDateTime = $rowChar['logonDateTime'];
//                $member->logoffDateTime= $rowChar['logoffDateTime'];

                $member->locationID = $rowChar['locationID'];
                $member->locationName = $rowChar['location'];
                $member->shipTypeID = $rowChar['shipTypeID'];
                $member->shipTypeName = $rowChar['shipType'];
                $member->roles = $rowChar['roles'];
                $member->grantableRoles = $rowChar['grantableRoles'];

                if ($member->save()) {
                    $characterIDs[] = $member->characterID;
                }
            }
        }

        if ($characterIDs) {
            CorporationMember::deleteAll(['not in', 'characterID', $characterIDs]);
        }

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteAll()
    {
        CorporationMember::deleteAll();

        return $this->redirect(['index']);
    }
}