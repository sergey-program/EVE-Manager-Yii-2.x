<?php

use yii\db\Migration;

/**
 * Class m180928_084137_bpo_bonus_column
 */
class m180928_084137_bpo_bonus_column extends Migration
{
    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->addColumn('_blueprint_settings', 'meBonus', 'INTEGER DEFAULT NULL');
        $this->addColumn('_blueprint_settings', 'teBonus', 'INTEGER DEFAULT NULL');
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropColumn('_blueprint_settings', 'meBonus');
        $this->dropColumn('_blueprint_settings', 'teBonus');
    }
}
