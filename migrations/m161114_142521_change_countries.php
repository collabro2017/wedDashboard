<?php

use yii\db\Migration;

class m161114_142521_change_countries extends Migration
{
    public function up()
    {
        $this->dropColumn('country', 'fips');
        $this->dropColumn('country', 'iso');
        $this->dropColumn('country', 'tld');
    }

    public function down()
    {
        echo "m161114_142521_change_countries cannot be reverted.\n";

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
