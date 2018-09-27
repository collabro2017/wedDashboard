<?php

namespace app\modules\api\controllers;

use app\models\ext\Guest;
use app\models\ext\Token;
use app\models\ext\Trivia;
use app\models\Wedding;
use app\modules\api\components\Controller;
use yii\db\Exception;
use yii\db\Expression;
use yii\web\HttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;
use yii2vm\media\upload\BinaryUpload;

/**
 * Class GuestsController
 * @package app\modules\api\controllers
 */
class GuestsController extends Controller
{
    /**
     * Registers a new guest for the wedding
     *
     * @return array
     * @throws HttpException
     * @throws ModelException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionRegister()
    {
        $this->checkInputParams(function () {
            /** @noinspection SpellCheckingInspection */
            return [
                'guest'   => [
                    'first_name'    => 'Alex',
                    'last_name'     => 'Kryshtalev',
                    'email'         => 'kryshtalev@gmail.com',
                    'with_who'      => 'friend',
                    'who_met_first' => 'groom',
                    'how_know'      => 'cousin',
                    'wedding_id'    => 1,
                    'table'         => 1,
                    'device_token'  => [
                        'optional',
                        'value' => '1234567890'
                    ]
                ],
                'content' => [
                    'optional',
                    'value' => 'QmFzZTY0IC0g0Y3RgtC+INGB0L/QtdGG0LjQsNC70YzQvdGL0Lkg0LzQtdGC0L7QtCDQutC+0LTQuNGA0L7QstCw0L3QuNGPINC40L3RhNC+0YDQvNCw0YbQuNC4INCyIDY0LdGA0LDQt9GA0Y/QtNC90YvQuSDQutC+0LQgKDYg0LHQuNGCKSwg0YjQuNGA0L7QutC+INC40YHQv9C+0LvRjNC30YPQtdC80YvQuSDQsiDQv9GA0LjQu9C+0LbQtdC90LjRj9GFINGN0LvQtdC60YLRgNC+0L3QvdC+0Lkg0L/QvtGH0YLRiyDQtNC70Y8g0LrQvtC00LjRgNC+0LLQsNC90LjRjyDQsdC40L3QsNGA0L3Ri9GFINC00LDQvdC90YvRhS4g0JLQtdGB0Ywg0LTQuNCw0L/QsNC30L7QvSDQt9Cw0LrQvtC00LjRgNC+0LLQsNC90L3Ri9GFINGB0LjQvNCy0L7Qu9C+0LIg0YPQutC70LDQtNGL0LLQsNC10YLRgdGPINCyINCw0L3Qs9C70LjQudGB0LrQuNC5INCw0LvRhNCw0LLQuNGCLCDRhtC40YTRgNGLINC4INGA0Y/QtCDRgdC/0LXRhtC40LDQu9GM0L3Ri9GFINGB0LjQvNCy0L7Qu9C+0LIuINCd0LAg0YHQsNC50YLQtSDQv9GA0LXQtNGB0YLQsNCy0LvQtdC9INC+0L3Qu9Cw0LnQvSDQs9C10L3QtdGA0LDRgtC+0YAg0Lgg0LTQtdC60L7QtNC10YAg0YTRg9C90LrRhtC40LggYmFzZTY0Lg=='
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $wedding = Wedding::findOne(['id' => $this->request->guest->wedding_id]);

        if (!$wedding) {
            throw new HttpException('Wedding not found');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::findOne([
            'email'      => $this->request->guest->email,
            'wedding_id' => $this->request->guest->wedding_id
        ]);

        if (!$guest) {
            /** @var Guest $guest */
            /** @noinspection PhpUndefinedFieldInspection */
            $guest             = $this->request->guest->createModel('app\models\ext\Guest');
            $guest->created_at = new Expression('UTC_TIMESTAMP');

            if (!$guest->save() || !$guest->refresh()) {
                throw new ModelException($guest);
            }

            if ($this->request->has('content')) {
                /** @noinspection PhpUndefinedFieldInspection */
                BinaryUpload::createFromBase64($this->request->content)->toEntity($guest, 'image_filename');
            }
        }

        /** @noinspection PhpUndefinedFieldInspection */

        return [
            'guest' => $guest,
            'token' => $guest->activeToken
        ];
    }

    /**
     * Searches a guest by email
     *
     * @return array
     * @throws Exception
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionFindByEmail()
    {
        /** @noinspection SpellCheckingInspection */
        $this->checkInputParams(function () {
            return [
                'guest' => [
                    'email'      => 'kryshtalev@gmail.com',
                    'wedding_id' => 1
                ]
            ];
        });

        /** @var Guest $guest */
        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::findOne([
            'email'      => $this->request->guest->email,
            'wedding_id' => $this->request->guest->wedding_id
        ]);

        if (!$guest) {
            throw new Exception('Guest not found');
        }

        return $this->toArray($guest) + [
            'token' => $guest->getActiveToken()
        ];
    }

    /**
     * Formats a guest with additional information
     *
     * @param Guest $guest
     *
     * @return array
     */
    private function toArray($guest)
    {
        /** @noinspection PhpUndefinedFieldInspection */

        return [
            'guest' => ActiveUtils::toArray($guest, [], function (Guest $guest) {
                /** @noinspection PhpUndefinedFieldInspection */
                return [
                    'trivia'            => ActiveUtils::toArray($guest->getTrivia()->all(), [], function (Trivia $trivia) use
                    (
                        $guest
                    ) {
                        return [
                            'points' => (int)$guest->getPoints($trivia->id),
                            'ranked' => (int)$guest->getRank($trivia->id),
                            'of'     => (int)$guest->wedding->getGuests()->count(),
                        ];
                    }),
                    'songs_activity'    => [
                        'requested' => $guest->getSongs()->count(),
                        'liked'     => $guest->getSongLikes()->count(),
                    ],
                    'pictures_activity' => [
                        'uploaded'  => $guest->getPhotos()->count(),
                        'liked'     => $guest->getPhotoLikes()->count(),
                        'commented' => $guest->getPhotoComments()->count(),
                    ],
                    'video_activity'    => [
                        'uploaded'  => $guest->getVideo()->count(),
                        'liked'     => $guest->getVideoLikes()->count(),
                        'commented' => $guest->getVideoComments()->count(),
                    ],
                ];
            }),
        ];
    }

    /**
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionSetDeviceToken()
    {
        $this->checkInputParams(function () {
            return [
                'token'        => [
                    'hash' => Token::find()->random()->one()->hash
                ],
                'device_token' => '1234567890'
            ];
        });

        /** @var Guest $guest */
        $guest = Guest::loggedIn();

        /** @noinspection PhpUndefinedFieldInspection */
        $guest->device_token = $this->request->device_token;

        if (!$guest->save()) {
            throw new ModelException($guest);
        }

        return [];
    }

    /**
     * Gets info about the current user identified by token
     *
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionGet()
    {
        $this->checkInputParams(function () {
            return [
                'token'        => [
                    'hash' => Token::find()->random()->one()->hash
                ],
                'device_token' => [
                    'optional',
                    'value' => '1234567890'
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::loggedIn();

        return $this->toArray($guest);
    }
}
