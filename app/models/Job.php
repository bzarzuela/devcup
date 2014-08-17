<?php

class Job extends Eloquent
{
  public function addInfluencer($user, $tweet)
  {
    // So we don't do duplicates
    try {
      $inf = Influencer::where('job_id', '=', $this->id)
        ->where('user_id', '=', $tweet['user_id'])
        ->firstOrFail();
    } catch (Exception $e) {
      $inf = new Influencer;
      $this->progress++;
    }

    $inf->job_id = $this->id;
    $inf->user_id = $tweet['user_id'];
    $inf->tweet_id = $tweet['id'];
    $inf->screen_name = $user['screen_name'];
    $inf->profile_image_url = $user['profile_image_url'];
    $inf->excerpt = $tweet['text'];
    $inf->save();

    return $this;
  }
}