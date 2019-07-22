<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResturantsTable extends Migration {

	public function up()
	{
		Schema::create('resturants', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('city_id')->unsigned();
			$table->string('email');
			$table->string('password');
			$table->decimal('minimum_order', 8,2);
			$table->decimal('delivery_cost', 8,2);
			$table->string('phone');
			$table->string('whattsapp');
			$table->text('image');
			$table->tinyInteger('activated')->default('0');
			$table->string('pin_code')->nullable();
			$table->enum('availability', array('opened', 'closed'));
			$table->string('api_token', 60)->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('resturants');
	}
}