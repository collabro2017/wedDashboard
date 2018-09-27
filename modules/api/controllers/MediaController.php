<?php

namespace app\modules\api\controllers;

use app\models\ext\Guest;
use app\models\ext\Media;
use app\models\ext\Token;
use app\models\MediaGuest;
use app\models\MediaLike;
use app\modules\api\components\Controller;
use yii\db\Expression;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii2vm\components\ArrayObject;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;
use yii2vm\media\upload\BinaryUpload;

/**
 * Class MediaController
 * @package app\modules\api\controllers
 */
class MediaController extends Controller
{
    /**
     * Uploads a new media
     *
     * @return array
     * @throws ModelException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionUpload()
    {
        /** @noinspection SpellCheckingInspection */
        $this->checkInputParams(function () {
            /** @noinspection SpellCheckingInspection */
            return [
                'token'     => ['hash' => Token::find()->random()->one()->hash],
                'media'     => ['kind' => 'photo'],
                'tags'      => [
                    'optional',
                    'array',
                    'value' => [
                        'tag_x'    => 1,
                        'tag_y'    => 2,
                        'guest_id' => 98
                    ]
                ],
                'content'   => 'QmFzZTY0DQoNCkJhc2U2NCBpcyBhIGdlbmVyaWMgdGVybSBmb3IgYSBudW1iZXIgb2Ygc2ltaWxhciBlbmNvZGluZyBzY2hlbWVzIHRoYXQgZW5jb2RlIGJpbmFyeSBkYXRhIGJ5IHRyZWF0aW5nIGl0IG51bWVyaWNhbGx5IGFuZCB0cmFuc2xhdGluZyBpdCBpbnRvIGEgYmFzZSA2NCByZXByZXNlbnRhdGlvbi4gVGhlIEJhc2U2NCB0ZXJtIG9yaWdpbmF0ZXMgZnJvbSBhIHNwZWNpZmljIE1JTUUgY29udGVudCB0cmFuc2ZlciBlbmNvZGluZy4NCg0KQmFzZTY0IGVuY29kaW5nIHNjaGVtZXMgYXJlIGNvbW1vbmx5IHVzZWQgd2hlbiB0aGVyZSBpcyBhIG5lZWQgdG8gZW5jb2RlIGJpbmFyeSBkYXRhIHRoYXQgbmVlZHMgYmUgc3RvcmVkIGFuZCB0cmFuc2ZlcnJlZCBvdmVyIG1lZGlhIHRoYXQgYXJlIGRlc2lnbmVkIHRvIGRlYWwgd2l0aCB0ZXh0dWFsIGRhdGEuIFRoaXMgaXMgdG8gZW5zdXJlIHRoYXQgdGhlIGRhdGEgcmVtYWlucyBpbnRhY3Qgd2l0aG91dCBtb2RpZmljYXRpb24gZHVyaW5nIHRyYW5zcG9ydC4gQmFzZTY0IGlzIHVzZWQgY29tbW9ubHkgaW4gYSBudW1iZXIgb2YgYXBwbGljYXRpb25zIGluY2x1ZGluZyBlbWFpbCB2aWEgTUlNRSwgYW5kIHN0b3JpbmcgY29tcGxleCBkYXRhIGluIFhNTC4NCg0KRGVzaWduDQoNClRoZSBwYXJ0aWN1bGFyIGNob2ljZSBvZiBjaGFyYWN0ZXJzIHRvIG1ha2UgdXAgdGhlIDY0IGNoYXJhY3RlcnMgcmVxdWlyZWQgZm9yIGJhc2UgdmFyaWVzIGJldHdlZW4gaW1wbGVtZW50YXRpb25zLiBUaGUgZ2VuZXJhbCBydWxlIGlzIHRvIGNob29zZSBhIHNldCBvZiA2NCBjaGFyYWN0ZXJzIHRoYXQgaXMgYm90aCBwYXJ0IG9mIGEgc3Vic2V0IGNvbW1vbiB0byBtb3N0IGVuY29kaW5ncywgYW5kIGFsc28gcHJpbnRhYmxlLiBUaGlzIGNvbWJpbmF0aW9uIGxlYXZlcyB0aGUgZGF0YSB1bmxpa2VseSB0byBiZSBtb2RpZmllZCBpbiB0cmFuc2l0IHRocm91Z2ggc3lzdGVtcywgc3VjaCBhcyBlbWFpbCwgd2hpY2ggd2VyZSB0cmFkaXRpb25hbGx5IG5vdCA4LWJpdCBjbGVhbi4gRm9yIGV4YW1wbGUsIE1JTUUncyBCYXNlNjQgaW1wbGVtZW50YXRpb24gdXNlcyBBLVosIGEteiwgYW5kIDAtOSBmb3IgdGhlIGZpcnN0IDYyIHZhbHVlcy4gT3RoZXIgdmFyaWF0aW9ucywgdXN1YWxseSBkZXJpdmVkIGZyb20gQmFzZTY0LCBzaGFyZSB0aGlzIHByb3BlcnR5IGJ1dCBkaWZmZXIgaW4gdGhlIHN5bWJvbHMgY2hvc2VuIGZvciB0aGUgbGFzdCB0d28gdmFsdWVzOyBhbiBleGFtcGxlIGlzIFVURi03Lg==',
                'thumbnail' => [
                    'optional',
                    'value' => 'QmFzZTY0DQoN'
                ],
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        /** @var Media $media */
        $media = $this->request->media->createModel('app\models\Media');

        /** @noinspection PhpUndefinedFieldInspection */
        $media->guest_id   = Guest::loggedIn()->id;
        $media->created_at = new Expression('UTC_TIMESTAMP');

        if (!$media->save() || !$media->refresh()) {
            throw new ModelException($media);
        }

        if ($this->request->has('tags')) {
            /** @noinspection PhpUndefinedFieldInspection */
            /** @var ArrayObject $tag */
            foreach ($this->request->tags as $tag) {
                /** @var MediaGuest $mediaGuest */
                $mediaGuest = $tag->createModel('\app\models\MediaGuest');
                $media->link('mediaGuests', $mediaGuest);
            }
        }

        /** @noinspection PhpUndefinedFieldInspection */
        BinaryUpload::createFromBase64($this->request->content)->toEntity($media, 'content_filename');;

        if ($this->request->has('thumbnail')) {
            /** @noinspection PhpUndefinedFieldInspection */
            BinaryUpload::createFromBase64($this->request->thumbnail)->toEntity($media, 'content_thumbnail');
        }

        return [
            'media' => ActiveUtils::toArray($media, [], function ($media) {
                return [
                    'tags'   => ActiveUtils::toArray($media->mediaGuests, ['guest']),
                    'author' => $media->guest,
                ];
            })
        ];
    }

    /**
     * Gets a media by id
     *
     * @return array
     * @throws NotFoundHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionGet()
    {
        $this->checkInputParams(function () {
            return [
                'token' => [
                    'hash' => Token::find()->random()->one()->hash
                ],
                'media' => [
                    'id' => Media::find()->random()->one()->id
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        /** @var Media $media */
        $media = Media::findOne($this->request->media->id);
        if (!$media) {
            throw new NotFoundHttpException('Media not found');
        }

        return [
            'media' => ActiveUtils::toArray($media, [], function ($media) {
                /** @var Media $media */
                return [
                    'tags'     => ActiveUtils::toArray($media->mediaGuests, ['guest']),
                    'author'   => $media->guest,
                    'likes'    => $media->mediaLikes,
                    'comments' => ActiveUtils::toArray($media->mediaComments, [], function ($comment) {
                        return ['guest' => $comment->guest];
                    }),
                    'is_liked' => $media->isLikedByGuest(\Yii::$app->user->id)
                ];
            })
        ];
    }

    /**
     *
     * Likes the media for the current user
     *
     * @return array
     * @throws HttpException
     * @throws ModelException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionLike()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
                'media' => [
                    'id' => Media::find()->random()->one()->id
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $exists = MediaLike::find()->where([
                'guest_id' => Guest::loggedIn()->id,
                'media_id' => $this->request->media->id
            ])->count() > 0;

        if ($exists) {
            throw new HttpException(500, 'You have already liked the media');
        }

        $like = new MediaLike();

        /** @noinspection PhpUndefinedFieldInspection */
        $like->guest_id = Guest::loggedIn()->id;

        /** @noinspection PhpUndefinedFieldInspection */
        $like->media_id = $this->request->media->id;
        $like->liked_at = new Expression('UTC_TIMESTAMP');

        if (!$like->save() || !$like->refresh()) {
            throw new ModelException($like);
        }

        /** @var Media $media */
        /** @noinspection PhpUndefinedFieldInspection */
        $media = Media::findOne($this->request->media->id);

        return [
            'media' => ActiveUtils::toArray($media, [], function ($media) {
                /** @noinspection PhpUndefinedFieldInspection */
                /** @var Media $media */
                return [
                    'likes_count' => count($media->mediaLikes),
                    'is_liked'    => $media->isLikedByGuest(Guest::loggedIn()->id)
                ];
            })
        ];
    }

    /**
     * Dislikes the media for the current user
     *
     * @return array
     * @throws HttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionDislike()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
                'media' => [
                    'id' => Media::find()->random()->one()->id
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $deleted = MediaLike::deleteAll([
            'guest_id' => Guest::loggedIn()->id,
            'media_id' => $this->request->media->id
        ]);

        if (!$deleted) {
            throw new HttpException(500, 'You never liked this media');
        }

        /** @var Media $media */
        /** @noinspection PhpUndefinedFieldInspection */
        $media = Media::findOne($this->request->media->id);

        return [
            'media' => ActiveUtils::toArray($media, [], function ($media) {
                /** @noinspection PhpUndefinedFieldInspection */
                /** @var Media $media */
                return [
                    'likes_count' => count($media->mediaLikes),
                    'is_liked'    => $media->isLikedByGuest(Guest::loggedIn()->id)
                ];
            })
        ];
    }

    /**
     * Updates the passed update
     *
     * @return array
     * @throws ModelException
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionUpdate()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
                'media' => [
                    'caption' => 'Hello!',
                    'id'      => Media::find()->random()->one()->id
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        /** @var Media $media */
        $media = Media::findOne($this->request->media->id);
        if (!$media) {
            throw new NotFoundHttpException('Media not found');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        if ($media->guest_id !== Guest::loggedIn()->id) {
            throw new UnauthorizedHttpException('You are not authorized to update the media');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $media->caption = $this->request->media->caption;

        if (!$media->save() || !$media->refresh()) {
            throw new ModelException($media);
        }

        /** @noinspection PhpUndefinedFieldInspection */

        /** @var Media $media */

        return [
            'media' => ActiveUtils::toArray($media, [], function ($media) {
                /** @var Media $media */
                /** @noinspection PhpUndefinedFieldInspection */
                return [
                    'likes'    => count($media->mediaLikes),
                    'is_liked' => $media->isLikedByGuest(Guest::loggedIn()->id)
                ];
            })
        ];
    }
}