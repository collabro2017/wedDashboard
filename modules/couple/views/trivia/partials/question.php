<?php
use app\modules\couple\components\ModuleAsset;
use app\modules\couple\components\widgets\ActiveButtons;
use yii\helpers\Html;
use yii\helpers\Url;

$baseUrl = ModuleAsset::register($this)->baseUrl;
?>

<div class="well">
    <div class="row">
        <div class="col-xs-9 col-md-4 list-image">
            <i class="icon icon-drag hidden-xs hidden-sm"></i>

            <div class="single-image-wrap">
                <?php
                if ($model->image_filename) {
                    echo Html::img(Url::to([
                        '/' . $model->image_filename . '?utm=' . crc32(uniqid()),
                    ]), ['class' => 'single-image']);
                } else {
                    echo Html::img($baseUrl . '/images/placeholder-image.jpg', ['class' => 'single-image']);
                }
                ?>
            </div>
        </div>

        <div class="col-xs-9 col-md-5 col-md-offset-4 list-details">
            <h3><?= $model->topic ?></h3>

            <p><?= $model->answersLabel; ?></p>
        </div>

        <div class="col-xs-3 active-buttons">
            <?= ActiveButtons::widget([
                'model' => $model,
                'updateUrl' => ['update-question', 'id' => $model->id],
            ]); ?>
        </div>
    </div>

    <div class="alert alert-danger hide" role="alert">
        <button type="button" class="close close-alert"><span aria-hidden="true">×</span></button>
        <h4>Are you sure?</h4>

        <p>Selecting Yes will permanently delete this section</p>

        <p class="text-right">
            <button type="button" class="btn btn-warning close-alert">No</button>
            <a href="<?= \yii\helpers\Url::to(['delete-question', 'id' => $model->id]) ?>" class="btn btn-danger">Yes,
                                                                                                                  please!</a>
        </p>
    </div>
</div>