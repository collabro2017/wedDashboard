<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14/11/2016
 * Time: 23:17
 */

namespace app\modules\admin\models;

use yii\base\Model;

/**
 * Class SignInModel
 * @package app\modules\admin\models
 */
class SignInModel extends Model
{
    /**
     * @var
     */
    public $email;

    /**
     * @var
     */
    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'trim'],
            [['email', 'password'], 'required'],
            ['email', 'email'],
            [
                'email',
                function () {
                    if (!User::find()->andWhere(['email' => $this->email])->active()->exists()) {
                        $this->addError('email', 'Invalid email or password');
                    }
                },
            ],
        ];
    }

    /**
     * @return bool
     */
    public function signIn()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = User::findOne(['email' => $this->email]);

        if (!\Yii::$app->security->validatePassword($this->password, $user->password)) {
            $this->addError('email', 'Invalid email or password');

            return null;
        }

        $user->access_token = \Yii::$app->security->generateRandomString();

        return $user->save() && \Yii::$app->user->login($user);
    }
}