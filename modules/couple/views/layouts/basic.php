<?php
use app\modules\couple\components\ModuleAsset;
use app\modules\couple\models\Wedding;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $this \yii\web\View */
/* @var $content string */

$base = ModuleAsset::register($this);

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width">
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::$app->name; ?> - <?= Inflector::camel2words(Yii::$app->controller->action->id) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel'            => Html::img($base->baseUrl . '/images/logo.png'),
            'brandUrl'              => ['default/index'],
            'options'               => [
                'class' => 'navbar-fixed-top',
            ],
            'innerContainerOptions' => ['class' => 'container-fluid']
        ]);

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items'   => [
                [
                    'label'       => 'Sign In',
                    'linkOptions' => ['class' => 'link-sign-in'],
                    'url'         => ['default/sign-in'],
                    'visible'     => Yii::$app->user->isGuest && Yii::$app->controller->action->id != 'sign-in'
                ],
                [
                    'label'   => 'Register',
                    'url'     => ['default/register'],
                    'visible' => Yii::$app->user->isGuest && Yii::$app->controller->action->id != 'register'
                ],
                [
                    'label'   => !Yii::$app->user->isGuest ? 'Hi, ' . strtoupper(Wedding::current()->title) : null,
                    'url'     => ['info/index'],
                    'visible' => !Yii::$app->user->isGuest
                ],
                [
                    'label'       => 'Logout',
                    'url'         => ['default/logout'],
                    'visible'     => !Yii::$app->user->isGuest,
                    'linkOptions' => ['class' => 'btn btn-danger', 'method' => 'post']
                ]
            ],
        ]);

        NavBar::end();
        ?>

        <div class="container-fluid">
            <div>
                <?= $content ?>
            </div>
        </div>
    </div>

    <footer class="footer">

    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>