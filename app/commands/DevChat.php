<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DevChat extends Command {

  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'dev:chat';

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
    $chatty = new Chatty('http://localhost:8081/chatty');
    $chatty->send([
      'room' => 'job-1',
      'sender' => 'system',
      'message' => 'Hello',
      'timestamp' => date('Y-m-d H:i:s'),
    ]);
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
