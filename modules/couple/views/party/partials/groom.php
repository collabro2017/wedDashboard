<?php
use app\modules\couple\components\ModuleAsset;
use app\modules\couple\components\widgets\FileUpload;
use app\modules\couple\models\Wedding;

$baseUrl = ModuleAsset::register($this)->baseUrl;
?>

<div class="well">
    <div class="row row-groom">
        <div class="col-xs-9 col-md-4 list-image">
            <?php

            /** @var Wedding $wedding */
            $wedding = Wedding::current();

            echo FileUpload::widget([
                'model'     => $wedding,
                'attribute' => 'groom',
                'action'    => ['update-groom']
            ]);

            ?>
        </div>

        <div class="col-xs-9 col-md-5 col-md-offset-2 list-details">
            <h3><?= $model->member ?></h3>

            <p><?= $model->fullname ?></p>
        </div>
        <div class="col-xs-3 active-buttons"></div>
    </div>
</div>