<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25/03/15
 * Time: 19:06
 */

namespace app\modules\couple\controllers;

use app\modules\couple\components\Controller;
use app\modules\couple\components\ReorderAction;
use app\modules\couple\models\Participant;
use app\modules\couple\models\Wedding;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii2vm\components\ModelException;
use yii2vm\media\upload\ImageUpload;

/**
 * Class PartyController
 * @package app\modules\couple\controllers
 */
class PartyController extends Controller
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
                    return Wedding::current()->getParticipants();
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
            ['label' => 'WEDDING PARTY'],
        ];

        return $this->render('index', [
            'query' => Wedding::current()
                ->getParticipants()
                ->orderBy('order asc, fullname asc'),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $participant             = new Participant();
        $participant->wedding_id = Wedding::current()->id;

        $this->breadcrumbs = [
            ['label' => 'WEDDING PARTY', 'url' => ['index']],
            ['label' => 'UPDATE ' . $participant->member],
        ];

        if ($participant->load(Yii::$app->request->post())
            && $participant->validate()
            && $participant->save()
            && $participant->refresh()
        ) {
            $size = (object)ArrayHelper::getValue(Yii::$app->params, 'welcome', []);

            ImageUpload::createFromEntity($participant, 'image')
                       ->resize($size->width, $size->height)
                       ->toEntity($participant, 'image_filename');

            return $this->redirect(['index']);
        }

        if ($member = Yii::$app->request->get('member')) {
            $participant->member = $member;
        }

        return $this->render('edit', [
            'model' => $participant,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        /** @var Participant $participant */
        $participant = Participant::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'WEDDING PARTY', 'url' => ['index']],
            ['label' => 'UPDATE ' . $participant->member],
        ];

        if ($participant->load(Yii::$app->request->bodyParams)
            && $participant->validate()
            && $participant->save()
            && $participant->refresh()
        ) {
            $size = (object)ArrayHelper::getValue(Yii::$app->params, 'welcome', []);

            ImageUpload::createFromEntity($participant, 'image')
                       ->resize($size->width, $size->height)
                       ->toEntity($participant, 'image_filename');

            if (Yii::$app->request->isAjax) {
                return 'success';
            }

            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model' => $participant,
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        Participant::deleteAll([
            'id' => $id,
        ]);

        return $this->redirect('index');
    }

    public function actionUpdateImage()
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }

        $attributes = ArrayHelper::getValue(Yii::$app->request->post(), 'Participant');
        $identifier = ArrayHelper::getValue($attributes, 'id', null);

        if (!$identifier) {
            throw new BadRequestHttpException('ID is not specified');
        }

        /** @var Participant $model */
        $model                 = Participant::findOne($identifier);
        $model->image_filename = ArrayHelper::getValue($attributes, 'image_filename', null);
        if (!$model->save()) {
            throw new ModelException($model);
        };

        $size = (object)ArrayHelper::getValue(Yii::$app->params, 'avatar', []);

        ImageUpload::createFromEntity($model, 'image')
                   ->resize($size->width, $size->height)
                   ->toEntity($model, 'image_filename');

        return 'success';
    }

    /**
     * @return string
     */
    public function actionUpdateGroom()
    {
        return $this->updateImage('groom');
    }

    /**
     * @param string $attribute
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws ModelException
     */
    private function updateImage($attribute)
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }

        /** @var Wedding $wedding */
        $wedding = Wedding::current();
        $size    = (object)ArrayHelper::getValue(Yii::$app->params, 'avatar', []);

        $attributes = ArrayHelper::getValue(Yii::$app->request->post(), 'Wedding');
        $wedding->setAttribute(
            $attribute . '_filename',
            ArrayHelper::getValue($attributes, $attribute . '_filename', null));

        if (!$wedding->save()) {
            throw new ModelException($wedding);
        };

        ImageUpload::createFromEntity($wedding, $attribute)
                   ->resize($size->width, $size->height)
                   ->toEntity($wedding, $attribute . '_filename');

        return 'success';
    }

    /**
     * @return string
     */
    public function actionUpdateBride()
    {
        return $this->updateImage('bride');
    }
}