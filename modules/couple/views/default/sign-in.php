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
                <h1>Bride & Groom sign in</h1>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php

            if (Yii::$app->session->hasFlash('password.changed')) {
                echo \yii\bootstrap\Alert::widget([
                    'options' => [
                        'class' => 'alert alert-success'
                    ],
                    'body'    => Yii::$app->session->getFlash('password.changed')
                ]);
            }

            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>Admin Login</h4>

            <?php
            $form = ActiveForm::begin([
                'layout'                 => 'horizontal',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => false
            ]);

            echo $form->field($model, 'code', $fieldOptions)->label('Wedding ID');
            echo $form->field($model, 'email', $fieldOptions)->label('Admin Email');
            echo $form->field($model, 'password', $fieldOptions)->passwordInput()->label('Admin Password');
            ?>

            <br/>

            <div class="row">
                <div class="col-sm-5">
                    <a class="btn btn-danger btn-lg btn-block" href="<?= \yii\helpers\Url::to(['forgot-password']); ?>">
                        I forgot my password
                    </a>
                </div>
                <div class="col-sm-5 col-sm-offset-2 text-right">
                    <button type="submit" class="btn btn-warning btn-lg btn-block">SIGN IN</button>
                </div>
            </div>

            <?php
            $form->end();
            ?>
        </div>
    </div>
</div>