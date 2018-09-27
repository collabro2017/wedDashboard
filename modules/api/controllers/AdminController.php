<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22/04/15
 * Time: 10:24
 */

namespace app\modules\api\controllers;

use app\models\ext\Poll;
use app\models\ext\PollOption;
use app\models\ext\Wedding;
use app\modules\api\components\Controller;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii2vm\api\components\VerboseException;
use yii2vm\components\ModelException;
use yii2vm\db\ActiveUtils;

/**
 * Class AdminController
 * @package app\modules\api\controllers
 */
class AdminController extends Controller
{
    /**
     * @return array
     * @throws ModelException
     * @throws UnauthorizedHttpException
     * @throws VerboseException
     */
    public function actionSignIn()
    {
        $this->checkInputParams(function () {
            /** @noinspection SpellCheckingInspection */
            return [
                'wedding' => [
                    'code'           => 'ABCDEF',
                    'admin_email'    => 'admin@wedo.com',
                    'admin_password' => 'admin'
                ]
            ];
        });

        //TODO: optimize

        /** @var Wedding $wedding */
        /** @noinspection PhpUndefinedFieldInspection */
        $wedding = Wedding::find()->where([
            'code'           => $this->request->wedding->code,
            'admin_email'    => $this->request->wedding->admin_email,
            'admin_password' => $this->request->wedding->admin_password
        ])->one();

        if (!$wedding) {
            throw new UnauthorizedHttpException('Incorrect admin email or password');
        }

        $wedding->admin_access_token = Yii::$app->security->generateRandomString();
        if (!$wedding->save()) {
            throw new ModelException($wedding);
        };

        return [
            'wedding' => $wedding
        ];
    }

    /**
     * @return array
     * @throws UnauthorizedHttpException
     * @throws VerboseException
     */
    public function actionPollToRun()
    {
        $this->checkInputParams(function () {
            return [
                'wedding' => [
                    'admin_password'     => 'admin',
                    'admin_access_token' => 'dUNw7t8KvwXFjLWmQc4jE3P4Sb5TlZwg'
                ]
            ];
        });

        /** @var Wedding $wedding */
        $wedding = $this->authorize();

        return [
            'polls' => $wedding->getPolls()->all()
        ];
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws ModelException
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     * @throws VerboseException
     */
    public function actionRunPolling()
    {
        $this->checkInputParams(function () {
            return [
                'wedding' => [
                    'admin_password'     => 'admin',
                    'admin_access_token' => 'dUNw7t8KvwXFjLWmQc4jE3P4Sb5TlZwg'
                ],
                'poll'    => [
                    'id' => 1
                ]
            ];
        });

        $wedding = $this->authorize();

        /** @var Poll $poll */
        /** @noinspection PhpUndefinedFieldInspection */
        $poll = $wedding->getPolls()->andWhere(['id' => $this->request->poll->id])->one();
        if (!$poll) {
            throw new NotFoundHttpException('Poll not found');
        }

        $poll->start();

        return [
            'poll' => $poll
        ];
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws ModelException
     * @throws UnauthorizedHttpException
     * @throws VerboseException
     */
    public function actionStopPolling()
    {
        $this->checkInputParams(function () {
            return [
                'wedding' => [
                    'admin_password'     => 'admin',
                    'admin_access_token' => 'dUNw7t8KvwXFjLWmQc4jE3P4Sb5TlZwg'
                ],
                'poll'    => [
                    'id' => 1
                ]
            ];
        });

        $wedding = $this->authorize();

        /** @var Poll $poll */
        /** @noinspection PhpUndefinedFieldInspection */
        $poll = $wedding->getPolls()->andWhere(['id' => $this->request->poll->id])->one();

        $poll->stop();

        return [
            'poll' => $poll
        ];
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     * @throws UnauthorizedHttpException
     * @throws VerboseException
     */
    public function actionPoll()
    {
        $this->checkInputParams(function () {
            return [
                'wedding' => [
                    'admin_password'     => 'admin',
                    'admin_access_token' => 'dUNw7t8KvwXFjLWmQc4jE3P4Sb5TlZwg'
                ],
                'poll'    => [
                    'id' => 1
                ]
            ];
        });

        $wedding = $this->authorize();

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
                return [
                    'poll_options' => ActiveUtils::toArray($poll->pollOptions, [], function (PollOption $option) {
                        return [
                            'votes_count' => (int)$option->getGuestPollOptions()->count()
                        ];
                    }),
                    'votes_count'  => (int)$poll->getVotes()->count()
                ];
            }),
        ];
    }

    /**
     * @return Wedding
     * @throws UnauthorizedHttpException
     */
    private function authorize()
    {
        // TODO: optimize

        /** @var Wedding $wedding */
        /** @noinspection PhpUndefinedFieldInspection */
        $wedding = Wedding::find()->where([
            'admin_password'     => $this->request->wedding->admin_password,
            'admin_access_token' => $this->request->wedding->admin_access_token
        ])->one();

        if (!$wedding) {
            throw new UnauthorizedHttpException('Incorrect admin password or access token');
        }

        return $wedding;
    }
}