<?php

use yii\db\Migration;

class m150302_121301_add_keyword_to_wedding extends Migration {
    public function up() {
        $this->addColumn('wedding', 'keyword', 'varchar(255) not null');
    }

    public function down() {
        echo "m150302_121301_add_keyword_to_wedding cannot be reverted.\n";

        return false;
    }
}
