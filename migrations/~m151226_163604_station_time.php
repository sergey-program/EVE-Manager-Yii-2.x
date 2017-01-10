<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m151226_163604_station_time
 */
class m151226_163604_station_time extends Migration
{
    /**
     * @return bool
     */
    public function safeUp()
    {
        $this->addColumn('api_eve_conquerableStation', 'timeUpdate', Schema::TYPE_BIGINT . ' NULL');

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropColumn('api_eve_conquerableStation', 'timeUpdate');

        echo "m151226_163604_station_time reverted.\n";

        return true;
    }
}
