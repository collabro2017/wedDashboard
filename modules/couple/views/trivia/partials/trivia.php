<?php

use app\models\ext\Trivia;
use app\modules\couple\components\widgets\ActiveButtons;
use yii\helpers\Url;

/** @var Trivia $model */
?>

<div class="well">
    <div class="row">
        <div class="col-xs-1 hidden-xs hidden-sm">
            <i class="icon icon-drag"></i>
        </div>
        <div class="col-xs-7 col-md-8 list-details">
            <h3>
                <a href="<?=

                Url::to(['questions', 'id' => $model->id]) ?>">
                    <?= $model->title ?>
                </a>
            </h3>

            <p><?= $model->hint; ?></p>
        </div>

        <div class="col-xs-5 col-md-3 active-buttons">
            <?= ActiveButtons::widget([
                'model'        => $model,
                'editButtons'  => $model->is_removable,
                'createButton' => !$model->getQuestions()->count(),
                'createUrl'    => ['create-question', 'trivia' => $model->id],
                'updateUrl'    => ['questions', 'id' => $model->id],
            ]); ?>
        </div>

    </div>

    <?php

    if ($model->is_removable) {
        echo $this->render('removing-alert', ['model' => $model]);
    }

    ?>
</div>