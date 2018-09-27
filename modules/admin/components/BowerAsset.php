<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 14/11/2016
 * Time: 23:30
 */

namespace app\modules\admin\components;

use yii\web\AssetBundle;

/**
 * Class BowerAsset
 * @package app\modules\admin\components
 */
class BowerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower';

    public $css = [
        'nprogress/nprogress.css',
        'font-awesome/css/font-awesome.min.css',
        'animate.css/animate.min.css',
    ];

    public $js = [
        'nprogress/nprogress.js',
        'fastclick/lib/fastclick.js',
    ];
}