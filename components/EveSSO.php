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

        $callbackUrl = \Yii::$app->params['application']['callbackUrl'];

        if ($action == self::ACTION_SI) {
//            $scopes = [
//                'characterAssetsRead',
//                'characterChatChannelsRead',
//                'characterContactsRead',
//                'characterLocationRead',
//                'characterMailRead',
//                'characterMarketOrdersRead',
//                'characterNotificationsRead',
//                'characterSkillsRead',
//                'characterWalletRead',
//                'esi-assets.read_assets.v1',
//                'esi-wallet.read_character_wallet.v1',
//            ];

            // copied from api client description, should be exact
            $scopes = 'publicData esi-calendar.respond_calendar_events.v1 esi-calendar.read_calendar_events.v1 esi-location.read_location.v1 esi-location.read_ship_type.v1 esi-mail.organize_mail.v1 esi-mail.read_mail.v1 esi-mail.send_mail.v1 esi-skills.read_skills.v1 esi-skills.read_skillqueue.v1 esi-wallet.read_character_wallet.v1 esi-wallet.read_corporation_wallet.v1 esi-search.search_structures.v1 esi-clones.read_clones.v1 esi-characters.read_contacts.v1 esi-universe.read_structures.v1 esi-bookmarks.read_character_bookmarks.v1 esi-killmails.read_killmails.v1 esi-corporations.read_corporation_membership.v1 esi-assets.read_assets.v1 esi-planets.manage_planets.v1 esi-fleets.read_fleet.v1 esi-fleets.write_fleet.v1 esi-ui.open_window.v1 esi-ui.write_waypoint.v1 esi-characters.write_contacts.v1 esi-fittings.read_fittings.v1 esi-fittings.write_fittings.v1 esi-markets.structure_markets.v1 esi-corporations.read_structures.v1 esi-corporations.write_structures.v1 esi-characters.read_loyalty.v1 esi-characters.read_opportunities.v1 esi-characters.read_chat_channels.v1 esi-characters.read_medals.v1 esi-characters.read_standings.v1 esi-characters.read_agents_research.v1 esi-industry.read_character_jobs.v1 esi-markets.read_character_orders.v1 esi-characters.read_blueprints.v1 esi-characters.read_corporation_roles.v1 esi-location.read_online.v1 esi-contracts.read_character_contracts.v1 esi-clones.read_implants.v1 esi-characters.read_fatigue.v1 esi-killmails.read_corporation_killmails.v1 esi-corporations.track_members.v1 esi-wallet.read_corporation_wallets.v1 esi-characters.read_notifications.v1 esi-corporations.read_divisions.v1 esi-corporations.read_contacts.v1 esi-assets.read_corporation_assets.v1 esi-corporations.read_titles.v1 esi-corporations.read_blueprints.v1 esi-bookmarks.read_corporation_bookmarks.v1 esi-contracts.read_corporation_contracts.v1 esi-corporations.read_standings.v1 esi-corporations.read_starbases.v1 esi-industry.read_corporation_jobs.v1 esi-markets.read_corporation_orders.v1 esi-corporations.read_container_logs.v1 esi-industry.read_character_mining.v1 esi-industry.read_corporation_mining.v1 esi-planets.read_customs_offices.v1 esi-corporations.read_facilities.v1 esi-corporations.read_medals.v1 esi-characters.read_titles.v1 esi-alliances.read_contacts.v1 esi-characters.read_fw_stats.v1 esi-corporations.read_fw_stats.v1 esi-corporations.read_outposts.v1 esi-characterstats.read.v1';
            $scopes = explode(' ', $scopes);

            $url .= '&redirect_uri=' . $callbackUrl . '?' . self::VN . '=' . self::ACTION_SI;
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

            $url .= '&redirect_uri=' . $callbackUrl . '?' . self::VN . '=' . self::ACTION_IC;
            $url .= '&scope=' . implode('%20', $scopes);

            return $url;
        }

        throw new InvalidParamException('Unknown action. Cannot create url by action name "' . $action . '".');
    }
}