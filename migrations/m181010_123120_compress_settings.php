<?php

use yii\db\Migration;

/**
 * Class m181010_123120_compress_settings
 */
class m181010_123120_compress_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('_compress_settings', [
            'id' => $this->primaryKey(),
            'userID' => $this->integer()->null(),
            'order' => $this->integer()->defaultValue('0')->null(),
            'mineralTypeID' => $this->integer()->null(),
            'oreTypeID' => $this->integer()->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181010_123120_compress_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181010_123120_compress_settings cannot be reverted.\n";

        return false;
    }
    */
}
