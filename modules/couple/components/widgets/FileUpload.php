<?php

namespace app\modules\couple\components\widgets;

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Widget;

class FileUpload extends Widget
{
    public $model;
    public $attribute;
    public $action;

    public function run()
    {
        $form = ActiveForm::begin([
            'layout'                 => 'horizontal',
            'action'                 => $this->action,
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'options'                => [
                'encType' => 'multipart/form-data',
            ],
            'fieldConfig'            => [
                'template' => "{input}"
            ]
        ]);

        echo $form->field($this->model, 'id')->hiddenInput()->label(false);
        echo $form->field($this->model, $this->attribute)->widget(FilePreview::className(), ['ajaxSubmit' => true]);

        $form->end();
    }
}