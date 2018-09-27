<?php

use app\modules\couple\components\ActiveForm;
use app\modules\couple\components\widgets\AddNewButton;
use app\modules\couple\models\Trivia;
use app\modules\couple\models\Wedding;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$model             = new Trivia();
$model->wedding_id = Wedding::current()->id;

$types = Trivia::getAvailableTypes();

$dataProvider = new ActiveDataProvider([
    'query'      => $query,
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => 'partials/trivia',
    'layout'       => "{items}\n{pager}",
    'options'      => ['class' => 'list-view', 'data-sort-url' => yii\helpers\Url::to(['reorder'])],
]);

if (count($types)) {
    echo AddNewButton::widget(['url' => '#', 'text' => 'Add new trivia']);

    $form = ActiveForm::begin([
        'layout'                 => 'horizontal',
        'action'                 => 'create',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => false,
        'options'                => ['class' => 'template hide'],
    ]);

    echo $form->field($model, 'type', [
            'template'     => $this->render('../layouts/partials/template'),
            'inputOptions' => [
                'autofocus' => 'autofocus',
            ],
        ]
    )->dropDownList($types);

    echo $form->field($model, 'wedding_id')->hiddenInput()->label(false);

    $form->end();
}

