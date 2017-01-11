<?php

namespace app\components;

use yii\base\InvalidParamException;

/**
 * Class EveSSO
 * Creates url links for SSO.
 * Detects what action we should do after code received.
 *
 * @package app\components
 */
class EveSSO
{
    const VN = 'action'; // variable name
    // actions
    const ACTION_SI = 'sign-in'; // sign in
    const ACTION_IC = 'install-corporation'; // install corporation

    /**
     * Use self::ACTION_SIGN_IN as argument.
     *
     * @param string $action
     *
     * @return bool
     */
    public static function isAction($action)
    {
        return (\Yii::$app->request->get(self::VN) == $action);
    }

    /**
     * @param string $action
     *
     * @return string
     */
    public static function createUrl($action)
    {
        $clientID = \Yii::$app->params['application']['clientID'];
        $url = 'https://login.eveonline.com/oauth/authorize/?client_id=' . $clientID . '&response_type=code&state=uniquestate123';

        if ($action == self::ACTION_SI) {
            $scopes = [
                'characterAssetsRead',
                'characterChatChannelsRead',
                'characterContactsRead',
                'characterLocationRead',
                'characterMailRead',
                'characterMarketOrdersRead',
                'characterNotificationsRead',
                'characterSkillsRead',
                'characterWalletRead'
            ];

            $url .= '&redirect_uri=http://eve-manager/callback-url?' . self::VN . '=' . self::ACTION_SI;
            $url .= '&scope=' . implode('%20', $scopes);

            return $url;
        }

        if ($action == self::ACTION_IC) {
            $scopes = [
                'corporationAssetsRead',
                'corporationContactsRead',
                'corporationKillsRead',
                'corporationMembersRead',
                'corporationStructuresRead',
                'corporationWalletRead'
            ];

            $url .= '&redirect_uri=http://eve-manager/callback-url?' . self::VN . '=' . self::ACTION_IC;
            $url .= '&scope=' . implode('%20', $scopes);

            return $url;
        }

        throw new InvalidParamException('Unknown action. Cannot create url by action name "' . $action . '".');
    }

//    public static function getScopes()
//    {
//        return [
//            'characterAccountRead', 'characterAssetsRead', 'characterBookmarksRead',
//            'characterCalendarRead', 'characterChatChannelsRead', 'characterClonesRead', 'characterContactsRead',
//            'characterContactsWrite', 'characterContractsRead', 'characterFactionalWarfareRead',
//            'characterFittingsRead', 'characterFittingsWrite', 'characterIndustryJobsRead', 'characterKillsRead',
//            'characterLocationRead', 'characterLoyaltyPointsRead', 'characterMailRead', 'characterMarketOrdersRead',
//            'characterMedalsRead', 'characterNavigationWrite', 'characterNotificationsRead',
//            'characterOpportunitiesRead', 'characterResearchRead', 'characterSkillsRead', 'characterStatsRead',
//            'characterWalletRead', 'corporationAssetsRead', 'corporationBookmarksRead', 'corporationContactsRead',
//            'corporationContractsRead', 'corporationFactionalWarfareRead', 'corporationIndustryJobsRead',
//            'corporationKillsRead', 'corporationMarketOrdersRead', 'corporationMedalsRead',
//            'corporationMembersRead', 'corporationShareholdersRead', 'corporationStructuresRead',
//            'corporationWalletRead', 'fleetRead', 'fleetWrite', 'publicData', 'remoteClientUI', 'structureVulnUp'];
//    }
}