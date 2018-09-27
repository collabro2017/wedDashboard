<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $created_at
 * @property integer $is_active
 * @property string $role
 * @property string $access_token
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'first_name', 'last_name', 'password'], 'required'],
            [['created_at'], 'safe'],
            [['is_active'], 'integer'],
            [['role'], 'string'],
            [['email', 'first_name', 'last_name', 'password'], 'string', 'max' => 255],
            [['access_token'], 'string', 'max' => 128],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'password' => Yii::t('app', 'Password'),
            'created_at' => Yii::t('app', 'Created At'),
            'is_active' => Yii::t('app', 'Is Active'),
            'role' => Yii::t('app', 'Role'),
            'access_token' => Yii::t('app', 'Access Token'),
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
