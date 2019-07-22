<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('resturant_id')->unsigned();
			$table->decimal('amount', 8,2)->default(0);
			$table->string('note')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}