<?php

namespace app\modules\api\controllers;

use app\models\BeverageLike;
use app\models\ext\Beverage;
use app\models\ext\DrinkCategory;
use app\models\ext\FoodCategory;
use app\models\ext\Guest;
use app\models\ext\Media;
use app\models\ext\Poll;
use app\models\ext\Token;
use app\models\ext\Wedding;
use app\models\ext\WeddingDrink;
use app\models\PollOption;
use app\models\Song;
use app\models\Trivia;
use app\models\TriviaAnswer;
use app\modules\api\components\Controller;
use Faker\Factory;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;

/**
 * Class WeddingController
 * @package app\modules\api\controllers
 */
class WeddingController extends Controller
{

    /**
     * Gets all info about the wedding
     * @return array
     * @throws NotFoundHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionGet()
    {
        $this->checkInputParams(function () {
            /** @noinspection SpellCheckingInspection */
            return [
                'wedding' => ['code' => 'ABCDEF'],
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        /** @var Wedding $wedding */
        $wedding = Wedding::findOne(['code' => $this->request->wedding->code]);
        if (!$wedding) {
            throw new NotFoundHttpException('Wedding not found');
        }

        $wedding->admin_access_token = null;

        return ['wedding' => $wedding];
    }

    /**
     * Returns a list of participants
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionParticipants()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        /** @var Guest $guest */
        $guest = Guest::loggedIn();

        /** @noinspection PhpUndefinedFieldInspection */

        /** @noinspection SpellCheckingInspection */
        $participants = $guest->wedding
            ->getParticipants()
            ->orderBy('order asc, fullname asc')
            ->all();

        return ['participants' => $participants];
    }

    /**
     * Returns a list of guests for the wedding
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionGuests()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @var Guest $guest */
        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::loggedIn();

        /** @noinspection PhpUndefinedFieldInspection */

        return ['guests' => $guest->wedding->guests];
    }

    /**
     * Returns a list of polls
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionPolls()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @var Guest */
        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::loggedIn();

        /** @noinspection PhpUndefinedFieldInspection */
        $polls = $guest->wedding->getPolls()->orderBy('order asc, topic asc')->all();

        return [
            'polls' => ActiveUtils::toArray($polls, [], function ($poll) use ($guest) {
                /** @noinspection PhpUndefinedFieldInspection */
                /** @var Poll $poll */
                return [
                    'poll_options' => ActiveUtils::toArray($poll->pollOptions, [], function (PollOption $option) {
                        return [
                            'votes_count' => (int)$option->getGuestPollOptions()->count(),
                        ];
                    }),
                    'voted'        => boolval($poll->voteOf($guest)),
                    'votes_count'  => (int)$poll->getVotes()->count(),
                ];
            }),
        ];
    }

    /**
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionFood()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @var Guest $guest */
        /** @noinspection PhpUndefinedFieldInspection */
        $guest = Guest::loggedIn();

        $categories = $guest->wedding
            ->getFoodCategories()
            ->orderBy('food_category.order asc')
            ->all();

        return [
            'categories' => ActiveUtils::toArray($categories, [], function ($category) {
                /** @var FoodCategory $category */
                return [
                    'food' => $category->getFoods()->orderBy('food.order asc')->all(),
                ];
            }),
        ];
    }

    /**
     * Returns a list of drinks
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionDrinks()
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

        $categories = DrinkCategory::find()
            ->where([
                'wedding_id' => $guest->wedding->id,
            ])
            ->orderBy('order asc, name asc')
            ->all();

        /** @noinspection PhpUndefinedFieldInspection */

        return [
            'categories' => ActiveUtils::toArray($categories, [], function ($category) {

                /** @var DrinkCategory $category */
                return [
                    'drinks' => ActiveUtils::toArray(WeddingDrink::find()
                        ->where(['drink_category_id' => $category->id])
                        ->all(), ['alcohol']),
                ];
            }),
        ];
    }

    /**
     * Returns a list of all media for the wedding
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionMedia()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $media = Media::find()->joinWith([
            'guest',
            'guest.wedding',
        ])->where(['wedding.id' => Guest::loggedIn()->wedding_id])
            ->orderBy('created_at desc')
            ->all();

        return [
            'media' => ActiveUtils::toArray($media, ['guest'], function (Media $media) {
                /** @noinspection PhpUndefinedFieldInspection */
                return [
                    'comments_count' => $media->getMediaComments()->count(),
                    'likes_count'    => $media->getMediaLikes()->count(),
                    'is_liked'       => $media->isLikedByGuest(Guest::loggedIn()->id),
                ];
            }),
        ];
    }

    /**
     * Returns a list of trivia
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionTrivia()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        $trivia = Guest::loggedIn()->wedding->getTrivias()->orderBy('order asc')->all();

        return [
            'trivia' => ActiveUtils::toArray($trivia, [], function (Trivia $trivia) {
                return [
                    'questions' => ActiveUtils::toArray($trivia->questions, ['answers'],
                        function ($question) {
                            $answered = TriviaAnswer::find()
                                ->joinWith('answer')
                                ->where([
                                    'guest_id'           => Guest::loggedIn()->id,
                                    'answer.question_id' => $question->id,
                                ])->count();

                            return ['answered' => $answered];
                        }
                    ),
                ];
            }),
        ];
    }

    /**
     * Returns a list of vendors
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionVendors()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @var Wedding $wedding */
        /** @noinspection PhpUndefinedFieldInspection */
        $wedding = Guest::loggedIn()->wedding;

        $vendors = $wedding->getVendors()->orderBy('order asc')->all();

        /** @noinspection PhpUndefinedFieldInspection */

        return ['vendors' => $vendors];
    }

    /**
     * Returns a list of songs
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionSongs()
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
        $songs = Song::find()->joinWith([
            'guest',
            'guest.wedding',
        ])->where(['wedding.id' => $guest->wedding_id])->all();

        return [
            'songs' => ActiveUtils::toArray($songs, ['guest'], function (Song $song) use ($guest) {
                return [
                    'likes' => $song->getSongLikes()->count(),
                    'liked' => $song->getSongLikes()->andWhere(['guest_id' => $guest->id])->count() > 0,
                ];
            }),
        ];
    }

    /**
     * @return array
     */
    public function actionTables()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @var Wedding $wedding */
        /** @noinspection PhpUndefinedFieldInspection */
        $wedding = Guest::loggedIn()->wedding;

        $tableGuests = $wedding->getGuests()
            ->addSelect('*, count(*) as count')
            ->groupBy('table')
            ->asArray(true)
            ->all();

        return [
            'tables' => ArrayHelper::getColumn($tableGuests, function ($tableGuest) use ($wedding) {

                $number = ArrayHelper::getValue($tableGuest, 'table');
                $guests = $wedding->getGuests()->andWhere(['table' => $number])->all();

                return [
                    'wedding_id' => ArrayHelper::getValue($tableGuest, 'wedding_id'),
                    'count'      => ArrayHelper::getValue($tableGuest, 'count'),
                    'number'     => $number,
                    'guests'     => ActiveUtils::toArray($guests, []),
                ];
            }),
        ];
    }

    /**
     * Returns a list of beverages
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionBeverages()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        $drinks = Beverage::find()
            ->forWedding(Guest::loggedIn()->wedding)
            ->leftJoin([
                'likes' => BeverageLike::find()
                    ->select('beverage_id, count(*) as cnt')
                    ->joinWith('guest')
                    ->groupBy('beverage_id')
                    ->andWhere(['guest.wedding_id' => Guest::loggedIn()->wedding_id]),
            ], 'beverage.id = likes.beverage_id')
            ->andWhere('likes.cnt >0')
            ->groupBy('beverage.id')
            ->orderBy('likes.cnt DESC')
            ->limit(100)
            ->all();

        return [
            'beverages' => ActiveUtils::toArray($drinks, [], function ($drinks) {
                /** @var Beverage $drinks */
                return [
                    'likes' => (int)$drinks->getBeverageLikes()->forWedding(Guest::loggedIn()->wedding_id)->count(),
                ];
            }),
        ];
    }

    /**
     * @return array
     */
    public function actionMine()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        /** @var Guest $guest */
        $guest = Guest::loggedIn();

        return [
            'weddings' => Wedding::find()->forGuest($guest)->all(),
        ];
    }

    public function actionRegister()
    {
        $this->checkInputParams(function () {
            $faker = Factory::create();

            return [
                'validate_only'     => '0',
                'code'             => strtoupper($faker->randomLetter . $faker->randomLetter . $faker->randomLetter
                                                 . $faker->randomLetter . $faker->randomLetter . $faker->randomLetter),
                'bride_first_name' => $faker->firstName('female'),
                'bride_last_name'  => $faker->lastName,
                'groom_first_name' => $faker->firstName('male'),
                'groom_last_name'  => $faker->lastName,
                'admin_email'      => $faker->safeEmail,
                'admin_password'   => $faker->words(1, true),
                'wedding_date'     => $faker->dateTimeThisYear->format('Y-m-d'),
                'city'             => 'Toronto',
                'state'            => 'Ontario',
                'country'          => 'Canada',
            ];
        });

        $wedding = new Wedding();
        $wedding->setAttributes($this->request->getValues(), true);

        /** @noinspection PhpUndefinedFieldInspection */
        if ($this->request->validate_only) {
            if (!$wedding->validate()) {
                throw new ModelException($wedding);
            } else {
                return [];
            }
        }

        if (!($wedding->save() && $wedding->refresh())) {
            throw new ModelException($wedding);
        }

        return [
            'wedding' => $wedding,
        ];
    }
}
