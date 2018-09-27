<?php

use yii\db\Migration;

class m150409_162734_participant_rename_description extends Migration
{
    public function up()
    {
        $this->renameColumn('participant', 'description', 'member');
    }

    public function down()
    {
        echo "m150409_162734_participant_rename_description cannot be reverted.\n";

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
