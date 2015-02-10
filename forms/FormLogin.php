<?php

namespace app\forms;

use app\components\UserIdentity;
use app\models\User;
use Yii;
use yii\base\Model;

class FormLogin extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_mUserIdentity;

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
     * @param string $sAttribute
     * @param array  $aParam
     */
    public function ruleValidatePassword($sAttribute, $aParam)
    {
        if (!$this->hasErrors()) {
            $mUserIdentity = $this->getUserIdentity();

            if (!$mUserIdentity || !$this->checkPassword($this->password, $mUserIdentity->password)) {
                $this->addError($sAttribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * @return boolean
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUserIdentity(), $this->getRememberTime());
        }

        return false;
    }

    /**
     * @return int
     */
    private function getRememberTime()
    {
        return $this->rememberMe ? 3600 * 24 * 30 : 0;
    }

    /**
     * @return User|null
     */
    public function getUserIdentity()
    {
        if (!$this->_mUserIdentity) {
            $this->_mUserIdentity = UserIdentity::findOne(['username' => $this->username]);
        }

        return $this->_mUserIdentity;
    }

    /**
     * @param string $sOriginalPassword
     * @param string $sHashedPassword
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    private function checkPassword($sOriginalPassword, $sHashedPassword)
    {
        // @todo add validation on incorrect hash exception
        return Yii::$app->getSecurity()->validatePassword($sOriginalPassword, $sHashedPassword);
    }
}
