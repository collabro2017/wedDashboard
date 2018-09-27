<?php

use yii\db\Migration;

class m150428_121457_create_drink_types extends Migration
{
    public function up()
    {
        $this->execute('delete from beverage_like');
        $this->execute('delete from beverage');
        $this->execute('delete from drink_category');
        $this->execute('delete from drink');

        $this->create(['Vodka', 'Whiskey', 'Rome', 'Beer', 'Spirits']);
        $this->create(['Juice', 'Soft', 'Water'], 0);
    }

    public function down()
    {
        echo "m150428_121457_create_drink_types cannot be reverted.\n";

        return false;
    }

    private function create($names, $isAlcoholic = 1)
    {
        foreach ($names as $name) {
            $this->insert('drink_category', [
                'name'         => $name,
                'vanity_url'       => \yii\helpers\Inflector::slug($name),
                'is_alcoholic' => $isAlcoholic
            ]);
        }
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
