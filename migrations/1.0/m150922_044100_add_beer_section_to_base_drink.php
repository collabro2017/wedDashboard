<?php

use yii\db\Migration;

class m150922_044100_add_beer_section_to_base_drink extends Migration
{
    public function up()
    {
        $this->addColumn('base_drink', 'can_combine', 'tinyint(1) default 1');
        $this->execute('INSERT INTO base_drink (name, can_combine) VALUES ("Beer", 0)');
    }

    public function down()
    {
        $this->execute('DELETE FROM base_drink WHERE name = "Beer"');
        $this->dropColumn('base_drink', 'can_combine');
    }
}
