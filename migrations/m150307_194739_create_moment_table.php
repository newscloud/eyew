<?php

use yii\db\Schema;
use yii\db\Migration;

class m150307_194739_create_moment_table extends Migration
{
  public function up()
  {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%moment}}', [
            'id' => Schema::TYPE_PK,
            'latitude' => Schema::TYPE_FLOAT.' NOT NULL DEFAULT 0',
            'longitude' => Schema::TYPE_FLOAT.' NOT NULL DEFAULT 0',
            'start_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'duration' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);          
    }

  public function down()
  {
    $this->dropTable('{{%moment}}');
  }
    
}
