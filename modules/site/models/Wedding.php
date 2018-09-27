<?php

namespace app\modules\site\models;

use Yii;

/**
 * Class Wedding
 * @package app\modules\site\models
 */
class Wedding extends \app\models\ext\Wedding
{

    /**
     * @return Wedding
     */
    public static function current()
    {
        return Yii::$app->user->identity->guest->wedding;
    }
}