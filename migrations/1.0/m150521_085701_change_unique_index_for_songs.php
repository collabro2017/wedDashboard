<?php

use yii\db\Migration;

class m150521_085701_change_unique_index_for_songs extends Migration
{
    public function up()
    {
        $this->dropIndex('title', 'song');
        $this->createIndex('idx_title_artist_wedding_song', 'song', [
            'title', 'artist'
        ], false);
    }

    public function down()
    {
        echo "m150521_085701_change_unique_index_for_songs cannot be reverted.\n";

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
