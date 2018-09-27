<?php

namespace app\modules\site;

use app\models\ext\Wedding;
use app\modules\site\models\Token;
use yii\base\Module;
use yii\web\User;

/**
 * Class SiteModule
 * @package app\modules\site
 */
class SiteModule extends Module
{
    /**
     * @var string
     */
    public $controllerNamespace = 'app\modules\site\controllers';

    /**
     *
     */
    public function init()
    {
        parent::init();

        \Yii::$app->components = [
            'user'    => [
                'class'           => User::className(),
                'identityClass'   => Token::className(),
                'idParam'         => 'wedo\site',
                'enableAutoLogin' => true,
                'loginUrl'        => ['/site/default/sign-in'],
                'identityCookie'  => ['name' => 'site', 'httpOnly' => true],
            ],
            'wedding' => [
                'class' => Wedding::className(),
            ],
        ];

        \Yii::$app->homeUrl = ['wedding-pictures'];
    }
}
