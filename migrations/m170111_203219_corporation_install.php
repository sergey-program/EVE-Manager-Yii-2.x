<?php

use yii\db\Migration;

class m170111_203219_corporation_install extends Migration
{
    public function safeUp()
    {
        $this->createTable('em2_corporation', [
            'id' => $this->primaryKey(),
            'corporationID' => $this->bigInteger()->null(),
            'corporationName' => $this->string(255)->null(),
            'characterID' => $this->bigInteger()->null()->comment('ceo or director'),
            'characterName' => $this->string()->null(),
            'timeCreate' => $this->integer()->unsigned()->null()
        ]);

        $this->createTable('em2_corporation_token', [
            'id' => $this->primaryKey(),
            'corporationID' => $this->bigInteger()->notNull()->comment('AI from corporation table'),
            'tokenType'=>$this->string(255)->null(),
            'accessToken' => $this->string(255)->null(),
            'refreshToken' => $this->string(255)->null(),
            'expiresIn' => $this->integer()->null(),
            'timeUpdate' => $this->integer()->unsigned()->null(),
        ]);

        return true;
    }

    public function safeDown()
    {
        $this->dropTable('em2_corporation');
        $this->dropTable('em2_corporation_token');
        echo "m170111_203219_corporation_install reverted.\n";

        return true;
    }
}
