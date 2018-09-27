<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/01/15
 * Time: 20:54
 */

namespace app\components;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $baseUrl = '@web';

    public $js = [
        'jquery-fullscreen/jquery.fullscreen-min.js'
    ];

    public $css = [

    ];

    public $depends = [

    ];
}