<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/01/15
 * Time: 20:54
 */

namespace app\modules\couple\components;

use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/couple/assets';

    public $js = [
        'js/image-upload.js',
        'js/resize-and-crop.js',
        'js/move.js',
        'js/swipe.js',
        'js/site.js',
    ];

    public $css = [
        'fonts/fonts.css',
        'css/icons.css',
        'css/site.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii2vm\components\Yii2VmAsset',
        'dosamigos\datepicker\DatePickerAsset'
    ];
}