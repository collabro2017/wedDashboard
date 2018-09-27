<?php

use app\models\Food;
use app\models\FoodCategory;
use yii\db\Migration;

class m150409_090145_food_to_categories extends Migration
{
    public function up()
    {
        /** @var Food $food */
        foreach (\app\models\Food::find()->all() as $food) {
            $category = FoodCategory::findOne(['name' => $food->name]);
            if (!$category) {
                $category             = new FoodCategory();
                $category->name       = $food->category;
                $category->wedding_id = $food->wedding_id;
                $category->vanity_url = \yii\helpers\Inflector::slug($category->name);
                $category->save();
                $category->refresh();
            }

            $food->food_category_id = $category->id;
            $food->save();
        }
    }

    public function down()
    {
        echo "m150409_090145_food_to_categories cannot be reverted.\n";

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
