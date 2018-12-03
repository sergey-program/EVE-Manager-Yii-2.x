<?php

use yii\db\Migration;

/**
 * Class m181202_162712_market_update_item
 */
class m181202_162712_market_update_item extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('_market_update_item', [
            'id' => $this->primaryKey(),
            'typeID' => $this->integer()->unsigned(),
            'updated' => $this->dateTime()->null()
        ]);
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropTable('_market_update_item');
        return true;
    }
}
