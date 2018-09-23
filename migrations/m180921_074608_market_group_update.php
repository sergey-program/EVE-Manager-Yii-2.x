<?php

use yii\db\Migration;

/**
 * Class m180921_074608_market_group_update
 */
class m180921_074608_market_group_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('_market_update_group', [
            'id' => $this->primaryKey(),
            'groupID' => $this->integer()->null(),
            'timeUpdate' => $this->integer()->unsigned()->null()
        ]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('_market_update_group');

        echo "m180921_074608_market_group_update is reverted.\n";

        return true;
    }
}
