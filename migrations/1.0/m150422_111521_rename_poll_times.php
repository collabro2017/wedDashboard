<?php

use yii\db\Migration;

class m150422_111521_rename_poll_times extends Migration
{
    public function up()
    {
        $this->renameColumn('poll', 'starts_at', 'started_at');
        $this->renameColumn('poll', 'ends_at', 'ended_at');
    }

    public function down()
    {
        echo "m150422_111521_rename_poll_times cannot be reverted.\n";

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
