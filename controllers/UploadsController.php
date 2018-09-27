<?php
namespace app\controllers;

use yii\web\Controller;

/**
 * Class UploadsController
 * @package app\controllers
 */
class UploadsController extends Controller
{
    public $placeholder = '¯\_(ツ)_/¯';

    public function actionStub($width = 500, $height = 500)
    {
        $url = sprintf('http://dummyimage.com/%dx%d/000000/ffffff&text=%s',
            $width, $height, $this->placeholder);

        return $this->redirect($url);
    }
}