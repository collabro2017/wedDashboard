<?php

namespace app\modules\couple\models;

class Food extends \app\models\ext\Food
{
    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->order = static::find()
                                 ->where([
                                     'food_category_id' => $this->food_category_id
                                 ])
                                 ->count() + 1;
        }

        return parent::beforeSave($insert);
    }
}