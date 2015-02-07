<?php

use yii\db\Schema;
use yii\db\Migration;

class m150207_000417_api_table extends Migration
{
    /**
     * @return bool
     */
    public function safeUp()
    {
        $this->createTable('api', [
            'id' => 'pk',
            'userID' => Schema::TYPE_INTEGER . ' NOT NULL',
            'keyID' => Schema::TYPE_INTEGER . ' NOT NULL',
            'vCode' => Schema::TYPE_STRING . ' NOT NULL'
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropTable('api');
        echo "m150207_000417_api_table reverted.\n";

        return true;
    }
}
