<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Instagram".
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
class Instagram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Instagram';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['moment_id', 'text', 'created_time', 'created_at', 'updated_at'], 'required'],
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
}
