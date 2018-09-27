<?php

use yii\bootstrap\ActiveForm;

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
                <h3>Guest: 
                    <small><?php echo $data['first_name']." ".$data['last_name']; ?></small>
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
                    <?= $form->field($model, 'first_name')->textInput(['class'=>'form-inline','style' => 'width:50%','value'=>$data['first_name']] )->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'last_name')->textInput( ['class'=>'form-inline','style' => 'width:50%','value'=>$data['last_name']])->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'email')->textInput(['class'=>'form-inline','style' => 'width:50%','value'=>$data['email']] )->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'password')->passwordInput( ['class'=>'form-inline','style' => 'width:50%','value'=>''])->label(true) ?>
                </div>
                <?= $form->field($model, 'id')->hiddenInput( ['value'=>$data['id']])->label(false) ?>
                <?= $form->field($model, 'created_at')->hiddenInput( ['value'=>$data['created_at']])->label(false) ?>
                <?= $form->field($model, 'is_active')->hiddenInput( ['value'=>$data['is_active']])->label(false) ?>
                <?= $form->field($model, 'role')->hiddenInput( ['value'=>$data['role']])->label(false) ?>
                <?= $form->field($model, 'access_token')->hiddenInput( ['value'=>$data['access_token']])->label(false) ?>
                <div>
                    <button type="button" class="btn btn-danger submit">Delete</button>
                    <button type="submit" class="btn btn-success submit">Update</button>
                </div>
                <?php ActiveForm::end() ?>
            </div>
                </div>
            </div>

        </div>
    </div>
</div>
    