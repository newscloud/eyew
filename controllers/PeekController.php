<?php

namespace app\controllers;

use Instagram;
use TwitterAPIExchange;

class PeekController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTwitter() {
      $settings = array(
          'oauth_access_token' => \Yii::$app->params['twitter']['oauth_token'],
          'oauth_access_token_secret' => \Yii::$app->params['twitter']['oauth_secret'],
          'consumer_key' => \Yii::$app->params['twitter']['key'],
          'consumer_secret' => \Yii::$app->params['twitter']['secret'],
      );
    
      $url = 'https://api.twitter.com/1.1/search/tweets.json';
      $getfield ="?result_type=recent&geocode=47.614264,-122.328008,.1mi&include_entities=false&since=2015-02-28&until=2015-03-02";
      //&since=
      $requestMethod = 'GET';

      $twitter = new TwitterAPIExchange($settings);
      $tweets = json_decode($twitter->setGetfield($getfield)
                   ->buildOauth($url, $requestMethod)
                   ->performRequest());
      foreach ($tweets->statuses as $t) {
        print_r($t);echo "<br><br>";
      }
    }
    
    public function actionInstagram()
    {
        $instagram = new Instagram\Instagram;
        $instagram->setAccessToken( '1742382410.4de1c75.9ae21b41aa1548db8e1dda95739541d2' );
        //$current_user = $instagram->getCurrentUser();
        //var_dump($current_user);die();
        //$instagram->setClientID( '4de1c75008cc4237a6fd4d44386c62d7' );
        $params = array('min_timestamp'=>1424308000,'max_timestamp'=>1424311600,'distance'=>50);
        $media = $instagram->searchMedia( 47.614264, -122.328008,$params ); 
        foreach ($media as $m) {
          //print_r($m);
          echo $m->user->username.'<br />';
          //echo $m->user->full_name.'<br />';
          if (isset($m->caption->text)) {
            echo $m->caption->text.'<br />'; 
          }
          echo $m->link.'<br />';
          echo $m->created_time.'<br />';
          echo '<img src="'.$m->images->thumbnail->url.'" />';
          echo '<br /><br />';
        }
        return $this->render('instagram');
    }

}
