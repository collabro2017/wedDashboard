<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09/04/15
 * Time: 16:25
 */

namespace app\models\ext;

/**
 * Class DrinkCategory
 * @package app\models\ext
 */
class DrinkCategory extends \app\models\DrinkCategory
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlcohols()
    {
        return $this->hasMany(Alcohol::className(), ['id' => 'alcohol_id'])
            ->viaTable('wedding_drink', ['drink_category_id' => 'id']);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function beforeDelete()
    {
        foreach ($this->weddingDrinks as $drink) {
            $drink->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        return parent::beforeValidate();
    }
}