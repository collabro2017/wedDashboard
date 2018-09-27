<?php

use app\modules\couple\components\ActiveForm;
use app\modules\couple\components\ModuleAsset;
use app\modules\couple\components\widgets\FilePreview;
use app\modules\couple\models\Participant;
use yii\helpers\Html;

$baseUrl = ModuleAsset::register($this)->baseUrl;
$form    = ActiveForm::begin([
    'options' => [
        'encType' => 'multipart/form-data',
    ],
]);

echo $form->field($model, 'fullname', [
    'inputOptions' => [
        'autofocus' => 'autofocus',
    ]
]);
echo $form->field($model, 'member')->dropDownList(Participant::members());

echo $form->field($model, 'relation_to');
echo $form->field($model, 'wedding_id')->hiddenInput()->label(false);

echo $form->field($model, 'image')->widget(FilePreview::className(), [

])
          ->label('Image (optional)');
?>

<?php
echo Html::submitButton('Save', ['class' => 'btn btn-warning btn-save']);

$form->end();
