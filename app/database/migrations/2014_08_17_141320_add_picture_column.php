<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPictureColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('influencers', function(Blueprint $table)
		{
			$table->string('profile_image_url', 250)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('influencers', function(Blueprint $table)
		{
			$table->dropColumn('profile_image_url');
		});
	}

}
