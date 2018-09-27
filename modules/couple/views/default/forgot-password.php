<?php
use yii\bootstrap\ActiveForm;

$fieldOptions = [
    'horizontalCssClasses' => [
        'label'   => 'col-xs-5 col-md-3',
        'wrapper' => 'col-xs-7 col-md-9'
    ]
];
?>

<header class="header header-single">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Resetting password</h1>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <?php
            $form = ActiveForm::begin([
                'layout'                 => 'horizontal',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => false
            ]);

            echo $form->field($model, 'email', $fieldOptions)
                      ->textInput([
                          'autofocus' => 'autofocus'
                      ])
                      ->label('Email');

            ?>

            <div class="row">
                <div class="col-sm-5 col-sm-offset-7 text-right">
                    <button type="submit" class="btn btn-warning btn-lg btn-block">RESET PASSWORD</button>
                </div>
            </div>

            <?php
            $form->end();
            ?>
        </div>
    </div>
</div>