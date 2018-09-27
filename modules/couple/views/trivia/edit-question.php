<?php

use app\models\Answer;
use app\modules\couple\components\ActiveForm;
use app\modules\couple\components\ModuleAsset;
use app\modules\couple\components\widgets\FilePreview;
use app\modules\couple\models\Wedding;
use yii\helpers\Html;

$baseUrl = ModuleAsset::register($this)->baseUrl;
$form    = ActiveForm::begin([
    'options' => [
        'encType' => 'multipart/form-data',
    ],
]);

/** @var Answer $model */
echo $form->field($model, 'topic', [
    'inputOptions' => [
        'autofocus' => 'autofocus',
    ],
]);

echo $form->field($model, 'image')
          ->widget(FilePreview::className())
          ->label('Image (optional)');
?>

    <br/>
    <br/>

<?= $form->field($correctAnswer, 'body')->label('Correct Answer'); ?>
<?= $form->field($correctAnswer, 'question_id')->hiddenInput()->label(false)->error(false) ?>

    <br/>

    <div class="form-group">
        <div class="col-xs-8 col-md-10 col-xs-offset-4 col-md-offset-2">
            Please fill in at least 1
        </div>
    </div>

<?php

foreach ($wrongAnswers as $index => $wrongAnswer) {
    echo $form->field($wrongAnswer, 'body', [
        'inputOptions' => [
            'name' => sprintf('Answer[%d][body]', $index),
        ],
    ])->label($index != 0 ? '&nbsp;' : 'Wrong answers', ['class' => 'label-counter control-label col-xs-4 col-md-2']);
}

echo $form->field($model, 'trivia_id')->hiddenInput()->label(false);
echo Html::submitButton('Save', [
    'class'    => 'btn btn-warning btn-save',
    'disabled' => !Wedding::current()->editable,
]);

$form->end();
