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
    

}
