<?php

class ApiAccountApiKeyInfo extends AbstractModel
{
    public $id;
    public $apiID;
    public $accessMask;
    public $type;
    public $expires;

    /**
     * @param string $sClass
     *
     * @return CActiveRecord
     */
    public static function model($sClass = __CLASS__)
    {
        return parent::model($sClass);
    }

    /**
     * @return string
     */
    public function tableName()
    {
        return 'api_account_apiKeyInfo';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            // create
            array('apiID, accessMask, type', 'required', 'on' => 'create'),
            array('expires', 'safe', 'on' => 'create')
        );
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'oApi' => array(self::BELONGS_TO, 'Api', 'apiID')
        );
    }
}