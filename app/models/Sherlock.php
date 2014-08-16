<?php

use TwitterOAuth\TwitterOAuth;

class Sherlock
{
  public function getTweets($keyword)
  {
    $tw = new TwitterOAuth(Config::get('app.twitter'));
    $redis = Redis::connection();
    $prefix = Config::get('app.redis_prefix');

    $params = array(
        'q' => $keyword,
        'lang' => 'en',
        'count' => 100,
    );

    $response = $tw->get('search/tweets', $params);

    $tweets = [];

    foreach ($response['statuses'] as $status) {
      $redis->set($prefix . ':status:' . $status['id_str'], json_encode($status));

      $tweets[] = [
        'id' => $status['id_str'],
        'text' => $status['text'],
      ];
    }

    return $tweets;
  }
}