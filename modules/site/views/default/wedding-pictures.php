<div class="row">
    <?php

    /** @var ActiveQuery $query */
    use app\modules\site\components\widgets\PhotoThumbnail;
    use yii\db\ActiveQuery;

    foreach ($query->all() as $media) {
        echo PhotoThumbnail::widget(['media' => $media, 'canSharing' => $canSharing]);
    }

    ?>
</div>