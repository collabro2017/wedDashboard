<?php

use yii\db\Migration;

class m150515_104640_change_trivia_type extends Migration
{
    public function up()
    {
        $this->addColumn('trivia', 'type', 'enum(\'bride-and-groom\', \'bride\', \'groom\', \'friends\') not null default \'bride-and-groom\' after title');
    }

    public function down()
    {
        echo "m150515_104640_change_trivia_type cannot be reverted.\n";

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
