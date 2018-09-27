<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider([
    'query'      => $query,
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => 'partials/drink',
    'layout'       => "{items}\n{pager}",
    'options'      => ['class' => 'list-view', 'data-sort-url' => yii\helpers\Url::to(['reorder-drinks'])]
]);

?>

<p id="add-new-section">
    <a href="<?= Url::to(['create-drink', 'category' => $category->id]) ?>">
        <button class="btn circle btn-success">
            <i class="icon icon-add"></i>
        </button>
        <span>Add drink</span>
    </a>
</p>
