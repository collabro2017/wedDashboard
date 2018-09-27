<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22/01/15
 * Time: 09:48
 */

namespace app\modules\api\controllers;

use app\models\ext\Guest;
use app\models\ext\Token;
use app\models\Media;
use app\models\MediaComment;
use app\modules\api\components\Controller;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;

/**
 * Class CommentsController
 * @package app\modules\api\controllers
 */
class CommentsController extends Controller
{
    /**
     * Adds a comment to the passed media
     *
     * @return array
     * @throws ModelException
     * @throws \yii2vm\api\components\VerboseException
     * @throws \yii\base\Exception
     */
    public function actionAdd()
    {
        $this->checkInputParams(function () {
            return [
                'token'         => ['hash' => Token::find()->random()->one()->hash],
                'media_comment' => [
                    'body'     => 'Hello!',
                    'media_id' => 1
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $comment = $this->request->media_comment->createModel('app\models\MediaComment');

        /** @noinspection PhpUndefinedFieldInspection */
        $comment->guest_id   = Guest::loggedIn()->id;
        $comment->created_at = new Expression('UTC_TIMESTAMP');

        if (!$comment->save() || !$comment->refresh()) {
            /** @var MediaComment $comment */
            throw new ModelException($comment);
        }

        return ['media_comment' => $comment];
    }

    /**
     * Gets a list of all comments for the passed media entry
     *
     * @return array
     * @throws NotFoundHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionList()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
                'media' => [
                    'id' => 1
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        /** @var Media $media */
        $media = Media::findOne($this->request->media->id);
        if (!$media) {
            throw new NotFoundHttpException('Media not found');
        }

        $comments = $media->getMediaComments()->orderBy('created_at desc')->all();

        return [
            'comments' => ActiveUtils::toArray($comments, [], function ($comment) {
                return ['guest' => $comment->guest];
            })
        ];
    }
}