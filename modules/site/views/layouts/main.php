<?php

use app\modules\site\components\ModuleAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

$assets = ModuleAsset::register($this)->baseUrl;

$isSlideShow = Yii::$app->controller->action->id == 'slide-show' ? 'start-slide-show' : null;
?>

<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <?= Html::csrfMetaTags() ?>

        <title>
            <?= Yii::$app->name ?> :: Guests
        </title>
        <?php $this->head() ?>

    </head>

    <body>

    <?php $this->beginBody() ?>
    <?php

    NavBar::begin([
        'brandLabel'            => Html::img(Url::to($assets . '/images/logo.png')),
        'brandUrl'              => Yii::$app->homeUrl,
        'innerContainerOptions' => [
            'class' => 'container-fluid',
        ],
        'options'               => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items'   => [
            [
                'encode'  => false,
                'label'   =>
                    Html::tag('i', null, ['class' => 'icon icon-slide-show']) .
                    Html::tag('span', 'PHOTO SLIDE SHOW'),
                'options' => ['class' => 'uppercase ' . $isSlideShow],
                'url'     => ['slide-show'],
            ],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid">
        <div class="row">
            <?= $this->render('partials/side-bar', ['isSlideShow' => $isSlideShow]); ?>

            <div class="col-sm-9 col-md-10 content">
                <div class="header-title">
                    <a href="<?php
                    // TODO: this is really bad but I have to

                    if (Url::current() === Url::to(['default/wedding-pictures'])) {
                        echo Url::to(['default/slide-show']);
                    } else {
                        echo Url::to(['default/wedding-pictures']);
                    }

                    ?>"
                       type="button" class="btn btn-transparent grid-toggle pull-right">
                        <i class="icon icon-grid"></i>
                    </a>

                    <h2>WEDDING PICTURES</h2>
                </div>

                <div class="content-body">
                    <?= $content; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>