<?php
namespace app\modules\couple\models;

class AvailableDrink extends \app\models\AvailableDrink
{
    public function getTitle()
    {
        $brandName     = null;
        $baseDrinkName = null;

        if ($this->drinkBrand) {

            $brandName = $this->drinkBrand->name;
        }

        if (!$brandName) {
            $brandName = $this->exclusive_brand_name;
        }

        if ($this->baseDrink) {
            $baseDrinkName = $this->baseDrink->name;
        }

        return sprintf('%s %s', $baseDrinkName, $brandName);
    }

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
                                     'drink_category_id' => $this->drink_category_id
                                 ])
                                 ->count() + 1;
        }

        return parent::beforeSave($insert);
    }
}