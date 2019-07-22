<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('description');
			$table->integer('price');
			$table->time('preparing_time');
			$table->text('image');
			$table->integer('resturant_id')->unsigned();
			$table->tinyInteger('disabled')->default('0');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}