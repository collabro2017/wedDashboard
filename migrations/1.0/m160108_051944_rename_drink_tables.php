<?php

use yii\db\Migration;

class m160108_051944_rename_drink_tables extends Migration
{
    public function up()
    {
        /* fks for existing_drink_base_drink table */
        $this->dropForeignKey('fk_existing_drink_base_drink_base_drink_idx', 'existing_drink_base_drink');
        $this->dropForeignKey('fk_existing_drink_base_drink_existing_drink_idx', 'existing_drink_base_drink');
        
        /* fks for existing_drink_mixer table */
        $this->dropForeignKey('fk_existing_drink_mixer_existing_drink_idx', 'existing_drink_mixer');
        $this->dropForeignKey('fk_existing_drink_mixer_drink_mixer_idx', 'existing_drink_mixer');

        /* fks for existing_drink_brand table*/
        $this->dropForeignKey('fk_existing_drink_brand_existing_drinks_idx', 'existing_drink_brand');
        $this->dropForeignKey('fk_existing_drink_brand_drink_brand_idx', 'existing_drink_brand');

        /* drink likes */
        $this->dropForeignKey('fk_drink_like_existing_drink_idx', 'drink_like');    // 2
        $this->dropForeignKey('fk_drink_like_guest_idx', 'drink_like');             // 2

        /* existing drink */
        $this->dropForeignKey('fk_existing_drink_drink_type_idx', 'existing_drink'); // 1

        /* drink_brand */
        $this->dropForeignKey('fk_drink_brand_base_drink_idx', 'drink_brand'); //не надо

        /* available_drink */
        $this->dropForeignKey('fk_available_drink_base_drink_idx', 'available_drink');
        $this->dropForeignKey('fk_available_drink_category_idx', 'available_drink');
        $this->dropForeignKey('fk_available_drink_drink_brand_idx', 'available_drink');


        $this->renameTable('available_drink', 'wedding_drink'); //alcohol id, category id
//        $this->renameTable('base_drink', 'alcohol');
//        $this->renameTable('drink_brand', 'brand');
        $this->renameTable('drink_like', 'beverage_like');
        $this->renameTable('drink_mixer', 'mixer');
        $this->renameTable('drink_type', 'beverage_type');
        $this->renameTable('existing_drink', 'beverage');
        $this->renameTable('existing_drink_mixer', 'beverage_mixer');




        $this->createTable('beverage_alcohol', [
            'beverage_id' => 'int not null',
            'alcohol_id' => 'int not null',
        ]);

        $this->addPrimaryKey('pk_beverage_alcohol_idx', 'beverage_alcohol', ['beverage_id', 'alcohol_id']);

        $this->addColumn('wedding_drink', 'alcohol_id', 'int');
        $this->renameColumn('beverage_like', 'existing_drink_id', 'beverage_id');
        $this->renameColumn('beverage_mixer', 'existing_drink_id', 'beverage_id');
        $this->renameColumn('beverage_mixer', 'drink_mixer_id', 'mixer_id');

        $this->dropColumn('wedding_drink', 'base_drink_id');
        $this->dropColumn('wedding_drink', 'drink_brand_id');
        $this->dropColumn('wedding_drink', 'exclusive_brand_name');

        $this->execute('TRUNCATE beverage_like');
        $this->execute('TRUNCATE wedding_drink');



        $this->addForeignKey('fk_beverage_category_idx', 'beverage', 'type_id', 'beverage_type', 'id');

        $this->addForeignKey('fk_beverage_like_beverage_idx', 'beverage_like', 'beverage_id', 'beverage', 'id');
        $this->addForeignKey('fk_beverage_like_guest_idx', 'beverage_like', 'guest_id', 'guest', 'id');

        $this->addForeignKey('fk_beverage_mixer_beverage_idx', 'beverage_mixer', 'beverage_id', 'beverage', 'id');
        $this->addForeignKey('fk_beverage_mixer_mixer_idx', 'beverage_mixer', 'mixer_id', 'mixer', 'id');

        $this->addForeignKey('fk_beverage_alcohol_beverage_idx', 'beverage_alcohol', 'beverage_id', 'beverage', 'id');
        $this->addForeignKey('fk_beverage_alcohol_alcohol_idx', 'beverage_alcohol', 'alcohol_id', 'alcohol', 'id');

        $this->addForeignKey('fk_alcohol_parent_idx', 'alcohol', 'parent_id', 'alcohol', 'id');

        $this->addForeignKey('fk_wedding_drink_alcohol_idx', 'wedding_drink', 'alcohol_id', 'alcohol', 'id');
        $this->addForeignKey('fk_wedding_drink_drink_category_idx', 'wedding_drink', 'drink_category_id', 'drink_category', 'id');
    }

    public function down()
    {
        echo "m160108_051944_rename_drink_tables cannot be reverted.\n";

        return false;
    }
}
