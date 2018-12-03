<?php

use yii\db\Migration;

/**
 * Class m181202_195508_rename_table
 */
class m181202_195508_rename_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('_market_update_item','_market_price_schedule');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181202_195508_rename_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181202_195508_rename_table cannot be reverted.\n";

        return false;
    }
    */
}
