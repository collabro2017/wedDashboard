<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25/03/15
 * Time: 19:05
 */

namespace app\modules\couple\controllers;

use app\modules\couple\components\Controller;
use app\modules\couple\components\ReorderAction;
use app\modules\couple\models\Answer;
use app\modules\couple\models\Question;
use app\modules\couple\models\Trivia;
use app\modules\couple\models\Wedding;
use Yii;
use yii\helpers\ArrayHelper;
use yii2vm\components\ModelException;
use yii2vm\media\upload\ImageUpload;

/**
 * Class TriviaController
 * @package app\modules\couple\controllers
 */
class TriviaController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'reorder'           => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    return Wedding::current()->getTrivias();
                },
            ],
            'reorder-questions' => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    /** @var Question $current */
                    $current = Question::findOne(Yii::$app->request->get('current'));

                    return $current->trivia->getQuestions();
                },
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->breadcrumbs = [
            ['label' => 'TRIVIA'],
        ];

        return $this->render('index', [
            'query' => Wedding::current()
                ->getTrivias()
                ->orderBy('order asc'),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $trivia = new Trivia();

        /** @noinspection PhpUndefinedFieldInspection */
        $trivia->wedding_id = Wedding::current()->id;

        if ($trivia->load(Yii::$app->request->bodyParams)
            && $trivia->validate()
            && $trivia->save()
            && $trivia->refresh()
        ) {
            return $this->redirect(['index']);
        }

        return $this->render('edit-trivia', [
            'model' => $trivia,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        /** @var Trivia $trivia */
        $trivia = Trivia::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'TRIVIA', 'url' => ['index']],
            ['label' => 'UPDATE ' . $trivia->getTitle()],
        ];

        if ($trivia->load(Yii::$app->request->bodyParams)
            && $trivia->validate()
            && $trivia->save()
            && $trivia->refresh()
        ) {
            return $this->redirect(['index']);
        }

        return $this->render('edit-trivia', [
            'model' => $trivia,
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        Trivia::findOne($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws \Exception
     */
    public function actionQuestions($id)
    {
        /** @var Trivia $trivia */
        $trivia = Trivia::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'TRIVIA', 'url' => ['index']],
            ['label' => $trivia->getTitle()],
        ];

        return $this->render('questions', [
            'model' => $trivia,
        ]);
    }

    /**
     * @param null $trivia
     *
     * @return string|\yii\web\Response
     */
    public function actionCreateQuestion($trivia = null)
    {
        $question            = new Question();
        $question->trivia_id = $trivia;

        $this->breadcrumbs = [
            ['label' => 'TRIVIA', 'url' => ['index']],
            ['label' => $question->trivia->title, 'url' => ['questions', 'id' => $question->trivia_id]],
            ['label' => 'CREATE'],
        ];

        return $this->editQuestion($question);
    }

    /**
     * @param Question $question
     *
     * @return string|\yii\web\Response
     * @throws ModelException
     */
    private function editQuestion($question)
    {
        $wrongAnswers  = $question->wrongAnswers;
        $correctAnswer = $question->correctAnswer;

        if ($question->load(Yii::$app->request->post())
            && $correctAnswer->load(Yii::$app->request->post())
            && Answer::loadMultiple($wrongAnswers, Yii::$app->request->post())
            && $correctAnswer->body
        ) {
            if (!$question->save() && $question->refresh()) {
                throw new ModelException($question);
            }

            if ($question->setAnswers($correctAnswer, $wrongAnswers)) {

                $size = (object)ArrayHelper::getValue(Yii::$app->params, 'question', []);
                ImageUpload::createFromEntity($question, 'image')
                           ->resize($size->width, $size->height)
                           ->toEntity($question, 'image_filename');

                return $this->redirect(['questions', 'id' => $question->trivia_id]);
            } else {
                $question->delete();
            }
        }

        return $this->render('edit-question', [
            'model'         => $question,
            'correctAnswer' => $correctAnswer,
            'wrongAnswers'  => $wrongAnswers,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdateQuestion($id)
    {
        /** @var Question $question */
        $question = Question::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'TRIVIA', 'url' => ['index']],
            ['label' => $question->trivia->title, 'url' => ['questions', 'id' => $question->trivia_id]],
            ['label' => 'UPDATE ' . $question->topic],
        ];

        return $this->editQuestion($question);
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function actionDeleteQuestion($id)
    {
        /** @var Question $question */
        $question = Question::findOne($id);
        $question->delete();

        $this->redirect([
            'questions',
            'id' => $question->trivia_id,
        ]);
    }
}