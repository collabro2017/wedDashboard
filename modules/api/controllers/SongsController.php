<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 06/12/14
 * Time: 05:51
 */

namespace app\modules\api\controllers;

use app\models\ext\Guest;
use app\models\ext\Token;
use app\models\ext\Wedding;
use app\models\PartySummary;
use app\models\Song;
use app\models\SongLike;
use app\models\SongSummary;
use app\modules\api\components\Controller;
use yii\db\Expression;
use yii\web\HttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;

/**
 * Class SongsController
 * @package app\modules\api\controllers
 */
class SongsController extends Controller
{

    /**
     * Gets the summary for songs and votes
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionSummary()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /**
         * @var Guest
         */
        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::loggedIn();

        /** @noinspection PhpUndefinedFieldInspection */

        return [
            'summary' => [
                'songs' => SongSummary::find()
                                      ->where(['wedding_id' => $guest->wedding_id])
                                      ->count(),
                'likes' => SongSummary::find()
                                      ->where(['wedding_id' => $guest->wedding_id])
                                      ->sum('likes'),
            ],
        ];
    }

    /**
     * Returns a list of party table
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionPartyTables()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /**
         * @var Guest
         */
        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::loggedIn();

        /** @noinspection PhpUndefinedFieldInspection */
        $summaries = PartySummary::find()
                                 ->where(['wedding_id' => $guest->wedding_id])
                                 ->orderBy('songs desc')
                                 ->all();

        return [
            'summary' => ActiveUtils::toArray($summaries, [], function ($summary) use ($guest) {
                /** @noinspection PhpUndefinedFieldInspection */
                return [
                    'guests' =>
                        Guest::find()
                             ->where([
                                 'wedding_id' => $guest->wedding_id,
                                 'table'      => $summary->table,
                             ])
                             ->select(['id', 'table', 'first_name', 'last_name'])
                             ->all(),
                ];
            }),
        ];
    }

    /**
     * Creates a request for a song
     * @return array
     * @throws HttpException
     * @throws ModelException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionRequest()
    {
        $this->checkInputParams(function () {
            /** @noinspection SpellCheckingInspection */
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
                'song'  => [
                    'title'     => 'I believe in love',
                    'artist'    => 'Elton John',
                    'cover_url' => 'http://userserve-ak.last.fm/serve/300x300/87434825.png',
                ],
            ];
        });

        /** @var Wedding $wedding */
        $wedding = Guest::loggedIn()->wedding;

        /** @noinspection PhpUndefinedFieldInspection */
        $exists = Song::find()->joinWith('guest')
                      ->where([
                          'title'            => $this->request->song->title,
                          'artist'           => $this->request->song->artist,
                          'guest.wedding_id' => $wedding->id,
                      ])
                      ->count() > 0;

        if ($exists) {
            throw new HttpException(500, 'This song is already requested');
        }

        /** @var Song $song */
        /** @noinspection PhpUndefinedFieldInspection */
        $song = $this->request->song->createModel('app\models\Song');

        /** @noinspection PhpUndefinedFieldInspection */
        $song->guest_id     = Guest::loggedIn()->id;
        $song->requested_at = new Expression('UTC_TIMESTAMP');

        if (!$song->save() || !$song->refresh()) {
            throw new ModelException($song);
        }

        return ['song' => $song];
    }

    /**
     * Likes a song
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
                'song'  => [
                    'id' => 39,
                ],
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $exists = SongLike::find()->where([
                'guest_id' => Guest::loggedIn()->id,
                'song_id'  => $this->request->song->id,
            ])->count() > 0;

        if ($exists) {
            throw new HttpException(500, 'You have already liked the song');
        }

        $like = new SongLike();

        /** @noinspection PhpUndefinedFieldInspection */
        $like->guest_id = Guest::loggedIn()->id;

        /** @noinspection PhpUndefinedFieldInspection */
        $like->song_id  = $this->request->song->id;
        $like->liked_at = new Expression('UTC_TIMESTAMP');

        if (!$like->save() || !$like->refresh()) {
            throw new ModelException($like);
        }

        return [
            'song' => ActiveUtils::toArray($like->song, [], function ($song) {
                return ['likes' => count($song->songLikes)];
            }),
        ];
    }

    /**
     * Dislikes a song
     * @return array
     * @throws HttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionDislike()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
                'song'  => [
                    'id' => 39,
                ],
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $deleted = SongLike::deleteAll([
            'guest_id' => Guest::loggedIn()->id,
            'song_id'  => $this->request->song->id,
        ]);

        if (!$deleted) {
            throw new HttpException(500, 'You never liked this song');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        /** @var Song $song */
        $song = Song::findOne($this->request->song->id);

        return [
            'song' => ActiveUtils::toArray($song, [], function ($song) {
                /** @var Song $song */
                return ['likes' => $song->getSongLikes()->count()];
            }),
        ];
    }
} 