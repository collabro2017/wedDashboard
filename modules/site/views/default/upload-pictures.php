<h3>Upload Pictures</h3>

<div class="wrap-upload-photos">
    <div class="strip strip-ver"></div>
    <div class="strip strip-hor"></div>
    <div class="upload-photos">
        <?php

        use yii\bootstrap\ActiveForm;
        use yii\helpers\Html;
        use yii\helpers\Url;

        $model           = new \app\modules\site\models\Media();
        $model->guest_id = Yii::$app->user->identity->guest_id;
        $model->kind     = 'photo';

        $form = ActiveForm::begin([
            'action'  => ['upload'],
            'options' => [
                'id'          => 'weddingPhotos',
                'class'       => 'form-dropzone',
                'enctype'     => 'multipart/form-data',
                'data-remove' => Url::to(['remove-picture'])
            ]
        ]);

        echo $form->field($model, 'guest_id')->hiddenInput()->label(false);

        ?>

        <div class="fallback">
            <input type="file" name="<?= Html::getInputName($model, 'image') ?>" multiple accept="image/*"/>
        </div>

        <div class="dz-message">
            <p>Drop files here</p>

            <p class="text-big">or</p>
            <button type="button" class="btn btn-default">Select Files</button>
        </div>

        <?php $form->end(); ?>
    </div>
</div>