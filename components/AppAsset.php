<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */
namespace app\componentns\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class AppAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $sourcePath = '@app/assets';

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
        'yii2vm\assets\Yii2VmAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}