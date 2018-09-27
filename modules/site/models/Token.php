<?php

namespace app\modules\site\models;

class Token extends \app\models\ext\Token
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
    }
}