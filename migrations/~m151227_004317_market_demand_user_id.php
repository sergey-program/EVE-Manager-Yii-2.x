<?php

use yii\db\Schema;
use yii\db\Migration;

class m151227_004317_market_demand_user_id extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('market_demand', 'useID', 'userID');

        return true;
    }

    public function safeDown()
    {
        $this->renameColumn('market_demand', 'userID', 'useID');

        echo "m151227_004317_market_demand_user_id reverted.\n";

        return true;
    }
}
