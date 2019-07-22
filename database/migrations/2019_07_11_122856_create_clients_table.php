<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->integer('city_id')->unsigned();
			$table->string('address');
			$table->string('password');
			$table->text('image');
			$table->tinyInteger('activated')->default('0');
			$table->string('pin_code')->nullable();
			$table->string('api_token', 60)->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}