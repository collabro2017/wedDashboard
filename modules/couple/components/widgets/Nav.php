<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13/04/15
 * Time: 14:24
 */

namespace app\modules\couple\components\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Nav extends \yii\bootstrap\Nav
{
    protected function isItemActive($item)
    {
        $url = ArrayHelper::getValue($item, 'url');

        return substr_count($url[0], \Yii::$app->controller->id);
    }

    public function renderItem($item)
    {
        if (array_key_exists('icon', $item)) {
            $item['label'] = Html::tag('span',
                    Html::tag('i', '', [
                        'class' => 'icon ' . $item['icon']
                    ])) . $item['label'];
        }

        return parent::renderItem($item);
    }
}