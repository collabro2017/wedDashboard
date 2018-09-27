<?php

use yii\db\Migration;

class m150618_051114_extending_drinks_tables extends Migration
{
    public function up()
    {
        $this->createTable('base_drink', [
            'id' => 'pk',
            'name' => 'string'
        ]);

        $this->createTable('drink_brand', [
            'id' => 'pk',
            'name' => 'string',
            'base_drink_id' => 'int'
        ]);

        $this->createTable('drink_mixer', [
            'id' => 'pk',
            'name' => 'string'
        ]);

        $this->createTable('existing_drink', [
            'id' => 'pk',
            'name' => 'string',
            'ingredients' => 'text',
            'instructions' => 'text',
            'category' => 'enum("shot", "cocktail", "martini")'
        ]);

        $this->createTable('existing_drink_base_drink', [
            'id' => 'pk',
            'existing_drink_id' => 'int not null',
            'base_drink_id' => 'int not null'
        ]);

        $this->createTable('existing_drink_mixer', [
            'id' => 'pk',
            'existing_drink_id' => 'int not null',
            'drink_mixer_id' => 'int not null',
        ]);

        $this->createTable('existing_drink_brand', [
            'id' => 'pk',
            'existing_drink_id' => 'int not null',
            'drink_brand_id' => 'int not null'
        ]);

        $this->addForeignKey('fk_drink_brand_base_drink_idx', 'drink_brand', 'base_drink_id', 'base_drink', 'id');

        /* fks for existing_drink_base_drink table */
        $this->addForeignKey(
            'fk_existing_drink_base_drink_existing_drink_idx',
            'existing_drink_base_drink',
            'existing_drink_id',
            'existing_drink',
            'id'
        );
        $this->addForeignKey(
            'fk_existing_drink_base_drink_base_drink_idx',
            'existing_drink_base_drink',
            'base_drink_id',
            'base_drink',
            'id'
        );

        /* fks for existing_drink_mixer table */
        $this->addForeignKey(
            'fk_existing_drink_mixer_existing_drink_idx',
            'existing_drink_mixer',
            'existing_drink_id',
            'existing_drink',
            'id'
        );
        $this->addForeignKey(
            'fk_existing_drink_mixer_drink_mixer_idx',
            'existing_drink_mixer',
            'drink_mixer_id',
            'drink_mixer',
            'id'
        );

        /* fks for existing_drink_brand table*/
        $this->addForeignKey(
            'fk_existing_drink_brand_existing_drinks_idx',
            'existing_drink_brand',
            'existing_drink_id',
            'existing_drink',
            'id'
        );
        $this->addForeignKey(
            'fk_existing_drink_brand_drink_brand_idx',
            'existing_drink_brand',
            'drink_brand_id',
            'drink_brand',
            'id'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk_existing_drink_brand_drink_brand_idx', 'existing_drink_brand');
        $this->dropForeignKey('fk_existing_drink_brand_existing_drinks_idx', 'existing_drink_brand');

        $this->dropForeignKey('fk_existing_drink_mixer_drink_mixer_idx', 'existing_drink_mixer');
        $this->dropForeignKey('fk_existing_drink_mixer_existing_drink_idx', 'existing_drink_mixer');

        $this->dropForeignKey('fk_existing_drink_base_drink_base_drink_idx', 'existing_drink_base_drink');
        $this->dropForeignKey('fk_existing_drink_base_drink_existing_drink_idx', 'existing_drink_base_drink');

        $this->dropForeignKey('fk_drink_brand_base_drink_idx', 'drink_brand');

        $this->dropTable('existing_drink_brand');
        $this->dropTable('existing_drink_mixer');
        $this->dropTable('existing_drink_base_drink');
        $this->dropTable('existing_drink');
        $this->dropTable('drink_mixer');
        $this->dropTable('drink_brand');
        $this->dropTable('base_drink');

    }
}