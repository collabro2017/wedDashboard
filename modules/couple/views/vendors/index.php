<?php

use app\models\Vendor;
use app\modules\couple\components\widgets\AddNewButton;
use app\modules\couple\models\Wedding;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

$model             = new Vendor();
$model->wedding_id = Wedding::current()->id;

$dataProvider = new ActiveDataProvider([
    'query'      => Vendor::find()
                          ->orderBy('order asc, name asc')
                          ->where(['wedding_id' => Wedding::current()->id]),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => 'partials/item',
    'layout'       => "{items}\n{pager}",
    'options'      => ['class' => 'list-view', 'data-sort-url' => yii\helpers\Url::to(['reorder'])],
]);

echo AddNewButton::widget(['url' => '#', 'text' => 'Add new vendor']);

$form = ActiveForm::begin([
    'layout'                 => 'horizontal',
    'action'                 => 'create',
    'method'                 => 'get',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'options'                => ['class' => 'template hide'],
]);
?>
    <div class="form-group field-vendor-type required">
        <div class="col-sm-2 col-lg-1"><label class="control-label col-sm-3" for="vendor-type">Type</label></div>
        <div class="col-sm-10 col-lg-11">
            <div class="input-group static">
                <?= Html::dropDownList('type', null, [
                    'dj'           => 'DJ',
                    'photography'  => 'Photography',
                    'video'        => 'Video',
                    'centerpieces' => 'Centerpieces',
                    'general'      => 'General',

                ], [
                    'id'    => 'vendor-type',
                    'class' => 'form-control',
                ]) ?>
                <span class="input-group-btn">
                <button type="submit" class="btn btn-success pull-right">Add</button>
            </span>
            </div>
        </div>
    </div>
<?php

$form->end();
