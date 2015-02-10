<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m150210_151740_rbac
 *
 * Call before in console "php yii migrate/up --migrationPath=@yii/rbac/migrations".
 */
class m150210_151740_rbac extends Migration
{
    /**
     * Check if authManager tables were all created.
     *
     * @return bool|null|string
     */
    private function checkAuthManagerTables()
    {
        $oDB = \Yii::$app->getDb();
        $oAuthManager = \Yii::$app->getAuthManager();

        $bTableSchema = (
            $oDB->getTableSchema($oAuthManager->itemTable, true) &&
            $oDB->getTableSchema($oAuthManager->itemChildTable, true) &&
            $oDB->getTableSchema($oAuthManager->assignmentTable, true) &&
            $oDB->getTableSchema($oAuthManager->ruleTable, true)
        );

        return $bTableSchema;
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function safeUp()
    {
        if (!$this->checkAuthManagerTables()) {
            echo "You must execute 'php yii migrate/up --migrationPath=@yii/rbac/migrations' first.\n";

            return false;
        }

        $this->createTable('user', [
            'id' => 'pk',
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'password' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'authKey' => Schema::TYPE_STRING . ' NOT NULL'
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropTable('user');
        echo "m150210_151740_rbac reverted.\n";

        return true;
    }
}