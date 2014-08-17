<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class JobWorker extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'worker:job';

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
		DB::disableQueryLog();

		// My goto easter egg
		begin:

		try {
			$pending = Job::whereRaw('finished_at IS NULL')
				->where('next_run', '<=', date('Y-m-d H:i:s'))
				->orderBy('next_run')
				->firstOrFail();
		} catch (Exception $e) {
			$this->info('Nothing to do');
			sleep(1);
			goto begin;
		}

		$sh = new Sherlock;
		$psycho = new Shrink;
		$j = new Judge;
		$chatty = new Chatty('http://localhost:8081/chatty');

		$this->info('Fetching Tweets for Job: ' . $pending->id);

		$tweets = $sh->getTweets($pending->keyword, $pending->since_id);

		$this->info('Got ' . count($tweets) . ' Tweets');

		$classified = $psycho->classify($tweets);

		$orig_progress = $pending->progress;

		foreach ($classified as $rec) {
			$chatty->send([
			  'room' => 'job-' . $pending->id,
			  'sender' => 'tweet',
			  'message' => $rec['text'],
			  'timestamp' => date('Y-m-d H:i:s'),
			]);

			// 1500 - 2000ms delay for each message
			usleep(rand(1500, 2000) * 1000);

			$chatty->send([
			  'room' => 'job-' . $pending->id,
			  'sender' => 'sentiment',
			  'message' => $rec['sentiment'],
			  'timestamp' => date('Y-m-d H:i:s'),
			]);

			// 500-700ms delay for sentiment
			usleep(rand(500, 700) * 1000);

		  if ($rec['sentiment'] == 'positive') {
		    // We need to submit this account to our BotFilter
		    $this->info($rec['text']);
		    if ($user = $j->rule($rec['user_id'])) {
		      $this->info("Winner");

		      $pending->addInfluencer($user, $rec);
		      $pending->save();

		      $chatty->send([
		        'room' => 'job-' . $pending->id,
		        'sender' => 'mover',
		        'message' => 'Mover!',
		        'timestamp' => date('Y-m-d H:i:s'),
		      ]);

		      $chatty->send([
		        'room' => 'job-' . $pending->id,
		        'sender' => 'progress',
		        'message' => $pending->progress,
		        'timestamp' => date('Y-m-d H:i:s'),
		      ]);

		    } else {

		    	$chatty->send([
		    	  'room' => 'job-' . $pending->id,
		    	  'sender' => 'mover',
		    	  'message' => $j->getReason(),
		    	  'timestamp' => date('Y-m-d H:i:s'),
		    	]);

		      $this->error("Loser");
		    }
		  } else {
		  	$chatty->send([
		  	  'room' => 'job-' . $pending->id,
		  	  'sender' => 'mover',
		  	  'message' => 'Sentiment not positive.',
		  	  'timestamp' => date('Y-m-d H:i:s'),
		  	]);
		    $this->comment($rec['text']);
		  }

		  usleep(rand(300, 500) * 1000);

		  $chatty->send([
		    'room' => 'job-' . $pending->id,
		    'sender' => 'reset',
		    'message' => '',
		    'timestamp' => date('Y-m-d H:i:s'),
		  ]);

		  $pending->since_id = $rec['id'];
		} // End loop of $classified

		if ($pending->progress >= $pending->target) {
			$pending->finished_at = date('Y-m-d H:i:s');

			$chatty->send([
			  'room' => 'job-' . $pending->id,
			  'sender' => 'pay',
			  'message' => 1,
			  'timestamp' => date('Y-m-d H:i:s'),
			]);
		} else {
			$pending->next_run = date('Y-m-d H:i:s', time() + 0);
		}

		$pending->save();

		goto begin;

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
