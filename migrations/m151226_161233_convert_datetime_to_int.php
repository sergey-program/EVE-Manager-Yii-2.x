<?php

use yii\db\Schema;
use yii\db\Migration;

class m151226_161233_convert_datetime_to_int extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('api_account_apiKeyInfo', 'expires', Schema::TYPE_BIGINT . ' NULL');

        return true;

    }

    public function safeDown()
    {
        $this->alterColumn('api_account_apiKeyInfo', 'expires', Schema::TYPE_DATETIME . ' NULL');
        echo "m151226_161233_convert_datetime_to_int reverted.\n";

        return true;
    }
}
