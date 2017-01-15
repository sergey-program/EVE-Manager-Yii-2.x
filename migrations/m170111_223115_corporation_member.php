<?php

use yii\db\Migration;

class m170111_223115_corporation_member extends Migration
{
    public function safeUp()
    {
        $this->createTable('_corporation_member', [
            'id' => $this->primaryKey(),
            'characterID' => $this->integer()->unsigned()->null(),
            'characterName' => $this->string(255)->null(),
            'startDateTime' => $this->integer()->unsigned()->null(),
            'baseID' => $this->integer()->unsigned()->null(),
            'baseName' => $this->string(255)->null(),
            'title' => $this->string(255)->null(),
            'logonDateTime' => $this->integer()->unsigned()->null(),
            'logoffDateTime' => $this->integer()->unsigned()->null(),
            'locationID' => $this->integer()->unsigned()->null(),
            'locationName' => $this->string(255)->null(),
            'shipTypeID' => $this->integer()->unsigned()->null(),
            'shipTypeName' => $this->string(255)->null(),
            'roles' => $this->string(255)->null(),
            'grantableRoles' => $this->string(255)->null()
        ]);

        return true;
    }

    public function safeDown()
    {
        $this->dropTable('_corporation_member');
        echo "m170111_223115_corporation_member reverted.\n";

        return true;
    }
}
