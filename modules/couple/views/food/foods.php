<?php

use app\models\Food;
use app\modules\couple\components\widgets\AddNewButton;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider([
    'query'      => $foods,
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => 'partials/food',
    'layout'       => "{items}\n{pager}",
    'options'      => ['class' => 'list-view', 'data-sort-url' => Url::to(['reorder-food'])]
]);

echo AddNewButton::widget(['url' => '#', 'text' => 'Add Food']);

$form = ActiveForm::begin([
    'layout'                 => 'horizontal',
    'action'                 => 'create-food',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'options'                => ['class' => 'template hide'],
]);

$food                   = new Food();
$food->food_category_id = $category->id;

echo $form->field($food, 'name', [
    'template'     => $this->render('partials/template-name'),
    'inputOptions' => [
        'autofocus' => 'autofocus',
    ]
]);

echo \yii\helpers\Html::tag('br');

echo $form->field($food, 'description', [
    'template' => $this->render('partials/template-description'),
]);

echo $form->field($food, 'food_category_id')->hiddenInput()->label(false);

$form->end();
