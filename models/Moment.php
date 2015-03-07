<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Moment".
 *
 * @property integer $id
 * @property double $latitude
 * @property double $longitude
 * @property integer $start_at
 * @property integer $duration
 * @property integer $created_at
 * @property integer $updated_at
 */
class Moment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Moment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude'], 'number'],
            [['start_at', 'duration', 'created_at', 'updated_at'], 'integer'],
            [['created_at', 'updated_at'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'start_at' => 'Start At',
            'duration' => 'Duration',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
