<?php
use app\modules\site\components\widgets\PhotoThumbnail;
use yii\db\ActiveQuery;
use yii\helpers\Html;

?>

<div class="header">
    <h3>
        <?php

        $guest = Yii::$app->user->identity->guest;

        echo Html::img($guest->avatarUrl, ['class' => 'img-circle']);
        echo $guest->fullName . '\'s Photos';

        ?>
    </h3>
</div>

<div class="row">
    <?php

    /** @var ActiveQuery $query */
    foreach ($query->all() as $media) {
        echo PhotoThumbnail::widget(['media' => $media]);
    }

    ?>
</div>
