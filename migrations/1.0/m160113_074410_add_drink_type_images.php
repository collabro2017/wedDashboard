<?php

use yii\db\Migration;
use app\models\BeverageType;
use yii2vm\components\ModelException;

class m160113_074410_add_drink_type_images extends Migration
{
    public function up()
    {
        $cocktail = BeverageType::find()->where(['name' => 'cocktail'])->one();
        $cocktail->image_filename = 'cocktail-placeholder.png';
        if (!$cocktail->save()) {
            throw new ModelException($cocktail);
        }

        $martini = BeverageType::find()->where(['name' => 'martini'])->one();
        $martini->image_filename = 'martini-placeholder.png';
        if (!$martini->save()) {
            throw new ModelException($martini);
        }

        $shot = BeverageType::find()->where(['name' => 'shot'])->one();
        $shot->image_filename = 'shot-placeholder.png';
        if (!$shot->save()) {
            throw new ModelException($shot);
        }
    }

    public function down()
    {
        echo "m160113_074410_add_drink_type_images cannot be reverted.\n";

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
