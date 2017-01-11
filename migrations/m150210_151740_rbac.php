<?php

use yii\db\Migration;

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
        $db = \Yii::$app->db;
        $am = \Yii::$app->authManager;

        return (
            $db->getTableSchema($am->itemTable, true) &&
            $db->getTableSchema($am->itemChildTable, true) &&
            $db->getTableSchema($am->assignmentTable, true) &&
            $db->getTableSchema($am->ruleTable, true)
        );
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

        $this->createTable('em2_user', [
            'id' => $this->primaryKey(),
            'characterName' => $this->string(255)->null()->comment('Character Name'),
            'characterID' => $this->bigInteger()->unsigned()->null()->comment('Character ID'),
            'authKey' => $this->string(255)->notNull(),
            'timeCreate' => $this->integer()->unsigned()->null()
        ]);

        $this->createTable('em2_user_token', [
            'id' => $this->primaryKey(),
            'userID' => $this->integer()->unsigned()->notNull(),
            'accessToken' => $this->string(255)->null(),
            'tokenType' => $this->string(255)->null(),
            'expiresIn' => $this->integer()->null(),
            'refreshToken' => $this->string(255)->null(),
            'timeUpdate' => $this->integer()->unsigned()->null()->comment('When token was updated last time')
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropTable('em2_user');
        $this->dropTable('em2_user_token');
        echo "m150210_151740_rbac reverted.\n";

        return true;
    }
}