<?php

use yii\bootstrap\ActiveForm;
use \app\models\Wedding;

$wedding = Wedding::findOne((int)$data['id']);
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
                <h3>Weddings Id: 
                    <small><?php echo $data['code']; ?></small>
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
                    <?= $form->field($model, 'code')->textInput(['class'=>'form-inline','style' => 'width:50%','value'=>$data['code']] )->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'bride_first_name')->textInput(['class'=>'form-inline','style' => 'width:50%','value'=>$data['bride_first_name']] )->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'bride_last_name')->textInput( ['class'=>'form-inline','style' => 'width:50%','value'=>$data['bride_last_name']])->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'groom_first_name')->textInput(['class'=>'form-inline','style' => 'width:50%','value'=>$data['groom_first_name']] )->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'groom_last_name')->textInput( ['class'=>'form-inline','style' => 'width:50%','value'=>$data['groom_last_name']])->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'admin_email')->textInput( ['class'=>'form-inline','style' => 'width:50%','value'=>$data['admin_email']])->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'wedding_date')->widget(\yii\jui\DatePicker::classname(), [
                        'language' => 'en-US',
                        'dateFormat' => 'yyyy-MM-dd',
                        'value' => $data['wedding_date'],
                    ]) ?>
                </div>
                <div class="form-group field-wedding-wedding_date">
                <label class="control-label" for="wedding-wedding_date">Guest Profile</label>
                 <?php echo $wedding->getGuests()->count(); ?>&nbsp;&nbsp;<button class="btn btn-warning" ><i class="fa fa-download"></i>  Download</button>
                </div>
                <div>
                    <?= $form->field($model, 'city')->textInput( ['class'=>'form-inline','style' => 'width:50%','value'=>$data['city']])->label(true) ?>
                </div>
                <div>
                <div>
                    <?= $form->field($model, 'state')->textInput( ['class'=>'form-inline','style' => 'width:50%','value'=>$data['state']])->label(true) ?>
                </div>
                <div>
                    <?= $form->field($model, 'country')->textInput( ['class'=>'form-inline','style' => 'width:50%','value'=>$data['country']])->label(true) ?>
                </div>
                <?= $form->field($model, 'id')->hiddenInput( ['value'=>$data['id']])->label(false) ?>
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