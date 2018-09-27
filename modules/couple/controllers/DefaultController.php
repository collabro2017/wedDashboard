<?php
namespace app\modules\couple\controllers;

use app\modules\couple\models\forms\ForgotPasswordModel;
use app\modules\couple\models\forms\SignInModel;
use app\modules\couple\models\Wedding;
use Faker\Factory;
use Yii;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package app\modules\couple\controllers
 */
class DefaultController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'basic';

    /**
     *
     */
    public function actionIndex()
    {
        $this->redirect(['sign-in']);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSignIn()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['info/index']);
        }

        $signIn = new SignInModel();
        if (YII_DEBUG) {
            $signIn->email    = 'admin@wedo.com';
            $signIn->password = 'admin';
            $signIn->code     = 'abcdef';
        }

        if ($signIn->load(\Yii::$app->request->bodyParams) && $signIn->authorize()) {
            return $this->redirect(['info/index']);
        }

        return $this->render('sign-in', [
            'model' => $signIn,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii2vm\components\ModelException
     */
    public function actionRegister()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['info/index']);
        }

        $register          = new Wedding();
        $register->country = 'Canada';

        if (YII_DEBUG) {
            $faker = Factory::create();

            $register->code             = strtoupper($faker->word);
            $register->bride_first_name = $faker->firstNameFemale;
            $register->bride_last_name  = $faker->lastName;
            $register->groom_first_name = $faker->firstNameMale;
            $register->groom_last_name  = $faker->lastName;

            $register->admin_email    = $faker->email;
            $register->admin_password = $faker->password;
            $register->wedding_date   = $faker->dateTimeBetween('now', '+2 years')->format('Y-m-d');
        }

        if ($register->load(Yii::$app->request->post()) && $register->validate() && $register->create()) {

            \Yii::$app->mailer->compose('registration', [
                'wedding' => $register,
            ])->setTo($register->admin_email)
                              ->setSubject('Get Started with WeDo')
                              ->setFrom(\Yii::$app->params['adminEmail'])
                              ->send();

            return $this->redirect(['info/index']);
        }

        return $this->render('register', [
            'model' => $register,
        ]);
    }

    public function actionForgotPassword()
    {
        $model = new ForgotPasswordModel();
        if ($model->load(Yii::$app->request->post()) && $model->remind()) {
            Yii::$app->session->setFlash('password.changed', 'Password has been sent');

            return $this->redirect(['sign-in']);
        }

        return $this->render('forgot-password', [
            'model' => $model,
        ]);
    }

    /**
     *
     */
    public function actionError()
    {
        return $this->render('error', [
            'exception' => \Yii::$app->errorHandler->exception,
        ]);
    }

    /**
     *
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        $this->redirect(\Yii::$app->user->loginUrl);
    }
}