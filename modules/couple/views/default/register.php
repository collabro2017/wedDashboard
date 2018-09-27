<?php
use app\components\AutocompleteWidget;
use app\modules\couple\components\DefaultActiveForm;

?>
<header class="header header-single">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Bride & Groom Register</h1>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>Create New Wedding</h4>

            <?php

            $form = DefaultActiveForm::begin(['layout' => 'horizontal', 'enableClientValidation' => true,]);

            echo $form->field($model, 'code')->label('Wedding ID');
            ?>
            <div class="form-group">
                <div class="col-xs-offset-5 col-md-offset-3 col-xs-7 col-md-9 register-hint">Will be used by guests
                    joining your wedding. (6-16
                    characters)
                </div>
            </div>
            <?= $form->field($model, 'bride_first_name')->label('Bride\'s First Name'); ?>
            <?= $form->field($model, 'bride_last_name')->label('Bride\'s Last Name'); ?>
            <?= $form->field($model, 'groom_first_name')->label('Groom\'s First Name'); ?>
            <?= $form->field($model, 'groom_last_name')->label('Groom\'s Last Name'); ?>

            <div class="form-group">
                <div class="col-xs-7 col-md-9 col-xs-offset-5 col-md-offset-3">
                    <?= AutocompleteWidget::widget([
                        'name' => 'location'
                    ]); ?>
                    <div class="help-block help-block-error "></div>
                </div>

            </div>


            <?= $form->field($model, 'city')->textInput([
                'class' => 'locality',
                'readonly' => 'readonly'
            ]); ?>

            <?= $form->field($model, 'state')->textInput([
                'class' => 'administrative_area_level_1',
                'readonly' => 'readonly'
            ]); ?>

            <?= $form->field($model, 'country')->textInput([
                'class' => 'country',
                'readonly' => 'readonly'
            ]); ?>

            <?= $form->field($model, 'admin_email'); ?>

            <?= $form->field($model, 'admin_password')->passwordInput(); ?>

            <?php
            /** @noinspection SpellCheckingInspection */
            echo $form->field($model, 'wedding_date', ['template' => $this->render('partials/datepicker')])
                ->textInput([
                    'class' => 'form-control datepicker',
                    'pattern' => '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])',
                ]);
            ?>

            <br/>

            <div class="row">
                <div class="col-sm-5 col-sm-offset-7">
                    <button type="submit" class="btn btn-warning btn-lg btn-block">Create Wedding Now!</button>
                </div>
            </div>

            <?php $form->end(); ?>
        </div>
    </div>
</div>

<br>

