<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductTable extends Migration {

	public function up()
	{
		Schema::create('order_product', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('product_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('price');
			$table->integer('quantity');
			$table->text('special_order')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('order_product');
	}
}