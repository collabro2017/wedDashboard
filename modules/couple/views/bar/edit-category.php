<?php

use app\modules\couple\components\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin();

?>
    <div>
        <?php

        echo $form->field($model, 'name', [
            'inputOptions' => [
                'autofocus' => 'autofocus',
            ]
        ]);

        echo $form->field($model, 'wedding_id')->hiddenInput()->label(false);

        ?>
    </div>

<?php

echo Html::submitButton('Save', ['class' => 'btn btn-warning btn-save']);

$form->end();
