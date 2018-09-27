<?php

use yii\db\Migration;

class m150519_120155_change_media extends Migration
{
    public function up()
    {
        $this->alterColumn('media', 'kind', 'enum(\'photo\', \'video\') default \'photo\'');
        $this->alterColumn('media', 'created_at', 'datetime null default null');
    }

    public function down()
    {
        echo "m150519_120155_change_media cannot be reverted.\n";

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
