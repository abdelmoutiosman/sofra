<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('description');
			$table->decimal('price', 8,2);
			$table->datetime('starting_at');
			$table->datetime('ending_at');
			$table->text('image');
			$table->integer('resturant_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}