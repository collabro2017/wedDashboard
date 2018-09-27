<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09/04/15
 * Time: 20:45
 */

namespace app\models\ext;


use yii\helpers\Inflector;

/**
 * Class FoodCategory
 * @package app\models\ext
 */
class FoodCategory extends \app\models\FoodCategory
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoods()
    {
        return $this->hasMany(Food::className(), ['food_category_id' => 'id']);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function beforeDelete()
    {
        foreach ($this->foods as $food) {
            $food->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->vanity_url = Inflector::slug($this->name);

        return parent::beforeValidate();
    }
}