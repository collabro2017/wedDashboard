<?php

$attributes = array_merge([
    'href'  => $url,
    'class' => 'btn-add-new'
], $options);

?>

<p id="add-new-section">
    <a <?= \yii\helpers\Html::renderTagAttributes($attributes) ?>>
        <button class="btn circle btn-success">
            <i class="icon icon-add"></i>
        </button>
        <span><?= $text ?></span>
    </a>
</p>