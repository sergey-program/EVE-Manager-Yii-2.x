<?php

use yii\db\Migration;

class m170126_141817__user_alt extends Migration
{
    public function safeUp()
    {
        $this->addColumn('_user', 'altGroup', $this->string(255)->null()->comment('Group one user with several characters.'));

        return true;
    }

    public function safeDown()
    {
        $this->dropColumn('_user', 'altGroup');
        echo "m170126_141817__user_alt reverted.\n";

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
