<?php

namespace app\modules\couple\models\forms;

use app\modules\couple\models\Wedding;
use yii\base\Model;

/**
 * Class ChangePassword
 * @package app\modules\couple\models\forms
 */
class ChangePasswordModel extends Model
{
    /**
     * @var
     */
    public $oldPassword;

    /**
     * @var
     */
    public $password;
    /**
     * @var
     */
    public $passwordRepeat;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['oldPassword', 'password', 'passwordRepeat'], 'required'],
            [['passwordRepeat'], 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        /** @var Wedding $wedding */
        $wedding                 = Wedding::current();
        $wedding->admin_password = $this->password;

        return $wedding->save();
    }
}