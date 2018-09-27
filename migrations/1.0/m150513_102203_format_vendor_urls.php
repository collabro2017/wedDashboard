<?php

use app\models\Vendor;
use yii\db\Migration;

class m150513_102203_format_vendor_urls extends Migration
{
    /**
     *
     */
    public function up()
    {
        /** @var Vendor $vendor */
        foreach (Vendor::find()->all() as $vendor) {
            if ($vendor->website &&
                !(substr_count('http://', $vendor->website) > 0) &&
                !(substr_count('https://', $vendor->website) > 0)
            ) {
                $vendor->website = 'http://' . $vendor->website;
                $vendor->save();
            }
        }
    }

    public function down()
    {
        echo "m150513_102203_format_vendor_urls cannot be reverted.\n";

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
