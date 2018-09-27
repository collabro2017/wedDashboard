<?php
namespace app\models\ext;

use app\models\BeverageLike;

class Beverage extends \app\models\Beverage
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlcohols()
    {
        return $this->hasMany(Alcohol::className(), ['id' => 'alcohol_id'])->viaTable('beverage_alcohol', ['beverage_id' => 'id']);
    }

    public function isLikedByGuest($id)
    {
        return BeverageLike::find()->where([
            'beverage_id' => $this->id,
            'guest_id' => $id
        ])->count() > 0;
    }
}