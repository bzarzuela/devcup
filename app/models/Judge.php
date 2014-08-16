<?php

class Judge
{
  private $reason;

  public function rule($user_id)
  {
    $redis = Redis::connection();
    $prefix = Config::get('app.redis_prefix');
    $config = Config::get('app.judge');

    $user = json_decode($redis->get($prefix . ':user:' . $user_id), true);

    if ($user['followers_count'] <= $config['min_follower']) {
      $this->reason = "Follower count: {$user['followers_count']} too low";
      return false;
    }

    return $user;
  }
}