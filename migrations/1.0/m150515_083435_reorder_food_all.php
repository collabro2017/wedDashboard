<?php

use app\models\ext\FoodCategory;
use app\models\Food;
use yii\db\Migration;

class m150515_083435_reorder_food_all extends Migration
{
    /**
     *
     */
    public function up()
    {
        /** @var FoodCategory $category */
        foreach (FoodCategory::find()->orderBy('id asc')->all() as $category) {
            $category->order = (int)FoodCategory::find()->max('food_category.order') + 1;
            $category->save();

            /** @var Food $food */
            foreach ($category->getFoods()->orderBy('id asc')->all() as $food) {
                $food->order = (int)Food::find()->max('food.order') + 1;
            }
        }

        return true;
    }

    public function down()
    {
        echo "m150515_083435_reorder_all cannot be reverted.\n";

        return false;
    }
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
