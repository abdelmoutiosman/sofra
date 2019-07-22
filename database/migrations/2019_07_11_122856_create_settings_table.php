<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->text('conditons_and_rules');
			$table->longText('about_app');
			$table->string('facebook_url');
			$table->string('twitter_url');
			$table->string('instagram_url');
			$table->decimal('commission', 8,2);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}