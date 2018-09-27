<?php

use app\models\ext\WeddingDrink;
use app\modules\couple\components\ActiveForm;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var ActiveForm $form */
$form = ActiveForm::begin();

$types  = ActiveRecord::find()->select('type')->from('drink')->asArray()->all();
$names  = [];
$brands = [];

$drinkType  = null;
$drinkName  = null;
$drinkBrand = null;

/** @var WeddingDrink $model */

if ($model->drink) {
    $drinkType = $model->drink->type;

    $drinkName = $model->drink->name;
    $names     = ArrayHelper::map(
        ActiveRecord::find()
                    ->select(['name'])
                    ->from('drink')
                    ->where(['type' => $drinkType])
                    ->asArray()->all(), 'name', 'name');;

    $drinkBrand = $model->drink->brand;
    $brands     = ArrayHelper::map(
        Drink::find()->where(['name' => $drinkName])->all(), 'id', 'brand');
}

?>

<div class="form-group required">
    <?= Html::label('Type', null, [
        'class' => 'control-label col-xs-4 col-md-2',
    ]); ?>

    <div class="col-xs-6 col-md-4">
        <?= Html::dropDownList('type', $drinkType,
            ArrayHelper::map($types, 'type', 'type'), [
                'class'  => 'form-control get-data',
                'prompt' => 'Choose drink type',
                'data'   => [
                    'url'    => \yii\helpers\Url::to(['names-of-type']),
                    'target' => '#drink-classes',
                ],
            ]);

        ?>

        <div class="help-block help-block-error "></div>
    </div>
</div>

<div class="form-group required">
    <?= Html::label('Drink', null, [
        'class' => 'control-label col-xs-4 col-md-2',
    ]); ?>

    <div class="col-xs-6 col-md-4">
        <?= Html::dropDownList('class', $drinkName, $names, [
            'class'  => 'form-control get-data toggle-disabled',
            'id'     => 'drink-classes',
            'prompt' => 'Choose drink',
            'data'   => [
                'url'    => \yii\helpers\Url::to(['drinks-of-name']),
                'target' => '#brand-drinks',
            ],
        ]) ?>
        <div class="help-block help-block-error "></div>
    </div>
</div>

<?php

echo $form->field($model, 'drink_id')->dropDownList($brands,
    [
        'id'       => 'brand-drinks',
        'class'    => 'form-control toggle-disabled',
        'prompt'   => 'Choose brand',
        'disabled' => true,
    ])->label('Brand');

echo Html::submitButton('Save', ['class' => 'btn btn-warning btn-save']);

$form->end();
?>
