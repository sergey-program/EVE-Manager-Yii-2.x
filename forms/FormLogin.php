<?php

namespace app\forms;

use app\components\UserIdentity;
use yii\base\Model;

/**
 * Class FormLogin
 *
 * @package app\forms
 */
class FormLogin extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    /**
     * @var UserIdentity
     */
    private $userIdentity;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'ruleValidatePassword']
        ];
    }

    /**
     * @param string $attribute
     * @param array  $params
     */
    public function ruleValidatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $userIdentity = $this->getUserIdentity();

            if ($userIdentity) {
                if (!\Yii::$app->security->validatePassword($this->password, $userIdentity->password)) {
                    $this->addError($attribute, 'Incorrect username or password.');
                }
            } else {
                $this->addError($attribute, 'Invalid identity.');
            }
        }
    }

    /**
     * @return boolean
     */
    public function login()
    {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getUserIdentity(), ($this->rememberMe ? 3600 * 24 * 30 : 0));
        }

        return false;
    }

    /**
     * @return UserIdentity|null
     */
    public function getUserIdentity()
    {
        if (!$this->userIdentity) {
            $this->userIdentity = UserIdentity::findOne(['username' => $this->username]);
        }

        return $this->userIdentity;
    }
}
