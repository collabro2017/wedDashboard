<?php

use app\modules\couple\components\ActiveForm;
use app\modules\couple\models\Wedding;
use yii\helpers\Html;

$form = ActiveForm::begin();

echo $form->field($model, 'type', [
        'inputOptions' => [
            'autofocus' => 'autofocus',
        ],
    ]
)->dropDownList([
    'bride-and-groom' => 'Bride & Groom Trivia',
    'groom'           => 'Groom Trivia',
    'bride'           => 'Bride Trivia',
    'friends'         => 'Friends Trivia',
]);

echo $form->field($model, 'wedding_id')->hiddenInput()->label(false);
echo Html::submitButton('Save', [
    'class'    => 'btn btn-warning btn-save',
    'disabled' => !Wedding::current()->editable,
]);

$form->end();
