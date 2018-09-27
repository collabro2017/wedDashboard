<?php

use app\modules\couple\components\widgets\ActiveButtons;
use app\modules\couple\components\widgets\FileUpload;

?>

<div class="well">
    <div class="row">
        <div class="col-xs-9 col-md-4 list-image">
            <i class="icon icon-drag hidden-xs hidden-sm"></i>

            <?php
            echo FileUpload::widget([
                'model'     => $model,
                'attribute' => 'image',
                'action'    => ['update-image']
            ]);
            ?>

        </div>

        <div class="col-xs-9 col-md-5 col-md-offset-2 list-details">
            <h3><?= $model->member ?></h3>

            <p><?php

                $attributes = [$model->fullname];
                if ($model->relation_to) {
                    $attributes[] = $model->relation_to;
                }

                echo implode(', ', $attributes) ?></p>
        </div>

        <div class="col-xs-3 active-buttons">
            <?= ActiveButtons::widget([
                'model' => $model
            ]); ?>
        </div>

    </div>

    <div class="alert alert-danger hide" role="alert">
        <button type="button" class="close close-alert"><span aria-hidden="true">×</span></button>
        <h4>Are you sure?</h4>

        <p>If you remove this section, you will not return it!</p>

        <p class="text-right">
            <button type="button" class="btn btn-warning close-alert">No</button>
            <a href="<?= \yii\helpers\Url::to(['delete', 'id' => $model->id]) ?>" class="btn btn-danger">Yes, please!</a>
        </p>
    </div>

</div>