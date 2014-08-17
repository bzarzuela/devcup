<?php

class Chatty
{
  private $endpoint;

  public function __construct($endpoint)
  {
    $this->endpoint = $endpoint;
  }

  public function send($payload)
  {
    $postdata = http_build_query(['json' => json_encode($payload)]);
    $opts = [
      'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata,
      ]
    ];

    $context = stream_context_create($opts);
    return file_get_contents($this->endpoint . '/send', false, $context);
  }

  public function whisper($payload)
  {
    $postdata = http_build_query(['json' => json_encode($payload)]);
    $opts = [
      'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata,
      ]
    ];

    $context = stream_context_create($opts);
    return file_get_contents($this->endpoint . '/whisper', false, $context);
  }

  public function popup($conn, $room, $ref, $name)
  {
    $name = rawurlencode($name);
    $ref = rawurlencode($ref);
    $room = rawurlencode($room);
    $conn = rawurlencode($conn);
    $url = $this->endpoint . "/popup/$conn/$room/$ref/$name";
    return json_decode(file_get_contents($url), true);
  }

  public function popupSupervisor($supervisor, $room, $ref, $name)
  {
    foreach ($supervisor as $ss) {
      $name = rawurlencode($name);
      $ref = rawurlencode($ref);
      $room = rawurlencode($room);
      $conn = rawurlencode($ss->getConnId());
      $url = $this->endpoint . "/popup-supervisor/$conn/$room/$ref/$name";
      return json_decode(file_get_contents($url), true);
    }
  }
}