<?php

/**
 * @var $categories array
 */

use app\models\ext\DrinkCategory;
use app\modules\couple\components\widgets\AddNewButton;
use app\modules\couple\models\Wedding;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var Wedding $wedding */
$model = Wedding::current();

$dataProvider = new ActiveDataProvider([
    'query'      => $query,
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => 'partials/category',
    'layout'       => "{items}\n{pager}",
    'options'      => ['class' => 'list-view', 'data-sort-url' => Url::to(['reorder'])]
]);

echo AddNewButton::widget(['url' => '#', 'text' => 'Add new section']);

$form = ActiveForm::begin([
    'layout'                 => 'horizontal',
    'method'                 => 'post',
    'action'                 => ['create'],
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'options'                => ['class' => 'template hide'],
]);

$category             = new DrinkCategory();
$category->wedding_id = Wedding::current()->id;

echo $form->field($category, 'name', [
    'template'     => $this->render('../layouts/partials/template'),
    'inputOptions' => [
        'autofocus' => 'autofocus',
    ]
]);

echo $form->field($category, 'wedding_id')->hiddenInput()->label(false);

$form->end();