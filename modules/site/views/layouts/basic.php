<?php

use app\modules\site\components\ModuleAsset;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

$assets = ModuleAsset::register($this)->baseUrl;

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
        'brandUrl'              => ['/site/default/index'],
        'innerContainerOptions' => [
            'class' => 'container-fluid',
        ],
        'options'               => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    NavBar::end();
    ?>

    <div class="container-fluid">
        <div class="row">
            <?= $content; ?>
        </div>
    </div>
    <!-- /.container -->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>