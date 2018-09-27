<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider([
    'query'      => $model->getQuestions()->orderBy('order asc'),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => 'partials/question',
    'layout'       => "{items}\n{pager}",
    'options'      => [
        'class'         => 'list-view',
        'data-sort-url' => Url::to(['reorder-questions'])
    ]
]);

?>

<p id="add-new-section">
    <a href="<?= Url::to(['create-question', 'trivia' => $model->id]) ?>">
        <button class="btn circle btn-success">
            <i class="icon icon-add"></i>
        </button>
        <span>Add question</span>
    </a>
</p>
