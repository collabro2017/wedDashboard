<?php

namespace app\modules\couple\models\forms;

use app\modules\couple\models\Wedding;
use yii\base\Model;

class ForgotPasswordModel extends Model
{
    public $email;

    public function rules()
    {
        return [
            [['email'], 'exists'],
            [['email'], 'safe'],
            [['email'], 'email']
        ];
    }

    public function exists()
    {
        if (Wedding::find()->where(['admin_email' => $this->email])->count() == 0) {
            $this->addError('email', 'This email is not registered');
        }
    }

    public function remind()
    {
        if (!$this->validate()) {
            return false;
        }

        $wedding = Wedding::findOne(['admin_email' => $this->email]);

        \Yii::$app->mailer->compose('forgot-password', [
            'wedding' => $wedding
        ])->setTo($this->email)
                          ->setSubject('Password recovery')
                          ->setFrom(\Yii::$app->params['adminEmail'])
                          ->send();

        return true;
    }
}