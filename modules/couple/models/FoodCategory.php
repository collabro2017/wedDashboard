<?php

namespace app\modules\couple\models;

class FoodCategory extends \app\models\ext\FoodCategory
{
    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->order = static::find()->count() + 1;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoods()
    {
        return $this->hasMany(Food::className(), ['food_category_id' => 'id']);
    }
}