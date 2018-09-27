<?php

use app\models\Country;
use app\modules\couple\components\ActiveForm;
use app\modules\couple\components\ModuleAsset;
use app\modules\couple\components\widgets\FilePreview;
use app\modules\couple\models\forms\ChangePasswordModel;
use app\modules\couple\models\Wedding;
use dosamigos\selectize\SelectizeDropDownList;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\AutocompleteWidget;

/** @var Wedding $model */
/** @var string $baseUrl */
$baseUrl = ModuleAsset::register($this)->baseUrl;

$checkboxOptions = [
    'template' => $this->render('partials/checkbox'),
];

$form = ActiveForm::begin([
    'layout'                 => 'horizontal',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'options'                => [
        'encType' => 'multipart/form-data',
    ],
]);

$alert = Yii::$app->session->getFlash('clear-data');
if ($alert) {
    echo Alert::widget([
        'options'     => [
            'class' => 'alert-success',
        ],
        'closeButton' => [],
        'body'        => $alert,
    ]);
}

?>
<h4>General Settings</h4>
<div>

    <div class="form-group">
        <label class="control-label col-xs-4 col-md-2" for="">Wedding ID</label>

        <div class="col-xs-6 col-md-4">
            <p><?= $model->code ?></p>

            <div class="help-block help-block-error "></div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4 col-md-2" for="">Wedding Date</label>

        <div class="col-xs-6 col-md-4">
            <p><?= Yii::$app->formatter->asDate($model->wedding_date, 'long') ?></p>

            <div class="help-block help-block-error "></div>
        </div>
    </div>

    <?php
    echo $form->field($model, 'bride_first_name');
    echo $form->field($model, 'bride_last_name');
    echo $form->field($model, 'groom_first_name');
    echo $form->field($model, 'groom_last_name');

    echo $form->field($model, 'welcome')
              ->widget(FilePreview::className())
              ->label('Welcome Screen Picture');
    ?>

</div>

<h4>Location</h4>
<div>

    <div class="form-group">
        <div class="col-xs-5 col-md-4 col-xs-offset-4 col-md-offset-2">
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

</div>

<h4>Password Settings</h4>
<div>
    <?= $form->field($model, 'admin_email'); ?>
</div>
<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#change-password-modal">
        Change password
    </button>
</div>
<br/>

<h4>Social Sharing Settings</h4>
<div>
    <?= $form
        ->field($model, 'enable_sharing', $checkboxOptions)
        ->checkbox(['class' => 'checkbox-custom'], false)
        ->label('Enable social picture sharing', ['class' => 'control-label col-xs-5 col-md-3']);
    ?>
</div>

<h4>Clear User Data</h4>
<div>
    <div class="alert alert-danger hide" role="alert">
        <button type="button" class="close close-alert"><span aria-hidden="true">×</span></button>
        <h4>Are you sure?</h4>

        <p>This will delete all user data for testing purposes</p>

        <p class="text-right">
            <button type="button" class="btn btn-warning close-alert">No</button>
            <a href="<?= Url::to(['clear-data']) ?>" class="btn btn-danger">Yes, please!</a>
        </p>
    </div>

    This option will clear all user data allowing you to preview & test your wedding app before your big day.
    &emsp;
    &emsp;
    <?= Html::button('Clear', [
        'class'    => 'btn btn-danger confirm-delete',
        'disabled' => !Wedding::current()->editable,
    ]); ?>

</div>
<?php

echo Html::submitButton('Save', [
    'class'    => 'btn btn-warning btn-save',
    'disabled' => !Wedding::current()->editable,
]);

$form->end();
?>

<div class="modal fade" id="change-password-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change password</h4>
            </div>
            <div class="modal-body">
                <?php

                $model = new ChangePasswordModel;

                $form = \yii\bootstrap\ActiveForm::begin([
                    'layout'                 => 'horizontal',
                    'enableClientValidation' => false,
                    'enableAjaxValidation'   => true,
                    'action'                 => ['change-password'],
                ]);

                echo $form->field($model, 'oldPassword')->passwordInput([
                    'autofocus' => 'autofocus',
                ]);

                echo $form->field($model, 'password')->passwordInput();
                echo $form->field($model, 'passwordRepeat')->passwordInput();

                $form->end();

                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Change</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->