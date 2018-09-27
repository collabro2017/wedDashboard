<?php

use yii\bootstrap\ActiveForm;
$model = new \app\models\User();
?>
<style>
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: bold;
        width: 20%;
        text-align: right;
        margin-right: 20px;
    }

</style>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Admin: 
                    <small>Add User</small>
                </h3>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                <?php $form = ActiveForm::begin() ?>

                <h1>Edit Form</h1>
                <div>
                    <?= $form->field($model, 'first_name')->textInput(['class'=>'form-inline','style' => 'width:50%'] )->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'last_name')->textInput( ['class'=>'form-inline','style' => 'width:50%'])->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'email')->textInput(['class'=>'form-inline','style' => 'width:50%'] )->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'password')->passwordInput( ['class'=>'form-inline','style' => 'width:50%'])->label(true) ?>
                </div>
                <?= $form->field($model, 'role')->hiddenInput( ['value'=>'admin'])->label(false) ?>
                <?= $form->field($model, 'is_active')->hiddenInput( ['value'=>'1'])->label(false) ?>
                <div>
                    <button type="submit" class="btn btn-success submit"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
                </div>
                <?php ActiveForm::end() ?>
            </div>
                </div>
            </div>

        </div>
    </div>
</div>