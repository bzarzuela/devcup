<?php

use GuzzleHttp\Client;

// The one responsible for determining sentiment.
class Shrink
{
  public function classify($tweets)
  {
    $payload = json_encode([
      'data' => $tweets,
    ]);

    $client = new Client;

    $request = $client->createRequest('POST', Config::get('app.sentiment_api'), ['body' => $payload]);
    $request->addHeader('Accept-Encoding','GZIP');
    $request->addHeader('Content-Type','application/json');
    $response = $client->send($request);
    //     var_dump($response->json());
    // $response = $client->post(Config::get('app.sentiment_api'), ['body' => $payload]);

    try {
      $classified = $response->json();
    } catch (Exception $e) {
      echo($response->getBody());
      die("Crap. We need to work around this");
    }
    

    $redis = Redis::connection();
    $prefix = Config::get('app.redis_prefix');

    foreach ($classified['data'] as $key => $rec) {
      $tweet = json_decode($redis->get("$prefix:status:" . $rec['id']), true);

      switch ($rec['polarity']) {
        case 4:
          $tweet['sentiment'] = 'positive';
          $rec['sentiment'] = 'positive';
        break;

        case 2:
          $tweet['sentiment'] = 'neutral';
          $rec['sentiment'] = 'neutral';
        break;

        case 0:
          $tweet['sentiment'] = 'negative';
          $rec['sentiment'] = 'negative';
        break;

        default:
          # TODO handle shit here.
        break;
      }

      $classified['data'][$key] = $rec;

      $redis->set("$prefix:status:" . $rec['id'], json_encode($tweet));
    }

    return $classified['data'];
  }
}