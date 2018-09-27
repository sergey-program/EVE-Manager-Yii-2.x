<?php

use yii\db\Migration;

/**
 * Class m180927_071951_bpo_me
 */
class m180927_071951_bpo_me extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable('_blueprint_settings', [
            'id' => $this->primaryKey(),
            'userID' => $this->integer()->null(),
            'typeID' => $this->integer()->null(),
            'me' => $this->integer()->null(),
            'te' => $this->integer()->null()
        ]);
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable('_blueprint_settings');
    }
}
