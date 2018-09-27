<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/03/15
 * Time: 21:06
 */

namespace app\modules\couple\models\forms;

use app\modules\couple\models\Wedding;
use Yii;
use yii\base\Model;

class SignInModel extends Model
{
    public $email;
    public $code;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password', 'code'], 'required'],
            [['password'], 'string', 'max' => 255],
            [['email', 'code'], 'unique']
        ];
    }

    public function authorize()
    {
        $wedding = Wedding::findOne([
            'code'           => $this->code,
            'admin_email'    => $this->email,
            'admin_password' => $this->password
        ]);

        if ($wedding) {
            return Yii::$app->user->login($wedding);
        }

        $this->addError('code', 'Incorrect wedding code or keyword');

        return false;
    }
}