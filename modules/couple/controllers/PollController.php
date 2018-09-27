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
use app\modules\couple\models\Poll;
use app\modules\couple\models\PollOption;
use app\modules\couple\models\Wedding;
use Yii;

/**
 * Class PollController
 * @package app\modules\couple\controllers
 */
class PollController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'reorder' => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    return Wedding::current()->getPolls();
                }
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->breadcrumbs = [
            ['label' => 'POLL AUDIENCE']
        ];

        return $this->render('index', [
            'query' => Wedding::current()
                ->getPolls()
                ->orderBy('order asc')
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->breadcrumbs = [
            ['label' => 'POLL AUDIENCE', 'url' => ['index']],
            ['label' => 'CREATE POLL'],
        ];

        $poll             = new Poll();
        $poll->wedding_id = Wedding::current()->id;

        return $this->editPoll($poll);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        /** @var Poll $poll */
        $poll = Poll::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'POLL AUDIENCE', 'url' => ['index']],
            ['label' => 'UPDATE ' . $poll->topic],
        ];

        return $this->editPoll($poll);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public
    function actionDelete($id)
    {
        Poll::findOne($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param Poll $poll
     *
     * @return string|\yii\web\Response
     */
    private function editPoll($poll)
    {
        $options = $poll->editableOptions;

        $isCreating = $poll->isNewRecord;
        if ($poll->load(Yii::$app->request->post())) {

            if (PollOption::loadMultiple($options, Yii::$app->request->bodyParams)
                   && $poll->validate()
                   && $poll->save()
                   && $poll->refresh()
                   && $poll->setEditableOptions($options))
            {
                return $this->redirect(['index']);
            } elseif ($isCreating) {
                $poll->delete();
            }
        }

        return $this->render('edit', [
            'model'   => $poll,
            'options' => $options
        ]);
    }
}