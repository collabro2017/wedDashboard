<?php

use app\modules\couple\components\widgets\ActiveButtons;
use app\modules\couple\models\AvailableDrink;

/** @var AvailableDrink $model */

?>

<div class="well">
    <div class="row">
        <div class="col-xs-1 hidden-xs hidden-sm">
            <i class="icon icon-drag"></i>
        </div>
        <div class="col-xs-7 col-md-8 list-details">
            <h3><?= $model->title; ?></h3>
        </div>
        <div class="col-xs-5 col-md-3 active-buttons">
            <?= ActiveButtons::widget([
                'model'     => $model,
                'updateUrl' => ['update-available-drink', 'id' => $model->id]
            ]); ?>
        </div>
    </div>

    <div class="alert alert-danger hide" role="alert">
        <button type="button" class="close close-alert"><span aria-hidden="true">×</span></button>
        <h4>Are you sure?</h4>

        <p>If you remove this section, you will not return it!</p>

        <p class="text-right">
            <button type="button" class="btn btn-warning close-alert">No</button>
            <a href="<?= \yii\helpers\Url::to(['delete-available-drink', 'id' => $model->id]) ?>" class="btn btn-danger">Yes,
                                                                                                                         please!</a>
        </p>
    </div>
</div>