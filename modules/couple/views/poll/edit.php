<div>

</div>

<?php

use app\models\ext\Poll;
use app\modules\couple\components\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin();

/** @var Poll $model */
echo $form->field($model, 'topic', [
    'inputOptions' => [
        'autofocus' => 'autofocus',
    ]
]);

?>

<br/>

<?php

foreach ($options as $index => $option) {
    echo $form->field($option, 'body', [
        'inputOptions' => [
            'name' => sprintf('PollOption[%d][body]', $index)
        ]
    ])->label('Answer ' . ($index + 1));
}

echo $form->field($model, 'wedding_id')->hiddenInput()->label(false);
echo Html::submitButton('Save', ['class' => 'btn btn-warning btn-save']);

$form->end();
