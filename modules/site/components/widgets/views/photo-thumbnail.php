<?php
use app\modules\site\models\Guest;
use app\modules\site\models\Media;
use app\modules\site\models\MediaComment;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Media $model
 * @var Guest $guest
 * @var int   $canSharing
 */
$guest    = $model->guest;
$comments = MediaComment::find()->where(['media_id' => $model->id])->all();

?>
<div class="col-sm-6 col-md-4 col-lg-3 thumbnail-block">
    <div class="thumbnail">
        <div class="toggle-comment invisible">
            <a href="#" class="btn-camera" title="Return to image">
                <i class="icon icon-thumb icon-camera"></i>
            </a>

            <div class="comments">
                <div class="comment template hide">
                    <img class="img-circle" src="<?= Yii::$app->user->identity->guest->avatarUrl ?>"/>

                    <p class="first-name"><?= Yii::$app->user->identity->guest->first_name ?></p>

                    <p class="created-at text-small"></p>

                    <p class="comment-text"></p>
                </div>

                <?php
                foreach ($comments as $comment) {
                    echo $this->render('partials/comment', [
                        'comment' => $comment,
                        'media'   => $model,
                        'guest'   => $guest,
                    ]);
                }
                ?>
            </div>

            <?php

            $form = yii\bootstrap\ActiveForm::begin([
                'action'                 => Url::to(['default/add-comment']),
                'enableClientValidation' => false,
                'enableAjaxValidation'   => false,
                'options'                => [
                    'class' => 'form form-comment',
                ],
            ]);

            ?>


            <?= $form->field($commentModel, 'media_id')->hiddenInput()->label(false) ?>
            <?= $form->field($commentModel, 'body')->textarea([
                'placeholder' => 'Leave a comment ...',
                'class'       => 'form-control',
                'required'    => true,
            ])->label(false); ?>

            <div class="caption text-center">
                <button type="submit" class="btn btn-danger">Add comment</button>
            </div>

            <?php
            $form->end();
            ?>
        </div>

        <div class="toggle-thumbnail">
            <div class="thumbnail-header">

                <div class="thumbnail-author">
                    <img class="img-circle" width="40" height="40" src="<?= $guest->avatarUrl ?>"/>
                    <span><?= $guest->getFullName(); ?></span>
                </div>

                <div class="thumbnail-choice">
                    <i class="icon icon-select icon-chosen" data-id="<?= $model->id ?>"></i>
                </div>
            </div>

            <div class="thumbnail-body">
                <?php
                if ($model->kind == 'photo') {
                    echo Html::img(Url::to($model->thumbnail), ['class'        => 'thumbnail-photo',
                                                                'data-highres' => Yii::getAlias('@web/'
                                                                                                . $model->content_filename),
                    ]);
                } else {
                    echo $this->render('partials/video', ['model' => $model]);
                }
                ?>
            </div>

            <div class="caption">
                <h4><?= $model->caption ?: '(No caption)'; ?></h4>

                <div class="text-center">
                    <button class="btn btn-primary btn-like" title="Like"
                            data-url="<?= Url::to(['default/toggle-like', 'id' => $model->id]) ?>">
                        <i class="icon icon-thumb icon-like"></i>
                        <span class="count"><?= $model->getMediaLikes()->count(); ?></span>
                    </button>

                    <a href="<?= Url::to(['default/download', 'id' => $model->id]) ?>"
                       class="btn btn-out btn-download" title="Download image">
                        <i class="icon icon-thumb icon-download"></i>
                    </a>

                    <?php
                    if ($canSharing) {
                        echo $this->render('partials/sharing', ['filename' => $model->content_filename]);
                    }
                    ?>

                    <button class="btn btn-danger btn-comment" title="View comments">
                        <i class="icon icon-thumb icon-comment"></i>
                        <span class="count"><?= $model->getMediaComments()->count(); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>