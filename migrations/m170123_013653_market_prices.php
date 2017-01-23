<?php

use yii\db\Migration;

class m170123_013653_market_prices extends Migration
{
    public function safeUp()
    {
        $this->createTable('_market_price', [
            'typeID' => $this->bigInteger()->unsigned()->notNull(),
            'sell' => $this->decimal(15, 2)->unsigned()->defaultValue('0'),
            'buy' => $this->decimal(15, 2)->unsigned()->defaultValue('0'),
            'timeUpdate' => $this->integer()->unsigned()->null()
        ]);

        $this->createIndex('_market_price.typeID', '_market_price', 'typeID', true);

        return true;
    }

    public function safeDown()
    {
        echo "m170123_013653_market_prices cannot be reverted.\n";
        $this->dropTable('_market_price');

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
