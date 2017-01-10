<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m151226_154400_time_info_characters
 */
class m151226_154400_time_info_characters extends Migration
{
    /**
     * @return bool
     */
    public function safeUp()
    {
        $this->addColumn('api', 'timeCreated', Schema::TYPE_BIGINT . ' NULL');
        $this->addColumn('api_account_apiKeyInfo', 'timeUpdated', Schema::TYPE_BIGINT . ' NULL');
        $this->addColumn('api_account_characters', 'timeUpdated', Schema::TYPE_BIGINT . ' NULL');

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropColumn('api', 'timeCreated');
        $this->dropColumn('api_account_apiKeyInfo', 'timeUpdated');
        $this->dropColumn('api_account_characters', 'timeUpdated');

        echo "m151226_154400_time_info_characters reverted.\n";

        return true;
    }
}
