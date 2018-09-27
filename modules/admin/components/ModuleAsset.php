<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23/01/15
 * Time: 20:54
 */

namespace app\modules\admin\components;

use yii\web\AssetBundle;

/**
 * Class ModuleAsset
 * @package app\modules\admin\components
 */
class ModuleAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/admin/assets';

    /**
     * @var array
     */
    public $js = [
        'js/custom.js',
    ];

    /**
     * @var array
     */
    public $css = [
        'css/custom.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        '\app\modules\admin\components\BowerAsset',
    ];
}