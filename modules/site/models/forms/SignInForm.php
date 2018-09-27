<?php

namespace app\modules\site\models\forms;

use app\modules\site\models\Guest;
use yii\base\Model;

/**
 * Class SignInForm
 * @package app\modules\site\models\forms
 */
class SignInForm extends Model
{
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $code;

    public function rules()
    {
        return [
            [['email', 'code'], 'required'],
            [['email'], 'email'],
        ];
    }

    public function authorize()
    {
        /** @var Guest $guest */
        $guest = Guest::find()
                      ->joinWith('wedding')
                      ->where([
                          'wedding.code' => $this->code,
                          'email'        => $this->email
                      ])->one();

        if (!$guest) {
            $this->addError('email', 'Incorrect guest email or wedding not found');

            return false;
        }

        return \Yii::$app->user->login($guest->getActiveToken());
    }
}