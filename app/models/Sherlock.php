<?php

use TwitterOAuth\TwitterOAuth;

class Sherlock
{
  public function getTweets($keyword)
  {
    $config = array(
      'consumer_key' => 'wRuU06HpNcDWd5yQqZtYOAIDk',
      'consumer_secret' => '8Bxs90ORCAWALw2Ap8Fhx4XVek6NF1ZqnvKS1THYSIjt9gfSjm',
      'oauth_token' => '14842370-LmGOUylI9aCigGdArqm4VnatZXi52firZ4LoBOrHl',
      'oauth_token_secret' => 'PSXA4CA3wVSNyhmSac86G195bIUbSY3aQiTmteBoNWgH7',
      'output_format' => 'object'
    );

    $tw = new TwitterOAuth($config);

    $params = array(
        'screen_name' => 'ricard0per',
        'count' => 5,
        'exclude_replies' => true
    );

    $response = $tw->get('statuses/user_timeline', $params);

    return $response;
  }
}