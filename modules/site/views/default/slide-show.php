<?php
use yii\helpers\Html;

?>

<div class="row">
    <div class="photoset-grid-lightbox invisible">
        <?php

        foreach ($query->all() as $media) {

            if ($media->thumbnail) {
                echo Html::img($media->thumbnail, ['data-highres' => Yii::getAlias('@web/' . $media->content_filename . '?utm=' . crc32(uniqid()))]);
            }
        }
        ?>
    </div>
</div>