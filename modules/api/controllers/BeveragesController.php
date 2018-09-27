<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10/12/14
 * Time: 20:42
 */

namespace app\modules\api\controllers;

use app\models\BeverageLike;
use app\models\BeverageType;
use app\models\ext\Beverage;
use app\models\ext\Alcohol;
use app\models\ext\ExistingDrink;
use app\models\ext\Guest;
use app\models\ext\Token;
use app\models\Mixer;
use app\modules\api\components\Controller;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;

/**
 * Class BeveragesController
 * @package app\modules\api\controllers
 */
class BeveragesController extends Controller
{

    /**
     * Gets a list of types fo beverages
     *
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionTypes()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
            ];
        });

        $types = BeverageType::find()->orderBy('name')->all();

        return [
            'types' => ActiveUtils::toArray($types, [], function ($type) {
                return [
                    'icon_url' => Url::to(sprintf('@web/images/%s', $type->image_filename), true)
                ];
            })
        ];
    }

    /**
     * Get available components for drink randomizer
     *
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionAvailableComponents()
    {
        $this->checkInputParams([
            'token' => ['hash' => Token::find()->random()->one()->hash],
        ]);

        $guest = Guest::loggedIn();

        $alcohols = Alcohol::find()
            ->joinWith('weddingDrinks.drinkCategory.wedding')
            ->where([
                'or',
                ['wedding.id' => $guest->wedding_id],
                ['alcohol.wedding_id' => $guest->wedding_id]
            ])
            ->andWhere(['can_combine' => 1])
            ->all();

        $parentIds = array_unique(ArrayHelper::getColumn($alcohols, 'parent_id'));
        $parents = Alcohol::find()->where([
            'id' => $parentIds,
            'can_combine' => 1
        ])->all();

        $mixers = Mixer::find()->all();

        return [
            'alcohols'   => ActiveUtils::toArray(ArrayHelper::merge($alcohols, $parents)),
            'mixers'        => ActiveUtils::toArray($mixers),
        ];
    }

    /**
     * Return one random beverage
     *
     * @return array
     * @throws NotFoundHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionRandomize()
    {
        $this->checkInputParams(function () {
            return [
                'token'          => ['hash' => Token::find()->random()->one()->hash],
                'alcohol_id'  => ['optional', 'value' => '1'],
                'mixer_id' => ['optional', 'value' => '7'],
                'type_id'  => ['optional', 'value' => '2'],
            ];
        });

        $hasAvailableDrink = Beverage::find()->forWedding(Guest::loggedIn()->wedding)->exists();

        if (!$hasAvailableDrink) {
            throw new NotFoundHttpException('No recipes found');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $beverage = Beverage::find()
                              ->random(
                                  Guest::loggedIn()->wedding,
                                  $this->request->alcohol_id,
                                  $this->request->mixer_id,
                                  $this->request->type_id)
                              ->one();

        return [
            'beverage' => $beverage ? ActiveUtils::toArray($beverage, [
                'alcohols',
                'mixers',
                'type'
            ], function ($beverage) {
                /** @var ExistingDrink $drink */
                return [
                    'likes' => (int)$beverage->getBeverageLikes()->forWedding(Guest::loggedIn()->wedding_id)->count()
                ];
            }) : null
        ];
    }

    public function actionCompletelyRandomize()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash]
            ];
        });

        /** @var Beverage $beverage */
        $beverage = Beverage::find()->forWedding(Guest::loggedIn()->wedding)->orderBy('RAND()')->one();
        return [
            'beverage' => ActiveUtils::toArray($beverage, [
                'alcohols',
                'mixers',
                'type'
            ], function ($beverage) {
                /** @var ExistingDrink $drink */
                return [
                    'likes' => (int)$beverage->getBeverageLikes()->forWedding(Guest::loggedIn()->wedding_id)->count()
                ];
            })
        ];
    }

    /**
     * Likes a beverage
     *
     * @return array
     * @throws HttpException
     * @throws ModelException
     * @throws NotFoundHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionLike()
    {
        $this->checkInputParams(function () {
            return [
                'token'             => ['hash' => Token::find()->random()->one()->hash],
                'beverage_id' => 3
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $exists = BeverageLike::find()->where([
            'guest_id'          => Guest::loggedIn()->id,
            'beverage_id' => $this->request->beverage_id
        ])->exists();

        if ($exists) {
            throw new HttpException(500, 'You have already liked the beverage');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $beverage = Beverage::findOne($this->request->beverage_id);
        if (!$beverage) {
            throw new NotFoundHttpException('Beverage not found');
        }

        $like = new BeverageLike();

        /** @noinspection PhpUndefinedFieldInspection */
        $like->guest_id = Guest::loggedIn()->id;

        /** @noinspection PhpUndefinedFieldInspection */
        $like->beverage_id = $this->request->beverage_id;
        $like->liked_at          = new Expression('UTC_TIMESTAMP');

        if (!$like->save() || !$like->refresh()) {
            throw new ModelException($like);
        }

        /** @var Beverage $likedDrink */
        $likedDrink = Beverage::findOne($like->beverage_id);

        return [
            'beverage' => ActiveUtils::toArray($likedDrink, ['alcohols', 'mixers'],
                function ($beverage) {
                    /** @var ExistingDrink $beverage */
                    return [
                        'likes_count' => (int)$beverage->getBeverageLikes()->count(),
                        'is_liked'    => $beverage->isLikedByGuest(Guest::loggedIn()->id)
                    ];
                }
            )
        ];
    }

    /**
     * Dislikes a beverage
     *
     * @return array
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionDislike()
    {
        $this->checkInputParams(function () {
            return [
                'token'             => ['hash' => Token::find()->random()->one()->hash],
                'beverage_id' => 3
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $beverage = Beverage::findOne($this->request->beverage_id);
        if (!$beverage) {
            throw new NotFoundHttpException('Beverage not found');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        $deleted = BeverageLike::deleteAll([
            'guest_id'          => Guest::loggedIn()->id,
            'beverage_id' => $this->request->beverage_id
        ]);

        if (!$deleted) {
            throw new HttpException(500, 'You never liked this beverage');
        }

        /** @noinspection PhpUndefinedFieldInspection */

        /** @var ExistingDrink $dislikedDrink */
        $dislikedDrink = Beverage::findOne($this->request->beverage_id);

        return [
            'beverage' => ActiveUtils::toArray($dislikedDrink, ['alcohols', 'mixers'],
                function ($beverage) {
                    /** @var ExistingDrink $beverage */
                    return [
                        'likes_count' => (int)$beverage->getBeverageLikes()->count(),
                        'is_liked'    => $beverage->isLikedByGuest(Guest::loggedIn()->id)
                    ];
                }
            )
        ];
    }
} 