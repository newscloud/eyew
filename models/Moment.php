<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Gram;
use Instagram;
use TwitterAPIExchange;

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

    public function getTwitters()
    {
        return $this->hasMany(Twitter::className(), ['moment_id' => 'id']);
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
     
     public function searchTwitter() {
       date_default_timezone_set('America/Los_Angeles');       
       Yii::trace('start searchTwitter '.date('y-m-d h:m '));
       // Load your Twitter application keys
       $settings = array(
           'oauth_access_token' => \Yii::$app->params['twitter']['oauth_token'],
           'oauth_access_token_secret' => \Yii::$app->params['twitter']['oauth_secret'],
           'consumer_key' => \Yii::$app->params['twitter']['key'],
           'consumer_secret' => \Yii::$app->params['twitter']['secret'],
       );
       // Connect to Twitter 
       $twitter = new TwitterAPIExchange($settings);
       // Query settings for search
       $url = 'https://api.twitter.com/1.1/search/tweets.json';
       $requestMethod = 'GET';
       // rate limit of 180 queries
       $limit = 180;
       $query_count=1;
       $count = 100;
       $result_type = 'recent';
       // calculate valid timestamp range
       $valid_start = $this->start_at;
       // $until_date and $valid_end = // start time + duration
       $valid_end = $this->start_at + ($this->duration*60);
       Yii::trace( 'Valid Range: '.$valid_start.' -> '.$valid_end);
       $until_date = date('Y-m-d',$valid_end+(24*3600)); // add one day 
       $distance_km = $this->distance/1000; // distance in km
       // Unused: &since=$since_date
       // $since_date = '2015-03-05'; 
       // Perform first query with until_date
       $getfield ="?result_type=$result_type&geocode=".$this->latitude.",".$this->longitude.",".$distance_km."mi&include_entities=false&until=$until_date&count=$count";
       $tweets = json_decode($twitter->setGetfield($getfield)
                    ->buildOauth($url, $requestMethod)
                    ->performRequest());
        if (isset($tweets->errors)) {
          Yii::$app->session->setFlash('error', 'Twitter Rate Limit Reached.');
          Yii::error($tweets->errors[0]->message);
          return;
        }
       $max_id = 0;
       Yii::trace( 'Count Statuses: '.count($tweets->statuses));
       Yii::trace( 'Max Tweet Id: '.$max_id);
       foreach ($tweets->statuses as $t) {
         // check if tweet in valid time range
         $unix_created_at = strtotime($t->created_at);         
         Yii::trace('Tweet @ '.$t->created_at.' '.$unix_created_at.':'.$t->user->screen_name.' '.(isset($t->text)?$t->text:''));
         if ($unix_created_at >= $valid_start && $unix_created_at <= $valid_end)
         {
           // print_r($t);
            $i = new Twitter();           $i->add($this->id,$t->id_str,$t->user->id_str,$t->user->screen_name,$unix_created_at,(isset($t->text)?$t->text:''));
         }        
         if ($max_id ==0) {
           $max_id = intval($t->id_str);
         } else {
           $max_id = min($max_id, intval($t->id_str));
         }
       }
       $count_repeat_max =0;
       // Perform all subsequent queries with addition of updated maximum_tweet_id
       while ($query_count<=$limit) {
         $prior_max_id = $max_id;
         $query_count+=1;
         Yii::trace( 'Request #: '.$query_count);
         
         // Perform subsequent query with max_id
         $getfield ="?result_type=$result_type&geocode=".$this->latitude.",".$this->longitude.",".$distance_km."mi&include_entities=false&max_id=$max_id&count=$count";
         
         $tweets = json_decode($twitter->setGetfield($getfield)
                      ->buildOauth($url, $requestMethod)
                      ->performRequest());

          if (isset($tweets->errors)) {
            Yii::$app->session->setFlash('error', 'Twitter Rate Limit Reached.');
            Yii::error($tweets->errors[0]->message);
            return;
          }
          // sometimes twitter api fails
          if (!isset($tweets->statuses)) continue;
          
          Yii::trace( 'Count Statuses: '.count($tweets->statuses));
          Yii::trace( 'Max Tweet Id: '.$max_id);
         foreach ($tweets->statuses as $t) {           
           // check if tweet in valid time range
           $unix_created_at = strtotime($t->created_at);
           if ($unix_created_at >= $valid_start && $unix_created_at <= $valid_end)
           {
              $i = new Twitter();           $i->add($this->id,$t->id_str,$t->user->id_str,$t->user->screen_name,$unix_created_at,(isset($t->text)?$t->text:''));
           } else if ($unix_created_at < $valid_start) {
             // stop querying when earlier than valid_start
             return;
           }
           $max_id = min($max_id,intval($t->id_str))-1;
         }       
         if ($prior_max_id - $max_id <=1 OR count($tweets->statuses)<1) {
           $count_repeat_max+=1;
         }           
         if ($count_repeat_max>5) {           
           // when the api isn't returning more results
           break;
         }
       } // end while 
     }
     
     public static function purge($moment_id) {
       Gram::deleteAll('moment_id='.$moment_id);
       Twitter::deleteAll('moment_id='.$moment_id);
     }
     
}
