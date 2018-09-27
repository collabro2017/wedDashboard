<?php

namespace app\modules\site\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class MediaComment extends \app\models\MediaComment
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
    }

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'value'              => new Expression('UTC_TIMESTAMP'),
                'updatedAtAttribute' => false
            ]
        ];
    }
}