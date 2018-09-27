<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/01/15
 * Time: 20:54
 */

namespace app\modules\site\components;

use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/site/assets';

    public $js = [
        'js/colorbox.js',
        'js/photoset.js',
        'js/dropzone.js',
        'js/site.js',
    ];

    public $css = [
        'css/font.css',
        'css/icon.css',
        'css/typography.css',
        'css/navigation.css',
        'css/button.css',
        'css/form.css',
        'css/colorbox.css',
        'css/site.css',
        'css/dropzone.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\components\BowerAsset'
    ];
}