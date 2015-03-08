<?php

use yii\db\Schema;
use yii\db\Migration;

class m150308_184606_create_gram_table extends Migration
{
    public function up()
    {
          $tableOptions = null;
          if ($this->db->driverName === 'mysql') {
              $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
          }

          $this->createTable('{{%gram}}', [
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
      $this->addForeignKey('fk_gram_moment', '{{%gram}}', 'moment_id', '{{%moment}}', 'id', 'CASCADE', 'CASCADE');     
    }
    
    
    public function down()
    {
      $this->dropForeignKey('fk_gram_moment','{{%gram}}');
      $this->dropTable('{{%gram}}');
    }
}
