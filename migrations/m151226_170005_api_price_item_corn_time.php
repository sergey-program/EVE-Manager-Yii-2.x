<?php

use yii\db\Schema;
use yii\db\Migration;

class m151226_170005_api_price_item_corn_time extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('api_price_item_cron', 'date', 'timeUpdated');
        $this->alterColumn('api_price_item_cron', 'timeUpdated', Schema::TYPE_BIGINT . ' NULL');

        return true;
    }

    public function safeDown()
    {
        $this->renameColumn('api_price_item_cron', 'timeUpdated', 'date');
        $this->alterColumn('api_price_item_cron', 'date', Schema::TYPE_DATETIME . ' NULL');

        echo "m151226_170005_api_price_item_corn_time reverted.\n";

        return true;
    }
}
