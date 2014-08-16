<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfluencersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('influencers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('job_id');
			$table->string('user_id', 100);
			$table->string('tweet_id', 100);
			$table->string('screen_name', 250);
			$table->string('excerpt', 140);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('influencers');
	}

}
