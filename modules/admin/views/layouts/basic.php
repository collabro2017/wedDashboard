<?php

use app\modules\admin\components\ModuleAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;

/* @var $this \yii\web\View */
/* @var $content string */

$base = ModuleAsset::register($this);

$this->beginPage();

?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width">
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::$app->name; ?> - <?= Inflector::camel2words(Yii::$app->controller->action->id) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="<?= ArrayHelper::getValue($this->params, 'body-class') ?>">

    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>
    </body>
    </html>

<?php $this->endPage() ?>