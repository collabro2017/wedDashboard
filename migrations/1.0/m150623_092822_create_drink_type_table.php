<?php

use yii\db\Migration;

class m150623_092822_create_drink_type_table extends Migration
{
    public function up()
    {
        $this->createTable('drink_type', [
            'id' => 'pk',
            'name' => 'string',
            'image_filename' => 'string'
        ]);

        $this->create(['cocktail', 'shot', 'martini']);
    }

    public function down()
    {
        $this->dropTable('drink_type');
    }

    private function create($names)
    {
        foreach ($names as $name) {
            $this->insert('drink_type', [
                'name'         => $name,
                'image_filename' => 'glass-placeholder.png'
            ]);
        }
    }
}
