<?php use app\modules\couple\models\Wedding;

$this->beginContent('@app/modules/couple/views/layouts/basic.php'); ?>

<?= $this->render('partials/nav', ['wedding' => Wedding::current()]) ?>
    <div class="content">
        <div class="header header-content">
            <button type="button" class="navbar-toggle" data-target=".nav-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php
            if (!Wedding::current()->editable) {
                echo \yii\helpers\Html::tag('span', 'READONLY', [
                    'class' => 'label label-warning pull-right',
                ]);
            }
            ?>

            <?= \yii\widgets\Breadcrumbs::widget([
                'homeLink' => false,
                'links'    => Yii::$app->controller->breadcrumbs,
            ]); ?>

        </div>
        <?= $content ?>
    </div>

<?php $this->endContent() ?>