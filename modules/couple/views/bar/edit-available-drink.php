<?php

use app\modules\couple\components\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\ext\Alcohol;
use app\modules\couple\models\forms\WeddingDrinkModel;

/** @var WeddingDrinkModel $model */
/** @var ActiveForm $form */
$form  = ActiveForm::begin();
$types = Alcohol::find()->orderBy('name')->withoutBrand()->all();
$names = [];
if ($model->brandId) {
    $brandsQuery = Alcohol::find()->where(['parent_id' => $model->alcoholId]);
    $names = ArrayHelper::map($brandsQuery->all(), 'id', 'name');;
}

echo $form->field($model, 'alcoholId')->dropDownList(
    ArrayHelper::map($types, 'id', 'name'), [
    'class'  => 'form-control get-data',
    'prompt' => 'Choose drink type',
    'data'   => [
        'url'    => \yii\helpers\Url::to(['brands-of-type']),
        'target' => '#drink-brands'
    ]
]);

echo $form->field($model, 'brandId')->dropDownList($names, [
    'id'       => 'drink-brands',
    'prompt'   => 'Choose brand',
    'class'    => 'form-control toggle-disabled',
    'disabled' => true,
])->label('Brand');

echo $form->field($model, 'exclusiveBrandName')->textInput();

echo Html::submitButton('Save', ['class' => 'btn btn-warning btn-save']);

$form->end();
