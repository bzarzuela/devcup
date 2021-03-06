<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DevRun extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'dev:run';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description.';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function fire()
  {
    $sh = new Sherlock;
    $psycho = new Shrink;
    $j = new Judge;

    $this->info('Fetching Tweets');

    $tweets = $sh->getTweets('Sprite');

    $this->info('Got ' . count($tweets) . ' Tweets');

    $classified = $psycho->classify($tweets);

    foreach ($classified as $rec) {
      if ($rec['sentiment'] == 'positive') {
        // We need to submit this account to our BotFilter
        $this->info($rec['text']);
        if ($j->rule($rec['user_id'])) {
          $this->info("Winner");
          print_r($rec);
        } else {
          $this->error("Loser");
        }
      } else {
        $this->comment($rec['text']);
      }
    }
  }

  /**
   * Get the console command arguments.
   *
   * @return array
   */
  protected function getArguments()
  {
    return array(
      
    );
  }

  /**
   * Get the console command options.
   *
   * @return array
   */
  protected function getOptions()
  {
    return array(
      
    );
  }

}
