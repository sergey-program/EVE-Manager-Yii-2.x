<?php

namespace app\commands;

use yii\console\Controller;

/**
 * Class RbacController
 *
 * @package app\commands
 */
class RbacController extends Controller
{
    /**
     * Create default roles for site.
     */
    public function actionInit()
    {
        $am = \Yii::$app->authManager;
        $am->removeAll();

        // role user
        $roleUser = $am->createRole('user');
        $roleUser->description = 'Registered user.';
        $am->add($roleUser);

        $roleDirector = $am->createRole('director');
        $roleDirector->description = 'Registered director.';
        $am->add($roleDirector);

        $roleAdmin = $am->createRole('admin');
        $roleAdmin->description = 'Administrator.';
        $am->add($roleAdmin);
    }
}