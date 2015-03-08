<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Gram;
use Instagram;

/**
 * This is the model class for table "Moment".
 *
 * @property integer $id
 * @property string $friendly
 * @property double $latitude
 * @property double $longitude
 * @property double $distance
 * @property integer $start_at
 * @property integer $duration
 * @property integer $created_at
 * @property integer $updated_at
 */
class Moment extends \yii\db\ActiveRecord
{
   const DURATION_QUARTER_HOUR=15;
    const DURATION_HALF_HOUR =30;
    const DURATION_ONE_HOUR =60;
    const DURATION_TWO_HOUR=120;
    const DURATION_THREE_HOUR =180;
    const DURATION_FIVE_HOUR =300;
    const DURATION_TEN_HOUR=600;
    const DURATION_DAY = 1440;
    
    public $start_picker_at;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Moment';
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
    
    public function getGrams()
    {
        return $this->hasMany(Gram::className(), ['moment_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude','distance'], 'number'],
            [['start_at', 'duration', 'created_at', 'updated_at'], 'integer'],
            [['friendly','latitude', 'longitude','distance','duration','start_at'], 'required'],
              [['friendly',], 'string', 'max' => 255]

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'friendly' => 'Description',            
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'distance' => 'Distance',
            'start_at' => 'Start At',
            'duration' => 'Duration',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getDurationType($data) {
        $options = $this->getDurationOptions();
        return $options[$data];
      }

      public function getDurationOptions()
      {
        return array(
            self::DURATION_QUARTER_HOUR => '15 minutes',
            self::DURATION_HALF_HOUR => '30 minutes',
            self::DURATION_ONE_HOUR => '1 hour',
            self::DURATION_TWO_HOUR => '2 hour',
            self::DURATION_THREE_HOUR => '3 hours',
            self::DURATION_FIVE_HOUR => '5 hours',
            self::DURATION_TEN_HOUR => '10 hours',
            self::DURATION_DAY => '24 hours',
           );
       }
    
    public function searchInstagram() {      
       $instagram = new Instagram\Instagram;
       $instagram->setClientID( \Yii::$app->params['instagram']['client_id'] );
       $end_at = $this->start_at + ($this->duration*60);
       $params = array('min_timestamp'=>$this->start_at,'max_timestamp'=>$end_at,'distance'=>$this->distance,'count'=>50);
       $media = $instagram->searchMedia( $this->latitude, $this->longitude,$params ); 

       foreach ($media as $m) {
         if (isset($m->caption->text)) {
          $caption = $m->caption->text;
         } else {
           $caption ='';                    
         }
        $i = new Gram();           $i->add($this->id,$m->user->username,$m->link,$m->created_time,$m->images->thumbnail->url,$caption);
       }
     }

     public static function purge($moment_id) {
       Gram::deleteAll('moment_id='.$moment_id);
     }
     
}
