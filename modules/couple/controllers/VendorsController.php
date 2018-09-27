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
use app\modules\couple\models\Vendor;
use app\modules\couple\models\Wedding;
use Yii;

/**
 * Class VendorsController
 * @package app\modules\couple\controllers
 */
class VendorsController extends Controller
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
                    return Wedding::current()->getVendors();
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
            ['label' => 'WEDDING VENDORS'],
        ];

        return $this->render('index', [
            'query' => Wedding::current()
                ->getVendors()
                ->orderBy('vendor.order asc')
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $vendor             = new Vendor();
        $vendor->wedding_id = Wedding::current()->id;

        if ($vendor->load(Yii::$app->request->post())
            && $vendor->validate()
            && $vendor->save()
            && $vendor->refresh()
        ) {
            return $this->redirect(['index']);
        }

        if ($type = Yii::$app->request->get('type')) {
            $vendor->type = $type;
        }

        $this->breadcrumbs = [
            ['label' => 'WEDDING VENDORS', 'url' => ['index']],
            ['label' => 'CREATE ' . $vendor->type],
        ];

        return $this->render('edit', [
            'model' => $vendor
        ]);
    }

    /**
     * @param $id
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        /** @var Vendor $vendor */
        $vendor            = Vendor::findOne($id);
        $this->breadcrumbs = [
            ['label' => 'WEDDING VENDORS', 'url' => ['index']],
            ['label' => 'UPDATE ' . $vendor->type],
        ];

        if ($vendor->load(Yii::$app->request->bodyParams)
            && $vendor->validate()
            && $vendor->save()
            && $vendor->refresh()
        ) {
            return $this->redirect(['index']);
        }

        return $this->render('edit', [
            'model' => $vendor
        ]);
    }

    /**
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        Vendor::deleteAll([
            'id' => $id
        ]);

        return $this->redirect(['index']);
    }
}