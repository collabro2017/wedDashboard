<?php
namespace app\modules\api\controllers;

use app\models\ext\Guest;
use app\models\ext\Poll;
use app\models\ext\Token;
use app\models\ext\Wedding;
use app\models\GuestPollOption;
use app\models\PollOption;
use app\modules\api\components\Controller;
use yii\base\Exception;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;

/**
 * Class PollsController
 * @package app\modules\api\controllers
 */
class PollsController extends Controller
{
    /**
     * Publishes an answer for a poll
     * @return array
     * @throws Exception
     * @throws ModelException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionPublish()
    {
        $this->checkInputParams(function () {
            return [
                'token'             => ['hash' => Token::find()->random()->one()->hash],
                'guest_poll_option' => [
                    'poll_option_id' => 3,
                ],
            ];
        });

        /** @var PollOption $pollOption */
        /** @noinspection PhpUndefinedFieldInspection */
        $pollOption = PollOption::findOne($this->request->guest_poll_option->poll_option_id);

        /** @noinspection PhpUndefinedFieldInspection */
        $answered = PollOption::find()
                              ->joinWith('guestPollOptions')
                              ->where([
                                  'guest_poll_option.guest_id' => Guest::loggedIn()->id,
                                  'poll_id'                    => $pollOption->poll_id,
                              ])->count() > 0;

        if ($answered) {
            throw new Exception('You have already voted');
        }

        $option = new GuestPollOption();

        /** @noinspection PhpUndefinedFieldInspection */
        $option->attributes = [
            'poll_option_id' => $this->request->guest_poll_option->poll_option_id,
            'guest_id'       => Guest::loggedIn()->id,
            'polled_at'      => new Expression('utc_timestamp'),
        ];

        if (!($option->save() && $option->refresh())) {
            throw new ModelException($option);
        }

        /** @noinspection PhpUndefinedFieldInspection */

        $votesCount = GuestPollOption::find()->joinWith([
            'pollOption',
            'pollOption.poll',
            'pollOption.poll.wedding',
        ])->andWhere(['wedding.id' => Guest::loggedIn()->wedding->id])
                                     ->count();

        return [
            'poll'        => ActiveUtils::toArray($option->pollOption->poll, [], function ($poll) use ($votesCount) {
                return [
                    'poll_options' => ActiveUtils::toArray($poll->pollOptions, [], function (PollOption $option) {
                        return [
                            'votes_count' => $option->getGuestPollOptions()->count(),
                        ];
                    }),
                    'votes_count'  => $votesCount,
                ];
            }),
            'votes_count' => $votesCount,
        ];
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionGet()
    {
        $this->checkInputParams(function () {
            return [
                'token' => ['hash' => Token::find()->random()->one()->hash],
                'poll'  => [
                    'id' => 2,
                ],
            ];
        });

        // TODO: remove this shit
        /** @var Wedding $wedding */
        $wedding = Guest::loggedIn() ? Guest::loggedIn()->wedding : null;

        // TODO: remove this shit
        if (!$wedding) {
            /** @noinspection PhpUndefinedFieldInspection */
            $wedding = Wedding::findOne($this->request->wedding->id);
        }

        /** @var Poll $poll */
        /** @noinspection PhpUndefinedFieldInspection */
        $poll = $wedding->getPolls()->andWhere(['id' => $this->request->poll->id])->one();
        if (!$poll) {
            throw new NotFoundHttpException('Poll not found');
        }

        return [
            'poll' => ActiveUtils::toArray($poll, [], function ($poll) {
                /** @noinspection PhpUndefinedFieldInspection */
                /** @var Poll $poll */
                $votesSum = 0;

                return [
                    'poll_options' => ActiveUtils::toArray($poll->pollOptions, [], function (PollOption $option) use (
                        $votesSum
                    ) {
                        $votesSum += (int)$option->getGuestPollOptions()->count();

                        return [
                            'votes_count' => $votesSum,
                        ];
                    }),
                    'votes_count'  => (int)$poll->getVotes()->count(),
                ];
            }),
        ];
    }

    public function actionAnswersCount()
    {
        $this->checkInputParams(function () {
            return [
                'admin_token' => ['hash' => Wedding::findOne(1)->admin_access_token],
                'poll'        => [
                    'id' => Poll::find()->one()->id,
                ],
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $wedding = Wedding::find()->andWhere(['admin_access_token' => $this->request->admin_token->hash])->one();

        if (!$wedding) {
            throw new NotFoundHttpException('Incorrect access token');
        }

        /** @var Poll $poll */
        /** @noinspection PhpUndefinedFieldInspection */
        $poll = $wedding->getPolls()->andWhere(['poll.id' => $this->request->poll->id])->exists();

        if (!$poll) {
            throw new NotFoundHttpException('Poll not found');
        }

        /** @noinspection PhpUndefinedFieldInspection */
        return [
            'answers_count' => GuestPollOption::find()
                                              ->joinWith('pollOption.poll')
                                              ->andWhere(['poll.id' => $this->request->poll->id])
                                              ->count(),
            'guests_count'  => $wedding->getGuests()->count(),
        ];
    }
}