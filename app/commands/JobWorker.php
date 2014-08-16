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
		try {
			$pending = Job::whereRaw('finished_at IS NULL')
				->where('next_run', '<=', date('Y-m-d H:i:s'))
				->orderBy('next_run')
				->firstOrFail();
		} catch (Exception $e) {
			print_r(DB::getQueryLog());
			$this->info('Nothing to do');
			exit;
		}

		$sh = new Sherlock;
		$psycho = new Shrink;
		$j = new Judge;

		$this->info('Fetching Tweets for Job: ' . $pending->id);

		$tweets = $sh->getTweets($pending->keyword);

		$this->info('Got ' . count($tweets) . ' Tweets');

		$classified = $psycho->classify($tweets);

		foreach ($classified as $rec) {
		  if ($rec['sentiment'] == 'positive') {
		    // We need to submit this account to our BotFilter
		    $this->info($rec['text']);
		    if ($user = $j->rule($rec['user_id'])) {
		      $this->info("Winner");

		      $pending->addInfluencer($user, $rec);
		      $pending->save();

		    } else {
		      $this->error("Loser");
		    }
		  } else {
		    $this->comment($rec['text']);
		  }
		}

		if ($pending->progress >= $pending->target) {
			$pending->finished_at = date('Y-m-d H:i:s');
		} else {
			$pending->next_run = date('Y-m-d H:i:s', time() + 60);
		}

		$pending->save();


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
