<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sendetMails".
 *
 * @property integer $id
 * @property string $email
 * @property integer $user_id
 * @property string $token
 */
class SendetMails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sendetMails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'token'], 'required'],
            [['email', 'token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'user_id' => 'User ID',
            'token' => 'Token',
        ];
    }
}
