<?php

use yii\db\Schema;
use yii\db\Migration;

class m150210_200441_base extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('api', [
            'id' => 'pk',
            'userID' => Schema::TYPE_INTEGER . ' NULL',
            'keyID' => Schema::TYPE_INTEGER . ' NOT NULL',
            'vCode' => Schema::TYPE_STRING . ' NOT NULL'
        ]);

        $this->createTable('api_account_apiKeyInfo', [
            'id' => 'pk',
            'apiID' => Schema::TYPE_INTEGER . ' NOT NULL',
            'accessMask' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type' => Schema::TYPE_STRING . ' NOT NULL',
            'expires' => Schema::TYPE_DATETIME . ' NULL'
        ]);

        $this->createTable('api_account_characters', [
            'id' => 'pk',
            'apiID' => Schema::TYPE_INTEGER . ' NOT NULL',
            'characterID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'characterName' => Schema::TYPE_STRING . ' NULL',
            'corporationID' => Schema::TYPE_BIGINT . ' NULL',
            'corporationName' => Schema::TYPE_STRING . ' NULL',
            'allianceID' => Schema::TYPE_BIGINT . ' NULL',
            'allianceName' => Schema::TYPE_STRING . ' NULL',
            'factionID' => Schema::TYPE_BIGINT . ' NULL',
            'factionName' => Schema::TYPE_STRING . ' NULL'
        ]);

        $this->createTable('api_character_marketOrders', [
            'id' => 'pk',
            'characterID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'orderID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'stationID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'volEntered' => Schema::TYPE_BIGINT . ' NOT NULL',
            'volRemaining' => Schema::TYPE_BIGINT . ' NOT NULL',
            'minVolume' => Schema::TYPE_BIGINT . ' NOT NULL',
            'orderState' => Schema::TYPE_INTEGER . ' NOT NULL',
            'typeID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'range' => Schema::TYPE_BIGINT . ' NOT NULL',
            'accountKey' => Schema::TYPE_INTEGER . ' NOT NULL',
            'duration' => Schema::TYPE_INTEGER . ' NOT NULL',
            'escrow' => Schema::TYPE_FLOAT . ' NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'bid' => Schema::TYPE_INTEGER . ' NOT NULL',
            'issued' => Schema::TYPE_DATETIME . ' NOT NULL'
        ]);

        $this->createTable('api_eve_conquerableStation', [
            'id' => 'pk',
            'stationID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'stationName' => Schema::TYPE_STRING . ' NOT NULL',
            'stationTypeID' => Schema::TYPE_BIGINT . ' NULL',
            'solarSystemID' => Schema::TYPE_BIGINT . ' NULL',
            'corporationID' => Schema::TYPE_BIGINT . ' NULL',
            'corporationName' => Schema::TYPE_STRING . ' NULL'
        ]);

        $this->createTable('api_price_item', [
            'id' => 'pk',
            'typeID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'volume' => Schema::TYPE_BIGINT . ' NOT NULL',
            'average' => Schema::TYPE_FLOAT . ' NOT NULL',
            'max' => Schema::TYPE_FLOAT . ' NOT NULL',
            'min' => Schema::TYPE_FLOAT . ' NOT NULL',
            'stdDev' => Schema::TYPE_FLOAT . ' NOT NULL',
            'median' => Schema::TYPE_FLOAT . ' NOT NULL',
            'percentile' => Schema::TYPE_FLOAT . ' NOT NULL'
        ]);

        $this->createTable('api_price_item_cron', [
            'id' => 'pk',
            'typeID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'date' => Schema::TYPE_DATETIME . ' NULL'
        ]);

        $this->createTable('market_demand', [
            'id' => 'pk',
            'useID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'characterID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'stationID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'typeID' => Schema::TYPE_BIGINT . ' NOT NULL',
            'quantity' => Schema::TYPE_BIGINT . ' NOT NULL',
            'type' => Schema::TYPE_STRING . ' NOT NULL'
        ]);
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropTable('api');
        $this->dropTable('api_account_apiKeyInfo');
        $this->dropTable('api_account_characters');
        $this->dropTable('api_character_marketOrders');
        $this->dropTable('api_eve_conquerableStation');
        $this->dropTable('api_price_item');
        $this->dropTable('api_price_item_cron');
        $this->dropTable('market_demand');

        echo "m150210_200441_base reverted.\n";

        return false;
    }
}
