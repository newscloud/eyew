<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "twitter".
 *
 * @property integer $id
 * @property integer $moment_id
 * @property integer $tweet_id
 * @property integer $twitter_id
 * @property string $screen_name
 * @property string $text
 * @property integer $tweeted_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Moment $moment
 */
class Twitter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'twitter';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['moment_id', 'tweet_id', 'twitter_id',  'tweeted_at'], 'required'],
            [['moment_id', 'tweet_id', 'twitter_id', 'tweeted_at', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['screen_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moment_id' => 'Moment ID',
            'tweet_id' => 'Tweet ID',
            'twitter_id' => 'Twitter ID',
            'screen_name' => 'Screen Name',
            'text' => 'Text',
            'tweeted_at' => 'Tweeted At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMoment()
    {
        return $this->hasOne(Moment::className(), ['id' => 'moment_id']);
    }
    
      public function getGrams()
      {
          return $this->hasMany(Gram::className(), ['moment_id' => 'id']);
      }

      public function add($moment_id,$tweet_id,$twitter_id,$screen_name, $tweeted_at,$text) {
        if (!Twitter::find()->where(['moment_id' => $moment_id])->andWhere(['tweet_id'=>$tweet_id])->exists()) {
          $i = new Twitter();
          $i->moment_id = $moment_id;
          $i->tweet_id = $tweet_id;
          $i->twitter_id = $twitter_id;
          $i->screen_name = $screen_name;
          $i->tweeted_at = strtotime($tweeted_at);
          $i->text = $text;        
          $i->save();
        }
      }    
}
