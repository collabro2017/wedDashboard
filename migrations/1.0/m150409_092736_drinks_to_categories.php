<?php

use app\models\Drink;
use app\models\DrinkCategory;
use yii\db\Migration;

class m150409_092736_drinks_to_categories extends Migration
{
    public function up()
    {
        /** @var Drink $drink */
        foreach (\app\models\Drink::find()->all() as $drink) {
            $category = DrinkCategory::findOne(['name' => $drink->name]);
            if (!$category) {
                $category             = new DrinkCategory();
                $category->name       = $drink->category;
                $category->wedding_id = $drink->wedding_id;
                $category->vanity_url = \yii\helpers\Inflector::slug($category->name);
                $category->save();
                $category->refresh();
            }

            $drink->drink_category_id = $category->id;
            $drink->save();
        }
    }

    public function down()
    {
        echo "m150409_092736_drinks_to_categories cannot be reverted.\n";

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
