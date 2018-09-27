<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14/11/2016
 * Time: 23:00
 */

namespace app\modules\api\controllers;

use app\models\ext\Guest;
use app\models\ext\Token;
use app\modules\api\components\Controller;
use Faker\Factory;
use yii\helpers\ArrayHelper;

class FeedbackController extends Controller
{
    public function actionSend()
    {
        $this->checkInputParams(function () {
            return [
                'token'    => ['hash' => Token::find()->random()->one()->hash],
                'subject'  => Factory::create()->words(5, true),
                'comments' => Factory::create()->words(5, true),
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        \Yii::$app->mailer->compose()
                          ->setTo(ArrayHelper::getValue(\Yii::$app->params, 'feedbackEmail'))
                          ->setFrom(Guest::loggedIn()->email)
                          ->setSubject($this->request->subject)
                          ->setTextBody($this->request->comments)
                          ->send();

        return [];
    }
}