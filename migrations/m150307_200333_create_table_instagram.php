<?php

use yii\db\Schema;
use yii\db\Migration;

class m150307_200333_create_table_instagram extends Migration
{
    public function up()
    {
          $tableOptions = null;
          if ($this->db->driverName === 'mysql') {
              $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
          }

          $this->createTable('{{%instagram}}', [
              'id' => Schema::TYPE_PK,
              'moment_id' => Schema::TYPE_INTEGER . ' NOT NULL',
              'username' => Schema::TYPE_STRING . ' NOT NULL DEFAULT 0',
              'link' => Schema::TYPE_STRING . ' NOT NULL DEFAULT 0',
              'image_url' => Schema::TYPE_STRING . ' NOT NULL DEFAULT 0',
              'text' => Schema::TYPE_TEXT . ' NOT NULL ',
              'created_time' => Schema::TYPE_INTEGER . ' NOT NULL',
              'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
              'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
          ], $tableOptions);          
      $this->addForeignKey('fk_instagram_moment', '{{%instagram}}', 'moment_id', '{{%moment}}', 'id', 'CASCADE', 'CASCADE');     
    }
    
    
    public function down()
    {
      $this->dropForeignKey('fk_instagram_moment','{{%instagram}}');
      $this->dropTable('{{%instagram}}');
    }
}
