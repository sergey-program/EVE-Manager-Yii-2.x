<?php

use yii\db\Migration;

/**
 * Class m181202_192008_market_price_time_as_int
 */
class m181202_192008_market_price_time_as_int extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('_market_update_item', 'updated', $this->integer()->unsigned()->null());
        $this->renameColumn('_market_update_item', 'updated', 'timeUpdated');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181202_192008_market_price_time_as_int cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181202_192008_market_price_time_as_int cannot be reverted.\n";

        return false;
    }
    */
}
