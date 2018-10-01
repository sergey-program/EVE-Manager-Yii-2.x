<?php

use yii\db\Migration;

/**
 * Class m181001_075038_me_refactor
 */
class m181001_075038_me_refactor extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('_blueprint_settings', 'meBonus');
        $this->dropColumn('_blueprint_settings', 'teBonus');
        $this->addColumn('_blueprint_settings', 'meHull', 'INTEGER DEFAULT NULL');
        $this->addColumn('_blueprint_settings', 'teHull', 'INTEGER DEFAULT NULL');

        $this->addColumn('_blueprint_settings', 'meRig', 'DECIMAL(10, 2) DEFAULT NULL');
        $this->addColumn('_blueprint_settings', 'teRig', 'DECIMAL(10, 2) DEFAULT NULL');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181001_075038_me_refactor cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181001_075038_me_refactor cannot be reverted.\n";

        return false;
    }
    */
}
