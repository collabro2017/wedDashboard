<?php

use app\models\Poll;
use app\modules\couple\models\Wedding;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ListView;

$model             = new Poll();
$model->wedding_id = Wedding::current()->id;

$dataProvider = new ActiveDataProvider([
    'query'      => $query,
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

?>

<p id="add-new-section">
    <a href="<?= Url::to(['create']) ?>">
        <button class="btn circle btn-success">
            <i class="icon icon-add"></i>
        </button>
        <span>Add poll question</span>
    </a>
</p>

