<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25/03/15
 * Time: 19:06
 */

namespace app\modules\couple\controllers;

use app\models\ext\FoodCategory;
use app\modules\couple\components\Controller;
use app\modules\couple\components\ReorderAction;
use app\modules\couple\models\Food;
use app\modules\couple\models\Wedding;
use Yii;
use yii2vm\components\ModelException;

/**
 * Class FoodController
 * @package app\modules\couple\controllers
 */
class FoodController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'reorder'      => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    return Wedding::current()->getFoodCategories();
                }
            ],
            'reorder-food' => [
                'class'    => ReorderAction::className(),
                'allQuery' => function () {
                    /** @var Food $current */
                    $current = Food::findOne(Yii::$app->request->get('current'));

                    return $current->foodCategory->getFoods();
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
            ['label' => 'FOOD']
        ];

        return $this->render('categories', [
            'query' => Wedding::current()
                ->getFoodCategories()
                ->orderBy('food_category.order asc')
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionFoods($id)
    {
        /** @var FoodCategory $category */
        $category = FoodCategory::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'FOOD', 'url' => ['index']],
            ['label' => $category->name],
        ];

        return $this->render('foods', [
            'foods'    => Food::find()
                              ->where([
                                  'food_category_id' => $id
                              ])
                              ->orderBy('order asc, name asc'),
            'category' => $category,
        ]);
    }

    /**
     * @throws ModelException
     */
    public function actionCreate()
    {
        /** @var FoodCategory $category */
        $category = new FoodCategory();

        /** @noinspection PhpUndefinedFieldInspection */
        $category->wedding_id = Wedding::current()->id;

        if (!($category->load(Yii::$app->request->bodyParams)
              && $category->save()
              && $category->refresh())
        ) {
            return $this->render('edit-category', [
                'model' => $category
            ]);
        }

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        /** @var FoodCategory $category */
        $category = FoodCategory::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'FOOD', 'url' => ['index']],
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
        FoodCategory::findOne($id)->delete();
        $this->redirect(['index']);
    }

    /**
     * @param null $category
     *
     * @return \yii\web\Response
     * @throws ModelException
     */
    public function actionCreateFood($category = null)
    {
        $food                   = new Food();
        $food->food_category_id = $category;

        $food->load(Yii::$app->request->post());
        if (!$food->name) {
            $this->breadcrumbs = [
                ['label' => 'FOOD', 'url' => ['index']],
                ['label' => $food->foodCategory->name, 'url' => ['foods', 'id' => $food->food_category_id]],
                ['label' => 'CREATE'],
            ];

            return $this->render('edit-food', [
                'model' => $food
            ]);
        }

        if (!($food->save() && $food->refresh())) {
            throw new ModelException($food);
        }

        return $this->redirect(['foods', 'id' => $food->food_category_id]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdateFood($id)
    {
        /** @var Food $food */
        $food = Food::findOne($id);

        $this->breadcrumbs = [
            ['label' => 'FOOD', 'url' => ['index']],
            ['label' => $food->foodCategory->name, 'url' => ['foods', 'id' => $food->food_category_id]],
            ['label' => 'UPDATE ' . $food->name],
        ];

        if ($food->load(Yii::$app->request->bodyParams) && $food->save()) {
            return $this->redirect(['foods', 'id' => $food->food_category_id]);
        }

        return $this->render('edit-food', [
            'model' => $food
        ]);
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function actionDeleteFood($id)
    {
        /** @var Food $food */
        $food = Food::findOne($id);
        $food->delete();

        $this->redirect(['foods', 'id' => $food->food_category_id]);
    }
}