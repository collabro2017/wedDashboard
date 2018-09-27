<?php

/**
 * @var $categories array
 */

use app\modules\couple\components\widgets\AddNewButton;
use app\modules\couple\models\Wedding;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

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
    'options'      => ['class' => 'list-view', 'data-sort-url' => yii\helpers\Url::to(['reorder'])],
]);

echo AddNewButton::widget(['url' => '#', 'text' => 'Add new section']);

$form = ActiveForm::begin([
    'layout'                 => 'horizontal',
    'action'                 => 'create',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'options'                => ['class' => 'template hide'],
]);

$category             = new \app\models\ext\FoodCategory();
$category->wedding_id = Wedding::current()->id;

echo $form->field($category, 'name', [
    'template'     => $this->render('../layouts/partials/template'),
    'inputOptions' => [
        'autofocus' => 'autofocus',
    ],
]);

echo $form->field($category, 'wedding_id')->hiddenInput()->label(false);

$form->end();
