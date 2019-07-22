<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassificationResturantTable extends Migration {

	public function up()
	{
		Schema::create('classification_resturant', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('resturant_id')->unsigned();
			$table->integer('classification_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('classification_resturant');
	}
}