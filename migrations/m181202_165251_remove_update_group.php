<?php

use yii\db\Migration;

/**
 * Class m181202_165251_remove_update_group
 */
class m181202_165251_remove_update_group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('_market_update_group');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181202_165251_remove_update_group cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181202_165251_remove_update_group cannot be reverted.\n";

        return false;
    }
    */
}
