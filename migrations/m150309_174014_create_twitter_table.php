<?php

use yii\db\Schema;
use yii\db\Migration;

class m150309_174014_create_twitter_table extends Migration
{
    public function up()
    {
          $tableOptions = null;
          if ($this->db->driverName === 'mysql') {
              $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
          }

          $this->createTable('{{%twitter}}', [
              'id' => Schema::TYPE_PK,
              'moment_id' => Schema::TYPE_INTEGER . ' NOT NULL',
              'tweet_id' => Schema::TYPE_BIGINT . ' NOT NULL',
              'twitter_id' => Schema::TYPE_BIGINT . ' NOT NULL',
              'screen_name' => Schema::TYPE_STRING . ' NOT NULL DEFAULT 0',
              'text' => Schema::TYPE_TEXT . ' NOT NULL ',
              'tweeted_at' => Schema::TYPE_INTEGER . ' NOT NULL',
              'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
              'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
          ], $tableOptions);          
      $this->addForeignKey('fk_twitter_moment', '{{%twitter}}', 'moment_id', '{{%moment}}', 'id', 'CASCADE', 'CASCADE');     
    }
    
    
    public function down()
    {
      $this->dropForeignKey('fk_twitter_moment','{{%twitter}}');
      $this->dropTable('{{%twitter}}');
    }
}
