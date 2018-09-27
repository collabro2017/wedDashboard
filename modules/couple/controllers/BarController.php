<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25/03/15
 * Time: 19:05
 */

namespace app\modules\couple\controllers;

use app\models\ext\Alcohol;
use app\modules\couple\components\Controller;
use app\modules\couple\components\ReorderAction;
use app\modules\couple\models\AvailableDrink;
use app\modules\couple\models\Drink;
use app\modules\couple\models\DrinkCategory;
use app\modules\couple\models\forms\WeddingDrinkModel;
use app\modules\couple\models\Wedding;
use app\models\ext\WeddingDrink;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii2vm\components\ModelException;

/**
 * Class BarController
 * @package app\modules\couple\controllers
 */
class BarController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'reorder'                  => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    return Wedding::current()->getDrinkCategories();
                }
            ],
            'reorder-drinks'           => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    /** @var WeddingDrink $current */
                    $current = WeddingDrink::findOne(Yii::$app->request->get('current'));

                    return $current->drinkCategory->getWeddingDrinks();
                }
            ],
            'reorder-available-drinks' => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    /** @var AvailableDrink $current */
                    $current = AvailableDrink::findOne(Yii::$app->request->get('current'));

                    return $current->drinkCategory->getAvailableDrinks()->all();
                }
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->breadcrumbs = [
            ['label' => 'BAR DETAILS']
        ];

        /** @var Wedding $wedding */
        $wedding = Wedding::current();

        return $this->render('categories', [
            'query' => $wedding->getDrinkCategories()->orderBy('order asc')
        ]);
    }

    /**
     * @throws ModelException
     */
    public function actionCreate()
    {
        $category = new DrinkCategory();
        /** @noinspection PhpUndefinedFieldInspection */
        $category->wedding_id = Wedding::current()->id;

        $category->load(Yii::$app->request->bodyParams);
        $category->save();
        $category->refresh();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        /** @var DrinkCategory $category */
        $category = DrinkCategory::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'BAR DETAILS', 'url' => ['index']],
            ['label' => 'UPDATE ' . $category->name],
        ];

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('edit-category', [
            'model' => $category
        ]);
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        /** @var DrinkCategory $category */
        $category = DrinkCategory::findOne($id);
        $category->delete();

        $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAvailableDrinks($id)
    {
        /** @var DrinkCategory $category */
        $category = DrinkCategory::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException('Drink category not found');
        }

        $this->breadcrumbs = [
            ['label' => 'BAR DETAILS', 'url' => ['index']],
            ['label' => $category->name],
        ];

        return $this->render('available-drinks', [
            'query'    => $category->getWeddingDrinks()->orderBy('order asc'),
            'category' => $category,
        ]);
    }

    /**
     * @param $category
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreateAvailableDrink($category)
    {
        $categoryModel = DrinkCategory::findOne($category);

        if (!$categoryModel) {
            throw new NotFoundHttpException('Drink category not found');
        }

        $drink                    = new WeddingDrinkModel();
        $drink->setCategory($categoryModel);

        $this->breadcrumbs = [
            ['label' => 'BAR DETAILS', 'url' => ['index']],
            [
                'label' => $categoryModel->name,
                'url'   => ['available-drinks', 'id' => $categoryModel->id]
            ],
            ['label' => 'CREATE DRINK'],
        ];

        if ($drink->load(Yii::$app->request->bodyParams) && $drink->save()) {
            return $this->redirect(['available-drinks', 'id' => $categoryModel->id]);
        }

        return $this->render('edit-available-drink', [
                'model' => $drink
            ]
        );
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdateAvailableDrink($id)
    {
        /** @var WeddingDrink $drink */
        $drink = WeddingDrink::findOne($id);

        if (!$drink) {
            throw new NotFoundHttpException('Drink not found');
        }

        $drinkForm = new WeddingDrinkModel();
        $drinkForm->setWeddingDrink($drink);

        $this->breadcrumbs = [
            ['label' => 'BAR DETAILS', 'url' => ['index']],
            ['label' => 'UPDATE ' . $drink->title],
        ];

        if ($drinkForm->load(Yii::$app->request->bodyParams) && $drinkForm->save()) {
            return $this->redirect(['available-drinks', 'id' => $drink->drink_category_id]);
        }

        return $this->render('edit-available-drink', [
            'model' => $drinkForm
        ]);
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function actionDeleteAvailableDrink($id)
    {
        /** @var WeddingDrink $drink */
        $drink = WeddingDrink::findOne($id);

        if (!$drink) {
            throw new NotFoundHttpException('Drink not found');
        }

        $drink->delete();

        $this->redirect(['index']);
    }

    /**
     * @param $arg
     *
     * @return string
     */
    public function actionBrandsOfType($arg)
    {
        return Json::encode(
            Alcohol::find()
                      ->select([
                          'name'  => 'name',
                          'value' => 'id'
                      ])
                      ->where(['parent_id' => $arg])
                      ->common()
                      ->orderBy('name')
                      ->asArray()
                      ->all()
        );
    }
}