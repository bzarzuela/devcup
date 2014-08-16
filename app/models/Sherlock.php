<?php

use TwitterOAuth\TwitterOAuth;

class Sherlock
{
  public function getTweets($keyword)
  {
    $tw = new TwitterOAuth(Config::get('app.twitter'));

    $params = array(
        'q' => 'coke',
    );

    $response = $tw->get('search/tweets', $params);

    return $response;
  }
}