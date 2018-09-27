<?php

use app\models\PollOption;
use app\modules\couple\components\widgets\ActiveButtons;
use yii\helpers\ArrayHelper;

?>

<div class="well">
    <div class="row">
        <div class="col-xs-1 hidden-xs hidden-sm">
            <i class="icon icon-drag"></i>
        </div>
        <div class="col-xs-7 col-md-8 list-details">
            <h3><?= $model->topic ?></h3>

            <p>
                <?php

                $options = PollOption::find()
                                     ->where(['poll_id' => $model->id])
                                     ->all();

                $label = implode(', ', ArrayHelper::getColumn($options, 'body'));
                echo count($options) > 0 ? $label : 'No options yet';

                ?>
            </p>
        </div>
        <div class="col-xs-5 col-md-3 active-buttons">
            <?= ActiveButtons::widget([
                'model' => $model
            ]); ?>
        </div>
    </div>

    <div class="alert alert-danger hide" role="alert">
        <button type="button" class="close close-alert"><span aria-hidden="true">×</span></button>
        <h4>Are you sure?</h4>

        <p>If you remove this section, you will not return it!</p>

        <p class="text-right">
            <button type="button" class="btn btn-warning close-alert">No</button>
            <a href="<?= \yii\helpers\Url::to(['delete', 'id' => $model->id]) ?>" class="btn btn-danger">Yes, please!</a>
        </p>
    </div>
</div>