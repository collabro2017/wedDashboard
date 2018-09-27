<?php

use yii\db\Migration;

class m161121_182632_add_admin extends Migration
{
    public function up()
    {
        (new \app\modules\admin\models\User([
            'first_name' => 'Steve',
            'last_name'  => 'Fanous',
            'email'      => 'sfanous@rogers.com',
            'password'   => Yii::$app->security->generatePasswordHash('sfanous'),
        ]))->save();
    }

    public function down()
    {
        echo "m161121_182632_add_admin cannot be reverted.\n";

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
