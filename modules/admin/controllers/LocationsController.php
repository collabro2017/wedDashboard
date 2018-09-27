<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/11/2016
 * Time: 00:35
 */

namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;

/**
 * Class LocationsController
 * @package app\modules\admin\controllers
 */
class LocationsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}