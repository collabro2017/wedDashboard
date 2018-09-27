<?php

use app\modules\couple\components\widgets\ActiveButtons;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

<div class="well">
    <div class="row">
        <div class="col-xs-1 hidden-xs hidden-sm">
            <i class="icon icon-drag"></i>
        </div>
        <div class="col-xs-7 col-md-8 list-details">
            <h3>
                <a href="<?= Url::to(['foods', 'id' => strtolower($model->id)]) ?>">
                    <?= $model->name ?>
                </a>
            </h3>

            <p>
                <?=
                $model->getFoods()->count() > 0 ?
                    implode(', ', ArrayHelper::getColumn($model->foods, 'name')) :
                    'Click plus on right to add' ?>
            </p>
        </div>
        <div class="col-xs-5 col-md-3 active-buttons">
            <?= ActiveButtons::widget([
                'model'        => $model,
                'createUrl'    => ['create-food', 'category' => $model->id],
                'createButton' => !$model->getFoods()->count()
            ]); ?>
        </div>
    </div>

    <div class="alert alert-danger hide" role="alert">
        <button type="button" class="close close-alert"><span aria-hidden="true">×</span></button>
        <h4>Are you sure?</h4>

        <p>If you remove this section, you will not be able to return it back!</p>

        <p class="text-right">
            <button type="button" class="btn btn-warning close-alert">No</button>
            <a href="<?= Url::to(['delete', 'id' => $model->id]) ?>" class="btn btn-danger">Yes, please!</a>
        </p>
    </div>
</div>