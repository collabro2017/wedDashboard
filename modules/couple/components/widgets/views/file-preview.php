<?php

use app\modules\couple\components\ModuleAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$fileAttribute = $attribute . '_filename';
$unique        = md5(uniqid());
$baseUrl       = ModuleAsset::register($this)->baseUrl;

/* @var $ajaxSubmit Boolean */

echo Html::activeFileInput($model, $attribute, [
    'class'            => $ajaxSubmit ? 'image-upload-submit' : 'image-upload',
    'data-filename'    => '#filename-item-' . $unique,
    'data-placeholder' => Url::to($baseUrl . '/images/placeholder-square.jpg'),
    'data-image'       => $model->{$fileAttribute} ?
        Url::to(['/' . $model->{$fileAttribute} . '?utm=' . crc32(uniqid())]) :
        Url::to($baseUrl . '/images/placeholder-square.jpg'),
]);

?>

<div class="hide">
    <?= Html::activeHiddenInput($model, $fileAttribute, [
        'id' => 'filename-item-' . $unique,
    ]); ?>
</div>
