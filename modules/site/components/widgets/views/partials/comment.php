<?php
/* @var $comment app\models\MediaComment */
/* @var $media app\models\Media */
?>

<div class="comment">
    <img class="img-circle" src="<?= $comment->guest->avatarUrl ?>"/>

    <p class="first-name"><?= $comment->guest->first_name ?></p>

    <p class="created-at text-small"><?= Yii::$app->formatter->asDatetime($comment->created_at) ?></p>

    <p class="comment-text"><?= $comment->body ?></p>
</div>