<?php

use yii\db\Migration;

class m150428_123906_create_drinks extends Migration
{
    public function up()
    {
        $this->dropColumn('drink', 'is_alcoholic');

        $this->create('Vodka', ['Gzelka', 'Absolute', 'Putinka']);
        $this->create('Whiskey', ['Jameson', 'White Horse']);
        $this->create('Rome', ['Captain Morgan']);
        $this->create('Beer', ['Holsten', 'Guinness', 'Efes']);
        $this->create('Spirits', ['Gin & Tonic']);

        $this->create('Juice', ['Tomato', 'Pineapple', 'Apple']);
        $this->create('Soft', ['Coke', 'Fanta']);
        $this->create('Water', ['Still', 'Sparkle']);
    }

    private function create($category, $names)
    {
        foreach ($names as $name) {
            $this->insert('drink', [
                'name'              => $name,
                'drink_category_id' => \app\models\DrinkCategory::findOne(['name' => $category])->id
            ]);
        }
    }

    public function down()
    {
        echo "m150428_123906_create_drinks cannot be reverted.\n";

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
