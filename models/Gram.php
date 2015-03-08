<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "Gram".
 *
 * @property integer $id
 * @property integer $moment_id
 * @property string $username
 * @property string $link
 * @property string $image_url
 * @property string $text
 * @property integer $created_time
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Moment $moment
 */
class Gram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Gram';
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
            [['moment_id',  'created_time'], 'required'],
            [['moment_id', 'created_time', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['username', 'link', 'image_url'], 'string', 'max' => 255]
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
            'username' => 'Username',
            'link' => 'Link',
            'image_url' => 'Image Url',
            'text' => 'Text',
            'created_time' => 'Created Time',
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
    
    public function add($moment_id,$username,$link,$created_time,$image_url,$text) {
      if (!Gram::find()->where(['moment_id' => $moment_id])->andWhere(['link'=>$link])->andWhere(['created_time'=>$created_time])->exists()) {
        $i = new Gram();
        $i->moment_id = $moment_id;
        $i->username = $username;
        $i->link = $link;
        $i->created_time = $created_time;
        $i->image_url = $image_url;
        $i->text = $text;        
        $i->save();        
      }
    }
    
}
