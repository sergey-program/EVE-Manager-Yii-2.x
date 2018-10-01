<?php

use yii\db\Migration;

/**
 * Class m181001_080325_me_refactor
 */
class m181001_080325_me_refactor extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('_blueprint_settings', 'runPrice', 'INTEGER DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181001_080325_me_refactor cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181001_080325_me_refactor cannot be reverted.\n";

        return false;
    }
    */
}
