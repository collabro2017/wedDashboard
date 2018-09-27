<?php

namespace app\modules\couple\components\widgets;

use app\modules\couple\models\Wedding;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class ActiveButtons extends Widget
{
    public $model;

    public $createButton = false;
    public $editButtons  = true;
    public $createUrl    = null;
    public $updateUrl    = null;

    public function run()
    {
        return
            $this->renderAddButton() .
            $this->renderEditButton() .
            $this->renderDeleteButton();
    }

    private function renderAddButton()
    {
        if ($this->createButton) {
            return Html::a(
                Html::tag('i', '', ['class' => 'icon icon-add']),
                Url::to($this->createUrl ?: ['create']),
                [
                    'class'    => 'btn circle btn-success',
                    'disabled' => !Wedding::current()->editable,
                ]
            );
        }

        return null;
    }

    private function renderEditButton()
    {
        if ($this->editButtons) {
            return Html::a(
                Html::tag('i', '', ['class' => 'icon icon-edit']),
                Url::to($this->updateUrl ?: ['update', 'id' => $this->model->id]),
                [
                    'class'    => 'btn circle btn-warning',
                    'disabled' => !Wedding::current()->editable,
                ]);
        }

        return null;
    }

    private function renderDeleteButton()
    {
        if ($this->editButtons) {
            return Html::button(Html::tag('i', '', ['class' => 'icon icon-delete']), [
                'class'    => 'btn circle btn-danger confirm-delete',
                'disabled' => !Wedding::current()->editable,
            ]);
        }

        return null;
    }
}