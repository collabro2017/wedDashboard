<?php

use app\modules\couple\components\widgets\AddNewButton;
use app\modules\couple\models\Participant;
use app\modules\couple\models\Wedding;
use yii\bootstrap\ActiveForm;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

$model             = new Participant();
$model->wedding_id = Wedding::current()->id;

/** @var ActiveQuery $query */

/** @noinspection PhpUnusedParameterInspection */
echo ListView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => [
            Participant::bride(),
            Participant::groom(),
        ],
    ]),
    'itemView'     => function ($model, $key, $index, $widget) {
        $views = [
            'partials/bride',
            'partials/groom',
        ];

        return $this->render($views[$index], ['model' => $model]);
    },
    'layout'       => "{items}\n{pager}",
    'options'      => [],
]);

echo ListView::widget([
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $query,
    ]),
    'itemView'     => 'partials/item',
    'layout'       => "{items}\n{pager}",
    'options'      => ['class' => 'list-view', 'data-sort-url' => Url::to(['reorder'])],
]);

echo AddNewButton::widget(['url' => '#', 'text' => 'Add participant']);

$form = ActiveForm::begin([
    'layout'                 => 'horizontal',
    'action'                 => 'create',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'method'                 => 'get',
    'options'                => ['class' => 'template hide'],
]);
?>
    <div class="form-group field-vendor-type required">

        <div class="col-sm-2 col-lg-1"><label class="control-label col-sm-3" for="participant-member">Member</label>
        </div>
        <div class="col-sm-10 col-lg-11">
            <div class="input-group static">
                <?= Html::dropDownList('member', null, Participant::members(), [
                    'id'    => 'participant-member',
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
