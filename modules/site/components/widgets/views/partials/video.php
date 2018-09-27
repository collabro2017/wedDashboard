<?php
use app\modules\site\models\Media;
use yii\helpers\Url;

/**
 * @var Media $model
 */
?>

<video controls>
    <source src="<?= Url::to('@web/' . $model->content_filename) ?>" type="video/mp4">
    Your browser does not support this video.
</video>