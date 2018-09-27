<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 02/12/14
 * Time: 20:16
 */

namespace app\modules\api\controllers;

use app\models\ext\Guest;
use app\models\ext\Token;
use app\models\TriviaAnswer;
use app\models\TriviaLeaderboard;
use app\modules\api\components\Controller;
use yii\db\Expression;
use yii\web\ServerErrorHttpException;
use yii2vm\components\ModelException;

/**
 * Class TriviaController
 * @package app\modules\api\controllers
 */
class TriviaController extends Controller
{

    /**
     * Publishes the answer to trivia
     *
     * @return array
     * @throws ModelException
     * @throws ServerErrorHttpException
     * @throws \yii2vm\api\components\VerboseException
     */
    public function actionPublishAnswer()
    {
        $this->checkInputParams(function () {
            return [
                'token'         => ['hash' => Token::find()->random()->one()->hash],
                'trivia_answer' => [
                    'answer_id' => 2,
                    'score'     => 30
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */
        $found = TriviaAnswer::find()->where([
                'answer_id' => $this->request->trivia_answer->answer_id,
                'guest_id'  => Guest::loggedIn()->id
            ])->count() > 0;

        if ($found) {
            throw new ServerErrorHttpException('You have already answered the question');
        }

        /** @var TriviaAnswer $answer */
        /** @noinspection PhpUndefinedFieldInspection */
        $answer = $this->request->trivia_answer->createModel('\app\models\TriviaAnswer');

        /** @noinspection PhpUndefinedFieldInspection */
        $answer->guest_id    = Guest::loggedIn()->id;
        $answer->answered_at = new Expression('UTC_TIMESTAMP');

        if (!$answer->save() || !$answer->refresh()) {
            throw new ModelException($answer);
        }

        return ['trivia_answer' => $answer];
    }

    /**
     * Returns a leader board
     *
     * @return array
     * @throws \yii2vm\api\components\VerboseException
     */
    /** @noinspection SpellCheckingInspection */
    public function actionLeaderboard()
    {
        $this->checkInputParams(function () {
            return [
                'token'  => ['hash' => Token::find()->random()->one()->hash],
                'trivia' => [
                    'id' => '1',
                ]
            ];
        });

        /** @noinspection PhpUndefinedFieldInspection */

        /** @noinspection SpellCheckingInspection */

        return [
            'leaderboard' => TriviaLeaderboard::find()
                                              ->where(['trivia_id' => $this->request->trivia->id])
                                              ->orderBy('score desc')
                                              ->all()
        ];
    }
} 